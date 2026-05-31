<?php

namespace App\Http\Controllers\Dashboard\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PimpinanDocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen (read-only) untuk OPD yang dipimpin.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->opd_id) {
            abort(403, 'Akun pimpinan belum terhubung ke OPD manapun.');
        }

        // Query hanya untuk OPD user
        $query = Document::where('opd_id', $user->opd_id);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan klasifikasi
        if ($request->filled('classification')) {
            $query->where('classification', $request->classification);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Pencarian berdasarkan judul atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('doc_number', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest()->paginate(15)->withQueryString();

        // Data untuk filter dropdown
        $categories = \App\Models\Category::all();
        $years = Document::where('opd_id', $user->opd_id)
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dashboard.pimpinan.documents.index', compact(
            'documents',
            'categories',
            'years'
        ));
    }

    /**
     * Menampilkan detail dokumen (read-only).
     */
    public function show(Document $document)
    {
        $user = Auth::user();
        
        // Pastikan dokumen milik OPD user
        if ($document->opd_id !== $user->opd_id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        // Ambil log aktivitas dokumen
        $logs = $document->logs()->with('user')->latest()->get();

        return view('dashboard.pimpinan.documents.show', compact('document', 'logs'));
    }

    /**
     * Preview PDF (bisa diakses read-only)
     */
    public function preview(Document $document)
    {
        $user = Auth::user();
        
        // Pastikan dokumen milik OPD user
        if ($document->opd_id !== $user->opd_id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File dokumen tidak ditemukan.');
        }

        return response()->file($filePath, [
            'Content-Type' => $document->file_mime ?? 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->title . '.pdf"',
        ]);
    }
}