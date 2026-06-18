<?php

namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\News;
use App\Models\Opd;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    /**
     * Display monitoring dashboard
     */
    public function index()
    {
        // ========== STATISTIK UTAMA (Cache 5 menit) ==========
        $stats = Cache::remember('dashboard_stats', 300, function () {
            return [
                'totalDocuments' => Document::count(),
                'publishedDocuments' => Document::where('status', 'published')->count(),
                'excludedDocuments' => Document::where('classification', 'excluded')->count(),
                'totalDownloads' => Document::sum('download_count'),
            ];
        });

        // ========== OPD AKTIF (Cache 10 menit) ==========
        $activeOpds = Cache::remember('active_opds', 600, function () {
            return Opd::withCount([
                'documents',
                'documents as published_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->with(['documents' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->get()
            ->map(function ($opd) {
                $lastUpdate = $opd->documents->first()?->updated_at;
                
                return [
                    'name' => $opd->name,
                    'total_documents' => $opd->documents_count,
                    'published_documents' => $opd->published_count,
                    'last_update' => $lastUpdate ? $lastUpdate->diffForHumans() : 'Tidak pernah',
                    'status' => $this->calculateStatus($lastUpdate),
                    'status_text' => $this->getStatusText($this->calculateStatus($lastUpdate)),
                ];
            })
            ->sortByDesc('total_documents')
            ->values()
            ->toArray();
        });

        // ========== DOKUMEN PER KATEGORI ==========
        $documentsByCategory = Document::where('status', 'published')
            ->select('category_id', DB::raw('count(*) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->get();

        // ========== TREN PUBLIKASI (6 Bulan) ==========
        $publicationTrend = Document::where('status', 'published')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $date = \Carbon\Carbon::createFromFormat('Y-m', $item->month);
                return [
                    'month' => $date->format('M Y'),
                    'total' => $item->total,
                ];
            });

        // ========== DOKUMEN TERBARU ==========
        $recentDocuments = Document::with(['opd', 'category'])
            ->latest()
            ->limit(10)
            ->get();

        // ========== STATISTIK CMS ==========
        $cmsStats = Cache::remember('cms_stats', 300, function () {
            return [
                'totalInfografis' => News::where('type', 'infographic')->count(),
                'totalAgendas' => News::where('type', 'agenda')->count(),
                'totalGalleries' => News::where('type', 'gallery')->count(),
            ];
        });

        return view('dashboard.utama.index', array_merge(
            $stats,
            $cmsStats,
            [
                'activeOpds' => $activeOpds,
                'documentsByCategory' => $documentsByCategory,
                'publicationTrend' => $publicationTrend,
                'recentDocuments' => $recentDocuments,
            ]
        ));
    }

    /**
     * Calculate OPD activity status based on last update
     */
    private function calculateStatus($lastUpdate)
    {
        if (!$lastUpdate) {
            return 'red';
        }
        $days = $lastUpdate->diffInDays(now());
        if ($days <= 30) {
            return 'green';
        }
        if ($days <= 60) {
            return 'yellow';
        }
        return 'red';
    }

    /**
     * Get status text for display
     */
    private function getStatusText($status)
    {
        return match($status) {
            'green' => 'Aktif',
            'yellow' => 'Cukup Aktif',
            'red' => 'Tidak Aktif',
            default => 'Tidak Aktif',
        };
    }

    /**
     * Clear dashboard cache (bisa dipanggil setelah update data)
     */
    public function clearCache()
    {
        Cache::forget('dashboard_stats');
        Cache::forget('active_opds');
        Cache::forget('cms_stats');
        
        return redirect()->route('dashboard.utama')
            ->with('success', 'Cache dashboard berhasil dibersihkan.');
    }
}