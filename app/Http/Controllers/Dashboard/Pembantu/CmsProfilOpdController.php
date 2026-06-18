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

    /**
     * Konfigurasi untuk setiap section CMS Profil OPD
     */
    protected $sections = [
        'tentang' => [
            'view' => 'tentang',
            'field' => 'tentang_content',
            'pdf_field' => 'tentang_pdf',
            'route' => 'pembantu.cms.profil.tentang',
            'update_route' => 'pembantu.cms.profil.update-tentang',
            'pdf_folder' => 'tentang',
            'title' => 'Tentang OPD',
            'has_logo' => true,
            'has_google_maps' => true,
        ],
        'tugas-fungsi' => [
            'view' => 'tugas-fungsi',
            'field' => 'tugas_fungsi_content',
            'pdf_field' => 'tugas_fungsi_pdf',
            'route' => 'pembantu.cms.profil.tugas-fungsi',
            'update_route' => 'pembantu.cms.profil.update-tugas-fungsi',
            'pdf_folder' => 'tugas-fungsi',
            'title' => 'Tugas dan Fungsi',
            'has_logo' => false,
            'has_google_maps' => false,
        ],
        'struktur' => [
            'view' => 'struktur',
            'field' => 'struktur_content',
            'pdf_field' => 'struktur_pdf',
            'route' => 'pembantu.cms.profil.struktur',
            'update_route' => 'pembantu.cms.profil.update-struktur',
            'pdf_folder' => 'struktur',
            'title' => 'Struktur Organisasi',
            'has_logo' => false,
            'has_google_maps' => false,
        ],
        'dasar-hukum' => [
            'view' => 'dasar-hukum',
            'field' => 'dasar_hukum_content',
            'pdf_field' => 'dasar_hukum_pdf',
            'route' => 'pembantu.cms.profil.dasar-hukum',
            'update_route' => 'pembantu.cms.profil.update-dasar-hukum',
            'pdf_folder' => 'dasar-hukum',
            'title' => 'Dasar Hukum',
            'has_logo' => false,
            'has_google_maps' => false,
        ],
    ];

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

        $opd->update(['social_media' => $socialMedia]);

        $this->logActivity('update_media_sosial', 'Memperbarui media sosial OPD', $opd);

        return redirect()->route('pembantu.cms.profil.media-sosial')
            ->with('success', 'Media sosial berhasil diperbarui.');
    }

    // ========== TENTANG OPD ==========
    public function editTentang()
    {
        $opd = $this->getOpd();
        $config = $this->sections['tentang'];
        return view("dashboard.pembantu.cms.profil.{$config['view']}", compact('opd', 'config'));
    }

    public function updateTentang(Request $request)
    {
        $opd = $this->getOpd();
        $config = $this->sections['tentang'];
        
        $rules = [
            'tentang_content' => 'nullable|string',
            'vision_mission' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'google_maps_link' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tentang_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ];

        $validated = $request->validate($rules);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($opd->logo && Storage::disk('public')->exists($opd->logo)) {
                Storage::disk('public')->delete($opd->logo);
            }
            $validated['logo'] = $request->file('logo')->store('opds', 'public');
        }
        
        // Handle PDF upload
        if ($request->hasFile('tentang_pdf')) {
            if ($opd->tentang_pdf && Storage::disk('public')->exists($opd->tentang_pdf)) {
                Storage::disk('public')->delete($opd->tentang_pdf);
            }
            $validated['tentang_pdf'] = $request->file('tentang_pdf')->store('opds/tentang', 'public');
        }

        $opd->update($validated);

        $this->logActivity('update_tentang', 'Memperbarui Tentang OPD', $opd);

        return redirect()->route('pembantu.cms.profil.tentang')
            ->with('success', 'Tentang OPD berhasil diperbarui.');
    }

    // ========== SECTION GENERIC (Tugas Fungsi, Struktur, Dasar Hukum) ==========
    
    /**
     * Edit any section dynamically
     */
    public function editSection($section)
    {
        $config = $this->sections[$section] ?? abort(404, 'Section tidak ditemukan');
        $opd = $this->getOpd();
        return view("dashboard.pembantu.cms.profil.{$config['view']}", compact('opd', 'config'));
    }

    /**
     * Update any section dynamically
     */
    public function updateSection(Request $request, $section)
    {
        $config = $this->sections[$section] ?? abort(404, 'Section tidak ditemukan');
        $opd = $this->getOpd();

        $validated = $request->validate([
            $config['field'] => 'nullable|string',
            $config['pdf_field'] => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = [$config['field'] => $validated[$config['field']]];

        // Handle PDF upload
        if ($request->hasFile($config['pdf_field'])) {
            if ($opd->{$config['pdf_field']} && Storage::disk('public')->exists($opd->{$config['pdf_field']})) {
                Storage::disk('public')->delete($opd->{$config['pdf_field']});
            }
            $data[$config['pdf_field']] = $request->file($config['pdf_field'])
                ->store("opds/{$config['pdf_folder']}", 'public');
        }

        $opd->update($data);

        $this->logActivity("update_{$section}", "Memperbarui {$config['title']}", $opd);

        return redirect()->route($config['route'])
            ->with('success', "{$config['title']} berhasil diperbarui.");
    }

    // ========== LEGACY METHODS (untuk kompatibilitas route) ==========
    
    public function editTugasFungsi()
    {
        return $this->editSection('tugas-fungsi');
    }

    public function updateTugasFungsi(Request $request)
    {
        return $this->updateSection($request, 'tugas-fungsi');
    }

    public function editStruktur()
    {
        return $this->editSection('struktur');
    }

    public function updateStruktur(Request $request)
    {
        return $this->updateSection($request, 'struktur');
    }

    public function editDasarHukum()
    {
        return $this->editSection('dasar-hukum');
    }

    public function updateDasarHukum(Request $request)
    {
        return $this->updateSection($request, 'dasar-hukum');
    }
}