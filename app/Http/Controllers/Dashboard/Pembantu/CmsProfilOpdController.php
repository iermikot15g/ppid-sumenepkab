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

        // Filter hanya yang terisi
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
        $opd = $this->getOpd();

        $validated = $request->validate([
            'tentang_content' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'google_maps_link' => 'nullable|string',
        ]);

        // Ekstrak URL dari iframe jika diperlukan
        $googleMapsLink = $validated['google_maps_link'];
        if (preg_match('/src="([^"]+)"/', $googleMapsLink, $matches)) {
            $googleMapsLink = $matches[1];
        }

        if ($request->hasFile('logo')) {
            if ($opd->logo) {
                Storage::disk('public')->delete($opd->logo);
            }
            $validated['logo'] = $request->file('logo')->store('opds', 'public');
        }

        $opd->update([
            'tentang_content' => $validated['tentang_content'],
            'logo' => $validated['logo'] ?? $opd->logo,
            'google_maps_link' => $googleMapsLink,
        ]);

        return redirect()->route('pembantu.cms.profil.tentang')
            ->with('success', 'Konten Tentang OPD berhasil diperbarui.');
    }

    // ========== TUGAS DAN FUNGSI ==========
    public function editTugasFungsi()
    {
        $opd = $this->getOpd();
        return view('dashboard.pembantu.cms.profil.tugas-fungsi', compact('opd'));
    }

    public function updateTugasFungsi(Request $request)
    {
        $opd = $this->getOpd();

        $validated = $request->validate([
            'tusi_content' => 'nullable|string',
            'tusi_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = ['tusi_content' => $validated['tusi_content']];

        if ($request->hasFile('tusi_pdf')) {
            if ($opd->tusi_pdf) {
                Storage::disk('public')->delete($opd->tusi_pdf);
            }
            $data['tusi_pdf'] = $request->file('tusi_pdf')->store('opds/tusi', 'public');
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

    public function updateStruktur(Request $request)
    {
        $opd = $this->getOpd();

        $validated = $request->validate([
            'structure_content' => 'nullable|string',
            'structure_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = ['structure_content' => $validated['structure_content']];

        if ($request->hasFile('structure_pdf')) {
            if ($opd->structure_pdf) {
                Storage::disk('public')->delete($opd->structure_pdf);
            }
            $data['structure_pdf'] = $request->file('structure_pdf')->store('opds/structure', 'public');
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
            if ($opd->dasar_hukum_pdf) {
                Storage::disk('public')->delete($opd->dasar_hukum_pdf);
            }
            $data['dasar_hukum_pdf'] = $request->file('dasar_hukum_pdf')->store('opds/dasar-hukum', 'public');
        }

        $opd->update($data);

        return redirect()->route('pembantu.cms.profil.dasar-hukum')
            ->with('success', 'Dasar Hukum berhasil diperbarui.');
    }
}