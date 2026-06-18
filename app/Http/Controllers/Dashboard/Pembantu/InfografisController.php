<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InfografisController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $infografis = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'infographic')
            ->latest()
            ->paginate(10);
            
        return view('dashboard.pembantu.cms.infographic.index', compact('infografis'));
    }

    public function create()
    {
        return view('dashboard.pembantu.cms.infographic.create');
    }

    public function store(NewsRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('infographic/' . $user->opd_id, $fileName, 'public');
        }

        $infografis = News::create([
            'opd_id' => $user->opd_id,
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'thumbnail' => $filePath ?? null,
            'type' => 'infographic',
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
            'created_by' => $user->id,
        ]);

        $this->logActivity('create_infographic', 'Membuat infografis: ' . $infografis->title, $infografis);

        return redirect()->route('pembantu.cms.infographic.index')
            ->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $infografis = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'infographic')
            ->findOrFail($id);
            
        return view('dashboard.pembantu.cms.infographic.edit', compact('infografis'));
    }

    public function update(NewsRequest $request, $id)
    {
        $infografis = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'infographic')
            ->findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($infografis->thumbnail && Storage::disk('public')->exists($infografis->thumbnail)) {
                Storage::disk('public')->delete($infografis->thumbnail);
            }
            
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('infographic/' . $infografis->opd_id, $fileName, 'public');
            $infografis->thumbnail = $filePath;
        }

        $infografis->title = $validated['title'];
        $infografis->content = $validated['content'] ?? null;
        $infografis->is_published = $validated['is_published'] ?? false;
        
        if (($validated['is_published'] ?? false) && !$infografis->published_at) {
            $infografis->published_at = now();
        }
        
        $infografis->save();

        $this->logActivity('update_infographic', 'Memperbarui infografis: ' . $infografis->title, $infografis);

        return redirect()->route('pembantu.cms.infographic.index')
            ->with('success', 'Infografis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $infografis = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'infographic')
            ->findOrFail($id);
            
        $this->logActivity('delete_infographic', 'Menghapus infografis: ' . $infografis->title, $infografis);
        
        if ($infografis->thumbnail && Storage::disk('public')->exists($infografis->thumbnail)) {
            Storage::disk('public')->delete($infografis->thumbnail);
        }
        
        $infografis->delete();

        return redirect()->route('pembantu.cms.infographic.index')
            ->with('success', 'Infografis berhasil dihapus.');
    }

    public function togglePublished($id)
    {
        $infografis = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'infographic')
            ->findOrFail($id);
            
        $infografis->is_published = !$infografis->is_published;
        
        if ($infografis->is_published && !$infografis->published_at) {
            $infografis->published_at = now();
        }
        
        $infografis->save();
        
        $this->logActivity('toggle_infographic', 'Mengubah status publikasi infografis: ' . $infografis->title, $infografis);

        return response()->json(['success' => true]);
    }
}