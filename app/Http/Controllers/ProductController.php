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
        $product = Product::with(['reviews' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(5); // Ambil 5 review pertama
        }])->findOrFail($id);

        // Menghitung rata-rata rating, jika ada ulasan
        $averageRating = $product->reviews->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : 0; // Membulatkan ke satu desimal

        // Ambil total review untuk pagination
        $totalReviews = $product->reviews()->count();

        return view('products.show', compact('product', 'averageRating', 'totalReviews'));
    }

    public function reviews($id)
    {
        $page = request()->query('page', 1);
        $perPage = 5;
        $skip = ($page - 1) * $perPage;

        $product = Product::findOrFail($id);
        $reviews = $product->reviews()
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($perPage)
            ->get();

        return response()->json([
            'reviews' => $reviews->map(function ($review) {
                return [
                    'rating' => $review->rating,
                    'user_name' => $review->user->name,
                    'review' => $review->review,
                    'created_at' => $review->created_at->format('M d, Y'),
                ];
            }),
        ]);
    }
}
