<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Login</h2>

    <a href="{{ url('auth/redirect') }}"
        class="bg-red-500 text-white py-2 px-4 rounded-lg w-full text-center block hover:bg-red-600">
        Login with Google
    </a>


    @if (Route::has('password.request'))
    <a href="{{ route('password.request') }}" class="block text-center text-blue-500 mt-4">
        Forgot Your Password?
    </a>
    @endif
</div>
@endsection