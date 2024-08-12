@extends('admin.layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold mb-6">Manage Products</h1>

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg shadow mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Search Form -->
    <form action="{{ route('admin.products.index') }}" method="GET" class="mb-4 flex items-center space-x-4">
        <input type="text" name="search" placeholder="Search by name or description..." value="{{ request('search') }}"
            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <select name="category"
            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Categories</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category')==$category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <button type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">Search</button>
    </form>

    <a href="{{ route('admin.products.create') }}"
        class="inline-block mb-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
        Add New Product
    </a>

    <table class="w-full bg-white rounded-lg shadow-lg">
        <thead>
            <tr>
                @php
                $isAsc = $sortDirection === 'asc';
                $nextSortDirection = $isAsc ? 'desc' : 'asc';
                @endphp
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.products.index', ['sort_by' => 'id', 'sort_direction' => $nextSortDirection]) }}">
                        No @if($sortBy === 'id') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.products.index', ['sort_by' => 'name', 'sort_direction' => $nextSortDirection]) }}">
                        Product's Name @if($sortBy === 'name') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.products.index', ['sort_by' => 'category_id', 'sort_direction' => $nextSortDirection]) }}">
                        Category @if($sortBy === 'category_id') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.products.index', ['sort_by' => 'price', 'sort_direction' => $nextSortDirection]) }}">
                        Price @if($sortBy === 'price') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.products.index', ['sort_by' => 'stock', 'sort_direction' => $nextSortDirection]) }}">
                        Stock @if($sortBy === 'stock') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.products.index', ['sort_by' => 'is_featured', 'sort_direction' => $nextSortDirection]) }}">
                        Featured @if($sortBy === 'is_featured') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr class="text-center">
                <td class="px-4 py-2">{{ $products->firstItem() + $index }}</td>
                <td class="px-4 py-2">
                    <img src="/images/products/{{ $product->image }}" alt="{{ $product->name }}"
                        class="w-16 h-16 rounded mx-auto">
                </td>
                <td class="px-4 py-2">{{ $product->name }}</td>
                <td class="px-4 py-2">{{ $product->category->name }}</td>
                <td class="px-4 py-2">Rp.{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $product->stock }}</td>
                <td class="px-4 py-2">
                    @if($product->is_featured)
                    <span class="text-green-500">Featured</span>
                    @else
                    <span class="text-red-500">Not Featured</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600"
                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


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
@endsection