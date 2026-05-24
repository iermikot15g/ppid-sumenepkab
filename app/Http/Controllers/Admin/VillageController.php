<?php
// app/Http/Controllers/Admin/VillageController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Traits\LogsActivity;  // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageController extends Controller
{
    use LogsActivity;  // <-- TAMBAHKAN INI

    public function index()
    {
        $villages = Village::latest()->paginate(10);
        return view('admin.villages.index', compact('villages'));
    }

    public function create()
    {
        return view('admin.villages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:villages',
            'head_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('villages', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $village = Village::create($validated);  // <-- UBAH: simpan ke variabel

        // <-- TAMBAHKAN LOG ACTIVITY
        $this->logActivity('create_village', 'Menambahkan desa: ' . $village->name, $village);

        return redirect()->route('admin.villages.index')
            ->with('success', 'Desa berhasil ditambahkan.');
    }

    public function edit(Village $village)
    {
        return view('admin.villages.edit', compact('village'));
    }

    public function update(Request $request, Village $village)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:villages,name,' . $village->id,
            'head_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($village->logo) {
                Storage::disk('public')->delete($village->logo);
            }
            $validated['logo'] = $request->file('logo')->store('villages', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $village->update($validated);

        // <-- TAMBAHKAN LOG ACTIVITY
        $this->logActivity('update_village', 'Memperbarui desa: ' . $village->name, $village);

        return redirect()->route('admin.villages.index')
            ->with('success', 'Desa berhasil diperbarui.');
    }

    public function destroy(Village $village)
    {
        // <-- TAMBAHKAN LOG ACTIVITY (SEBELUM DELETE)
        $this->logActivity('delete_village', 'Menghapus desa: ' . $village->name, $village);

        if ($village->logo) {
            Storage::disk('public')->delete($village->logo);
        }
        
        $village->delete();

        return redirect()->route('admin.villages.index')
            ->with('success', 'Desa berhasil dihapus.');
    }
}