@extends('admin.layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="container mx-auto px-6 py-8">
    <a href="{{ url()->previous() }}"
        class="inline-block mb-4 bg-gray-200 px-4 py-2 rounded-lg shadow hover:bg-gray-300">Back</a>
    <h1 class="text-3xl font-bold mb-6">Edit Product</h1>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg" required>
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg" min="0" required>
            @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Stock -->
        <div class="mb-4">
            <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg" min="0" required>
            @error('stock')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" class="px-4 py-2 w-full border border-gray-300 rounded-lg"
                required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
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
                <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>Not Featured</option>
                <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Featured</option>
            </select>
            @error('is_featured')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" id="description" rows="4"
                class="px-4 py-2 w-full border border-gray-300 rounded-lg">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
            <input type="file" name="image" id="image" class="px-4 py-2 w-full border border-gray-300 rounded-lg">
            @if($product->image)
            <div class="mt-2">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                    class="w-32 h-32 object-cover rounded">
            </div>
            @endif
            @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Update
                Product</button>
        </div>
    </form>
</div>
@endsection