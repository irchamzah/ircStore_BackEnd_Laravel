<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = \App\Models\Cart::with('items.product')->where('user_id', auth()->id())->first();

        // Mengambil alamat-alamat pengguna
        $addresses = auth()->user()->addresses; // Pastikan user memiliki relasi ke alamat

        // Mendapatkan metode pengiriman
        $shippingMethods = ['Standard', 'Express', 'Next Day']; // Contoh metode pengiriman

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
        // Logic for processing payment goes here
        // E.g., saving order to the database, charging the card, etc.

        return redirect()->route('home')->with('success', 'Your order has been placed successfully!');
    }
}
