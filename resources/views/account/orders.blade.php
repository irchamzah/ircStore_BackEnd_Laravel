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
        $color = 'bg-gray-500';
        if ($order->status == 'success') {
        $color = 'bg-green-500';
        } elseif (in_array($order->status, ['pending', 'waiting_payment'])) {
        $color = 'bg-gray-500';
        } elseif ($order->status == 'cancel') {
        $color = 'bg-red-500';
        }elseif ($order->status == 'completed') {
        $color = 'bg-blue-500';
        }
        @endphp

        <div class="mb-4 border-b border-gray-300 pb-4">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Total Items:</strong> {{ $order->items->count() }}</p>
            <p><strong>Total:</strong> Rp.{{ number_format($order->total, 0, ',', '.') }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
            <p><strong>Status:</strong> <span class="text-white {{ $color }} px-2">{{
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

    <!-- Paginasi -->
    <div class="mt-20 flex justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            @if ($orders->onFirstPage())
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-not-allowed"
                aria-disabled="true">
                Previous
            </span>
            @else
            <a href="{{ $orders->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100">
                Previous
            </a>
            @endif

            @for ($i = 1; $i <= $orders->lastPage(); $i++)
                @if ($i == $orders->currentPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 cursor-not-allowed"
                    aria-current="page">
                    {{ $i }}
                </span>
                @else
                <a href="{{ $orders->url($i) . '&' . http_build_query(request()->except('page')) }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
                    {{ $i }}
                </a>
                @endif
                @endfor

                @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100">
                    Next
                </a>
                @else
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-not-allowed"
                    aria-disabled="true">
                    Next
                </span>
                @endif
        </nav>
    </div>
</div>


@endsection