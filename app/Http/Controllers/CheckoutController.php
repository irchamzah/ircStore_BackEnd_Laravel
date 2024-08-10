<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
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


    public function process(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'shipping_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $cartItems = Cart::with('items.product')->where('user_id', auth()->id())->first();

        if (!$cartItems || $cartItems->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Menghitung total harga
        $totalPrice = $cartItems->items->sum(fn($item) => $item->product->price * $item->quantity);

        // Membuat Order baru
        $order = Order::create([
            'order_id_midtrans' => Str::uuid()->toString(),
            'user_id' => auth()->id(),
            'total' => $totalPrice,
            'status' => 'waiting',
            'address_id' => $request->address_id,
            'shipping_method' => $request->shipping_method,
            'notes' => $request->notes,
        ]);

        // Menyimpan detail order (order items)
        foreach ($cartItems->items as $item) {
            // Kurangi stok produk
            $product = $item->product;
            if ($product->stock >= $item->quantity) {
                $product->stock -= $item->quantity;
                $product->save();

                // Simpan detail order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            } else {
                return redirect()->route('cart.index')->with('error', 'Stock not available for some items.');
            }
        }

        // Hapus cart setelah checkout
        $cartItems->delete();

        return redirect()->route('order.show', $order->id)->with('success', 'Your order has been placed successfully.');
    }
}
