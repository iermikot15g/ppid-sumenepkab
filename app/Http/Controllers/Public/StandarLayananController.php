<?php
// app/Http/Controllers/Public/StandarLayananController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;

class StandarLayananController extends Controller
{
    public function index()
    {
        $sections = [
            'maklumat' => StaticPage::where('page_key', 'standar_maklumat')->first(),
            'prosedur' => StaticPage::where('page_key', 'standar_prosedur_permohonan')->first(),
            'keberatan' => StaticPage::where('page_key', 'standar_prosedur_keberatan')->first(),
            'sengketa' => StaticPage::where('page_key', 'standar_prosedur_sengketa')->first(),
            'jalur-waktu' => StaticPage::where('page_key', 'standar_jalur_waktu')->first(),
            'biaya' => StaticPage::where('page_key', 'standar_biaya')->first(),
        ];
        
        $activeSlug = request()->slug ?? 'maklumat';
        
        return view('public.standar-layanan.index', compact('sections', 'activeSlug'));
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