<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id'); // Default sorting by name
        $sortDirection = $request->get('sort_direction', 'desc'); // Default sorting direction is ascending
        $search = $request->get('search'); // Get the search query

        // Ambil kategori dengan sorting dan pencarian yang diinginkan
        $query = Category::query();

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->orderBy($sortBy, $sortDirection)
            ->paginate(10); // Sesuaikan jumlah pagination jika diperlukan

        return view('admin.categories.index', compact('categories', 'sortBy', 'sortDirection'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Membuat instance baru dari model Category
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        // Menangani upload gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
            $category->image = $imageName;
        }

        // Menyimpan kategori ke database
        $category->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update category details
        $category->name = $request->name;
        $category->description = $request->description;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus foto sebelumnya jika ada
            if ($category->image && file_exists(public_path('images/categories/' . $category->image))) {
                unlink(public_path('images/categories/' . $category->image));
            }

            // Upload foto baru
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
            $category->image = $imageName;
        }

        // Save the updated category
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            unlink(public_path('images/categories/' . $category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
