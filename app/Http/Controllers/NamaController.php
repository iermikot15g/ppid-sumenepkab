<?php
// Template controller dengan semua method yang diperlukan
namespace App\Http\Controllers\NamaController;

use App\Http\Controllers\Controller;
use App\Models\NamaModel;
use Illuminate\Http\Request;

class NamaController extends Controller
{
    public function index() { return view('...'); }
    public function create() { return view('...'); }
    public function store(Request $request) { /* ... */ }
    public function edit($id) { return view('...', compact('data')); }
    public function update(Request $request, $id) { /* ... */ }
    public function destroy($id) { /* ... */ }
}