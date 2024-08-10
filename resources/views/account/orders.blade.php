@extends('layouts.app')

@section('title', 'Order History')



@section('content')

@if(session('success'))
<div class="bg-green-500 text-white p-4 rounded-lg mb-4">
    {{ session('success') }}
</div>
@endif

<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Order History</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @forelse ($orders as $order)

        @php
        $color = 'gray';
        if ($order->status == 'success') {
        $color = 'green';
        } elseif (in_array($order->status, ['pending', 'waiting_payment'])) {
        $color = 'gray';
        } elseif ($order->status == 'cancel') {
        $color = 'red';
        }
        @endphp

        <div class="mb-4 border-b border-gray-300 pb-4">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Total Items:</strong> {{ $order->items->count() }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
            <p><strong>Status:</strong> <span class="text-white bg-{{ $color }}-500 px-2">{{
                    $order->status }}</p>
            </span>
            <!-- Add more order details here -->

            <!-- Link to order confirmation -->
            <a href="{{ route('order.show',  $order->id) }}" class="text-blue-500 hover:underline">
                View Order Details
            </a>
        </div>
        @empty
        <p class="text-gray-500">You have no orders.</p>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>


@endsection