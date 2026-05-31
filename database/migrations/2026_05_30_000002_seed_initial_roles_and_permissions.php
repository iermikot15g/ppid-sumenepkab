<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up(): void
    {
        // ========== DAFTAR PERMISSION LENGKAP (SEMUA YANG DIBUTUHKAN) ==========
        $permissions = [
            // === DOKUMEN ===
            'view documents',
            'view any documents',
            'create documents',
            'update documents',
            'delete documents',
            'publish documents',
            'unpublish documents',
            'archive documents',
            'force unpublish documents',
            'view any documents global',
            'update any documents',
            'delete any documents',
            
            // === OPD ===
            'view opds',
            'view any opds',
            'create opds',
            'update opds',
            'update any opds',        // ← DITAMBAHKAN
            'delete opds',
            'activate opds',
            
            // === DESA ===
            'view villages',
            'view any villages',
            'create villages',
            'update villages',
            'update any villages',     // ← DITAMBAHKAN
            'delete villages',
            
            // === CMS ===
            'manage news',
            'manage hero slides',
            'manage static pages',
            'manage quick access',
            'manage opd services',
            
            // === MONITORING & LAPORAN ===
            'view monitoring dashboard',
            'view reports',
            'export reports',
            
            // === MANAJEMEN USER ===
            'manage users',
            'manage roles',
            
            // === MASTER DATA ===
            'manage categories',
            
            // === AUDIT ===
            'view audit logs',
        ];
        
        // Buat semua permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
        
        // ========== DAFTAR ROLE ==========
        $roles = ['super_admin', 'ppid_utama', 'ppid_pembantu', 'pimpinan', 'masyarakat'];
        
        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
        }
        
        // ========== ASSIGN PERMISSIONS KE ROLE ==========
        
        // 1. SUPER ADMIN (semua permission)
        $superAdmin = Role::where('name', 'super_admin')->first();
        $superAdmin->syncPermissions(Permission::all());
        
        // 2. PPID UTAMA
        $ppidUtama = Role::where('name', 'ppid_utama')->first();
        $ppidUtama->syncPermissions([
            'force unpublish documents',
            'view any documents global',
            'update any documents',
            'delete any documents',
            'manage news',
            'manage hero slides',
            'manage static pages',
            'manage quick access',
            'manage opd services',
            'view monitoring dashboard',
            'view reports',
            'export reports',
            'view any opds',
            'update any opds',        // ← SEKARANG SUDAH ADA
            'view any villages',
            'update any villages',     // ← SEKARANG SUDAH ADA
        ]);
        
        // 3. PPID PEMBANTU
        $ppidPembantu = Role::where('name', 'ppid_pembantu')->first();
        $ppidPembantu->syncPermissions([
            'view documents',
            'create documents',
            'update documents',
            'delete documents',
            'publish documents',
            'unpublish documents',
            'archive documents',
            'update opds',
            'manage opd services',
        ]);
        
        // 4. PIMPINAN (READ-ONLY)
        $pimpinan = Role::where('name', 'pimpinan')->first();
        $pimpinan->syncPermissions([
            'view monitoring dashboard',
            'view reports',
            'export reports',
            'view any documents',
            'view documents',
        ]);
        
        // 5. MASYARAKAT
        $masyarakat = Role::where('name', 'masyarakat')->first();
        $masyarakat->syncPermissions([
            'view documents',
        ]);
    }

    public function down(): void
    {
        // Data akan ikut terhapus saat tabel di-drop
    }
};