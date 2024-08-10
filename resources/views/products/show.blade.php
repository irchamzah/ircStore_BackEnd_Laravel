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
            <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                class="w-full h-auto rounded-lg shadow-lg">
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{!! $product->description !!}</p>
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
        <p class="text-gray-600 mb-4"><strong>Stock:</strong> {{ $product->stock > 0 ? $product->stock : 0 }}
        </p>
    </div>



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
    <div id="reviews-container" class="mt-6 space-y-6">
        <h2 class="text-2xl font-bold mb-4">Customer Reviews</h2>

        @if($product->reviews->count() > 0)
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


            @else
            <p class="text-gray-500">No reviews yet.</p>
            @endif
        </div>

        <div id="more-reviews" class="text-center mt-4">
            @if ($totalReviews > 5)
            <button id="load-more" data-page="1"
                class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
                See more reviews
            </button>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const loadMoreButton = document.getElementById('load-more');
        const reviewsContainer = document.getElementById('reviews-container');
    
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function() {
                const page = parseInt(this.getAttribute('data-page')) + 1;
                const productId = '{{ $product->id }}';
    
                fetch(`/product/${productId}/reviews?page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.reviews.length > 0) {
                            data.reviews.forEach(review => {
                                const reviewElement = document.createElement('div');
                                reviewElement.classList.add('bg-gray-100', 'p-4', 'rounded-lg', 'shadow');
                                reviewElement.innerHTML = `
                                    <div class="flex items-center mb-2">
                                        <div class="text-yellow-400">
                                            ${'★'.repeat(review.rating)}
                                            ${'☆'.repeat(5 - review.rating)}
                                        </div>
                                        <h4 class="ml-4 text-lg font-semibold">${review.user_name}</h4>
                                    </div>
                                    <p class="text-gray-600">${review.review}</p>
                                    <small class="text-gray-500">Reviewed on ${review.created_at}</small>
                                `;
                                reviewsContainer.appendChild(reviewElement);
                            });
                            loadMoreButton.setAttribute('data-page', page);
                        } else {
                            loadMoreButton.remove();
                        }
                    })
                    .catch(error => console.error('Error loading more reviews:', error));
            });
        }
    });
    </script>
    @endsection