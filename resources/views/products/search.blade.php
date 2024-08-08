@extends('layouts.app')

@section('title', 'Search Products')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Search Products</h1>

    <!-- Search and Filter Form -->
    <form action="{{ route('search') }}" method="GET" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Search Input -->
            <input type="text" name="query" placeholder="Search products..." value="{{ request('query') }}"
                class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Category Filter -->
            <select name="category"
                class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category')==$category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>

            <!-- Price Filter -->
            <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}" min="0"
                step="10"
                class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}" min="0"
                step="10"
                class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Sort By -->
            <select name="sort_by"
                class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Sort By</option>
                <option value="name" {{ request('sort_by')=='name' ? 'selected' : '' }}>Name</option>
                <option value="price" {{ request('sort_by')=='price' ? 'selected' : '' }}>Price</option>
            </select>

            <!-- Buttons -->
            <div class="flex items-center gap-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
                    Apply Filters
                </button>
                <button type="reset" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600">
                    Reset
                </button>
            </div>
        </div>
    </form>

    <!-- Products List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($products as $product)
        <div class="product-card bg-white p-6 rounded-lg shadow-lg">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-4 rounded">
            <h2 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
            <p class="text-gray-600 mt-2">${{ number_format($product->price, 2) }}</p>
            <a href="{{ route('product.show', $product->id) }}"
                class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                View Product
            </a>
        </div>
        @empty
        <p class="text-gray-500">No products found.</p>
        @endforelse
    </div>
</div>
@endsection