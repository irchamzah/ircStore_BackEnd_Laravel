<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Midtrans\Config;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class OrderController extends Controller
{


    public function create()
    {
        $cartItems = \App\Models\Cart::with('items.product')->where('user_id', auth()->id())->first();

        $user = User::with(['addresses'])->findOrFail(auth()->id());

        // Mengambil alamat-alamat pengguna
        $addresses = $user->addresses()->orderByDesc('is_primary')->get();

        // Mendapatkan metode pengiriman
        $shippingMethods = ['Standard', 'Express', 'Next Day'];

        // Mendapatkan catatan dari session
        $note = session('checkout_note', '');

        return view('checkout.index', [
            'cartItems' => $cartItems->items ?? [],
            'addresses' => $addresses,
            'shippingMethods' => $shippingMethods,
            'note' => $note,
        ]);
    }

    public function show($id)
    {
        // Ambil order berdasarkan ID
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        // Tampilkan view dengan data order
        return view('order.show', compact('order'));
    }

    public function generateSnapToken(Request $request)
    {
        // Validasi data
        $request->validate([
            'id' => 'required|exists:orders,id',
            'order_id_midtrans' => 'required|exists:orders,order_id_midtrans',
        ]);

        $order = Order::findOrFail($request->id);

        // Midtrans Configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        // Membuat item details
        $itemDetails = $order->items->map(function ($item) {
            if ($item->product) {
                return [
                    'id' => $item->product_id,
                    'price' => round($item->product->price),
                    'quantity' => $item->quantity,
                    'name' => $item->product->name,
                ];
            } else {
                return [
                    'id' => $item->product_id,
                    'price' => round(0),
                    'quantity' => $item->quantity,
                    'name' => 'Product not found',
                ];
            }
        })->toArray();

        // Membuat Midtrans Snap parameters
        $params = [
            'transaction_details' => [
                'order_id' => $request->order_id_midtrans,
                'gross_amount' => round($order->total),
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('order.finish'),
                'unfinish' => route('order.unfinish'),
                'error' => route('order.error'),
            ],
        ];

        // Cek apakah snap_token sudah ada
        if (empty($order->snap_token)) {
            // Ambil Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
        }

        $order->order_id_midtrans = $request->order_id_midtrans;
        $order->status = 'pending';
        $order->save();

        return redirect()->route('order.show', ['id' => $order->id])->with('success', 'Order updated successfully.');
    }

    public function delete(Request $request)
    {
        // Validasi data
        $request->validate([
            'id' => 'required',
        ]);

        try {
            // Temukan dan hapus order berdasarkan ID
            $order = Order::findOrFail($request->id);
            $order->delete();

            return redirect()->route('account.orders')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('account.orders')->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {
        // Validasi data
        $request->validate([
            'order_id' => 'required',
            'status' => 'required',
        ]);

        // Cari dan ubah status transaksi
        $order = Order::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }

    public function cancel(Request $request)
    {
        // Validasi data
        $request->validate([
            'order_id_midtrans' => 'required',
        ]);

        $order = Order::where('order_id_midtrans', $request->order_id_midtrans)->firstOrFail();

        // Midtrans Configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        try {
            $cancel = MidtransTransaction::cancel($request->order_id_midtrans);

            // Cari dan ubah status transaksi
            $order->status = 'cancel';
            $order->save();

            return response()->json(['message' => 'order cancelled successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to cancel order: ' . $e->getMessage()], 500);
        }
    }

    public function syncStatus(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        try {
            // Ambil status dari Midtrans
            $status = MidtransTransaction::status($request->order_id_midtrans);
            $order = Order::where('order_id_midtrans', $request->order_id_midtrans)->firstOrFail();

            // Menyimpan status dari Midtrans ke database
            /** @var \stdClass $status */
            $order->status = $this->mapMidtransStatus($status->transaction_status);
            $order->save();

            return response()->json(['message' => 'Order status synced successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to sync order status: ' . $e->getMessage()], 500);
        }
    }

    private function mapMidtransStatus($midtransStatus)
    {
        // Mengubah status Midtrans ke status yang sesuai
        switch ($midtransStatus) {
            case 'settlement':
                return 'success';
            case 'pending':
                return 'waiting_payment';
            case 'deny':
                return 'deny';
            case 'cancel':
                return 'cancel';
            case 'expire':
                return 'expire';
            default:
                return 'expire';
        }
    }

    public function complete(Order $order)
    {
        if ($order->status == 'success') {
            $order->status = 'completed';
            $order->save();

            return redirect()->back()->with('success', 'Pesanan telah diselesaikan.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat diselesaikan.');
    }


    // private function getOrderDetails($orderId)
    // {
    //     // Logika untuk mengambil data pesanan
    //     return Order::with('items.product')->findOrFail($orderId);
    // }

    // public function complete()
    // {
    //     // Logika untuk menyelesaikan pesanan
    //     return view('checkout.complete');
    // }

    public function finish(Request $request)
    {
        // Jika payment sukses
        $orderId = $request->input('order_id');
        return view('order.finish', compact('orderId'));
    }

    public function unfinish(Request $request)
    {
        // Jika payment unfinish
        $orderId = $request->input('order_id');
        return view('order.unfinish', compact('orderId'));
    }

    public function error(Request $request)
    {
        // Jika payment error
        $orderId = $request->input('order_id');
        return view('order.error', compact('orderId'));
    }
}
