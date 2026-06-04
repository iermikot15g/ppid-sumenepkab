<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GaleriController extends Controller
{
    use LogsActivity, AuthorizesRequests;

    // Constructor dihapus karena middleware sudah di handle di routes/web.php
    // dan authorization sudah di handle oleh Policy

    public function index()
    {
        $this->authorize('viewAny', News::class);
        
        $galleries = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'gallery')
            ->latest()
            ->paginate(10);
            
        return view('dashboard.pembantu.cms.gallery.index', compact('galleries'));
    }

    public function create()
    {
        $this->authorize('create', News::class);
        
        return view('dashboard.pembantu.cms.gallery.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', News::class);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'is_published' => 'boolean',
        ]);

        $user = Auth::user();
        
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('galleries/' . $user->opd_id, $fileName, 'public');
        }

        $gallery = News::create([
            'opd_id' => $user->opd_id,
            'title' => $validated['title'],
            'content' => $validated['description'] ?? null,
            'thumbnail' => $filePath ?? null,
            'type' => 'gallery',
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
            'created_by' => $user->id,
        ]);

        $this->logActivity('create_gallery', 'Membuat galeri foto: ' . $gallery->title, $gallery);

        return redirect()->route('pembantu.cms.gallery.index')
            ->with('success', 'Galeri foto berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gallery = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'gallery')
            ->findOrFail($id);
            
        $this->authorize('update', $gallery);
            
        return view('dashboard.pembantu.cms.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $gallery = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'gallery')
            ->findOrFail($id);
            
        $this->authorize('update', $gallery);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('galleries/' . $gallery->opd_id, $fileName, 'public');
            $gallery->thumbnail = $filePath;
        }

        $gallery->title = $validated['title'];
        $gallery->content = $validated['description'] ?? null;
        $gallery->is_published = $validated['is_published'] ?? false;
        
        if (($validated['is_published'] ?? false) && !$gallery->published_at) {
            $gallery->published_at = now();
        }
        
        $gallery->save();

        $this->logActivity('update_gallery', 'Memperbarui galeri foto: ' . $gallery->title, $gallery);

        return redirect()->route('pembantu.cms.gallery.index')
            ->with('success', 'Galeri foto berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gallery = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'gallery')
            ->findOrFail($id);
            
        $this->authorize('delete', $gallery);
            
        $this->logActivity('delete_gallery', 'Menghapus galeri foto: ' . $gallery->title, $gallery);
        
        if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }
        
        $gallery->delete();

        return redirect()->route('pembantu.cms.gallery.index')
            ->with('success', 'Galeri foto berhasil dihapus.');
    }

    public function togglePublished($id)
    {
        $gallery = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'gallery')
            ->findOrFail($id);
            
        $this->authorize('update', $gallery);
            
        $gallery->is_published = !$gallery->is_published;
        
        if ($gallery->is_published && !$gallery->published_at) {
            $gallery->published_at = now();
        }
        
        $gallery->save();
        
        $this->logActivity('toggle_gallery', 'Mengubah status publikasi galeri: ' . $gallery->title, $gallery);

        return response()->json(['success' => true]);
    }
}