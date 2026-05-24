<?php
// app/Http/Controllers/Dashboard/Utama/LaporanController.php

namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentsExport;

class LaporanController extends Controller
{
    public function index()
    {
        $opds = Opd::where('is_active', true)->orderBy('name')->get();
        $years = Document::select(DB::raw('DISTINCT year'))->orderBy('year', 'desc')->pluck('year');
        
        return view('dashboard.utama.laporan.index', compact('opds', 'years'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'opd_id' => 'nullable|exists:opds,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'year' => 'nullable|integer',
            'format' => 'required|in:pdf,excel',
        ]);

        $query = Document::with(['opd', 'category']);

        // Filter by OPD
        if ($request->filled('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $documents = $query->latest()->get();

        $stats = [
            'total' => $documents->count(),
            'published' => $documents->where('status', 'published')->count(),
            'unpublished' => $documents->where('status', 'unpublished')->count(),
            'archived' => $documents->where('status', 'archived')->count(),
            'open' => $documents->where('classification', 'open')->count(),
            'excluded' => $documents->where('classification', 'excluded')->count(),
            'total_downloads' => $documents->sum('download_count'),
        ];

        $data = [
            'documents' => $documents,
            'stats' => $stats,
            'filters' => [
                'opd' => $request->filled('opd_id') ? Opd::find($request->opd_id)->name : 'Semua OPD',
                'start_date' => $request->start_date ?? '-',
                'end_date' => $request->end_date ?? '-',
                'year' => $request->year ?? '-',
                'generated_at' => now()->format('d/m/Y H:i:s'),
            ]
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('dashboard.utama.laporan.pdf', $data);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('laporan-dokumen-' . now()->format('Ymd_His') . '.pdf');
        }

        // Excel export - buat export class jika belum ada
        return Excel::download(new DocumentsExport($documents), 'laporan-dokumen-' . now()->format('Ymd_His') . '.xlsx');
    }
}