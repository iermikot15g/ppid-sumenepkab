<?php

namespace App\Traits;

use App\Models\OpdService;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ManagesPublicServices
{
    /**
     * Get the service model instance
     */
    protected function getServiceModel()
    {
        return app(OpdService::class);
    }

    /**
     * Validate service request data
     */
    protected function validateService(Request $request)
    {
        return $request->validate([
            'opd_id' => 'required|exists:opds,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
    }

    /**
     * Handle icon upload
     */
    protected function handleIconUpload(Request $request, $existingIcon = null)
    {
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($existingIcon && Storage::disk('public')->exists($existingIcon)) {
                Storage::disk('public')->delete($existingIcon);
            }
            return $request->file('icon')->store('services', 'public');
        }
        return $existingIcon;
    }

    /**
     * Get list of active OPDs for dropdown
     */
    protected function getOpdsForSelect()
    {
        return Opd::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * Prepare service data from request
     */
    protected function prepareServiceData(Request $request, $existingIcon = null)
    {
        $validated = $this->validateService($request);
        
        $data = [
            'opd_id' => $validated['opd_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'url' => $validated['url'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle icon
        $iconPath = $this->handleIconUpload($request, $existingIcon);
        if ($iconPath) {
            $data['icon'] = $iconPath;
        }

        return $data;
    }
}