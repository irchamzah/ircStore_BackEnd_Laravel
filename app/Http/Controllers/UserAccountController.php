<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserAccountController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders;
        return view('account.orders', compact('orders'));
    }

    public function wishlist()
    {
        $user = Auth::user();
        $wishlist = $user->wishlist;
        return view('account.wishlist', compact('wishlist'));
    }


    public function edit()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'status' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $auth = Auth::user();

        $user = User::find($auth->id);
        $data = $request->only(['name', 'email', 'phone_number', 'date_of_birth', 'status']);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $path = $request->file('photo')->store('profile_photos');
            $data['photo'] = $path;
        }

        $user->update($data);

        return redirect()->route('account.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
