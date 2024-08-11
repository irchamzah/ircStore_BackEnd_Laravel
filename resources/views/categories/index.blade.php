@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')

<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-16 min-h-[600px]">

    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">All Categories</h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">


            @foreach($categories as $category)
            <a href="{{ route('search', ['category' =>$category->id]) }}"
                class="flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img src="/images/categories/{{ $category->image }}"
                    class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-white" width="24" height="24" />
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
            </a>
            @endforeach



        </div>
    </div>
</section>

@endsection