@extends('layouts.app')
@section('title', $product->name)

@section('content')
@if(session('success'))
<div class="bg-green-500 text-white p-4 rounded-lg shadow mb-6">
    {{ session('success') }}
</div>
@endif

<section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                <img class="w-full dark:hidden" src="/images/products/{{ $product->image }}"
                    alt="{{ $product->name }}" />
                <img class="w-full hidden dark:block" src="/images/products/{{ $product->image }}"
                    alt="{{ $product->name }}" />
            </div>

            <div class="mt-6 sm:mt-8 lg:mt-0">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    {{ $product->name }}
                </h1>
                <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                    <p class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">
                        Rp.{{ number_format($product->price, 2) }}
                    </p>

                    <div class="flex items-center gap-2 mt-2 sm:mt-0">
                        <div class="flex items-center gap-1">
                            @php
                            $fullStars = floor($averageRating);
                            $halfStar = $averageRating - $fullStars >= 0.5;
                            @endphp

                            @for ($i = 0; $i < $fullStars; $i++) <i class="fas fa-star w-4 h-4 text-yellow-300"></i>
                                @endfor

                                @if($halfStar)
                                <i class="fas fa-star-half-alt w-4 h-4 text-yellow-300"></i>
                                @endif

                                @for ($i = $fullStars + $halfStar; $i < 5; $i++) <i
                                    class="far fa-star w-4 h-4 text-yellow-300"></i>
                                    @endfor

                        </div>
                        <p class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400">
                            ({{ number_format($averageRating, 1) }})
                        </p>
                        <a href="#reviews-container"
                            class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline dark:text-white">
                            {{ $product->reviews->count() }} {{ $product->reviews->count() == 1 ? 'Review' : 'Reviews'
                            }}
                        </a>
                    </div>
                </div>

                <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                    <a href="#" title=""
                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        role="button">
                        <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                        </svg>
                        Add to favorites
                    </a>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-white mt-4 sm:mt-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center hover:opacity-80"
                            role="button">
                            <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                            </svg>

                            Add to cart
                        </button>
                    </form>
                </div>

                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="mb-6 font-medium text-gray-900 dark:text-white">Category</p>
                        <a href="#"
                            class="inline-flex items-center justify-center py-1 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600  dark:hover:bg-gray-600">
                            {{ $product->category->name }}
                        </a>
                    </div>
                    <div>
                        <p class="mb-6 font-medium text-gray-900 dark:text-white">Stock</p>
                        <a href="#"
                            class="inline-flex items-center justify-center py-1 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600  dark:hover:bg-gray-600">
                            {{ $product->stock > 0 ? $product->stock : 0 }}
                        </a>
                    </div>
                </div>


                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                <p class="mb-6 text-gray-500 dark:text-gray-400">
                    {!! $product->description !!}
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="flex items-center mb-2">

            @php
            $fullStars = floor($averageRating);
            $halfStar = $averageRating - $fullStars >= 0.5;
            @endphp

            @for ($i = 0; $i < $fullStars; $i++) <i class="fas fa-star w-4 h-4 text-yellow-300 me-1"></i>
                @endfor

                @if($halfStar)
                <i class="fas fa-star-half-alt w-4 h-4 text-yellow-300 me-1"></i>
                @endif

                @for ($i = $fullStars + $halfStar; $i < 5; $i++) <i class="far fa-star w-4 h-4 text-yellow-300 me-1">
                    </i>
                    @endfor

                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">{{ $averageRating }}</p>
                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">out of</p>
                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">5</p>
        </div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $product->reviews->count() }} reviews
        </p>
        @for ($rating = 5; $rating >= 1; $rating--)
        @if(isset($ratingPercentages[$rating]))
        <div class="flex items-center mt-4">
            <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $rating }}
                star</a>
            <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
                <div class="h-5 bg-yellow-300 rounded" style="width: {{ $ratingPercentages[$rating] }}%"></div>
            </div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{
                number_format($ratingPercentages[$rating], 0) }}%</span>
        </div>
        @endif
        @endfor


        {{-- Reviews List --}}
        <article id="reviews-container" class="py-8 md:py-16">

            <h2 class="text-2xl font-bold my-10 text-white">Customer Reviews</h2>

            @if($product->reviews->count() > 0)
            @foreach($latestReviews as $review)
            <div class="flex items-center my-4">
                <img class="w-10 h-10 me-4 rounded-full" src="/images/profiles/{{ $review->user->photo }}"
                    alt="{{ $review->user->photo }}">
                <div class="font-medium dark:text-white">
                    <p>{{ $review->user->name }} <time datetime=""
                            class="block text-sm text-gray-500 dark:text-gray-400">Joined
                            on {{ $review->user->created_at->format('M d, Y') }}</time></p>
                </div>
            </div>
            <div class="flex items-center mb-1 space-x-1 rtl:space-x-reverse">

                @for ($i = 0; $i < $review->rating; $i++)
                    <i class="fas fa-star w-4 h-4 text-yellow-300 me-1"></i>
                    @endfor
                    @for ($i = $review->rating; $i < 5; $i++) <i class="far fa-star w-4 h-4 text-yellow-300 me-1">
                        </i> @endfor
                        <div></div>
            </div>



            <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                <p>Reviewed on <time datetime="">{{ $review->created_at->format('M d, Y') }}</time></p>
            </footer>
            <p class="mb-4 text-gray-500 dark:text-gray-400">{{ $review->review }}</p>
            <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />
            @endforeach

            @else
            <p class="text-gray-500">No reviews yet.</p>
            @endif

        </article>

        @if ($totalReviewsCount >= 5)
        <button id="load-more" data-page="1"
            class="block mb-5 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Read
            more</button>
        @endif

    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreButton = document.getElementById('load-more');
        const reviewsContainer = document.getElementById('reviews-container');
    
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function() {
                const page = parseInt(this.getAttribute('data-page'), 10) + 1;
                const productId = '{{ $product->id }}';
    
                fetch(`/products/${productId}/reviews?page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.reviews.length > 0) {
                            data.reviews.forEach(review => {
                                const reviewElement = document.createElement('div');
    
                                reviewElement.innerHTML = `
                                <div class="flex items-center my-4">
                                    <img class="w-10 h-10 me-4 rounded-full" src="/images/profiles/${review.user.photo}" alt="${review.user.name}">
                                    <div class="font-medium dark:text-white">
                                        <p>${review.user.name} <time datetime="" class="block text-sm text-gray-500 dark:text-gray-400">Joined on ${new Date(review.user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</time></p>
                                    </div>
                                </div>
                                    <div class="flex items-center mb-1 space-x-1 rtl:space-x-reverse">
                                        ${'<i class="fas fa-star w-4 h-4 text-yellow-300 me-1"></i>'.repeat(review.rating)}
                                        ${'<i class="far fa-star w-4 h-4 text-yellow-300 me-1"></i>'.repeat(5 - review.rating)}
                                    </div>
                                    <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                                        <p>Reviewed on <time datetime="">${new Date(review.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</time></p>
                                    </footer>
                                    <p class="mb-4 text-gray-500 dark:text-gray-400">${review.review}</p>
                                    <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />
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