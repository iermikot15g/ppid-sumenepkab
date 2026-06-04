<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CmsProfilOpdController extends Controller
{
    use LogsActivity;

    private function getOpd()
    {
        $opd = Auth::user()->opd;
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }
        return $opd;
    }

    public function index()
    {
        $opd = $this->getOpd();
        return view('dashboard.pembantu.cms.profil.index', compact('opd'));
    }

    // ========== MEDIA SOSIAL ==========
    public function editMediaSosial()
    {
        $opd = $this->getOpd();
        $socialMedia = $opd->getSocialMediaLinks();
        
        return view('dashboard.pembantu.cms.profil.media-sosial', compact('opd', 'socialMedia'));
    }

    public function updateMediaSosial(Request $request)
    {
        $opd = $this->getOpd();

        $validated = $request->validate([
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|url|max:255',
        ]);

        $socialMedia = array_filter($validated, function($value) {
            return !empty($value);
        });

        $opd->update([
            'social_media' => $socialMedia
        ]);

        return redirect()->route('pembantu.cms.profil.media-sosial')
            ->with('success', 'Media sosial berhasil diperbarui.');
    }

    // ========== TENTANG OPD ==========
    public function editTentang()
    {
        $opd = $this->getOpd();
        return view('dashboard.pembantu.cms.profil.tentang', compact('opd'));
    }

public function updateTentang(Request $request)
{
    $opd = Auth::user()->opd;
    
    $validated = $request->validate([
        'tentang_content' => 'nullable|string',
        'vision_mission' => 'nullable|string',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'google_maps_link' => 'nullable|url',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'tentang_pdf' => 'nullable|file|mimes:pdf|max:5120',  // TAMBAHKAN
    ]);
    
    // Handle logo upload
    if ($request->hasFile('logo')) {
        if ($opd->logo && Storage::disk('public')->exists($opd->logo)) {
            Storage::disk('public')->delete($opd->logo);
        }
        $logoPath = $request->file('logo')->store('opds', 'public');
        $validated['logo'] = $logoPath;
    }
    
    // Handle PDF upload
    if ($request->hasFile('tentang_pdf')) {
        if ($opd->tentang_pdf && Storage::disk('public')->exists($opd->tentang_pdf)) {
            Storage::disk('public')->delete($opd->tentang_pdf);
        }
        $validated['tentang_pdf'] = $request->file('tentang_pdf')->store('opds/tentang', 'public');
    }
    
    $opd->update($validated);
    
    return redirect()->route('pembantu.cms.profil.index')
        ->with('success', 'Profil OPD berhasil diperbarui.');
}

    // ========== TUGAS DAN FUNGSI ==========
    public function editTugasFungsi()
    {
        $opd = $this->getOpd();
        return view('dashboard.pembantu.cms.profil.tugas-fungsi', compact('opd'));
    }

    /**
     * PERBAIKAN: Menggunakan kolom 'tugas_fungsi_content' dan 'tugas_fungsi_pdf'
     */
    public function updateTugasFungsi(Request $request)
    {
        $opd = $this->getOpd();

        $validated = $request->validate([
            'tugas_fungsi_content' => 'nullable|string',  // PERBAIKAN
            'tugas_fungsi_pdf' => 'nullable|file|mimes:pdf|max:5120',  // PERBAIKAN
        ]);

        $data = ['tugas_fungsi_content' => $validated['tugas_fungsi_content']];  // PERBAIKAN

        if ($request->hasFile('tugas_fungsi_pdf')) {  // PERBAIKAN
            if ($opd->tugas_fungsi_pdf && Storage::disk('public')->exists($opd->tugas_fungsi_pdf)) {  // PERBAIKAN
                Storage::disk('public')->delete($opd->tugas_fungsi_pdf);
            }
            $data['tugas_fungsi_pdf'] = $request->file('tugas_fungsi_pdf')->store('opds/tugas-fungsi', 'public');  // PERBAIKAN
        }

        $opd->update($data);

        return redirect()->route('pembantu.cms.profil.tugas-fungsi')
            ->with('success', 'Tugas dan Fungsi berhasil diperbarui.');
    }

    // ========== STRUKTUR ORGANISASI ==========
    public function editStruktur()
    {
        $opd = $this->getOpd();
        return view('dashboard.pembantu.cms.profil.struktur', compact('opd'));
    }

    /**
     * PERBAIKAN: Menggunakan kolom 'struktur_content' dan 'struktur_pdf'
     */
    public function updateStruktur(Request $request)
    {
        $opd = $this->getOpd();

        $validated = $request->validate([
            'struktur_content' => 'nullable|string',  // PERBAIKAN
            'struktur_pdf' => 'nullable|file|mimes:pdf|max:5120',  // PERBAIKAN
        ]);

        $data = ['struktur_content' => $validated['struktur_content']];  // PERBAIKAN

        if ($request->hasFile('struktur_pdf')) {  // PERBAIKAN
            if ($opd->struktur_pdf && Storage::disk('public')->exists($opd->struktur_pdf)) {  // PERBAIKAN
                Storage::disk('public')->delete($opd->struktur_pdf);
            }
            $data['struktur_pdf'] = $request->file('struktur_pdf')->store('opds/struktur', 'public');  // PERBAIKAN
        }

        $opd->update($data);

        return redirect()->route('pembantu.cms.profil.struktur')
            ->with('success', 'Struktur Organisasi berhasil diperbarui.');
    }

    // ========== DASAR HUKUM ==========
    public function editDasarHukum()
    {
        $opd = $this->getOpd();
        return view('dashboard.pembantu.cms.profil.dasar-hukum', compact('opd'));
    }

    public function updateDasarHukum(Request $request)
    {
        $opd = $this->getOpd();

        $validated = $request->validate([
            'dasar_hukum_content' => 'nullable|string',
            'dasar_hukum_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = ['dasar_hukum_content' => $validated['dasar_hukum_content']];

        if ($request->hasFile('dasar_hukum_pdf')) {
            if ($opd->dasar_hukum_pdf && Storage::disk('public')->exists($opd->dasar_hukum_pdf)) {
                Storage::disk('public')->delete($opd->dasar_hukum_pdf);
            }
            $data['dasar_hukum_pdf'] = $request->file('dasar_hukum_pdf')->store('opds/dasar-hukum', 'public');
        }

        $opd->update($data);

        return redirect()->route('pembantu.cms.profil.dasar-hukum')
            ->with('success', 'Dasar Hukum berhasil diperbarui.');
    }
}