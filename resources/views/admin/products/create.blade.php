@extends('admin.layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="container mx-auto px-6 py-8">

    <a href="{{ url()->previous() }}"
        class="inline-block mb-4 bg-gray-200 px-4 py-2 rounded-lg shadow hover:bg-gray-300">Back</a>

    <h1 class="text-3xl font-bold mb-6">Add New Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg" required>
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
            <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg" min="0" required>
            @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Stock -->
        <div class="mb-4">
            <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg" min="0" required>
            @error('stock')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" class="px-4 py-2 w-full border border-gray-300 rounded-lg"
                required>
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Featured -->
        <div class="mb-4">
            <label for="is_featured" class="block text-gray-700 text-sm font-bold mb-2">Featured</label>
            <select name="is_featured" id="is_featured" class="px-4 py-2 w-full border border-gray-300 rounded-lg"
                required>
                <option value="0" {{ old('is_featured') ? 'selected' : '' }}>Not Featured</option>
                <option value="1" {{ old('is_featured') ? 'selected' : '' }}>Featured</option>
            </select>
            @error('is_featured')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" id="description" rows="4"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
            <input type="file" name="image" id="image" class="px-4 py-2 w-full border border-gray-300 rounded-lg">
            @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>



        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Add
            Product</button>
    </form>
</div>
@endsection