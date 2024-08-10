@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Order Summary</h2>
            <ul>
                @foreach($cartItems as $item)
                <li class="flex justify-between mb-4">
                    <div class="flex">
                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                            class="w-16 h-16 rounded">
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                            <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">${{ number_format($item->product->price *
                        $item->quantity, 2) }}</span>
                </li>
                @endforeach
            </ul>
            <hr class="my-6">
            <div class="flex justify-between">
                <span class="text-xl font-semibold text-gray-800">Total:</span>
                <span class="text-xl font-semibold text-gray-800">${{ number_format($cartItems->sum(fn($item) =>
                    $item->product->price * $item->quantity), 2) }}</span>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Payment Information</h2>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <!-- Pilihan Alamat Pengiriman -->
                <div class="mb-4">
                    <label for="address_id" class="block text-gray-700">Select Shipping Address</label>
                    <select name="address_id" id="address_id"
                        class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800">
                        @foreach($addresses as $address)
                        <option value="{{ $address->id }}">{{ $address->full_address }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Jasa Pengiriman -->
                <div class="mb-4">
                    <label for="shipping_method" class="block text-gray-700">Shipping Method</label>
                    <select name="shipping_method" id="shipping_method"
                        class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800">
                        <option value="standard">Standard Shipping</option>
                        <option value="express">Express Shipping</option>
                        <!-- Add other shipping methods as needed -->
                    </select>
                </div>

                <!-- Pesan (Catatan) untuk Penjual -->
                <div class="mb-4">
                    <label for="notes" class="block text-gray-700">Notes for Seller</label>
                    <textarea name="notes" id="notes"
                        class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800" rows="4"></textarea>
                </div>


                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Place
                    Order</button>
            </form>
        </div>
    </div>
</div>
@endsection