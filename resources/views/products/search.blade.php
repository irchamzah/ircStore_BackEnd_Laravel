@extends('layouts.app')

@section('title', 'Search Products')

@section('content')

<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class="mx-auto max-w-2xl px-4 2xl:px-0 py-8 sm:py-12 lg:max-w-7xl">
        <div class="flex flex-col">
            <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg">
                <form action="{{ route('search') }}" method="GET">
                    <div class="relative mb-10 w-full flex  items-center justify-between rounded-md">
                        <svg class="absolute left-2 block h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" class=""></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65" class=""></line>
                        </svg>
                        <input type="text" name="query"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Search by name" value="{{ request('query') }}" />
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <div class="flex flex-col">
                            <input type="number" name="min_price" placeholder="Minimum Price"
                                value="{{ request('min_price') }}" min="0" step="10000"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:hover:text-white dark:hover:bg-gray-700" />
                        </div>

                        <div class="flex flex-col">
                            <input type="number" name="max_price" placeholder="Maximum Price"
                                value="{{ request('max_price') }}" min="0" step="10000"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:hover:text-white dark:hover:bg-gray-700" />
                        </div>

                        <div class="flex flex-col">
                            <select name="category"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category')==$category->id ? 'selected' :
                                    '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col">

                            <select id="sort_by" name="sort_by"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <option value="">Sort By</option>
                                <option value="name" {{ request('sort_by')=='name' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('sort_by')=='price' ? 'selected' : '' }}>Price</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 grid w-full grid-cols-2 justify-end space-x-4 md:flex">
                        <button type="reset"
                            class="flex items-center justify-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Reset</button>
                        <button type="submit"
                            class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Apply
                            Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <!-- Heading & Filters -->
        <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
            <div>

                <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">All Products</h2>
            </div>
        </div>
        <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">

            @forelse($products as $product)
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="h-56 w-full">
                    <a href="{{ route('product.show', $product->id) }}">
                        <img class="mx-auto hidden h-full dark:block" src="/images/{{ $product->image }}"
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
                            number_format($product->price, 0, ',', '.') }}</p>

                        <a href="{{ route('product.show', $product->id) }}"
                            class="inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-min text-nowrap">
                            See Product
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500">No products found.</p>
            @endforelse

        </div>

        {{-- paginasi flowbite --}}
        <div class="my-20 flex justify-center">
            <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px text-base h-10">


                    @if ($products->onFirstPage())
                    <li>
                        <span
                            class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white cursor-not-allowed"
                            aria-disabled="true">Previous</span>
                    </li>
                    @else
                    <li>
                        <a href="{{ $products->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                            class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    @endif

                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        @if ($i == $products->currentPage())
                        <li>
                            <span
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white cursor-not-allowed"
                                aria-current="page">{{ $i }}</span>
                        </li>
                        @else
                        <li>
                            <a href="{{ $products->url($i) . '&' . http_build_query(request()->except('page')) }}"
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{
                                $i }}</a>
                        </li>
                        @endif
                        @endfor

                        @if ($products->hasMorePages())
                        <li>
                            <a href="{{ $products->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                        </li>
                        @else
                        <li>
                            <span
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white cursor-not-allowed"
                                aria-disabled="true">Next</span>
                        </li>
                        @endif


                </ul>
            </nav>
        </div>

    </div>
</section>




@endsection