<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        $items = $cart->items;

        return view('cart.index', compact('items'));
    }

    public function add(Request $request, $productId)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        // Cek jika item sudah ada di cart
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // Jika ada, tambahkan quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Jika tidak ada, tambahkan item baru
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function remove(Request $request, $itemId)
    {
        $cart = $this->getCart();
        $cartItem = $cart->items()->where('id', $itemId)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    private function getCart()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        return $cart;
    }

    public function update(Request $request, $id)
    {
        // Dapatkan cart berdasarkan user saat ini
        $cart = $this->getCart();

        // Temukan item di dalam cart berdasarkan ID
        $cartItem = $cart->items()->where('id', $id)->first();

        if ($cartItem) {
            // Perbarui kuantitas item
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();

            // Hitung total harga baru
            $totalPrice = $cartItem->product->price * $cartItem->quantity;

            // Kirimkan respons JSON
            return response()->json([
                'success' => true,
                'totalPrice' => $totalPrice
            ]);
        }

        // Kirimkan respons error jika item tidak ditemukan
        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }


    public function clear(Request $request)
    {
        $cart = $this->getCart();

        // Hapus semua item dari keranjang
        $cart->items()->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
