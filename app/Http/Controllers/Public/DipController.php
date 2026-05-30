<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DipController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['opd', 'category'])
            ->where('status', 'published');

        if ($request->category && $request->category !== 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->opd) {
            $query->where('opd_id', $request->opd);
        }

        if ($request->year) {
            $query->where('year', $request->year);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('doc_number', 'like', '%' . $request->search . '%');
            });
        }

        $documents = $query->latest('published_at')->paginate(12);
        $opds = Opd::where('is_active', true)->orderBy('name')->get();
        $years = range(date('Y'), 2000);
        $categories = \App\Models\Category::all();

        return view('public.dip.index', compact('documents', 'opds', 'years', 'categories'));
    }

    /**
     * Preview dokumen menggunakan Google Docs Viewer
     * - Membatasi kemampuan download
     * - Hanya untuk user yang login
     */
    public function preview(Document $document)
    {
        // Cek apakah dokumen bisa diakses publik
        if ($document->status !== 'published') {
            return response()->json(['error' => 'Dokumen tidak tersedia'], 404);
        }

        // Jika tidak login, kembalikan pesan yang meminta login
        if (!auth()->check()) {
            return response()->json([
                'error' => 'login_required',
                'message' => 'Silakan login terlebih dahulu untuk melihat preview dokumen',
                'login_url' => route('login')
            ], 401);
        }

        // ========== MENGGUNAKAN GOOGLE DOCS VIEWER ==========
        // Google Docs Viewer tidak menyediakan tombol download bawaan
        // Hanya bisa view, print, dan zoom
        $fileUrl = asset('storage/' . $document->file_path);
        $viewerUrl = 'https://docs.google.com/viewer?embedded=true&url=' . urlencode($fileUrl);
        
        // Untuk file gambar (JPG, PNG) tidak bisa menggunakan Google Docs Viewer
        // Maka tetap gunakan direct URL
        $isImage = in_array($document->file_mime, ['image/jpeg', 'image/jpg', 'image/png']);
        
        return response()->json([
            'title' => $document->title,
            'description' => $document->description,
            'file_url' => $isImage ? $fileUrl : $viewerUrl,
            'file_type' => $document->file_mime,
            'is_image' => $isImage,
            'is_pdf' => $document->file_mime === 'application/pdf',
            'opd' => $document->opd->name,
            'year' => $document->year,
            'category' => $document->category->name ?? '-',
            'viewer_notice' => 'Menggunakan Google Docs Viewer - Tidak dapat mengunduh langsung dari viewer',
        ]);
    }

    /**
     * Download dokumen - Wajib login (sudah ada middleware auth di route)
     */
    public function download(Document $document)
    {
        if ($document->status !== 'published' || $document->classification !== 'open') {
            abort(403, 'Dokumen tidak tersedia untuk diunduh.');
        }

        $document->increment('download_count');

        return Storage::disk('public')->download($document->file_path, $document->title . '.pdf');
    }

    public function byCategory($slug, Request $request)
    {
        $request->merge(['category' => $slug]);
        return $this->index($request);
    }
}