<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-white py-8">
    <div class="container mx-auto px-6">

        <!-- Hero Section -->
        <div class="hero bg-gray-100 rounded-lg p-8 mb-12">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800">Welcome to Our Shop!</h2>
                    <p class="text-gray-600 mt-2">Discover our exclusive collection of products.</p>
                    <a href="#products"
                        class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                        Shop Now
                    </a>
                </div>
                <div>
                    <img src="https://via.placeholder.com/400x300" alt="Hero Image" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        <div id="products" class="mb-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Featured Products</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @foreach($featuredProducts as $product)
                <div class="product-card bg-white p-6 rounded-lg shadow-lg">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover mb-4 rounded">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h4>
                    <p class="text-gray-600 mt-2">${{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->id) }}"
                        class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600">
                        View Product
                    </a>
                </div>
                @endforeach

            </div>
        </div>


        <!-- Categories Section -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Shop by Category</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                @foreach($categories as $category)
                <div class="category-card bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                        class="w-full h-24 object-cover mb-4 rounded">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $category->name }}</h4>
                    <a href="{{ route('search', ['category' =>$category->id]) }}"
                        class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                        Explore
                    </a>
                </div>
                @endforeach

            </div>
        </div>


        <!-- Promotional Banner -->
        <div class="promotion bg-blue-500 rounded-lg p-8 text-white text-center shadow-lg">
            <h3 class="text-3xl font-bold">Special Offer!</h3>
            <p class="mt-2">Get 50% off on selected items. Limited time only!</p>
            <a href="#" class="mt-4 inline-block bg-white text-blue-500 px-4 py-2 rounded-lg shadow hover:bg-gray-200">
                Shop Now
            </a>
        </div>

    </div>
</div>
@endsection