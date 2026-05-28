<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $user = Auth::user();
        $opdId = $user->opd_id;
        
        // Statistik dokumen DIP
        $totalDocuments = Document::where('opd_id', $opdId)->count();
        $publishedDocuments = Document::where('opd_id', $opdId)->where('status', 'published')->count();
        $unpublishedDocuments = Document::where('opd_id', $opdId)->where('status', 'unpublished')->count();
        $archivedDocuments = Document::where('opd_id', $opdId)->where('status', 'archived')->count();
        $totalDownloads = Document::where('opd_id', $opdId)->sum('download_count');
        
        // Dokumen terbaru
        $recentDocuments = Document::where('opd_id', $opdId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();
        
        // Statistik per kategori
        $statsByCategory = Document::where('opd_id', $opdId)
            ->selectRaw('category_id, count(*) as total')
            ->where('status', 'published')
            ->groupBy('category_id')
            ->with('category')
            ->get();
        
        // Log aktivitas
        $this->logActivity('view_dashboard', 'Melihat dashboard PPID Pembantu');
        
        return view('dashboard.pembantu.index', compact(
            'totalDocuments',
            'publishedDocuments',
            'unpublishedDocuments',
            'archivedDocuments',
            'totalDownloads',
            'recentDocuments',
            'statsByCategory',
            'user'
        ));
    }
}