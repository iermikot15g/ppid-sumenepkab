<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\OpdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OpdServiceController extends Controller
{
    private function getOpdId()
    {
        $opd = Auth::user()->opd;
        if (!$opd) {
            abort(403, 'Anda tidak memiliki OPD yang terdaftar.');
        }
        return $opd->id;
    }

    public function index()
    {
        $services = OpdService::where('opd_id', $this->getOpdId())
            ->orderBy('sort_order')
            ->get();
        return view('dashboard.pembantu.cms.services.index', compact('services'));
    }

    public function create()
    {
        return view('dashboard.pembantu.cms.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'opd_id' => $this->getOpdId(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'url' => $validated['url'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('services', 'public');
        }

        OpdService::create($data);

        return redirect()->route('pembantu.cms.services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(OpdService $service)
    {
        if ($service->opd_id !== $this->getOpdId()) {
            abort(403);
        }
        return view('dashboard.pembantu.cms.services.edit', compact('service'));
    }

    public function update(Request $request, OpdService $service)
    {
        if ($service->opd_id !== $this->getOpdId()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'url' => $validated['url'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('icon')) {
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            $data['icon'] = $request->file('icon')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('pembantu.cms.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(OpdService $service)
    {
        if ($service->opd_id !== $this->getOpdId()) {
            abort(403);
        }

        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }

        $service->delete();

        return redirect()->route('pembantu.cms.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    public function toggleActive(OpdService $service)
    {
        if ($service->opd_id !== $this->getOpdId()) {
            abort(403);
        }

        $service->update(['is_active' => !$service->is_active]);

        return response()->json(['success' => true]);
    }
}