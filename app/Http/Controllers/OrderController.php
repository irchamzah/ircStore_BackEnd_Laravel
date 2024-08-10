<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Midtrans\Config;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function show($id)
    {
        // Ambil order berdasarkan ID
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        // Tampilkan view dengan data order
        return view('order.show', compact('order'));
    }

    public function pay(Request $request)
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
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->name,
                ];
            } else {
                return [
                    'id' => $item->product_id,
                    'price' => 0,
                    'quantity' => $item->quantity,
                    'name' => 'Product not found',
                ];
            }
        })->toArray();


        // Membuat Midtrans Snap parameters
        $params = [
            'order_details' => [
                'order_id' => $request->order_id_midtrans,
                'gross_amount' => $order->total,
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

        // Ambil Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        $order->order_id_midtrans = $request->order_id_midtrans;
        $order->snap_token = $snapToken;
        $order->status = 'pending';
        $order->save();

        // Kirim Snap Token sebagai JSON response
        return view('order.show', compact('order'));
    }

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

    public function confirm(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = $this->getOrderDetails($orderId);

        return view('order.confirm', compact('order'));
    }

    private function getOrderDetails($orderId)
    {
        // Logika untuk mengambil data pesanan
        return Order::with('items.product')->findOrFail($orderId);
    }

    // public function complete()
    // {
    //     // Logika untuk menyelesaikan pesanan
    //     return view('checkout.complete');
    // }
}
