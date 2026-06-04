<?php

namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Opd;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        // ========== STATISTIK DOKUMEN ==========
        $totalDocuments = Document::count();
        $publishedDocuments = Document::where('status', 'published')->count();
        $excludedDocuments = Document::where('classification', 'excluded')->count();
        $totalDownloads = Document::sum('download_count');
        
        // ========== STATISTIK PER OPD ==========
        $opdStats = Opd::withCount(['documents' => function($query) {
                $query->where('status', 'published');
            }])
            ->withCount(['documents as total_documents'])
            ->orderBy('documents_count', 'desc')
            ->get();
        
        // ========== INDIKATOR KEAKTIFAN OPD ==========
        // Hijau: update dalam 30 hari terakhir
        // Kuning: update 31-90 hari
        // Merah: tidak ada update > 90 hari
        $activeOpds = Opd::all()->map(function($opd) {
            $lastUpdate = Document::where('opd_id', $opd->id)
                ->latest('updated_at')
                ->first();
            
            if (!$lastUpdate) {
                $status = 'red';
                $statusText = 'Tidak Aktif (Belum ada dokumen)';
            } else {
                $daysSinceUpdate = $lastUpdate->updated_at->diffInDays(now());
                
                if ($daysSinceUpdate <= 30) {
                    $status = 'green';
                    $statusText = 'Aktif (' . $daysSinceUpdate . ' hari yang lalu)';
                } elseif ($daysSinceUpdate <= 90) {
                    $status = 'yellow';
                    $statusText = 'Kurang Aktif (' . $daysSinceUpdate . ' hari yang lalu)';
                } else {
                    $status = 'red';
                    $statusText = 'Tidak Aktif (' . $daysSinceUpdate . ' hari yang lalu)';
                }
            }
            
            return [
                'id' => $opd->id,
                'name' => $opd->name,
                'short_name' => $opd->short_name,
                'total_documents' => Document::where('opd_id', $opd->id)->count(),
                'published_documents' => Document::where('opd_id', $opd->id)->where('status', 'published')->count(),
                'status' => $status,
                'status_text' => $statusText,
                'last_update' => $lastUpdate ? $lastUpdate->updated_at->format('d/m/Y') : '-',
            ];
        });
        
        // ========== DOKUMEN PER KATEGORI ==========
        $documentsByCategory = Document::select('category_id', DB::raw('count(*) as total'))
            ->where('status', 'published')
            ->groupBy('category_id')
            ->with('category')
            ->get();
        
        // ========== TREN PUBLIKASI (6 bulan terakhir) ==========
        $publicationTrend = Document::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // ========== DOKUMEN TERBARU ==========
        $recentDocuments = Document::with(['opd', 'category'])
            ->latest()
            ->take(10)
            ->get();
        
        // ========== STATISTIK CMS ==========
        $totalInfografis = News::where('type', 'infographic')->count();
        $totalAgendas = News::where('type', 'agenda')->count();
        $totalGalleries = News::where('type', 'gallery')->count();
        
        return view('dashboard.utama.index', compact(
            'totalDocuments',
            'publishedDocuments',
            'excludedDocuments',
            'totalDownloads',
            'opdStats',
            'activeOpds',
            'documentsByCategory',
            'publicationTrend',
            'recentDocuments',
            'totalInfografis',
            'totalAgendas',
            'totalGalleries'
        ));
    }
}