<?php
// app/Http/Controllers/Dashboard/Pembantu/DashboardController.php

namespace App\Http\Controllers\Dashboard\Pembantu;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.pembantu.index', [
            'user' => auth()->user(),
            'opd' => auth()->user()->opd
        ]);
    }
}