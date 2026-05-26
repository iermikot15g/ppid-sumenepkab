<?php
// app/Http/Controllers/Dashboard/Pembantu/ProfilOpdController.php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\LegalDocument; // akan dibuat nanti
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilOpdController extends Controller
{
    use LogsActivity;

    public function edit()
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }
        
        return view('dashboard.pembantu.profil-opd.edit', compact('opd'));
    }

    public function update(Request $request)
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }

        $validated = $request->validate([
            // Visi Misi
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            
            // Tentang OPD
            'about' => 'nullable|string',
            'address' => 'nullable|string',
            'google_maps_link' => 'nullable|string|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'structure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // <-- TAMBAHKAN
            
            // Tugas dan Fungsi
            'duties' => 'nullable|string',      // Tugas
            'functions' => 'nullable|string',   // Fungsi
            
            // Kontak PPID
            'ppid_name' => 'nullable|string|max:255',
            'ppid_phone' => 'nullable|string|max:20',
            
            // Logo
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($opd->logo) {
                Storage::disk('public')->delete($opd->logo);
            }
            $validated['logo'] = $request->file('logo')->store('opds', 'public');
        }

        // Upload Struktur Organisasi
        if ($request->hasFile('structure_image')) {
            if ($opd->structure_image) {
                Storage::disk('public')->delete($opd->structure_image);
            }
            $validated['structure_image'] = $request->file('structure_image')->store('opds/structure', 'public');
        }

        $opd->update($validated);

        $this->logActivity('update_opd_profile', 'Memperbarui profil OPD: ' . $opd->name, $opd);

        return redirect()->route('pembantu.profil-opd.edit')
            ->with('success', 'Profil OPD berhasil diperbarui.');
    }
}