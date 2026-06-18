<?php

use App\Models\Regency;
use App\Models\District;
use Illuminate\Support\Facades\Route;

// ============================================================================
// API ROUTES - Untuk dropdown dinamis di form
// ============================================================================

Route::get('/regencies/{provinceId}', function ($provinceId) {
    return Regency::where('province_id', $provinceId)
        ->orderBy('name')
        ->get(['id', 'name']);
});

Route::get('/districts/{regencyId}', function ($regencyId) {
    return District::where('regency_id', $regencyId)
        ->orderBy('name')
        ->get(['id', 'name']);
});