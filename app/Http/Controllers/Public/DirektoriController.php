<?php
// app/Http/Controllers/Public/DirektoriController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\Village;
use App\Models\Document;

class DirektoriController extends Controller
{
    public function opdIndex()
    {
        $opds = Opd::where('is_active', true)
            ->withCount(['documents' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->paginate(12);
        
        return view('public.direktori.opd-index', compact('opds'));
    }

    public function opdShow(Opd $opd)
    {
        $recentDocuments = Document::where('opd_id', $opd->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();
        
        $totalDocuments = Document::where('opd_id', $opd->id)
            ->where('status', 'published')
            ->count();
        
        return view('public.direktori.opd-show', compact('opd', 'recentDocuments', 'totalDocuments'));
    }

    public function desaIndex()
    {
        $villages = Village::where('is_active', true)
            ->orderBy('name')
            ->paginate(12);
        
        return view('public.direktori.desa-index', compact('villages'));
    }
}