<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)->take(4)->with('reviews')->get();
        $categories = Category::take(4)->get();

        // Menghitung rata-rata rating untuk setiap produk
        foreach ($featuredProducts as $product) {
            $product->averageRating = $product->reviews->avg('rating') ?? 0;
            $product->reviewsCount = $product->reviews->count();
        }

        return view('home', compact('featuredProducts', 'categories'));
    }
}
