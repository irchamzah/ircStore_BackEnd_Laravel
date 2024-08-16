@extends('admin.layouts.admin')

@section('title', 'Add New Category')

@section('content')

<a href="{{ url()->previous() }}"
    class="inline-block mb-4 bg-gray-200 px-4 py-2 rounded-lg shadow hover:bg-gray-300">Back</a>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold">Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded-lg px-4 py-2"
                value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold">Description</label>
            <textarea name="description" id="description"
                class="w-full border rounded-lg px-4 py-2">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-bold">Image</label>
            <input type="file" name="image" id="image" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Save
                Category</button>
        </div>
    </form>
</div>
@endsection