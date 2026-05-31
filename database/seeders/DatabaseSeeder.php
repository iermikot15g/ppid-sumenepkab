<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Opd;
use App\Models\Village;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========== 1. PASTIKAN PERMISSION SUDAH ADA ==========
        // Buat permission yang mungkin belum ada di migration
        $permissions = [
            // Dokumen
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
            
            // OPD & Desa
            'view opds',
            'view any opds',
            'create opds',
            'update opds',
            'delete opds',
            'activate opds',
            'view villages',
            'view any villages',
            'create villages',
            'update villages',
            'delete villages',
            
            // CMS
            'manage news',
            'manage hero slides',
            'manage static pages',
            'manage quick access',
            
            // Monitoring & Laporan
            'view monitoring dashboard',
            'view reports',
            'export reports',
            
            // Manajemen User
            'manage users',
            'manage roles',
            
            // Master Data
            'manage categories',
            
            // Audit
            'view audit logs',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        
        // ========== 2. AMBIL ROLE ==========
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $ppidUtamaRole = Role::firstOrCreate(['name' => 'ppid_utama', 'guard_name' => 'web']);
        $ppidPembantuRole = Role::firstOrCreate(['name' => 'ppid_pembantu', 'guard_name' => 'web']);
        $pimpinanRole = Role::firstOrCreate(['name' => 'pimpinan', 'guard_name' => 'web']);
        $masyarakatRole = Role::firstOrCreate(['name' => 'masyarakat', 'guard_name' => 'web']);

        // ========== 3. ASSIGN PERMISSIONS KE ROLE ==========
        
        // Super Admin: semua permission
        $superAdminRole->syncPermissions(Permission::all());
        
        // PPID Utama
        $ppidUtamaRole->syncPermissions([
            'force unpublish documents',
            'view any documents global',
            'update any documents',
            'delete any documents',
            'manage news',
            'manage hero slides',
            'manage static pages',
            'view monitoring dashboard',
            'view reports',
            'export reports',
            'view any opds',
            'update any opds',
            'view any villages',
            'update any villages',
        ]);
        
        // PPID Pembantu
        $ppidPembantuRole->syncPermissions([
            'view documents',
            'create documents',
            'update documents',
            'delete documents',
            'publish documents',
            'unpublish documents',
            'archive documents',
            'update opds',
        ]);
        
        // Pimpinan OPD (READ-ONLY)
        $pimpinanRole->syncPermissions([
            'view monitoring dashboard',
            'view reports',
            'export reports',
            'view any documents',
            'view documents',
        ]);
        
        // Masyarakat
        $masyarakatRole->syncPermissions([
            'view documents',
        ]);

        // ========== 4. CREATE OPDs ==========
        $diskominfo = Opd::create([
            'name' => 'Dinas Komunikasi dan Informatika',
            'short_name' => 'DISKOMINFO',
            'address' => 'Jl. Trunojoyo No. 1, Sumenep',
            'phone' => '(0328) 123456',
            'email' => 'diskominfo@sumenepkab.go.id',
            'is_active' => true,
        ]);
        
        $disdik = Opd::create([
            'name' => 'Dinas Pendidikan',
            'short_name' => 'DISDIK',
            'address' => 'Jl. Pendidikan No. 10, Sumenep',
            'phone' => '(0328) 654321',
            'email' => 'disdik@sumenepkab.go.id',
            'is_active' => true,
        ]);
        
        $dinkes = Opd::create([
            'name' => 'Dinas Kesehatan',
            'short_name' => 'DINKES',
            'address' => 'Jl. Kesehatan No. 5, Sumenep',
            'phone' => '(0328) 789012',
            'email' => 'dinkes@sumenepkab.go.id',
            'is_active' => true,
        ]);

        // ========== 5. CREATE VILLAGES ==========
        $villages = [
            ['name' => 'Pangarangan', 'head_name' => 'Kepala Desa Pangarangan', 'address' => 'Jl. KH. Mansyur No. 71, Pangarangan', 'phone' => '081234567890', 'email' => 'pangarangan@desa.id', 'is_active' => true],
            ['name' => 'Pabian', 'head_name' => 'Kepala Desa Pabian', 'address' => 'Jl. Pabian No. 1, Pabian', 'phone' => '081234567891', 'email' => 'pabian@desa.id', 'is_active' => true],
            ['name' => 'Kolor', 'head_name' => 'Kepala Desa Kolor', 'address' => 'Jl. Kolor No. 2, Kolor', 'phone' => '081234567892', 'email' => 'kolor@desa.id', 'is_active' => true],
            ['name' => 'Bangselok', 'head_name' => 'Kepala Desa Bangselok', 'address' => 'Jl. Bangselok No. 3, Bangselok', 'phone' => '081234567893', 'email' => 'bangselok@desa.id', 'is_active' => true],
        ];

        foreach ($villages as $village) {
            Village::create($village);
        }

        // ========== 6. CREATE USERS ==========
        
        // Super Admin
        $userSuperAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@ppid.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $userSuperAdmin->assignRole('super_admin');
        
        // PPID Utama (Kepala Dinas Kominfo)
        $userPpidUtama = User::create([
            'name' => 'Kepala Dinas Kominfo',
            'email' => 'ppid.utama@diskominfo.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $diskominfo->id,
            'is_active' => true,
        ]);
        $userPpidUtama->assignRole('ppid_utama');
        $userPpidUtama->assignRole('ppid_pembantu'); // Diskominfo juga sebagai PPID Pembantu
        
        // PPID Pembantu Diskominfo
        $userPpidPembantuDiskominfo = User::create([
            'name' => 'Operator DISKOMINFO',
            'email' => 'operator@diskominfo.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $diskominfo->id,
            'is_active' => true,
        ]);
        $userPpidPembantuDiskominfo->assignRole('ppid_pembantu');
        
        // PPID Pembantu Disdik
        $userPpidPembantuDisdik = User::create([
            'name' => 'Operator DISDIK',
            'email' => 'operator@disdik.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $disdik->id,
            'is_active' => true,
        ]);
        $userPpidPembantuDisdik->assignRole('ppid_pembantu');
        
        // PPID Pembantu Dinkes
        $userPpidPembantuDinkes = User::create([
            'name' => 'Operator DINKES',
            'email' => 'operator@dinkes.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $dinkes->id,
            'is_active' => true,
        ]);
        $userPpidPembantuDinkes->assignRole('ppid_pembantu');
        
        // ========== PIMPINAN OPD (READ-ONLY) ==========
        
        // Pimpinan DISKOMINFO
        $userPimpinanDiskominfo = User::create([
            'name' => 'Kepala Dinas Kominfo (Pimpinan)',
            'email' => 'pimpinan@diskominfo.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $diskominfo->id,
            'is_active' => true,
        ]);
        $userPimpinanDiskominfo->assignRole('pimpinan');
        
        // Pimpinan DISDIK
        $userPimpinanDisdik = User::create([
            'name' => 'Kepala Dinas Pendidikan',
            'email' => 'pimpinan@disdik.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $disdik->id,
            'is_active' => true,
        ]);
        $userPimpinanDisdik->assignRole('pimpinan');
        
        // Pimpinan DINKES
        $userPimpinanDinkes = User::create([
            'name' => 'Kepala Dinas Kesehatan',
            'email' => 'pimpinan@dinkes.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $dinkes->id,
            'is_active' => true,
        ]);
        $userPimpinanDinkes->assignRole('pimpinan');
        
        // Masyarakat Test
        $userMasyarakat = User::create([
            'name' => 'Masyarakat Test',
            'email' => 'masyarakat@example.com',
            'phone' => '081234567899',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $userMasyarakat->assignRole('masyarakat');

        // ========== 7. CREATE CATEGORIES ==========
        $categories = [
            ['name' => 'Informasi Berkala', 'slug' => 'informasi-berkala', 'sort_order' => 1],
            ['name' => 'Informasi Serta-Merta', 'slug' => 'informasi-serta-merta', 'sort_order' => 2],
            ['name' => 'Informasi Setiap Saat', 'slug' => 'informasi-setiap-saat', 'sort_order' => 3],
            ['name' => 'Informasi Dikecualikan', 'slug' => 'informasi-dikecualikan', 'sort_order' => 4],
        ];
        
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ========== 8. CREATE STATIC PAGES ==========
        $staticPages = [
            ['page_key' => 'profil_tentang_ppid', 'title' => 'Tentang PPID'],
            ['page_key' => 'profil_visi_misi', 'title' => 'Visi Misi'],
            ['page_key' => 'profil_dasar_hukum', 'title' => 'Dasar Hukum'],
            ['page_key' => 'profil_tugas_fungsi', 'title' => 'Tugas dan Fungsi'],
            ['page_key' => 'profil_struktur', 'title' => 'Struktur Organisasi'],
            ['page_key' => 'standar_maklumat', 'title' => 'Maklumat Pelayanan'],
            ['page_key' => 'standar_prosedur_permohonan', 'title' => 'Prosedur Permohonan Informasi'],
            ['page_key' => 'standar_prosedur_keberatan', 'title' => 'Prosedur Pengajuan Keberatan'],
            ['page_key' => 'standar_prosedur_sengketa', 'title' => 'Prosedur Sengketa Informasi'],
            ['page_key' => 'standar_jalur_waktu', 'title' => 'Jalur dan Waktu Layanan'],
            ['page_key' => 'standar_biaya', 'title' => 'Biaya Layanan'],
        ];
        
        foreach ($staticPages as $page) {
            StaticPage::updateOrCreate(
                ['page_key' => $page['page_key']],
                [
                    'title' => $page['title'],
                    'content' => '<p>Konten sedang dalam pengisian oleh administrator.</p>',
                    'updated_by' => $userSuperAdmin->id,
                ]
            );
        }

        $this->command->info('========================================');
        $this->command->info('Database Seeding Completed Successfully!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('Default Login Credentials:');
        $this->command->info('Super Admin    : superadmin@ppid.sumenepkab.go.id / password');
        $this->command->info('PPID Utama     : ppid.utama@diskominfo.sumenepkab.go.id / password');
        $this->command->info('Pimpinan DISKOMINFO : pimpinan@diskominfo.sumenepkab.go.id / password');
        $this->command->info('Pimpinan DISDIK    : pimpinan@disdik.sumenepkab.go.id / password');
        $this->command->info('Pimpinan DINKES    : pimpinan@dinkes.sumenepkab.go.id / password');
        $this->command->info('Masyarakat   : masyarakat@example.com / password');
        $this->command->info('========================================');
    }
}