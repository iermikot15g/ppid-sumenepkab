<?php

namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\OpdService;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicServiceController extends Controller
{
    public function index()
    {
        // PPID Utama bisa melihat semua layanan dari semua OPD
        $services = OpdService::with('opd')
            ->orderBy('sort_order')
            ->paginate(15);
        
        return view('dashboard.utama.cms.public-services.index', compact('services'));
    }

    public function create()
    {
        // Ambil semua OPD untuk dipilih
        $opds = Opd::where('is_active', true)->orderBy('name')->get();
        
        return view('dashboard.utama.cms.public-services.create', compact('opds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'opd_id' => 'required|exists:opds,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'opd_id' => $validated['opd_id'],
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

        return redirect()->route('utama.cms.public-services.index')
            ->with('success', 'Layanan publik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $service = OpdService::with('opd')->findOrFail($id);
        $opds = Opd::where('is_active', true)->orderBy('name')->get();
        
        return view('dashboard.utama.cms.public-services.edit', compact('service', 'opds'));
    }

    public function update(Request $request, $id)
    {
        $service = OpdService::findOrFail($id);

        $validated = $request->validate([
            'opd_id' => 'required|exists:opds,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'opd_id' => $validated['opd_id'],
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

        return redirect()->route('utama.cms.public-services.index')
            ->with('success', 'Layanan publik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $service = OpdService::findOrFail($id);

        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }

        $service->delete();

        return redirect()->route('utama.cms.public-services.index')
            ->with('success', 'Layanan publik berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $service = OpdService::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);

        return response()->json(['success' => true]);
    }
}