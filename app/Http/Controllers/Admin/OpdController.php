<?php
// app/Http/Controllers/Admin/OpdController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Traits\LogsActivity;  // <-- TAMBAHKAN INI (baris 7)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpdController extends Controller
{
    use LogsActivity;  // <-- TAMBAHKAN INI (baris 12)

    public function index()
    {
        $opds = Opd::withCount('documents')->latest()->paginate(10);
        return view('admin.opds.index', compact('opds'));
    }

    public function create()
    {
        return view('admin.opds.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:opds',
            'short_name' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'ppid_name' => 'nullable|string|max:255',
            'ppid_phone' => 'nullable|string|max:20',
            'vision_mission' => 'nullable|string',
            'duties' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('opds', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $opd = Opd::create($validated);  // <-- UBAH: simpan ke variabel $opd

        // <-- TAMBAHKAN LOG ACTIVITY (baris 56-60)
        $this->logActivity('create_opd', 'Menambahkan OPD: ' . $opd->name, $opd);

        return redirect()->route('admin.opds.index')
            ->with('success', 'OPD berhasil ditambahkan.');
    }

    public function edit(Opd $opd)
    {
        return view('admin.opds.edit', compact('opd'));
    }

    public function update(Request $request, Opd $opd)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:opds,name,' . $opd->id,
            'short_name' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'ppid_name' => 'nullable|string|max:255',
            'ppid_phone' => 'nullable|string|max:20',
            'vision_mission' => 'nullable|string',
            'duties' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($opd->logo) {
                Storage::disk('public')->delete($opd->logo);
            }
            $validated['logo'] = $request->file('logo')->store('opds', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $opd->update($validated);

        // <-- TAMBAHKAN LOG ACTIVITY (baris 93-95)
        $this->logActivity('update_opd', 'Memperbarui OPD: ' . $opd->name, $opd);

        return redirect()->route('admin.opds.index')
            ->with('success', 'OPD berhasil diperbarui.');
    }

    public function destroy(Opd $opd)
    {
        // <-- TAMBAHKAN LOG ACTIVITY (baris 102-104) - SEBELUM DELETE
        $this->logActivity('delete_opd', 'Menghapus OPD: ' . $opd->name, $opd);

        if ($opd->logo) {
            Storage::disk('public')->delete($opd->logo);
        }
        
        $opd->delete();

        return redirect()->route('admin.opds.index')
            ->with('success', 'OPD berhasil dihapus.');
    }

    public function toggleActive(Opd $opd)
    {
        $oldStatus = $opd->is_active ? 'Aktif' : 'Tidak Aktif';
        $newStatus = !$opd->is_active ? 'Aktif' : 'Tidak Aktif';
        
        $opd->update(['is_active' => !$opd->is_active]);
        
        // <-- TAMBAHKAN LOG ACTIVITY (baris 119-121)
        $this->logActivity('toggle_opd_status', 'Mengubah status OPD ' . $opd->name . ' dari ' . $oldStatus . ' menjadi ' . $newStatus, $opd);
        
        return response()->json([
            'success' => true,
            'is_active' => $opd->is_active
        ]);
    }
}