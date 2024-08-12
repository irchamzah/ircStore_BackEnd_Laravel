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

<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <!-- Heading & Filters -->
        <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
            <div>

                <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Featured Products</h2>
            </div>
        </div>
        <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">

            @foreach($featuredProducts as $product)
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="h-56 w-full">
                    <a href="{{ route('product.show', $product->id) }}">
                        <img class="mx-auto hidden h-full dark:block" src="/images/products/{{ $product->image }}"
                            alt="{{ $product->name }}" />
                    </a>
                </div>
                <div class="pt-6 flex flex-col">
                    <div>
                        <a href="{{ route('product.show', $product->id) }}"
                            class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
                            {{ $product->name }}</a>
                    </div>

                    <div class="mt-2 flex items-center gap-2">
                        <div class="flex items-center">
                            @php
                            $fullStars = floor($product->averageRating);
                            $halfStar = $product->averageRating - $fullStars >= 0.5;
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

                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{
                            number_format($product->averageRating, 1) }}</p>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">({{ $product->reviewsCount }})
                        </p>
                    </div>

                    <div class="mt-4 flex flex-col justify-between gap-4">
                        <p class="text-2xl font-extrabold leading-tight text-gray-900 dark:text-white">Rp.{{
                            number_format($product->price,0,'','.') }}</p>

                        <a href="{{ route('product.show', $product->id) }}"
                            class="inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-min text-nowrap">
                            See Product
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

</section>

<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Popular Categories</h2>

            <a href="{{ route('categories.index') }}" title=""
                class="flex items-center text-base font-medium text-primary-700 hover:underline dark:text-primary-500">
                See more categories
                <svg class="ms-1 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 12H5m14 0-4 4m4-4-4-4" />
                </svg>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">


            @foreach($categories as $category)
            <a href="{{ route('search', ['category' =>$category->id]) }}"
                class="flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v5m-3 0h6M4 11h16M5 15h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1Z">
                    </path>
                </svg>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
            </a>
            @endforeach


        </div>
    </div>
</section>

@endsection