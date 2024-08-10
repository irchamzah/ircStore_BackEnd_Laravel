@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')
<section>
    <!-- Container -->
    <div class="mx-auto w-full max-w-7xl px-5 py-16 md:px-10 md:py-20">
        <!-- Title -->
        <div class="flex flex-col items-center text-center">
            <h2 class="text-3xl font-bold md:text-4xl">All Categories</h2>
            <p class="mb-8 mt-4 max-w-xl text-base text-gray-500 md:mb-12 md:text-lg lg:mb-16"></p>
        </div>
        <!-- Features Content -->
        <div class="grid gap-5 sm:grid-cols-2 md:grid-cols-3 md:gap-4 lg:gap-6">
            <!-- Features Item -->

            @foreach($categories as $category)
            <a href="{{ route('search', ['category' =>$category->id]) }}">
                <div class="grid gap-6 rounded-md border border-solid border-gray-300 p-8 md:p-10 hover:opacity-75">
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
@endsection