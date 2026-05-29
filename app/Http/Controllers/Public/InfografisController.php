<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    /**
     * Menampilkan semua infografis yang dipublish
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query untuk mengambil semua infografis yang dipublish
        $infografis = News::where('type', 'infographic')
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(12); // 12 item per halaman (3 baris x 4 kolom)
        
        return view('public.infografis.index', compact('infografis'));
    }
}