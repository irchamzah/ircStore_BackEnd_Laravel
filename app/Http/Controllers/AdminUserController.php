<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $users = $query->orderBy($sortBy, $sortDirection)->paginate(5);
        $roles = User::select('role')->distinct()->pluck('role');

        return view('admin.users.index', compact('users', 'roles', 'sortBy', 'sortDirection'));
    }

    public function show($id)
    {
        $user = User::with(['addresses', 'orders', 'wishlistItems', 'reviews'])->findOrFail($id);

        $totalPurchases = $user->orders->sum('total_amount');
        $lastReview = $user->reviews()->latest()->first();

        return view('admin.users.show', compact('user', 'totalPurchases', 'lastReview'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'status' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru dan ambil path-nya
            $path = $request->file('photo')->store('profile_photos', 'public');

            // Simpan path ke dalam variabel $validated
            $validated['photo'] = $path;
        }


        $user->update($validated);

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'User updated successfully.');
    }
}
