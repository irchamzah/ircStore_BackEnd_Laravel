@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg shadow mb-6">
        {{ session('success') }}
    </div>
    @endif

    <h1 class="text-2xl font-semibold mb-6">User Details</h1>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">User Information</h2>
        @if ($user->photo)
        <div class="mb-2">
            <img src="{{ Storage::url($user->photo) }}" alt="Profile Photo" class="w-32 h-32 rounded-full">
        </div>
        @endif
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
        <p><strong>Phone:</strong> {{ $user->phone_number ?? 'N/A' }}</p>
        <p><strong>Date of Birth:</strong> {{ $user->date_of_birth ?
            \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') : 'N/A' }}</p>
        </p>
        <p><strong>Status:</strong> {{ $user->status }}</p>

        <a href="{{ route('account.profile.edit', $user->id) }}"
            class="inline-block mt-4 bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600">
            Edit User
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Addresses</h2>

        @if($user->addresses->isNotEmpty())
        <ul>
            @foreach($user->addresses as $address)
            <li class="mb-4">
                <p><strong>Address:</strong> {{ $address->full_address }}</p>
                <p><strong>City:</strong> {{ $address->city }}</p>
                <p><strong>State:</strong> {{ $address->state }}</p>
                <p><strong>Postal Code:</strong> {{ $address->postal_code }}</p>
                <p><strong>Country:</strong> {{ $address->country }}</p>
                @if($address->isPrimary())
                <span class="text-green-500">Primary Address</span>
                @endif
                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this address?');"
                        class="inline-block mt-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600">Delete</button>
                </form>
                <a href="{{ route('addresses.edit', $address->id) }}"
                    class="inline-block mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Edit</a>

            </li>
            @endforeach
        </ul>
        @else
        <p>No addresses available.</p>
        @endif

        <h2 class="text-xl font-semibold mt-6 mb-4">Add Address</h2>
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="full_address" class="block text-gray-700">Full Address</label>
                <input type="text" name="full_address" id="full_address"
                    class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800" required>
                @error('full_address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700">City</label>
                <input type="text" name="city" id="city"
                    class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800" required>
                @error('city')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="state" class="block text-gray-700">State</label>
                <input type="text" name="state" id="state"
                    class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800" required>
                @error('state')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="postal_code" class="block text-gray-700">Postal Code</label>
                <input type="text" name="postal_code" id="postal_code"
                    class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800" required>
                @error('postal_code')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="country" class="block text-gray-700">Country</label>
                <input type="text" name="country" id="country"
                    class="w-full px-4 py-2 border rounded-md bg-gray-200 text-gray-800" required>
                @error('country')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="is_primary" class="inline-flex items-center">
                    <input type="checkbox" name="is_primary" id="is_primary" class="form-checkbox" value="1">
                    @error('is_primary')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <span class="ml-2">Set as Primary Address</span>
                </label>
            </div>
            <button type="submit"
                class="w-full px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Add Address</button>
        </form>
    </div>


    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
        <p><strong>Total Orders:</strong> {{ $user->orders->count() }}</p>
        <p><strong>Total Purchases:</strong> ${{ number_format($totalPurchases, 2) }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Wishlist</h2>
        <p><strong>Total Wishlist Items:</strong> {{ $user->wishlistItems->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
        @if($user->reviews->isNotEmpty())
        <p><strong>Last Review:</strong> {{ $lastReview->content ?? 'No reviews yet.' }}</p>
        @else
        <p>No recent activity.</p>
        @endif
    </div>
</div>
@endsection