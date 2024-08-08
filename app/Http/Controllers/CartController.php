<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add($id)
    {
        $product = Product::findOrFail($id);

        Cart::add($product->id, $product->name, 1, $product->price);

        return redirect()->route('product.show', $id)->with('success', 'Product added to cart!');
    }
}
