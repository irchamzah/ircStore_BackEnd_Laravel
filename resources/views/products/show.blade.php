@extends('layouts.app')

@section('title', $product->name)

@section('content')

@if(session('success'))
<div class="bg-green-500 text-white p-4 rounded-lg shadow mb-6">
    {{ session('success') }}
</div>
@endif

<div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div>
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-lg">
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            <p class="text-2xl font-semibold text-gray-800 mb-6">${{ number_format($product->price, 2) }}</p>

            <!-- Add to Cart Button -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>

    <!-- Additional Product Information -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Additional Information</h2>
        <p class="text-gray-600 mb-4"><strong>Category:</strong> {{ $product->category->name }}</p>
        <p class="text-gray-600 mb-4"><strong>Stock:</strong> {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
        </p>
        <p class="text-gray-600 mb-4"><strong>SKU:</strong> {{ $product->sku }}</p>
    </div>
</div>
@endsection