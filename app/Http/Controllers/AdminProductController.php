<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id'); // Default sorting by name
        $sortDirection = $request->get('sort_direction', 'asc'); // Default sorting direction is ascending
        $search = $request->get('search'); // Get the search query
        $category = $request->get('category'); // Get the selected category

        // Ambil produk dengan sorting dan pencarian yang diinginkan
        $query = Product::with('category');

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($category) {
            $query->where('category_id', $category);
        }

        $products = $query->orderBy($sortBy, $sortDirection)
            ->paginate(10); // Sesuaikan jumlah pagination jika diperlukan

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories', 'sortBy', 'sortDirection'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Membuat instance baru dari model Product
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->is_featured = $request->is_featured;
        $product->description = $request->description;

        // Menangani upload gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $product->image = $imageName;
        }

        // Menyimpan produk ke database
        $product->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Update product details
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->is_featured = $request->is_featured;
        $product->description = $request->description;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus foto sebelumnya jika ada
            if ($product->image && file_exists(public_path('images/products' . $product->image))) {
                unlink(public_path('images/products' . $product->image));
            }

            // Upload foto baru
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $product->image = $imageName;
        }

        // Save the updated product
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        if ($product->image) {
            unlink(public_path('images/products' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
