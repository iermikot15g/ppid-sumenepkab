<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InfografisController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $infographics = News::where('type', 'infographic')
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(12);
        return view('dashboard.pembantu.cms.infographic.index', compact('infographics'));
    }

    public function create()
    {
        return view('dashboard.pembantu.cms.infographic.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('infographic', 'public');

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => '',
            'thumbnail' => $thumbnailPath,
            'type' => 'infographic',
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'created_by' => Auth::id(),
        ];

        News::create($data);

        $this->logActivity('create_infographic', 'Menambahkan infografis: ' . $validated['title']);

        return redirect()->route('pembantu.cms.infographic.index')
            ->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $infographic = News::where('type', 'infographic')
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        // Cek apakah file thumbnail masih ada
        if ($infographic->thumbnail && !Storage::disk('public')->exists($infographic->thumbnail)) {
            $infographic->thumbnail = null; // Set ke null jika file tidak ada
        }
        
        return view('dashboard.pembantu.cms.infographic.edit', compact('infographic'));
    }

    public function update(Request $request, $id)
    {
        $infographic = News::where('type', 'infographic')
            ->where('created_by', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$infographic->published_at ? now() : $infographic->published_at,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($infographic->thumbnail) {
                Storage::disk('public')->delete($infographic->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('infographic', 'public');
        }

        $infographic->update($data);

        $this->logActivity('update_infographic', 'Memperbarui infografis: ' . $validated['title']);

        return redirect()->route('pembantu.cms.infographic.index')
            ->with('success', 'Infografis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $infographic = News::where('type', 'infographic')
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        if ($infographic->thumbnail) {
            Storage::disk('public')->delete($infographic->thumbnail);
        }
        
        $this->logActivity('delete_infographic', 'Menghapus infografis: ' . $infographic->title);
        
        $infographic->delete();

        return redirect()->route('pembantu.cms.infographic.index')
            ->with('success', 'Infografis berhasil dihapus.');
    }

    public function togglePublished($id)
    {
        $infographic = News::where('type', 'infographic')
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        $infographic->update([
            'is_published' => !$infographic->is_published,
            'published_at' => !$infographic->is_published ? now() : null,
        ]);

        return response()->json(['success' => true]);
    }
}
