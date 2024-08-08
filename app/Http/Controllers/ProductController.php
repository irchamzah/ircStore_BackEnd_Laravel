<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('query')) {
            $query->where('name', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->filled('sort_by')) {
            $query->orderBy($request->input('sort_by'), 'asc');
        }

        $products = $query->get();

        $categories = Category::all();

        return view('products.search', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('reviews')->findOrFail($id);

        // Menghitung rata-rata rating, jika ada ulasan
        $averageRating = $product->reviews->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : 0; // Membulatkan ke satu desimal

        return view('products.show', compact('product', 'averageRating'));
    }
}
