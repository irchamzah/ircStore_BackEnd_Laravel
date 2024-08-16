@extends('layouts.app')

@section('title', 'Product Reviews')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Product Reviews</h1>

    @foreach($reviews as $review)
    <div class="mb-4 bg-white p-4 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="mr-4">
                <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full">
            </div>
            <div>
                <h4 class="text-lg font-semibold">{{ $review->user->name }}</h4>
                <div class="text-yellow-400">
                    @for ($i = 0; $i < $review->rating; $i++)
                        ★
                        @endfor
                        @for ($i = $review->rating; $i < 5; $i++) ☆ @endfor </div>
                </div>
            </div>
            <p class="mt-4 text-gray-600">{{ $review->review }}</p>
            <small class="text-gray-500">Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
        </div>
        @endforeach
    </div>
    @endsection