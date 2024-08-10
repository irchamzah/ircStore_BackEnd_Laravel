@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto px-6 py-8">

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('account.orders') }}" class="text-blue-500 hover:underline">View All Orders</a>
    </div>

    <!-- Order Details -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4">Order #{{ $order->id }}</h3>

        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-2">Shipping Recipient</h4>
            <span class="font-semibold">{{ $order->user->name }}</span>,
            <span class="text-gray-600">{{$order->user->phone_number }}</span>


        </div>

        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-2">Shipping Information</h4>
            <p>{{ $order->address->full_address }}</p>
            <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}</p>
        </div>

        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-2">Order Details</h4>
            <p class="font-semibold">Order Status: <span class="font-normal">{{ $order->status }}</span></p>
            <p class="font-semibold">Order Date: <span class="font-normal">{{ $order->created_at->format('d M Y, H:i')
                    }}</span></p>
            <p class="font-semibold">Shipping Method: <span class="font-normal">{{ $order->shipping_method }}</span></p>
            <p class="font-semibold">Notes: <span class="font-normal">{{ $order->notes }}</span></p>
            <p class="font-semibold">Order ID Midtrans: <span class="font-normal">{{ $order->order_id_midtrans }}</span>
            </p>
            <p class="font-semibold">Snap Token: <span class="font-normal">{{ $order->snap_token }}</span></p>
        </div>

        <!-- Order Items -->
        <h4 class="text-lg font-semibold mb-2">Order Items</h4>
        <table class="w-full bg-gray-100 border border-gray-300 rounded-lg">
            <thead>
                <tr class="text-left">
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


        <!-- Action Button -->
        <div class="mt-8 flex justify-center">
            <!-- Form untuk tombol Pay -->
            <form action="{{ route('order.pay') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <input type="hidden" name="order_id_midtrans" value="{{ $order->order_id_midtrans }}">
                <button type="submit"
                    class="px-6 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 mr-4">
                    Pay
                </button>
            </form>

            <form action="{{ route('order.delete') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 mr-4">
                    Cancel
                </button>
            </form>
        </div>


        <!-- Confirmation Action -->
        {{-- <div class="mt-8 flex justify-end">
            <a href="{{ route('checkout.complete') }}"
                class="px-6 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
                Complete Order
            </a>
        </div> --}}
    </div>
</div>
@endsection