<?php

namespace App\Http\Controllers\Dashboard\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Opd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PimpinanDashboardController extends Controller
{
    /**
     * Menampilkan dashboard monitoring untuk pimpinan OPD.
     * Hanya menampilkan data statistik dari OPD yang dipimpin.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan user pimpinan memiliki OPD terhubung
        if (!$user->opd_id) {
            abort(403, 'Akun pimpinan belum terhubung ke OPD manapun.');
        }

        $opdId = $user->opd_id;
        $opd = Opd::find($opdId);

        // Statistik dasar dokumen
        $totalDocuments = Document::where('opd_id', $opdId)->count();
        $publishedDocuments = Document::where('opd_id', $opdId)
            ->where('status', 'published')
            ->count();
        $unpublishedDocuments = Document::where('opd_id', $opdId)
            ->where('status', 'unpublished')
            ->count();
        $archivedDocuments = Document::where('opd_id', $opdId)
            ->where('status', 'archived')
            ->count();
        
        // Dokumen yang di-force unpublish oleh PPID Utama
        $forceUnpublishedDocuments = Document::where('opd_id', $opdId)
            ->whereNotNull('force_unpublished_by')
            ->count();

        // Statistik per kategori klasifikasi
        $openDocuments = Document::where('opd_id', $opdId)
            ->where('classification', 'open')
            ->count();
        $excludedDocuments = Document::where('opd_id', $opdId)
            ->where('classification', 'excluded')
            ->count();

        // Statistik per kategori utama (Berkala, Serta-Merta, Setiap Saat, Dikecualikan)
        $categoryStats = DB::table('documents')
            ->join('categories', 'documents.category_id', '=', 'categories.id')
            ->where('documents.opd_id', $opdId)
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->get();

        // 5 dokumen terbaru
        $recentDocuments = Document::where('opd_id', $opdId)
            ->latest()
            ->take(5)
            ->get();

        // Statistik tren publikasi per bulan (6 bulan terakhir)
        $monthlyStats = DB::table('documents')
            ->where('opd_id', $opdId)
            ->where('status', 'published')
            ->where('published_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(published_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // 5 dokumen paling banyak diunduh
        $mostDownloaded = Document::where('opd_id', $opdId)
            ->where('status', 'published')
            ->orderBy('download_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.pimpinan.dashboard', compact(
            'opd',
            'totalDocuments',
            'publishedDocuments',
            'unpublishedDocuments',
            'archivedDocuments',
            'forceUnpublishedDocuments',
            'openDocuments',
            'excludedDocuments',
            'categoryStats',
            'recentDocuments',
            'monthlyStats',
            'mostDownloaded'
        ));
    }
}