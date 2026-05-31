<?php

namespace App\Http\Controllers\Dashboard\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PimpinanLaporanExport;

class PimpinanLaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan statistik (read-only)
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->opd_id) {
            abort(403, 'Akun pimpinan belum terhubung ke OPD manapun.');
        }

        $opd = Opd::find($user->opd_id);
        
        // Data untuk filter
        $years = Document::where('opd_id', $user->opd_id)
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $categories = \App\Models\Category::all();

        return view('dashboard.pimpinan.laporan.index', compact('opd', 'years', 'categories'));
    }

    /**
     * Generate laporan statistik berdasarkan filter
     */
    public function generate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date|after_or_equal:period_start',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Query dasar untuk dokumen OPD user (belum ditambah filter)
        $baseQuery = Document::where('opd_id', $user->opd_id);

        // Filter periode (gunakan whereDate dengan prefix tabel)
        if ($request->filled('period_start')) {
            $baseQuery->whereDate('documents.created_at', '>=', $request->period_start);
        }
        if ($request->filled('period_end')) {
            $baseQuery->whereDate('documents.created_at', '<=', $request->period_end);
        }

        // Filter tahun
        if ($request->filled('year')) {
            $baseQuery->where('year', $request->year);
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $baseQuery->where('category_id', $request->category_id);
        }

        // Clone query untuk berbagai keperluan statistik
        $query = clone $baseQuery;
        
        // Data statistik
        $totalDocuments = $query->count();
        $publishedDocuments = (clone $baseQuery)->where('status', 'published')->count();
        $unpublishedDocuments = (clone $baseQuery)->where('status', 'unpublished')->count();
        $archivedDocuments = (clone $baseQuery)->where('status', 'archived')->count();
        
        $totalDownloads = (clone $baseQuery)->sum('download_count');
        $openDocuments = (clone $baseQuery)->where('classification', 'open')->count();
        $excludedDocuments = (clone $baseQuery)->where('classification', 'excluded')->count();

        // Statistik per kategori (PERBAIKAN: gunakan $baseQuery yang sudah memiliki filter)
        $categoryStats = (clone $baseQuery)
            ->join('categories', 'documents.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->get();

        // Statistik per bulan (untuk grafik)
        $monthlyStats = (clone $baseQuery)
            ->where('status', 'published')
            ->whereNotNull('documents.published_at')  // Tambahkan prefix
            ->select(
                DB::raw('DATE_FORMAT(documents.published_at, "%Y-%m") as month'),  // Tambahkan prefix
                DB::raw('count(*) as total'),
                DB::raw('sum(documents.download_count) as downloads')  // Tambahkan prefix
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // 10 dokumen paling banyak diunduh
        $topDocuments = (clone $baseQuery)
            ->where('status', 'published')
            ->orderBy('download_count', 'desc')
            ->take(10)
            ->get(['id', 'title', 'download_count', 'created_at']);

        $data = [
            'opd_name' => $user->opd->name,
            'period' => [
                'start' => $request->period_start,
                'end' => $request->period_end,
            ],
            'year' => $request->year,
            'total_documents' => $totalDocuments,
            'published_documents' => $publishedDocuments,
            'unpublished_documents' => $unpublishedDocuments,
            'archived_documents' => $archivedDocuments,
            'total_downloads' => $totalDownloads,
            'open_documents' => $openDocuments,
            'excluded_documents' => $excludedDocuments,
            'category_stats' => $categoryStats,
            'monthly_stats' => $monthlyStats,
            'top_documents' => $topDocuments,
            'generated_at' => now(),
        ];

        // Simpan data ke session untuk keperluan ekspor
        session(['laporan_data' => $data]);

        return view('dashboard.pimpinan.laporan.result', compact('data'));
    }

    /**
     * Ekspor laporan ke PDF
     */
    public function exportPdf()
    {
        $data = session('laporan_data');
        
        if (!$data) {
            return redirect()->route('pimpinan.laporan.index')
                ->with('error', 'Tidak ada data laporan untuk diekspor. Silakan generate laporan terlebih dahulu.');
        }

        $pdf = Pdf::loadView('dashboard.pimpinan.laporan.export-pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan_ppid_' . $data['opd_name'] . '_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Ekspor laporan ke Excel
     */
    public function exportExcel()
    {
        $data = session('laporan_data');
        
        if (!$data) {
            return redirect()->route('pimpinan.laporan.index')
                ->with('error', 'Tidak ada data laporan untuk diekspor. Silakan generate laporan terlebih dahulu.');
        }

        return Excel::download(new PimpinanLaporanExport($data), 'laporan_ppid_' . $data['opd_name'] . '_' . date('Y-m-d') . '.xlsx');
    }
}