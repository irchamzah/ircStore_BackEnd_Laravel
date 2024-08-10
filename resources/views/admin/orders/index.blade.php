@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8 max-w-3xl">
    <div class="py-8">
        <div class="flex justify-between">
            <h2 class="text-2xl font-semibold leading-tight">Order Management</h2>
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex items-center space-x-4">
                <input type="text" name="search" placeholder="Search by Order ID or User Name"
                    value="{{ request('search') }}"
                    class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <select name="status"
                    class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status')=='processing' ? 'selected' : '' }}>Processing
                    </option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
                    <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">Search</button>
            </form>
        </div>

        <div class="mt-6">
            <table class="w-full bg-white rounded-lg shadow-lg">
                <thead>
                    <tr>
                        @php
                        $isAsc = $sortDirection === 'asc';
                        $nextSortDirection = $isAsc ? 'desc' : 'asc';
                        @endphp
                        <th class="px-4 py-2">
                            <a
                                href="{{ route('admin.orders.index', ['sort_by' => 'id', 'sort_direction' => $nextSortDirection]) }}">
                                Order ID @if($sortBy === 'id') {{ $isAsc ? '▲' : '▼' }} @endif
                            </a>
                        </th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">
                            <a
                                href="{{ route('admin.orders.index', ['sort_by' => 'total_amount', 'sort_direction' => $nextSortDirection]) }}">
                                Total @if($sortBy === 'total_amount') {{ $isAsc ? '▲' : '▼' }} @endif
                            </a>
                        </th>
                        <th class="px-4 py-2">
                            <a
                                href="{{ route('admin.orders.index', ['sort_by' => 'status', 'sort_direction' => $nextSortDirection]) }}">
                                Status @if($sortBy === 'status') {{ $isAsc ? '▲' : '▼' }} @endif
                            </a>
                        </th>
                        <th class="px-4 py-2">
                            <a
                                href="{{ route('admin.orders.index', ['sort_by' => 'created_at', 'sort_direction' => $nextSortDirection]) }}">
                                Date @if($sortBy === 'created_at') {{ $isAsc ? '▲' : '▼' }} @endif
                            </a>
                        </th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name }}</td>
                        <td class="px-4 py-2">${{ $order->total_amount }}</td>
                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">View</a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}"
                                class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Paginasi -->
            <div class="mt-20 flex justify-center">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    @if ($orders->onFirstPage())
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 border border-gray-300 cursor-not-allowed"
                        aria-disabled="true">
                        Previous
                    </span>
                    @else
                    <a href="{{ $orders->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100">
                        Previous
                    </a>
                    @endif

                    @for ($i = 1; $i <= $orders->lastPage(); $i++)
                        @if ($i == $orders->currentPage())
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 cursor-not-allowed"
                            aria-current="page">
                            {{ $i }}
                        </span>
                        @else
                        <a href="{{ $orders->url($i) . '&' . http_build_query(request()->except('page')) }}"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
                            {{ $i }}
                        </a>
                        @endif
                        @endfor

                        @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
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
    </div>
</div>
@endsection