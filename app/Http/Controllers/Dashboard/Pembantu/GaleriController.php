<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GaleriController extends Controller
{
    use LogsActivity, AuthorizesRequests;

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

    public function store(NewsRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('galleries/' . $user->opd_id, $fileName, 'public');
        }

        $gallery = News::create([
            'opd_id' => $user->opd_id,
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
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

    public function update(NewsRequest $request, $id)
    {
        $gallery = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'gallery')
            ->findOrFail($id);
            
        $this->authorize('update', $gallery);

        $validated = $request->validated();

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
        $gallery->content = $validated['content'] ?? null;
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