@extends('admin.layouts.admin')

@section('title', 'Categories')

@section('content')

<!-- Search Form -->
<form action="{{ route('admin.categories.index') }}" method="GET" class="mb-4 flex items-center space-x-4">
    <input type="text" name="search" placeholder="Search by name or description..." value="{{ request('search') }}"
        class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">Search</button>
</form>

<a href="{{ route('admin.categories.create') }}"
    class="inline-block mb-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
    Add New Category
</a>

<table class="w-full bg-white rounded-lg shadow-lg">
    <thead>
        <tr class="text-left">
            @php
            $isAsc = $sortDirection === 'asc';
            $nextSortDirection = $isAsc ? 'desc' : 'asc';
            @endphp
            <th class="px-4 py-2 ">
                <a
                    href="{{ route('admin.categories.index', ['sort_by' => 'id', 'sort_direction' => $nextSortDirection]) }}">
                    No @if($sortBy === 'id') {{ $isAsc ? '▲' : '▼' }} @endif
                </a>
            </th>
            <th class="px-4 py-2">
                <a
                    href="{{ route('admin.categories.index', ['sort_by' => 'name', 'sort_direction' => $nextSortDirection]) }}">
                    Name @if($sortBy === 'name') {{ $isAsc ? '▲' : '▼' }} @endif
                </a>
            </th>
            <th class="px-4 py-2">
                <a
                    href="{{ route('admin.categories.index', ['sort_by' => 'description', 'sort_direction' => $nextSortDirection]) }}">
                    Description @if($sortBy === 'description') {{ $isAsc ? '▲' : '▼' }} @endif
                </a>
            </th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $index => $category)
        <tr>
            <td class="border px-4 py-2">{{ $categories->firstItem() + $index }}</td>
            <td class="border px-4 py-2">{{ $category->name }}</td>
            <td class="border px-4 py-2">{{ $category->description }}</td>
            <td class="border px-4 py-2">
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                    class="text-blue-500 hover:underline">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline"
                        onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $categories->links() }}
</div>

@endsection