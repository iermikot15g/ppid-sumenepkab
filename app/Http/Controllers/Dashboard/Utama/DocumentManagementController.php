<?php
// app/Http/Controllers/Dashboard/Utama/DocumentManagementController.php

namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Opd;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentManagementController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Document::with(['opd', 'category', 'creator']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->latest()->paginate(20);
        $opds = Opd::orderBy('name')->get();

        return view('dashboard.utama.documents.index', compact('documents', 'opds'));
    }

    public function forceUnpublish(Request $request, Document $document)
    {
        $oldStatus = $document->status;
        
        $document->update([
            'status' => 'unpublished',
            'force_unpublished_by' => auth()->id(),
            'force_unpublished_reason' => $request->reason,
        ]);

        $this->logActivity('force_unpublish_document', 
            'Memaksa unpublish dokumen: ' . $document->title . 
            ' (Status sebelumnya: ' . $oldStatus . 
            ', Alasan: ' . ($request->reason ?? 'Tidak disebutkan') . ')', 
            $document);

        return redirect()->back()->with('success', 'Dokumen berhasil di-unpublish paksa.');
    }

    public function destroy(Document $document)
    {
        $this->logActivity('delete_document_global', 'Menghapus dokumen: ' . $document->title, $document);
        
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function edit(Document $document)
    {
        $categories = \App\Models\Category::with('subCategories')->get();
        return view('dashboard.utama.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer',
            'classification' => 'required|in:open,excluded',
            'status' => 'required|in:published,unpublished,archived',
        ]);

        $document->update($validated);

        $this->logActivity('update_document_global', 'Memperbarui dokumen: ' . $document->title, $document);

        return redirect()->route('utama.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }
}