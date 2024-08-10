<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->input('rating'),
            'review' => $request->input('review'),
        ]);

        OrderItem::where('order_id', $request->input('order_id'))
            ->where('product_id', $productId)
            ->update(['is_reviewed' => true]);

        return back()->with('success', 'Review added successfully.');
    }

    public function index()
    {
        $reviews = Review::with('user', 'product')->get();

        return view('reviews.index', compact('reviews'));
    }
}
