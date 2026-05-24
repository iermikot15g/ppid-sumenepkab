<?php
// app/Http/Controllers/Admin/CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\LogsActivity;  // <-- TAMBAHKAN INI
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use LogsActivity;  // <-- TAMBAHKAN INI

    public function index()
    {
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'required|string|max:255|unique:categories',
            'sort_order' => 'nullable|integer',
        ]);

        $category = Category::create($validated);  // <-- UBAH: simpan ke variabel

        // <-- TAMBAHKAN LOG ACTIVITY
        $this->logActivity('create_category', 'Menambahkan kategori: ' . $category->name, $category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'sort_order' => 'nullable|integer',
        ]);

        $category->update($validated);

        // <-- TAMBAHKAN LOG ACTIVITY
        $this->logActivity('update_category', 'Memperbarui kategori: ' . $category->name, $category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // <-- TAMBAHKAN LOG ACTIVITY (SEBELUM DELETE)
        $this->logActivity('delete_category', 'Menghapus kategori: ' . $category->name, $category);

        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}