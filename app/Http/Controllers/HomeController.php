<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();
        $categories = Category::take(3)->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
