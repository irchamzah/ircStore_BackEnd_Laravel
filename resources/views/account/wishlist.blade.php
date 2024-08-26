@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Wishlist</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @forelse ($wishlist as $item)
        <div class="mb-4">
            <p><strong>Product:</strong> {{ $item->product->name }}</p>
            <p><strong>Price:</strong> ${{ number_format($item->product->price, 2) }}</p>
            <!-- Add more wishlist details here -->
        </div>
        @empty
        <p class="text-gray-500">Your wishlist is empty.</p>
        @endforelse
    </div>
</div>
@endsection