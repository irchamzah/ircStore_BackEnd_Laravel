@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Product Categories</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($categories as $category)
        <div class="category-card bg-white p-6 rounded-lg shadow-lg">
            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-48 object-cover mb-4 rounded">
            <h2 class="text-xl font-semibold text-gray-800">{{ $category->name }}</h2>
            <p class="text-gray-600 mt-2">{{ $category->description }}</p>
            <a href="{{ route('search', ['category' =>$category->id]) }}"
                class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                Explore Products
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection