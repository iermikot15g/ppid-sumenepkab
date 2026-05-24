<?php
// app/Http/Controllers/Dashboard/Pembantu/DocumentController.php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::where('opd_id', Auth::user()->opd_id)
            ->with('category')
            ->latest()
            ->paginate(10);
        
        return view('dashboard.pembantu.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = Category::with('subCategories')->get();
        return view('dashboard.pembantu.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'doc_number' => 'nullable|string|max:100',
            'officer_name' => 'nullable|string|max:255',
            'classification' => 'required|in:open,excluded',
            'status' => 'required|in:published,unpublished',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:25600',
        ]);

        $user = Auth::user();
        $file = $request->file('file');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $filePath = $file->storeAs('documents/' . $user->opd_id, $fileName, 'public');

        $document = Document::create([
            'opd_id' => $user->opd_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'sub_category_id' => $validated['sub_category_id'],
            'year' => $validated['year'],
            'doc_number' => $validated['doc_number'],
            'officer_name' => $validated['officer_name'],
            'classification' => $validated['classification'],
            'status' => $validated['status'],
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'file_mime' => $file->getMimeType(),
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'created_by' => $user->id,
            'last_edited_by' => $user->id,
        ]);

        return redirect()->route('pembantu.documents.index')
            ->with('success', 'Dokumen berhasil diupload!');
    }

    // Tambahkan method edit dan update yang lengkap:

public function edit(Document $document)
{
    // Cek akses: hanya OPD yang sama
    if ($document->opd_id !== auth()->user()->opd_id) {
        abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
    }
    
    $categories = Category::with('subCategories')->get();
    return view('dashboard.pembantu.documents.edit', compact('document', 'categories'));
}

public function update(Request $request, Document $document)
{
    // Cek akses
    if ($document->opd_id !== auth()->user()->opd_id) {
        abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'doc_number' => 'nullable|string|max:100',
        'officer_name' => 'nullable|string|max:255',
        'classification' => 'required|in:open,excluded',
        'status' => 'required|in:published,unpublished,archived',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:25600',
    ]);

    // Handle file upload if new file provided
    if ($request->hasFile('file')) {
        // Delete old file
        Storage::disk('public')->delete($document->file_path);
        
        $file = $request->file('file');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $filePath = $file->storeAs('documents/' . $document->opd_id, $fileName, 'public');
        
        $document->file_path = $filePath;
        $document->file_size = $file->getSize();
        $document->file_mime = $file->getMimeType();
    }

    $oldStatus = $document->status;
    $document->update($validated);
    
    if ($validated['status'] === 'published' && $oldStatus !== 'published') {
        $document->published_at = now();
        $document->save();
    }

    $document->last_edited_by = auth()->id();
    $document->save();

    return redirect()->route('pembantu.documents.index')
        ->with('success', 'Dokumen berhasil diperbarui!');
}

public function destroy(Document $document)
{
    if ($document->opd_id !== auth()->user()->opd_id) {
        abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
    }
    
    // Hapus file dari storage
    Storage::disk('public')->delete($document->file_path);
    
    // Hapus record dari database
    $document->delete();

    return redirect()->route('pembantu.documents.index')
        ->with('success', 'Dokumen berhasil dihapus!');
}

    public function updateStatus(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        if ($document->opd_id === Auth::user()->opd_id) {
            $document->status = $request->status;
            if ($request->status === 'published' && !$document->published_at) {
                $document->published_at = now();
            }
            $document->save();
        }
        return response()->json(['success' => true]);
    }
}