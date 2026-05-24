<?php
// app/Http/Controllers/Public/DipController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Category;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DipController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['opd', 'category'])
            ->where('status', 'published')
            ->where('classification', 'open');

        // Filter by category
        if ($request->category && $request->category !== 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by OPD
        if ($request->opd) {
            $query->where('opd_id', $request->opd);
        }

        // Filter by year
        if ($request->year) {
            $query->where('year', $request->year);
        }

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('doc_number', 'like', '%' . $request->search . '%');
            });
        }

        $documents = $query->latest('published_at')->paginate(12);
        $categories = Category::all();
        $opds = Opd::where('is_active', true)->orderBy('name')->get();
        $years = range(date('Y'), 2000);

        return view('public.dip.index', compact('documents', 'categories', 'opds', 'years'));
    }

    public function byCategory($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $request->merge(['category' => $slug]);
        return $this->index($request);
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function preview(Document $document)
    {
        if ($document->status !== 'published') {
            abort(404);
        }
        
        return response()->json([
            'title' => $document->title,
            'description' => $document->description,
            'file_url' => Storage::url($document->file_path),
            'file_type' => $document->file_mime,
            'opd' => $document->opd->name,
            'year' => $document->year,
            'category' => $document->category->name ?? '-',
        ]);
    }

    public function download(Document $document)
    {
        if ($document->status !== 'published' || $document->classification !== 'open') {
            abort(403, 'Dokumen tidak tersedia untuk diunduh.');
        }

        $document->increment('download_count');

        return Storage::disk('public')->download($document->file_path, $document->title . '.pdf');
    }
}