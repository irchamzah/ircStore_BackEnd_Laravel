@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg shadow mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(count($items) == 0)
    <p>Your cart is empty!</p>
    @else
    <table class="w-full bg-white rounded-lg shadow-lg">
        <thead>
            <tr>
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Product</th>
                <th class="px-4 py-2 text-center">Name</th>
                <th class="px-4 py-2 text-center">Quantity</th>
                <th class="px-4 py-2 text-center">Price</th>
                <th class="px-4 py-2 text-center">Total</th>
                <th class="px-4 py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 text-center">
                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                        class="w-16 h-16 rounded mx-auto">
                </td>
                <td class="px-4 py-2 text-center">
                    <span>{{ $item->product->name }}</span>
                </td>
                <td class="px-4 py-2 text-center">
                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                            class="w-16 text-center bg-gray-100 rounded">
                        <button type="submit"
                            class="ml-2 bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Update</button>
                    </form>
                </td>
                <td class="px-4 py-2 text-center">${{ $item->product->price }}</td>
                <td class="px-4 py-2 text-center">${{ $item->product->price * $item->quantity }}</td>
                <td class="px-4 py-2 text-center">
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Clear Cart</button>
        </form>
    </div>

    <!-- Checkout Button -->
    <div class="mt-6">
        <a href="{{ route('checkout.index') }}"
            class="bg-green-500 text-white px-6 py-3 rounded-lg shadow hover:bg-green-600">
            Proceed to
            Checkout
        </a>
    </div>

    @endif
</div>
@endsection