<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
        <div class="mr-auto place-self-center lg:col-span-7">
            <h1
                class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                Welcome to Our Shop!</h1>
            <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                Discover our exclusive collection of products.</p>
            <a href="#"
                class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                Get started
                <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
            <a href="#"
                class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                Speak to Sales
            </a>
        </div>
        <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
            <img src="/images/hero.jpg" alt="mockup">
        </div>
    </div>
</section>



<div class="bg-white py-8">
    <div class="container mx-auto px-6">



        <!-- Featured Products Section -->
        {{-- <div id="products" class="mb-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Featured Products</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @foreach($featuredProducts as $product)
                <div class="product-card bg-white p-6 rounded-lg shadow-lg">
                    <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover mb-4 rounded">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h4>
                    <p class="text-gray-600 mt-2">Rp.{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->id) }}"
                        class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600">
                        View Product
                    </a>
                </div>
                @endforeach

            </div>
        </div> --}}

        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">

                <div class="flex flex-col items-center text-center">
                    <h2 class="text-3xl font-bold md:text-4xl">Featured Products</h2>
                    <p class="mb-8 mt-4 max-w-xl text-base text-gray-500 md:mb-12 md:text-lg lg:mb-16"></p>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">

                    @foreach($featuredProducts as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="group">
                        <div
                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                            <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center group-hover:opacity-75">
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">Rp.{{ number_format($product->price, 2) }}</p>
                    </a>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- Categories Section -->
        {{-- <div class="mb-12">
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
        </div> --}}

        <section>
            <!-- Container -->
            <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
                <!-- Title -->
                <div class="flex flex-col items-center text-center">
                    <h2 class="text-3xl font-bold md:text-4xl">Popular Categories</h2>
                    <p class="mb-8 mt-4 max-w-xl text-base text-gray-500 md:mb-12 md:text-lg lg:mb-16"></p>
                </div>
                <!-- Features Content -->
                <div class="grid gap-5 sm:grid-cols-2 md:grid-cols-3 md:gap-4 lg:gap-6">
                    <!-- Features Item -->

                    @foreach($categories as $category)
                    <a href="{{ route('search', ['category' =>$category->id]) }}">
                        <div
                            class="grid gap-6 rounded-md border border-solid border-gray-300 p-8 md:p-10 hover:opacity-75">
                            <img src="/images/categories/{{ $category->image }}" alt="{{ $category->name }}"
                                class="inline-block h-16 w-16 object-cover rounded-full " />
                            <h3 class="text-xl font-semibold">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->description }}</p>
                        </div>
                    </a>
                    @endforeach

                </div>
            </div>
        </section>





        <!-- Promotional Banner -->
        {{-- <div class="promotion bg-blue-500 rounded-lg p-8 text-white text-center shadow-lg">
            <h3 class="text-3xl font-bold">Special Offer!</h3>
            <p class="mt-2">Get 50% off on selected items. Limited time only!</p>
            <a href="#" class="mt-4 inline-block bg-white text-blue-500 px-4 py-2 rounded-lg shadow hover:bg-gray-200">
                Shop Now
            </a>
        </div> --}}

    </div>
</div>
@endsection