<?php
// app/Http/Controllers/Dashboard/Utama/CmsNewsController.php

namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CmsNewsController extends Controller
{
    // ========== CMS BERITA ==========
    public function index()
    {
        $news = News::where('type', 'news')
            ->latest()
            ->paginate(10);
        return view('dashboard.utama.cms.news.index', compact('news'));
    }

    public function create()
    {
        return view('dashboard.utama.cms.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'type' => 'news',
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'created_by' => auth()->id(),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('utama.cms.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        if ($news->type !== 'news') {
            abort(404);
        }
        return view('dashboard.utama.cms.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        if ($news->type !== 'news') {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$news->published_at ? now() : $news->published_at,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('utama.cms.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->type !== 'news') {
            abort(404);
        }

        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        
        $news->delete();

        return redirect()->route('utama.cms.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function togglePublished(News $news)
    {
        $news->update([
            'is_published' => !$news->is_published,
            'published_at' => !$news->is_published ? now() : null,
        ]);

        return response()->json(['success' => true]);
    }

    // ========== CMS AGENDA ==========
    public function agendaIndex()
    {
        $agendas = News::where('type', 'agenda')
            ->latest()
            ->paginate(10);
        return view('dashboard.utama.cms.agenda.index', compact('agendas'));
    }

    public function agendaCreate()
    {
        return view('dashboard.utama.cms.agenda.create');
    }

    public function agendaStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'] ?? '',
            'type' => 'agenda',
            'event_date' => $validated['event_date'],
            'location' => $validated['location'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'created_by' => auth()->id(),
        ];

        News::create($data);

        return redirect()->route('utama.cms.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function agendaEdit(News $news)
    {
        if ($news->type !== 'agenda') {
            abort(404);
        }
        return view('dashboard.utama.cms.agenda.edit', compact('news'));
    }

    public function agendaUpdate(Request $request, News $news)
    {
        if ($news->type !== 'agenda') {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'] ?? '',
            'event_date' => $validated['event_date'],
            'location' => $validated['location'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$news->published_at ? now() : $news->published_at,
        ];

        $news->update($data);

        return redirect()->route('utama.cms.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function agendaDestroy(News $news)
    {
        if ($news->type !== 'agenda') {
            abort(404);
        }
        
        $news->delete();

        return redirect()->route('utama.cms.agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }

    // ========== CMS GALERI FOTO ==========
    public function galleryIndex()
    {
        $galleries = News::where('type', 'gallery')
            ->latest()
            ->paginate(12);
        return view('dashboard.utama.cms.gallery.index', compact('galleries'));
    }

    public function galleryCreate()
    {
        return view('dashboard.utama.cms.gallery.create');
    }

    public function galleryStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('gallery', 'public');

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => '',
            'thumbnail' => $thumbnailPath,
            'type' => 'gallery',
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'created_by' => auth()->id(),
        ];

        News::create($data);

        return redirect()->route('utama.cms.gallery.index')
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    public function galleryEdit(News $news)
    {
        if ($news->type !== 'gallery') {
            abort(404);
        }
        return view('dashboard.utama.cms.gallery.edit', compact('news'));
    }

    public function galleryUpdate(Request $request, News $news)
    {
        if ($news->type !== 'gallery') {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => '',
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$news->published_at ? now() : $news->published_at,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('gallery', 'public');
        }

        $news->update($data);

        return redirect()->route('utama.cms.gallery.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function galleryDestroy(News $news)
    {
        if ($news->type !== 'gallery') {
            abort(404);
        }
        
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        
        $news->delete();

        return redirect()->route('utama.cms.gallery.index')
            ->with('success', 'Foto berhasil dihapus.');
    }

    // ========== CMS INFOGRAFIS ==========
    public function infographicIndex()
    {
        $infographics = News::where('type', 'infographic')
            ->latest()
            ->paginate(10);
        return view('dashboard.utama.cms.infographic.index', compact('infographics'));
    }

    public function infographicCreate()
    {
        return view('dashboard.utama.cms.infographic.create');
    }

    public function infographicStore(Request $request)
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
            'created_by' => auth()->id(),
        ];

        News::create($data);

        return redirect()->route('utama.cms.infographic.index')
            ->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function infographicEdit(News $news)
    {
        if ($news->type !== 'infographic') {
            abort(404);
        }
        return view('dashboard.utama.cms.infographic.edit', compact('news'));
    }

    public function infographicUpdate(Request $request, News $news)
    {
        if ($news->type !== 'infographic') {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => '',
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$news->published_at ? now() : $news->published_at,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('infographic', 'public');
        }

        $news->update($data);

        return redirect()->route('utama.cms.infographic.index')
            ->with('success', 'Infografis berhasil diperbarui.');
    }

    public function infographicDestroy(News $news)
    {
        if ($news->type !== 'infographic') {
            abort(404);
        }
        
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        
        $news->delete();

        return redirect()->route('utama.cms.infographic.index')
            ->with('success', 'Infografis berhasil dihapus.');
    }

    // ========== CMS PROFIL PPID ==========
    public function profilIndex()
    {
        $pages = StaticPage::where('page_key', 'like', 'profil_%')->get();
        return view('dashboard.utama.cms.profil.index', compact('pages'));
    }

    public function profilEdit($pageKey)
    {
        $page = StaticPage::where('page_key', $pageKey)->firstOrFail();
        return view('dashboard.utama.cms.profil.edit', compact('page'));
    }

    public function profilUpdate(Request $request, $pageKey)
    {
        $page = StaticPage::where('page_key', $pageKey)->firstOrFail();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
        ]);
        
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'updated_by' => auth()->id(),
        ];
        
        if ($request->hasFile('pdf_file')) {
            if ($page->pdf_file_path) {
                Storage::disk('public')->delete($page->pdf_file_path);
            }
            $data['pdf_file_path'] = $request->file('pdf_file')->store('profil', 'public');
        }
        
        $page->update($data);
        
        return redirect()->route('utama.cms.profil.index')
            ->with('success', 'Konten profil berhasil diperbarui.');
    }

    // ========== CMS STANDAR LAYANAN ==========
    public function standarIndex()
    {
        $pages = StaticPage::where('page_key', 'like', 'standar_%')->get();
        return view('dashboard.utama.cms.standar.index', compact('pages'));
    }

    public function standarEdit($pageKey)
    {
        $page = StaticPage::where('page_key', $pageKey)->firstOrFail();
        return view('dashboard.utama.cms.standar.edit', compact('page'));
    }

    public function standarUpdate(Request $request, $pageKey)
    {
        $page = StaticPage::where('page_key', $pageKey)->firstOrFail();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
        ]);
        
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'updated_by' => auth()->id(),
        ];
        
        if ($request->hasFile('pdf_file')) {
            if ($page->pdf_file_path) {
                Storage::disk('public')->delete($page->pdf_file_path);
            }
            $data['pdf_file_path'] = $request->file('pdf_file')->store('standar', 'public');
        }
        
        $page->update($data);
        
        return redirect()->route('utama.cms.standar.index')
            ->with('success', 'Konten standar layanan berhasil diperbarui.');
    }
}