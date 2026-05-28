<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\LegalDocument;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilOpdController extends Controller
{
    use LogsActivity;

    // ========== CMS PROFIL OPD ==========
    public function index()
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }
        
        return view('dashboard.pembantu.profil-opd.index', compact('opd'));
    }

    public function editAbout()
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }
        
        return view('dashboard.pembantu.profil-opd.edit-about', compact('opd'));
    }

    public function updateAbout(Request $request)
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }

        $validated = $request->validate([
            'about_content' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'google_maps_link' => 'nullable|string|url',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($opd->logo) {
                Storage::disk('public')->delete($opd->logo);
            }
            $validated['logo'] = $request->file('logo')->store('opds', 'public');
        }

        $opd->update($validated);

        $this->logActivity('update_opd_about', 'Memperbarui Tentang OPD: ' . $opd->name, $opd);

        return redirect()->route('pembantu.profil-opd.index')
            ->with('success', 'Konten Tentang OPD berhasil diperbarui.');
    }

    public function editDuties()
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }
        
        return view('dashboard.pembantu.profil-opd.edit-duties', compact('opd'));
    }

    public function updateDuties(Request $request)
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }

        $validated = $request->validate([
            'duties_content' => 'nullable|string',
            'functions_content' => 'nullable|string',
        ]);

        $opd->update($validated);

        $this->logActivity('update_opd_duties', 'Memperbarui Tugas dan Fungsi OPD: ' . $opd->name, $opd);

        return redirect()->route('pembantu.profil-opd.index')
            ->with('success', 'Konten Tugas dan Fungsi berhasil diperbarui.');
    }

    public function editStructure()
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }
        
        return view('dashboard.pembantu.profil-opd.edit-structure', compact('opd'));
    }

    public function updateStructure(Request $request)
    {
        $opd = Auth::user()->opd;
        
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }

        $validated = $request->validate([
            'structure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('structure_image')) {
            if ($opd->structure_image) {
                Storage::disk('public')->delete($opd->structure_image);
            }
            $validated['structure_image'] = $request->file('structure_image')->store('opds/structure', 'public');
            $opd->update($validated);
        }

        $this->logActivity('update_opd_structure', 'Memperbarui Struktur Organisasi OPD: ' . $opd->name, $opd);

        return redirect()->route('pembantu.profil-opd.index')
            ->with('success', 'Struktur Organisasi berhasil diperbarui.');
    }
}