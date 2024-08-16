@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-6">User Management</h1>

    <!-- Search and Filter Form -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4 flex flex-wrap items-center space-x-4">
        <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}"
            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <select name="role"
            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Roles</option>
            @foreach($roles as $role)
            <option value="{{ $role }}" {{ request('role')==$role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
            @endforeach
        </select>

        <div class="flex items-center space-x-2">
            <label for="start_date" class="text-gray-600">From:</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-center space-x-2">
            <label for="end_date" class="text-gray-600">To:</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">Search</button>

        <a href="{{ route('admin.users.export') }}"
            class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600">
            Export Users to Excel
        </a>
    </form>




    <table class="w-full bg-white rounded-lg shadow-lg">
        <thead>
            <tr class="text-left">
                @php
                $isAsc = $sortDirection === 'asc';
                $nextSortDirection = $isAsc ? 'desc' : 'asc';
                @endphp
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.users.index', ['sort_by' => 'id', 'sort_direction' => $nextSortDirection]) }}">
                        No @if($sortBy === 'id') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.users.index', ['sort_by' => 'name', 'sort_direction' => $nextSortDirection]) }}">
                        Name @if($sortBy === 'name') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.users.index', ['sort_by' => 'email', 'sort_direction' => $nextSortDirection]) }}">
                        Email @if($sortBy === 'email') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.users.index', ['sort_by' => 'role', 'sort_direction' => $nextSortDirection]) }}">
                        Role @if($sortBy === 'role') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">
                    <a
                        href="{{ route('admin.users.index', ['sort_by' => 'created_at', 'sort_direction' => $nextSortDirection]) }}">
                        Registered At @if($sortBy === 'created_at') {{ $isAsc ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td class="border px-4 py-2">{{ $users->firstItem() + $index }}</td>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">{{ ucfirst($user->role) }}</td>
                <td class="border px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.users.show', $user->id) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                        View Details
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginasi -->
    <div class="mt-20 flex justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            @if ($users->onFirstPage())
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-not-allowed"
                aria-disabled="true">
                Previous
            </span>
            @else
            <a href="{{ $users->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100">
                Previous
            </a>
            @endif

            @for ($i = 1; $i <= $users->lastPage(); $i++)
                @if ($i == $users->currentPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 cursor-not-allowed"
                    aria-current="page">
                    {{ $i }}
                </span>
                @else
                <a href="{{ $users->url($i) . '&' . http_build_query(request()->except('page')) }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
                    {{ $i }}
                </a>
                @endif
                @endfor

                @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
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