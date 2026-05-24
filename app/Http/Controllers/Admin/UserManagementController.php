<?php
// app/Http/Controllers/Admin/UserManagementController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Opd;
use App\Traits\LogsActivity;  // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    use LogsActivity;  // <-- TAMBAHKAN INI

    public function index()
    {
        $users = User::with('opd', 'roles')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'super_admin')->get();
        $opds = Opd::where('is_active', true)->get();
        return view('admin.users.create', compact('roles', 'opds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
            'opd_id' => 'nullable|exists:opds,id',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'opd_id' => $validated['opd_id'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $user->assignRole($validated['role']);

        // <-- TAMBAHKAN LOG ACTIVITY
        $this->logActivity('create_user', 'Menambahkan user: ' . $user->name . ' dengan role ' . $validated['role'], $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'super_admin')->get();
        $opds = Opd::where('is_active', true)->get();
        return view('admin.users.edit', compact('user', 'roles', 'opds'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
            'role' => 'required|exists:roles,name',
            'opd_id' => 'nullable|exists:opds,id',
            'is_active' => 'boolean',
        ]);

        $oldRole = $user->roles->first()->name ?? 'none';
        $newRole = $validated['role'];

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'opd_id' => $validated['opd_id'],
            'is_active' => $request->boolean('is_active'),
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles([$newRole]);

        // <-- TAMBAHKAN LOG ACTIVITY
        $this->logActivity('update_user', 'Memperbarui user: ' . $user->name . ' (Role: ' . $oldRole . ' -> ' . $newRole . ')', $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('super_admin')) {
            return redirect()->back()->with('error', 'Super Admin tidak dapat dihapus.');
        }
        
        // <-- TAMBAHKAN LOG ACTIVITY (SEBELUM DELETE)
        $this->logActivity('delete_user', 'Menghapus user: ' . $user->name, $user);
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function toggleActive(User $user)
    {
        $oldStatus = $user->is_active ? 'Aktif' : 'Tidak Aktif';
        $newStatus = !$user->is_active ? 'Aktif' : 'Tidak Aktif';
        
        $user->update(['is_active' => !$user->is_active]);
        
        // <-- TAMBAHKAN LOG ACTIVITY
        $this->logActivity('toggle_user_status', 'Mengubah status user ' . $user->name . ' dari ' . $oldStatus . ' menjadi ' . $newStatus, $user);
        
        return response()->json([
            'success' => true,
            'is_active' => $user->is_active
        ]);
    }
}