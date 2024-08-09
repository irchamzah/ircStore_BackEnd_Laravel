@extends('admin.layouts.admin')

@section('title', 'Edit Category')

@section('content')

<a href="{{ url()->previous() }}"
    class="inline-block mb-4 bg-gray-200 px-4 py-2 rounded-lg shadow hover:bg-gray-300">Back</a>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold">Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded-lg px-4 py-2"
                value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold">Description</label>
            <textarea name="description" id="description"
                class="w-full border rounded-lg px-4 py-2">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-bold">Image</label>
            <input type="file" name="image" id="image" class="w-full border rounded-lg px-4 py-2">
            @if($category->image)
            <div class="mt-2">
                <img src="{{ asset('images/categories/' . $category->image) }}" alt="{{ $category->name }}"
                    class="w-16 h-16 rounded">
            </div>
            @endif
        </div>
        <div class="mb-4">
            <button type="submit"
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600">Update
                Category</button>
        </div>
    </form>
</div>
@endsection