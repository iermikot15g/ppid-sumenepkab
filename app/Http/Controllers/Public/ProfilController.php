<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;

class ProfilController extends Controller
{
    public function index()
    {
        return redirect()->route('profil.show', 'tentang-ppid');
    }

    public function show($section)
    {
        $pageKey = match($section) {
            'tentang-ppid' => 'profil_tentang_ppid',
            'visi-misi' => 'profil_visi_misi',
            'dasar-hukum' => 'profil_dasar_hukum',
            'tugas-fungsi' => 'profil_tugas_fungsi',
            'struktur' => 'profil_struktur',
            default => 'profil_tentang_ppid',
        };
        
        $content = StaticPage::where('page_key', $pageKey)->first();
        
        return view('public.profil.show', compact('content', 'section'));
    }
}