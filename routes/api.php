<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Contoh route API
Route::get('/user', function (Request $request) {
    return "API Berjalan!";
});