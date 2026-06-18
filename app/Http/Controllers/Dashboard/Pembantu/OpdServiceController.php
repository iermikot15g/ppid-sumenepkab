<?php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;
use App\Models\OpdService;
use App\Traits\ManagesPublicServices;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpdServiceController extends Controller
{
    use ManagesPublicServices, LogsActivity;

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
        $opdId = $this->getOpdId();
        $data = $this->prepareServiceData($request);
        $data['opd_id'] = $opdId;

        $service = OpdService::create($data);

        $this->logActivity('create_service', 'Menambahkan layanan publik: ' . $service->name, $service);

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

        $data = $this->prepareServiceData($request, $service->icon);
        $service->update($data);

        $this->logActivity('update_service', 'Memperbarui layanan publik: ' . $service->name, $service);

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

        $this->logActivity('delete_service', 'Menghapus layanan publik: ' . $service->name, $service);
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

        $this->logActivity('toggle_service', 'Mengubah status layanan: ' . $service->name, $service);

        return response()->json(['success' => true]);
    }
}