<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->get();
        return view('account.orders', compact('orders'));
    }

    public function wishlist()
    {
        $wishlist = Auth::user()->wishlist()->get();
        return view('account.wishlist', compact('wishlist'));
    }
}
