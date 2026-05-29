<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Menampilkan semua agenda kegiatan (termasuk yang sudah lewat)
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query untuk mengambil semua agenda yang dipublish (tanpa filter tanggal)
        $agendas = News::where('type', 'agenda')
            ->where('is_published', true)
            ->orderBy('event_date', 'desc') // Terbaru di atas
            ->paginate(12); // 12 item per halaman (4 kolom x 3 baris)
        
        return view('public.agenda.index', compact('agendas'));
    }
    
    /**
     * Filter agenda berdasarkan status (coming_soon, ongoing, expired)
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $query = News::where('type', 'agenda')
            ->where('is_published', true);
        
        // Filter berdasarkan status
        if ($request->status == 'upcoming') {
            $query->where('event_date', '>=', now());
        } elseif ($request->status == 'expired') {
            $query->where('event_date', '<', now());
        }
        
        $agendas = $query->orderBy('event_date', 'desc')->paginate(12);
        $activeFilter = $request->status ?? 'all';
        
        return view('public.agenda.index', compact('agendas', 'activeFilter'));
    }
}