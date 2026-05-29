<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Menampilkan semua galeri foto yang dipublish
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query untuk mengambil semua galeri foto yang dipublish
        $galeri = News::where('type', 'gallery')
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(12); // 12 item per halaman (3 baris x 4 kolom)
        
        return view('public.galeri.index', compact('galeri'));
    }
}