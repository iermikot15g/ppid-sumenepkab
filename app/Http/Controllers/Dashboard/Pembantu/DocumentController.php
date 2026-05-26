<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Category;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use LogsActivity;

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

        $this->logActivity('create_document', 'Mengupload dokumen: ' . $document->title, $document);

        // PERBAIKAN: Ganti route() dengan url()
        return redirect()->to(url('/dashboard/pembantu/documents'))
            ->with('success', 'Dokumen berhasil diupload.');
    }

    public function edit(Document $document)
    {
        if ($document->opd_id !== auth()->user()->opd_id) {
            abort(403);
        }
        $categories = Category::with('subCategories')->get();
        return view('dashboard.pembantu.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        if ($document->opd_id !== auth()->user()->opd_id) {
            abort(403);
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

        if ($request->hasFile('file')) {
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

        $this->logActivity('update_document', 'Memperbarui dokumen: ' . $document->title, $document);

        // PERBAIKAN: Ganti route() dengan url()
        return redirect()->to(url('/dashboard/pembantu/documents'))
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if ($document->opd_id !== auth()->user()->opd_id) {
            abort(403);
        }
        
        $this->logActivity('delete_document', 'Menghapus dokumen: ' . $document->title, $document);
        
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        // PERBAIKAN: Ganti route() dengan url()
        return redirect()->to(url('/dashboard/pembantu/documents'))
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function updateStatus(Request $request, Document $document)
    {
        if ($document->opd_id !== auth()->user()->opd_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:published,unpublished,archived',
        ]);

        $oldStatus = $document->status;
        $document->status = $validated['status'];
        
        if ($validated['status'] === 'published' && !$document->published_at) {
            $document->published_at = now();
        }
        $document->save();

        $this->logActivity('change_document_status', 'Mengubah status dokumen ' . $document->title . ' dari ' . $oldStatus . ' menjadi ' . $validated['status'], $document);

        return response()->json(['success' => true]);
    }
}