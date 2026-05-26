<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;

class StandarLayananController extends Controller
{
    public function index()
    {
        return redirect()->route('standar-layanan.show', 'maklumat');
    }

    public function show($slug)
    {
        $pageKey = match($slug) {
            'maklumat' => 'standar_maklumat',
            'prosedur' => 'standar_prosedur_permohonan',
            'keberatan' => 'standar_prosedur_keberatan',
            'sengketa' => 'standar_prosedur_sengketa',
            'jalur-waktu' => 'standar_jalur_waktu',
            'biaya' => 'standar_biaya',
            default => 'standar_maklumat',
        };
        
        $content = StaticPage::where('page_key', $pageKey)->first();
        
        return view('public.standar-layanan.show', compact('content', 'slug'));
    }
}