<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view_dashboard',
            'view_statistics',
            
            // Information management
            'view_information',
            'create_information',
            'edit_information',
            'delete_information',
            'publish_information',
            
            // Request management
            'view_requests',
            'process_requests',
            'approve_requests',
            'reject_requests',
            'export_requests',
            
            // Report management
            'view_reports',
            'generate_reports',
            'export_reports',
            
            // User management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'assign_roles',
            
            // Settings
            'manage_settings',
            'manage_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $roles = [
            'super_admin' => 'Super Administrator with full access',
            'ppid_utama' => 'Main PPID Officer',
            'ppid_pembantu' => 'Assistant PPID Officer',
            'pimpinan' => 'Leadership/Management',
            'masyarakat' => 'Public User'
        ];

        foreach ($roles as $roleName => $roleDescription) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            
            // Assign permissions based on role
            switch ($roleName) {
                case 'super_admin':
                    // Give all permissions
                    $role->givePermissionTo(Permission::all());
                    break;
                    
                case 'ppid_utama':
                    // Give main PPID permissions
                    $role->givePermissionTo([
                        'view_dashboard',
                        'view_statistics',
                        'view_information',
                        'create_information',
                        'edit_information',
                        'publish_information',
                        'view_requests',
                        'process_requests',
                        'approve_requests',
                        'reject_requests',
                        'view_reports',
                        'generate_reports',
                        'export_reports',
                        'view_users',
                        'manage_logs',
                    ]);
                    break;
                    
                case 'ppid_pembantu':
                    // Give assistant PPID permissions
                    $role->givePermissionTo([
                        'view_dashboard',
                        'view_information',
                        'create_information',
                        'edit_information',
                        'view_requests',
                        'process_requests',
                        'view_reports',
                    ]);
                    break;
                    
                case 'pimpinan':
                    // Give leadership permissions
                    $role->givePermissionTo([
                        'view_dashboard',
                        'view_statistics',
                        'view_information',
                        'view_requests',
                        'approve_requests',
                        'view_reports',
                        'view_users',
                    ]);
                    break;
                    
                case 'masyarakat':
                    // Give public user permissions
                    $role->givePermissionTo([
                        'view_information',
                        'view_dashboard',
                    ]);
                    break;
            }
        }
        
        $this->command->info('Roles and permissions seeded successfully!');
    }
}