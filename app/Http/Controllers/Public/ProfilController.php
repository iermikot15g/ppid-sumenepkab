<?php
// app/Http/Controllers/Public/ProfilController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;

class ProfilController extends Controller
{
    public function index()
    {
        $sections = [
            'visi-misi' => StaticPage::where('page_key', 'profil_visi_misi')->first(),
            'tentang-ppid' => StaticPage::where('page_key', 'profil_tentang_ppid')->first(),
            'dasar-hukum' => StaticPage::where('page_key', 'profil_dasar_hukum')->first(),
            'tugas-fungsi' => StaticPage::where('page_key', 'profil_tupoksi')->first(),
            'struktur' => StaticPage::where('page_key', 'profil_struktur')->first(),
        ];
        
        $activeSection = request()->section ?? 'visi-misi';
        
        return view('public.profil.index', compact('sections', 'activeSection'));
    }

    public function show($section)
    {
        $pageKey = match($section) {
            'visi-misi' => 'profil_visi_misi',
            'tentang-ppid' => 'profil_tentang_ppid',
            'dasar-hukum' => 'profil_dasar_hukum',
            'tugas-fungsi' => 'profil_tupoksi',
            'struktur' => 'profil_struktur',
            default => 'profil_visi_misi',
        };
        
        $content = StaticPage::where('page_key', $pageKey)->first();
        
        return view('public.profil.show', compact('content', 'section'));
    }
}