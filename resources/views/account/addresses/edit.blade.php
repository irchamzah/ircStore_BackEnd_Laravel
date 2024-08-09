@extends('layouts.app')

@section('title', 'Edit Address')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <a href="{{ route('account.profile') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 ">
            Kembali
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Address</h1>

    <form action="{{ route('addresses.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="full_address" class="block text-sm font-medium text-gray-700">Full Address</label>
            <input type="text" name="full_address" id="full_address"
                value="{{ old('full_address', $address->full_address) }}"
                class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800">
            @error('full_address')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" name="city" id="city" value="{{ old('city', $address->city) }}"
                class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800">
            @error('city')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="state" class="block text-sm font-medium text-gray-700">State</label>
            <input type="text" name="state" id="state" value="{{ old('state', $address->state) }}"
                class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800">
            @error('state')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code"
                value="{{ old('postal_code', $address->postal_code) }}"
                class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800">
            @error('postal_code')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <input type="text" name="country" id="country" value="{{ old('country', $address->country) }}"
                class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800">
            @error('country')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="is_primary" class="inline-flex items-center">
                <input type="checkbox" name="is_primary" id="is_primary" value="1" {{ $address->is_primary ? 'checked' :
                '' }}>
                <span class="ml-2 text-gray-700">Set as Primary Address</span>
            </label>
            @error('is_primary')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Update
            Address</button>
    </form>
</div>
@endsection