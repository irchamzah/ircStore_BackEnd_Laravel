@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <a href="{{ route('admin.users.index') }}"
        class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 mb-6">
        Back to User List
    </a>

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

        <a href="{{ route('admin.users.edit', $user->id) }}"
            class="inline-block mt-4 bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600">
            Edit User
        </a>

        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
            onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-block mt-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600">
                Delete User
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Addresses</h2>
        @if($user->addresses->isNotEmpty())
        <ul>
            @foreach($user->addresses as $address)
            <li>
                @if($address->isPrimary())
                <h3>
                    <strong>
                        <span class="text-green-500 text-lg">Primary Address</span>
                    </strong>
                </h3>
                @endif
                <p><strong>Address:</strong> {{ $address->full_address }}</p>
                <p><strong>City:</strong> {{ $address->city }}</p>
                <p><strong>State:</strong> {{ $address->state }}</p>
                <p><strong>Postal Code:</strong> {{ $address->postal_code }}</p>
                <p><strong>Country:</strong> {{ $address->country }}</p>
            </li>
            @endforeach
        </ul>
        @else
        <p>No addresses available.</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
        <p><strong>Total Orders:</strong> {{ $user->orders->count() }}</p>
        <p><strong>Total Purchases:</strong> Rp.{{ number_format($user->totalPurchases(), 0, ',', '.') }}</p>
    </div>

    {{-- <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
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
    </div> --}}

</div>
@endsection