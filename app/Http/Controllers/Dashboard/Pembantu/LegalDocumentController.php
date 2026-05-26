<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use App\Models\Category;  // <-- TAMBAHKAN INI
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LegalDocumentController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $documents = LegalDocument::where('opd_id', Auth::user()->opd_id)
            ->latest()
            ->paginate(10);
        return view('dashboard.pembantu.legal-documents.index', compact('documents'));
    }

    public function create()
    {
        // Kirim data categories ke view (meskipun mungkin tidak digunakan, tetap kirim untuk menghindari error)
        $categories = Category::all();  // <-- TAMBAHKAN INI
        return view('dashboard.pembantu.legal-documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'regulation_number' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $user = Auth::user();
        $file = $request->file('file');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $filePath = $file->storeAs('legal-documents/' . $user->opd_id, $fileName, 'public');

        $document = LegalDocument::create([
            'opd_id' => $user->opd_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'regulation_number' => $validated['regulation_number'],
            'year' => $validated['year'],
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'is_published' => true,
            'created_by' => $user->id,
        ]);

        $this->logActivity('create_legal_document', 'Menambahkan dokumen hukum: ' . $document->title, $document);

        return redirect()->route('legal-documents.index')
            ->with('success', 'Dokumen hukum berhasil ditambahkan.');
    }

    public function edit(LegalDocument $legalDocument)
    {
        $this->authorizeAccess($legalDocument);
        $categories = Category::all();  // <-- TAMBAHKAN INI
        return view('dashboard.pembantu.legal-documents.edit', compact('legalDocument', 'categories'));
    }

    public function update(Request $request, LegalDocument $legalDocument)
    {
        $this->authorizeAccess($legalDocument);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'regulation_number' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($legalDocument->file_path);
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('legal-documents/' . $legalDocument->opd_id, $fileName, 'public');
            $legalDocument->file_path = $filePath;
            $legalDocument->file_size = $file->getSize();
        }

        $legalDocument->update($validated);

        $this->logActivity('update_legal_document', 'Memperbarui dokumen hukum: ' . $legalDocument->title, $legalDocument);

        return redirect()->route('legal-documents.index')
            ->with('success', 'Dokumen hukum berhasil diperbarui.');
    }

    public function destroy(LegalDocument $legalDocument)
    {
        $this->authorizeAccess($legalDocument);
        
        $this->logActivity('delete_legal_document', 'Menghapus dokumen hukum: ' . $legalDocument->title, $legalDocument);
        
        Storage::disk('public')->delete($legalDocument->file_path);
        $legalDocument->delete();

        return redirect()->route('legal-documents.index')
            ->with('success', 'Dokumen hukum berhasil dihapus.');
    }

    private function authorizeAccess(LegalDocument $document)
    {
        if ($document->opd_id !== auth()->user()->opd_id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }
    }
}