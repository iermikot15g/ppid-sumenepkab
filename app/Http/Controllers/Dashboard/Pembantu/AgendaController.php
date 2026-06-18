<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $agendas = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'agenda')
            ->latest()
            ->paginate(10);
            
        return view('dashboard.pembantu.cms.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('dashboard.pembantu.cms.agenda.create');
    }

    public function store(NewsRequest $request)
    {
        $validated = $request->validated();
        
        $user = Auth::user();

        $agenda = News::create([
            'opd_id' => $user->opd_id,
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'type' => 'agenda',
            'event_date' => $validated['event_date'] ?? null,
            'location' => $validated['location'] ?? null,
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
            'created_by' => $user->id,
        ]);

        $this->logActivity('create_agenda', 'Membuat agenda: ' . $agenda->title, $agenda);

        return redirect()->route('pembantu.cms.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'agenda')
            ->findOrFail($id);
            
        return view('dashboard.pembantu.cms.agenda.edit', compact('agenda'));
    }

    public function update(NewsRequest $request, $id)
    {
        $agenda = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'agenda')
            ->findOrFail($id);

        $validated = $request->validated();

        $agenda->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'location' => $validated['location'] ?? null,
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => ($validated['is_published'] ?? false) ? now() : $agenda->published_at,
        ]);

        $this->logActivity('update_agenda', 'Memperbarui agenda: ' . $agenda->title, $agenda);

        return redirect()->route('pembantu.cms.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $agenda = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'agenda')
            ->findOrFail($id);
            
        $this->logActivity('delete_agenda', 'Menghapus agenda: ' . $agenda->title, $agenda);
        $agenda->delete();

        return redirect()->route('pembantu.cms.agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }

    public function togglePublished($id)
    {
        $agenda = News::where('opd_id', Auth::user()->opd_id)
            ->where('type', 'agenda')
            ->findOrFail($id);
            
        $agenda->is_published = !$agenda->is_published;
        
        if ($agenda->is_published && !$agenda->published_at) {
            $agenda->published_at = now();
        }
        
        $agenda->save();
        
        $this->logActivity('toggle_agenda', 'Mengubah status publikasi agenda: ' . $agenda->title, $agenda);

        return response()->json(['success' => true]);
    }
}