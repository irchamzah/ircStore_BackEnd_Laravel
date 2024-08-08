@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Profile</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-gray-800"><strong>Name:</strong> {{ $user->name }}</p>
        <p class="text-gray-800"><strong>Email:</strong> {{ $user->email }}</p>
        <!-- Add more profile details here -->
    </div>
</div>
@endsection