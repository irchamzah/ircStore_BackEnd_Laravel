@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Order History</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @forelse ($orders as $order)
        <div class="mb-4">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
            <!-- Add more order details here -->
        </div>
        @empty
        <p class="text-gray-500">You have no orders.</p>
        @endforelse
    </div>
</div>
@endsection