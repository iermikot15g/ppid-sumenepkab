<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $agendas = News::where('type', 'agenda')
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);
        return view('dashboard.pembantu.cms.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('dashboard.pembantu.cms.agenda.create');
    }

    public function store(Request $request)
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
            'created_by' => Auth::id(),
        ];

        News::create($data);

        $this->logActivity('create_agenda', 'Menambahkan agenda: ' . $validated['title']);

        return redirect()->route('pembantu.cms.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = News::where('type', 'agenda')
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        return view('dashboard.pembantu.cms.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $agenda = News::where('type', 'agenda')
            ->where('created_by', Auth::id())
            ->findOrFail($id);

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
            'published_at' => $request->boolean('is_published') && !$agenda->published_at ? now() : $agenda->published_at,
        ];

        $agenda->update($data);

        $this->logActivity('update_agenda', 'Memperbarui agenda: ' . $validated['title']);

        return redirect()->route('pembantu.cms.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $agenda = News::where('type', 'agenda')
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        $this->logActivity('delete_agenda', 'Menghapus agenda: ' . $agenda->title);
        
        $agenda->delete();

        return redirect()->route('pembantu.cms.agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }

    public function togglePublished($id)
    {
        $agenda = News::where('type', 'agenda')
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        
        $agenda->update([
            'is_published' => !$agenda->is_published,
            'published_at' => !$agenda->is_published ? now() : null,
        ]);

        return response()->json(['success' => true]);
    }
}