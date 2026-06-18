<?php

namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\OpdService;
use App\Traits\ManagesPublicServices;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class PublicServiceController extends Controller
{
    use ManagesPublicServices, LogsActivity;

    public function index()
    {
        $services = OpdService::with('opd')
            ->orderBy('sort_order')
            ->paginate(15);
        
        return view('dashboard.utama.cms.public-services.index', compact('services'));
    }

    public function create()
    {
        $opds = $this->getOpdsForSelect();
        return view('dashboard.utama.cms.public-services.create', compact('opds'));
    }

    public function store(Request $request)
    {
        $data = $this->prepareServiceData($request);
        $service = OpdService::create($data);

        $this->logActivity('create_service_global', 'Menambahkan layanan publik global: ' . $service->name, $service);

        return redirect()->route('utama.cms.public-services.index')
            ->with('success', 'Layanan publik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $service = OpdService::with('opd')->findOrFail($id);
        $opds = $this->getOpdsForSelect();
        
        return view('dashboard.utama.cms.public-services.edit', compact('service', 'opds'));
    }

    public function update(Request $request, $id)
    {
        $service = OpdService::findOrFail($id);
        $data = $this->prepareServiceData($request, $service->icon);
        $service->update($data);

        $this->logActivity('update_service_global', 'Memperbarui layanan publik global: ' . $service->name, $service);

        return redirect()->route('utama.cms.public-services.index')
            ->with('success', 'Layanan publik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $service = OpdService::findOrFail($id);

        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }

        $this->logActivity('delete_service_global', 'Menghapus layanan publik global: ' . $service->name, $service);
        $service->delete();

        return redirect()->route('utama.cms.public-services.index')
            ->with('success', 'Layanan publik berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $service = OpdService::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);

        $this->logActivity('toggle_service_global', 'Mengubah status layanan global: ' . $service->name, $service);

        return response()->json(['success' => true]);
    }
}