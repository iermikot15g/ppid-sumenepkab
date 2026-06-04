<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========== DAFTAR PERMISSION LENGKAP ==========
        $permissions = [
            // Dashboard
            'view_dashboard_all',
            'view_dashboard_own_opd',
            
            // Dokumen
            'manage_all_documents',
            'manage_own_opd_documents',
            'view_own_opd_documents',
            'download_document',
            'preview_document',
            
            // Laporan
            'view_reports_all',
            'view_reports_own_opd',
            
            // CMS Agenda
            'manage_all_agenda',
            'manage_own_opd_agenda',
            
            // CMS Galeri
            'manage_all_gallery',
            'manage_own_opd_gallery',
            'view_own_opd_gallery',
            
            // CMS Infografis
            'manage_all_infographic',
            'manage_own_opd_infographic',
            
            // CMS Hero Slider
            'manage_hero_slider',
            
            // CMS Profil PPID Utama
            'manage_ppid_utama_profile',
            
            // CMS Standar Layanan
            'manage_standar_layanan',
            
            // CMS Layanan Publik
            'manage_all_public_services',
            'manage_own_opd_public_services',
            
            // CMS Profil OPD
            'manage_own_opd_profile',
            
            // Administrasi
            'manage_opd',
            'manage_village',
            'manage_master_category',
            'manage_user',
            'view_audit_log',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ========== BUAT ROLE ==========
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $ppidUtama = Role::firstOrCreate(['name' => 'ppid_utama', 'guard_name' => 'web']);
        $ppidPembantu = Role::firstOrCreate(['name' => 'ppid_pembantu', 'guard_name' => 'web']);
        $pimpinan = Role::firstOrCreate(['name' => 'pimpinan', 'guard_name' => 'web']);
        $masyarakat = Role::firstOrCreate(['name' => 'masyarakat', 'guard_name' => 'web']);

        // ========== ASSIGN PERMISSION KE ROLE ==========
        
        // SUPER ADMIN (semua permission)
        $superAdmin->syncPermissions(Permission::all());

        // PPID UTAMA
        $ppidUtama->syncPermissions([
            'view_dashboard_all',
            'manage_all_documents',
            'view_reports_all',
            'manage_all_agenda',
            'manage_all_gallery',
            'manage_all_infographic',
            'manage_hero_slider',
            'manage_ppid_utama_profile',
            'manage_standar_layanan',
            'manage_all_public_services',
            'download_document',
            'preview_document',
        ]);

        // PPID PEMBANTU
        $ppidPembantu->syncPermissions([
            'view_dashboard_own_opd',
            'manage_own_opd_documents',
            'view_own_opd_documents',
            'view_reports_own_opd',
            'manage_own_opd_agenda',
            'manage_own_opd_gallery',
            'view_own_opd_gallery',
            'manage_own_opd_infographic',
            'manage_own_opd_profile',
            'manage_own_opd_public_services',
            'download_document',
            'preview_document',
        ]);

        // PIMPINAN
        $pimpinan->syncPermissions([
            'view_dashboard_own_opd',
            'view_own_opd_documents',
            'view_reports_own_opd',
            'download_document',
            'preview_document',
        ]);

        // MASYARAKAT
        $masyarakat->syncPermissions([
            'download_document',
            'preview_document',
        ]);

        $this->command->info('Roles and permissions seeded successfully!');
    }
}