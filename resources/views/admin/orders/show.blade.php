@extends('admin.layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Order Details - #{{ $order->id }}</h2>

    <div class="mb-6">
        <h3 class="text-lg font-semibold">Order Information</h3>
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Total Price:</strong> ${{ number_format($order->total, 2) }}</p>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold">Customer Information</h3>
        <p><strong>Name:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold">Products Ordered</h3>
        <table class="w-full bg-gray-100 rounded-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="px-4 py-2">{{ $item->product->name }}</td>
                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                    <td class="px-4 py-2">${{ number_format($item->price, 2) }}</td>
                    <td class="px-4 py-2">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold">Order Actions</h3>
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="inline-block">
            @csrf
            @method('PUT')
            <select name="status" class="px-4 py-2 rounded-lg bg-gray-200 border border-gray-300">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">Update
                Status</button>
        </form>

        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline-block ml-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600"
                onclick="return confirm('Are you sure you want to delete this order?')">Delete Order</button>
        </form>
    </div>
</div>
@endsection