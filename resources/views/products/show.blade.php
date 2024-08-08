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

    <h3 class="text-2xl font-bold mb-4 mt-6">Leave a Review</h3>

    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="rating" class="block text-gray-700">Rating:</label>
            <select name="rating" id="rating" class="block w-full mt-1 rounded-md bg-gray-200 text-gray-800">
                <option value="5">★★★★★</option>
                <option value="4">★★★★☆</option>
                <option value="3">★★★☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="1">★☆☆☆☆</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="review" class="block text-gray-700">Review:</label>
            <textarea name="review" id="review" rows="4"
                class="block w-full mt-1 rounded-md bg-gray-200 text-gray-800"></textarea>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Submit
            Review</button>
    </form>

    <!-- Ratings Summary -->
    <div class="mt-6">
        <h2 class="text-2xl font-bold mb-4">Customer Reviews</h2>

        <div class="text-yellow-400 text-lg">
            <!-- Menggunakan Font Awesome -->
            @php
            $fullStars = floor($averageRating);
            $halfStar = $averageRating - $fullStars >= 0.5;
            @endphp

            @for ($i = 0; $i < $fullStars; $i++) <i class="fas fa-star"></i>
                @endfor

                @if($halfStar)
                <i class="fas fa-star-half-alt"></i>
                @endif

                @for ($i = $fullStars + $halfStar; $i < 5; $i++) <i class="far fa-star"></i>
                    @endfor

                    <span class="text-gray-600">{{ $averageRating }} out of 5</span>
                    <span class="text-gray-600">({{ $product->reviews->count() }} reviews)</span>


        </div>
    </div>

    <!-- Reviews List -->
    @if($product->reviews->count() > 0)
    <div class="mt-6 space-y-6">
        @foreach($product->reviews as $review)
        <div class="bg-gray-100 p-4 rounded-lg shadow">
            <div class="flex items-center mb-2">
                <div class="text-yellow-400">
                    @for ($i = 0; $i < $review->rating; $i++)
                        ★
                        @endfor
                        @for ($i = $review->rating; $i < 5; $i++) ☆ @endfor </div>
                            <h4 class="ml-4 text-lg font-semibold">{{ $review->user->name }}</h4>
                </div>
                <p class="text-gray-600">{{ $review->review }}</p>
                <small class="text-gray-500">Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">No reviews yet.</p>
        @endif



    </div>
    @endsection