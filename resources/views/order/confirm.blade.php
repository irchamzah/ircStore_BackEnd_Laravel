<!-- resources/views/order/confirm.blade.php -->
@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Order Confirmation</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Order Summary</h2>

        <!-- Order Details -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Order #{{ $order->id }}</h3>

            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">Shipping Information</h4>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
            </div>

            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">Billing Information</h4>
                <p>{{ $order->billing_address }}</p>
                <p>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zip }}</p>
            </div>

            <!-- Order Items -->
            <h4 class="text-lg font-semibold mb-2">Order Items</h4>
            <table class="w-full bg-gray-100 border border-gray-300 rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-2">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                class="w-16 h-16 rounded">
                            <span>{{ $item->product->name }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">${{ $item->product->price }}</td>
                        <td class="px-4 py-2">${{ $item->product->price * $item->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Order Total -->
            <div class="mt-6 text-right">
                <h3 class="text-xl font-bold">Order Total: ${{ $order->total }}</h3>
            </div>
        </div>

        <!-- Confirmation Action -->
        <div class="mt-8 flex justify-end">
            <a href="{{ route('checkout.complete') }}"
                class="px-6 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
                Complete Order
            </a>
        </div>
    </div>
</div>
@endsection