@extends('layouts.app')

@section('title', 'Search Products')

@section('content')

<div class="bg-white">

    <div class="mx-auto max-w-2xl px-4 pt-16 sm:px-6 sm:pt-24 lg:max-w-7xl lg:px-8">

        <div class="flex flex-col">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
                <form class="" action="{{ route('search') }}" method="GET">
                    <div class="relative mb-10 w-full flex  items-center justify-between rounded-md">
                        <svg class="absolute left-2 block h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" class=""></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65" class=""></line>
                        </svg>
                        <input type="text" name="query"
                            class="h-12 w-full cursor-text rounded-md border border-gray-100 bg-gray-100 py-4 pr-40 pl-12 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            placeholder="Search by name" value="{{ request('query') }}" />
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <div class="flex flex-col">
                            <label for="min_price" class="text-sm font-medium text-stone-600">Min Price</label>
                            <input type="number" name="min_price" placeholder="Minimum Price"
                                value="{{ request('min_price') }}" min="0" step="10000"
                                class="mt-2 block w-full rounded-md border border-gray-100 bg-gray-100 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        </div>

                        <div class="flex flex-col">
                            <label for="max_price" class="text-sm font-medium text-stone-600">Max Price</label>
                            <input type="number" name="max_price" placeholder="Maximum Price"
                                value="{{ request('max_price') }}" min="0" step="10000"
                                class="mt-2 block w-full rounded-md border border-gray-100 bg-gray-100 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        </div>

                        <div class="flex flex-col">
                            <label for="manufacturer" class="text-sm font-medium text-stone-600">Categories</label>

                            <select name="category"
                                class="mt-2 block w-full rounded-md border border-gray-100 bg-gray-100 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category')==$category->id ? 'selected' :
                                    '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label for="sort_by" class="text-sm font-medium text-stone-600">Sort By</label>

                            <select id="sort_by" name="sort_by"
                                class="mt-2 block w-full cursor-pointer rounded-md border border-gray-100 bg-gray-100 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Sort By</option>
                                <option value="name" {{ request('sort_by')=='name' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('sort_by')=='price' ? 'selected' : '' }}>Price</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 grid w-full grid-cols-2 justify-end space-x-4 md:flex">
                        <button type="reset"
                            class="rounded-lg bg-gray-200 px-8 py-2 font-medium text-gray-700 outline-none hover:opacity-80 focus:ring">Reset</button>
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-8 py-2 font-medium text-white outline-none hover:opacity-80 focus:ring">Apply
                            Filters</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">

        <div class="flex flex-col items-center text-center">
            <h2 class="text-3xl font-bold md:text-4xl">All Products</h2>
            <p class="mb-8 mt-4 max-w-xl text-base text-gray-500 md:mb-12 md:text-lg lg:mb-16"></p>
        </div>

        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">

            @forelse ($products as $product)
            <a href="{{ route('product.show', $product->id) }}" class="group">
                <div
                    class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                    <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                        class="h-full w-full object-cover object-center group-hover:opacity-75">
                </div>
                <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                <p class="mt-1 text-lg font-medium text-gray-900">Rp.{{ number_format($product->price, 2) }}</p>
            </a>
            @empty
            <p class="text-gray-500">No products found.</p>
            @endforelse



        </div>

        <!-- Paginasi -->
        <div class="mt-20 flex justify-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                @if ($products->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-not-allowed"
                    aria-disabled="true">
                    Previous
                </span>
                @else
                <a href="{{ $products->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100">
                    Previous
                </a>
                @endif

                @for ($i = 1; $i <= $products->lastPage(); $i++)
                    @if ($i == $products->currentPage())
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 cursor-not-allowed"
                        aria-current="page">
                        {{ $i }}
                    </span>
                    @else
                    <a href="{{ $products->url($i) . '&' . http_build_query(request()->except('page')) }}"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
                        {{ $i }}
                    </a>
                    @endif
                    @endfor

                    @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100">
                        Next
                    </a>
                    @else
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-not-allowed"
                        aria-disabled="true">
                        Next
                    </span>
                    @endif
            </nav>
        </div>

    </div>


</div>





@endsection