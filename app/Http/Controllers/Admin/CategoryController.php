<?php
// app/Http/Controllers/Admin/CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use LogsActivity;

    // ========== KATEGORI UTAMA ==========
    public function index()
    {
        $categories = Category::with('subCategories')->orderBy('sort_order')->get();
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

        $category = Category::create($validated);

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

        $this->logActivity('update_category', 'Memperbarui kategori: ' . $category->name, $category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $this->logActivity('delete_category', 'Menghapus kategori: ' . $category->name, $category);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    // ========== SUB KATEGORI ==========
    public function subCategories(Category $category)
    {
        $subCategories = $category->subCategories()->orderBy('sort_order')->get();
        return view('admin.categories.subcategories', compact('category', 'subCategories'));
    }

    public function storeSubCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sub_categories',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        
        $subCategory = $category->subCategories()->create($validated);

        $this->logActivity('create_sub_category', 'Menambahkan sub kategori: ' . $subCategory->name . ' untuk kategori ' . $category->name, $subCategory);

        return redirect()->route('admin.categories.subcategories', $category)
            ->with('success', 'Sub Kategori berhasil ditambahkan.');
    }

    public function editSubCategory(SubCategory $subCategory)
    {
        $category = $subCategory->category;
        return view('admin.categories.edit-subcategory', compact('subCategory', 'category'));
    }

    public function updateSubCategory(Request $request, SubCategory $subCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sub_categories,slug,' . $subCategory->id,
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        
        $subCategory->update($validated);

        $this->logActivity('update_sub_category', 'Memperbarui sub kategori: ' . $subCategory->name, $subCategory);

        return redirect()->route('admin.categories.subcategories', $subCategory->category_id)
            ->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    public function destroySubCategory(SubCategory $subCategory)
    {
        $categoryId = $subCategory->category_id;
        
        $this->logActivity('delete_sub_category', 'Menghapus sub kategori: ' . $subCategory->name, $subCategory);
        
        $subCategory->delete();

        return redirect()->route('admin.categories.subcategories', $categoryId)
            ->with('success', 'Sub Kategori berhasil dihapus.');
    }
}