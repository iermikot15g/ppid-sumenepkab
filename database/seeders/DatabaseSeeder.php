<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Opd;
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
        // ========== 1. ROLES & PERMISSIONS ==========
        // Roles sudah dibuat di migration terpisah, kita hanya assign permissions
        $superAdmin = Role::findByName('super_admin');
        $ppidUtama = Role::findByName('ppid_utama');
        $ppidPembantu = Role::findByName('ppid_pembantu');
        $pimpinan = Role::findByName('pimpinan');
        $masyarakat = Role::findByName('masyarakat');

        // ========== 2. CREATE OPDs ==========
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

        // ========== 3. CREATE USERS ==========
        // Super Admin
        $userSuperAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@ppid.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $userSuperAdmin->assignRole('super_admin');
        
        // PPID Utama
        $userPpidUtama = User::create([
            'name' => 'PPID Utama',
            'email' => 'ppid.utama@diskominfo.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $diskominfo->id,
            'is_active' => true,
        ]);
        $userPpidUtama->assignRole('ppid_utama');
        
        // PPID Pembantu Diskominfo
        $userPpidPembantu1 = User::create([
            'name' => 'Operator DISKOMINFO',
            'email' => 'operator@diskominfo.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $diskominfo->id,
            'is_active' => true,
        ]);
        $userPpidPembantu1->assignRole('ppid_pembantu');
        
        // PPID Pembantu Disdik
        $userPpidPembantu2 = User::create([
            'name' => 'Operator DISDIK',
            'email' => 'operator@disdik.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'opd_id' => $disdik->id,
            'is_active' => true,
        ]);
        $userPpidPembantu2->assignRole('ppid_pembantu');
        
        // Pimpinan
        $userPimpinan = User::create([
            'name' => 'Kepala Dinas',
            'email' => 'kadis@diskominfo.sumenepkab.go.id',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $userPimpinan->assignRole('pimpinan');

        // ========== 4. CREATE CATEGORIES ==========
        $categories = [
            ['name' => 'Informasi Berkala', 'slug' => 'informasi-berkala', 'sort_order' => 1],
            ['name' => 'Informasi Serta-Merta', 'slug' => 'informasi-serta-merta', 'sort_order' => 2],
            ['name' => 'Informasi Setiap Saat', 'slug' => 'informasi-setiap-saat', 'sort_order' => 3],
            ['name' => 'Informasi Dikecualikan', 'slug' => 'informasi-dikecualikan', 'sort_order' => 4],
        ];
        
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ========== 5. CREATE SUB CATEGORIES ==========
        $berkala = Category::where('slug', 'informasi-berkala')->first();
        if ($berkala) {
            $berkalaSubs = [
                'Profil dan Visi Misi',
                'Laporan Keuangan',
                'Peraturan dan Kebijakan',
                'Rencana Kerja dan Anggaran',
                'Laporan Kinerja',
            ];
            foreach ($berkalaSubs as $index => $sub) {
                SubCategory::create([
                    'category_id' => $berkala->id,
                    'name' => $sub,
                    'slug' => \Str::slug($sub),
                    'sort_order' => $index + 1,
                ]);
            }
        }

        // ========== 6. CREATE STATIC PAGES ==========
        $staticPages = [
            ['page_key' => 'profil_visi_misi', 'title' => 'Visi dan Misi'],
            ['page_key' => 'profil_dasar_hukum', 'title' => 'Dasar Hukum'],
            ['page_key' => 'profil_tupoksi', 'title' => 'Tugas dan Fungsi'],
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

        $this->command->info('Database seeded successfully!');
        $this->command->info('Users created: ' . User::count());
        $this->command->info('OPDs created: ' . Opd::count());
        $this->command->info('Categories created: ' . Category::count());
    }
}