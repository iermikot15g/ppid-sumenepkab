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
            'vision' => 'Terwujudnya pelayanan informasi publik yang transparan, cepat, dan mudah diakses',
            'mission' => '1. Meningkatkan kualitas layanan informasi publik\n2. Mengembangkan sistem pengelolaan informasi yang terintegrasi\n3. Meningkatkan kapasitas SDM pengelola informasi',
            'about' => 'PPID (Pejabat Pengelola Informasi dan Dokumentasi) Kabupaten Sumenep adalah unit kerja yang bertugas mengelola dan melayani permintaan informasi publik sesuai dengan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.',
            'duties' => 'Menyediakan informasi publik yang akurat, cepat, dan mudah diakses',
            'functions' => 'Melayani permintaan informasi, mengelola dokumentasi, dan melakukan pengujian konsekuensi informasi',
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

        // ========== 3. CREATE VILLAGES ==========
        $villages = [
            ['name' => 'Pangarangan', 'head_name' => 'Kepala Desa Pangarangan', 'address' => 'Jl. KH. Mansyur No. 71, Pangarangan', 'phone' => '081234567890', 'email' => 'pangarangan@desa.id', 'is_active' => true],
            ['name' => 'Pabian', 'head_name' => 'Kepala Desa Pabian', 'address' => 'Jl. Pabian No. 1, Pabian', 'phone' => '081234567891', 'email' => 'pabian@desa.id', 'is_active' => true],
            ['name' => 'Kolor', 'head_name' => 'Kepala Desa Kolor', 'address' => 'Jl. Kolor No. 2, Kolor', 'phone' => '081234567892', 'email' => 'kolor@desa.id', 'is_active' => true],
            ['name' => 'Bangselok', 'head_name' => 'Kepala Desa Bangselok', 'address' => 'Jl. Bangselok No. 3, Bangselok', 'phone' => '081234567893', 'email' => 'bangselok@desa.id', 'is_active' => true],
        ];

        foreach ($villages as $village) {
            Village::create($village);
        }

        // ========== 4. CREATE USERS ==========
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

        // Masyarakat (sample user)
        $userMasyarakat = User::create([
            'name' => 'Masyarakat Test',
            'email' => 'masyarakat@example.com',
            'phone' => '081234567899',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $userMasyarakat->assignRole('masyarakat');

        // ========== 5. CREATE CATEGORIES ==========
        $categories = [
            ['name' => 'Informasi Berkala', 'slug' => 'informasi-berkala', 'sort_order' => 1],
            ['name' => 'Informasi Serta-Merta', 'slug' => 'informasi-serta-merta', 'sort_order' => 2],
            ['name' => 'Informasi Setiap Saat', 'slug' => 'informasi-setiap-saat', 'sort_order' => 3],
            ['name' => 'Informasi Dikecualikan', 'slug' => 'informasi-dikecualikan', 'sort_order' => 4],
        ];
        
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ========== 6. CREATE SUB CATEGORIES ==========
        // Informasi Berkala (category_id = 1)
        $berkala = Category::where('slug', 'informasi-berkala')->first();
        if ($berkala) {
            $berkalaSubs = [
                ['name' => 'Profil Badan Publik', 'slug' => 'profil-badan-publik', 'sort_order' => 1],
                ['name' => 'Ringkasan Program dan/atau Kegiatan', 'slug' => 'ringkasan-program-kegiatan', 'sort_order' => 2],
                ['name' => 'Ringkasan Informasi tentang Kinerja Badan Publik', 'slug' => 'ringkasan-kinerja', 'sort_order' => 3],
                ['name' => 'Ringkasan Laporan Keuangan', 'slug' => 'ringkasan-laporan-keuangan', 'sort_order' => 4],
                ['name' => 'Ringkasan Laporan Akses Informasi Publik', 'slug' => 'ringkasan-laporan-akses', 'sort_order' => 5],
                ['name' => 'Peraturan, Keputusan, dan/atau Kebijakan', 'slug' => 'peraturan-kebijakan', 'sort_order' => 6],
                ['name' => 'Prosedur Memperoleh Informasi Publik', 'slug' => 'prosedur-memperoleh-informasi', 'sort_order' => 7],
                ['name' => 'Pengaduan Penyalahgunaan Wewenang atau Pelanggaran Badan Publik', 'slug' => 'pengaduan-penyalahgunaan-wewenang', 'sort_order' => 8],
                ['name' => 'Pengadaan Barang dan Jasa Pemerintah', 'slug' => 'pengadaan-barang-jasa', 'sort_order' => 9],
                ['name' => 'Ketenagakerjaan', 'slug' => 'ketenagakerjaan', 'sort_order' => 10],
                ['name' => 'Prosedur Peringatan Dini dan Prosedur Evakuasi Keadaan Darurat', 'slug' => 'prosedur-peringatan-dini', 'sort_order' => 11],
                ['name' => 'Informasi Berkala Lainnya', 'slug' => 'informasi-berkala-lainnya', 'sort_order' => 12],
            ];
            
            foreach ($berkalaSubs as $sub) {
                SubCategory::updateOrCreate(
                    ['slug' => $sub['slug']],
                    [
                        'category_id' => $berkala->id,
                        'name' => $sub['name'],
                        'sort_order' => $sub['sort_order'],
                    ]
                );
            }
        }

        // Informasi Serta-Merta (category_id = 2)
        $sertaMerta = Category::where('slug', 'informasi-serta-merta')->first();
        if ($sertaMerta) {
            $sertaMertaSubs = [
                ['name' => 'Informasi bencana alam', 'slug' => 'bencana-alam', 'sort_order' => 1],
                ['name' => 'Informasi keadaan bencana nonalam', 'slug' => 'bencana-nonalam', 'sort_order' => 2],
                ['name' => 'Informasi bencana sosial', 'slug' => 'bencana-sosial', 'sort_order' => 3],
                ['name' => 'Informasi tentang jenis, persebaran dan daerah yang menjadi sumber penyakit yang berpotensi menular', 'slug' => 'sumber-penyakit-menular', 'sort_order' => 4],
                ['name' => 'Informasi tentang racun pada bahan makanan yang dikonsumsi oleh masyarakat', 'slug' => 'racun-bahan-makanan', 'sort_order' => 5],
                ['name' => 'Informasi tentang rencana gangguan terhadap utilitas publik', 'slug' => 'gangguan-utilitas-publik', 'sort_order' => 6],
                ['name' => 'Informasi Serta Merta Lainnya', 'slug' => 'informasi-serta-merta-lainnya', 'sort_order' => 7],
            ];
            
            foreach ($sertaMertaSubs as $sub) {
                SubCategory::updateOrCreate(
                    ['slug' => $sub['slug']],
                    [
                        'category_id' => $sertaMerta->id,
                        'name' => $sub['name'],
                        'sort_order' => $sub['sort_order'],
                    ]
                );
            }
        }

        // Informasi Setiap Saat (category_id = 3)
        $setiapSaat = Category::where('slug', 'informasi-setiap-saat')->first();
        if ($setiapSaat) {
            $setiapSaatSubs = [
                ['name' => 'Daftar Informasi Publik', 'slug' => 'daftar-informasi-publik', 'sort_order' => 1],
                ['name' => 'Informasi tentang peraturan, keputusan, dan/atau kebijakan Badan Publik', 'slug' => 'peraturan-keputusan-kebijakan', 'sort_order' => 2],
                ['name' => 'Informasi Setiap Saat Lainnya', 'slug' => 'informasi-setiap-saat-lainnya', 'sort_order' => 3],
            ];
            
            foreach ($setiapSaatSubs as $sub) {
                SubCategory::updateOrCreate(
                    ['slug' => $sub['slug']],
                    [
                        'category_id' => $setiapSaat->id,
                        'name' => $sub['name'],
                        'sort_order' => $sub['sort_order'],
                    ]
                );
            }
        }

        // Informasi Dikecualikan (category_id = 4)
        $dikecualikan = Category::where('slug', 'informasi-dikecualikan')->first();
        if ($dikecualikan) {
            $dikecualikanSubs = [
                ['name' => 'Daftar Informasi yang Dikecualikan', 'slug' => 'daftar-informasi-dikecualikan', 'sort_order' => 1],
                ['name' => 'Informasi Dikecualikan Lainnya', 'slug' => 'informasi-dikecualikan-lainnya', 'sort_order' => 2],
            ];
            
            foreach ($dikecualikanSubs as $sub) {
                SubCategory::updateOrCreate(
                    ['slug' => $sub['slug']],
                    [
                        'category_id' => $dikecualikan->id,
                        'name' => $sub['name'],
                        'sort_order' => $sub['sort_order'],
                    ]
                );
            }
        }

        // ========== 7. CREATE STATIC PAGES (PROFIL PPID & STANDAR LAYANAN) ==========
        $staticPages = [
            // Profil PPID
            ['page_key' => 'profil_tentang_ppid', 'title' => 'Tentang PPID'],
            ['page_key' => 'profil_visi_misi', 'title' => 'Visi Misi'],
            ['page_key' => 'profil_dasar_hukum', 'title' => 'Dasar Hukum'],
            ['page_key' => 'profil_tugas_fungsi', 'title' => 'Tugas dan Fungsi'],
            ['page_key' => 'profil_struktur', 'title' => 'Struktur Organisasi'],
            
            // Standar Layanan
            ['page_key' => 'standar_maklumat', 'title' => 'Maklumat Pelayanan'],
            ['page_key' => 'standar_prosedur_permohonan', 'title' => 'Prosedur Permohonan Informasi'],
            ['page_key' => 'standar_prosedur_keberatan', 'title' => 'Prosedur Pengajuan Keberatan'],
            ['page_key' => 'standar_prosedur_sengketa', 'title' => 'Prosedur Sengketa Informasi'],
            ['page_key' => 'standar_jalur_waktu', 'title' => 'Jalur dan Waktu Layanan'],
            ['page_key' => 'standar_biaya', 'title' => 'Biaya Layanan'],
        ];
        
        foreach ($staticPages as $page) {
            // Konten default untuk masing-masing halaman
            $defaultContent = '<p>Konten sedang dalam pengisian oleh administrator.</p>';
            
            if ($page['page_key'] == 'profil_tentang_ppid') {
                $defaultContent = '<h2>Tentang PPID Kabupaten Sumenep</h2>
<p>Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kabupaten Sumenep adalah unit kerja yang bertugas mengelola dan melayani permintaan informasi publik sesuai dengan Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</p>
<p>PPID Kabupaten Sumenep berkomitmen untuk memberikan layanan informasi yang transparan, cepat, tepat, dan mudah diakses oleh masyarakat.</p>';
            } elseif ($page['page_key'] == 'profil_visi_misi') {
                $defaultContent = '<h2>Visi</h2>
<p>Terwujudnya Kabupaten Sumenep yang Maju, Berdaya Saing, dan Sejahtera Berlandaskan Nilai-Nilai Kearifan Lokal</p>
<h2>Misi</h2>
<ol>
<li>Meningkatkan kualitas sumber daya manusia yang beriman, bertaqwa, dan berakhlak mulia</li>
<li>Mengembangkan infrastruktur dan perekonomian daerah yang berkeadilan</li>
<li>Mewujudkan tata kelola pemerintahan yang baik, bersih, dan melayani</li>
<li>Melestarikan nilai-nilai budaya dan kearifan lokal</li>
<li>Memanfaatkan sumber daya alam secara berkelanjutan</li>
</ol>';
            } elseif ($page['page_key'] == 'profil_dasar_hukum') {
                $defaultContent = '<h2>Dasar Hukum PPID Kabupaten Sumenep</h2>
<ul>
<li>Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik</li>
<li>Peraturan Komisi Informasi Nomor 1 Tahun 2021 tentang Standar Layanan Informasi Publik</li>
<li>Peraturan Bupati Sumenep Nomor 38 Tahun 2024 tentang Pedoman Pengelolaan Pelayanan Informasi dan Dokumentasi</li>
<li>Peraturan Bupati Sumenep Nomor 18 Tahun 2023 tentang Satu Data Kabupaten Sumenep</li>
<li>Peraturan Bupati Sumenep Nomor 26 Tahun 2023 tentang Sistem Klasifikasi Keamanan dan Akses Arsip Dinamis</li>
</ul>';
            } elseif ($page['page_key'] == 'profil_tugas_fungsi') {
                $defaultContent = '<h2>Tugas PPID Utama</h2>
<ul>
<li>Menyusun dan melaksanakan kebijakan informasi dan dokumentasi</li>
<li>Menyusun laporan pelaksanaan kebijakan informasi dan dokumentasi</li>
<li>Mengoordinasikan dan mengonsolidasikan pengumpulan bahan informasi dan dokumentasi dari PPID Pembantu</li>
<li>Menyimpan, mendokumentasikan, menyediakan, dan memberi pelayanan informasi dan dokumentasi kepada publik</li>
<li>Melakukan verifikasi bahan informasi dan dokumentasi publik</li>
<li>Melakukan uji konsekuensi atas informasi dan dokumentasi yang dikecualikan</li>
<li>Melakukan pemutakhiran informasi dan dokumentasi</li>
<li>Menyediakan informasi dan dokumentasi untuk diakses oleh masyarakat</li>
<li>Melakukan pembinaan, pengawasan, evaluasi, dan monitoring atas pelaksanaan kebijakan informasi dan dokumentasi yang dilakukan oleh PPID Pembantu</li>
</ul>
<h2>Wewenang PPID Utama</h2>
<ul>
<li>Menolak memberikan informasi dan dokumentasi yang dikecualikan sesuai dengan ketentuan peraturan perundang-undangan</li>
<li>Meminta dan memperoleh informasi dan dokumentasi dari PPID Pembantu yang menjadi cakupan kerjanya</li>
<li>Mengoordinasikan pemberian pelayanan informasi dan dokumentasi dengan PPID Pembantu yang menjadi cakupan kerjanya</li>
<li>Menentukan atau menetapkan suatu informasi dan dokumentasi yang dapat diakses oleh publik</li>
<li>Menugaskan PPID Pembantu dan/atau Pejabat Fungsional untuk membuat, mengumpulkan, serta memelihara informasi dan dokumentasi untuk kebutuhan organisasi</li>
</ul>
<h2>Tugas PPID Pembantu</h2>
<ul>
<li>Membantu PPID Utama melaksanakan tanggungjawab, tugas, dan kewenangannya</li>
<li>Menyampaikan informasi dan dokumentasi kepada PPID Utama dilakukan paling sedikit 6 (enam) bulan sekali atau sesuai kebutuhan</li>
<li>Melaksanakan kebijakan teknis informasi dan dokumentasi sesuai dengan tugas pokok dan fungsinya</li>
<li>Menjamin ketersediaan dan akselerasi layanan informasi dan dokumentasi bagi pemohon informasi secara cepat, tepat, berkualitas dengan mengedepankan prinsip-prinsip pelayanan prima</li>
<li>Mengumpulkan, mengolah dan mengompilasi bahan dan data lingkup komponen di lingkungan Perangkat Daerah menjadi bahan informasi publik</li>
<li>Menyampaikan laporan pelaksanaan kebijakan teknis dan pelayanan informasi dan dokumentasi kepada PPID Utama secara berkala dan sesuai kebutuhan</li>
</ul>';
            } elseif ($page['page_key'] == 'profil_struktur') {
                $defaultContent = '<p>Struktur Organisasi PPID Kabupaten Sumenep akan ditampilkan dalam bentuk gambar.</p>
<p>Saat ini struktur organisasi sedang dalam proses penyusunan. Informasi lebih lanjut akan segera diupdate.</p>';
            } elseif ($page['page_key'] == 'standar_maklumat') {
                $defaultContent = '<h2>Maklumat Pelayanan PPID Kabupaten Sumenep</h2>
<p>Kami berkomitmen untuk memberikan pelayanan informasi publik yang:</p>
<ul>
<li><strong>Transparan</strong> - Informasi disampaikan secara terbuka dan jujur</li>
<li><strong>Cepat</strong> - Proses pelayanan informasi dilakukan dengan cepat</li>
<li><strong>Tepat</strong> - Informasi yang diberikan akurat dan sesuai kebutuhan</li>
<li><strong>Mudah diakses</strong> - Masyarakat dapat mengakses informasi dengan mudah</li>
<li><strong>Non-diskriminatif</strong> - Setiap pemohon informasi mendapatkan pelayanan yang sama</li>
</ul>
<p>Jika Anda tidak puas dengan pelayanan kami, silakan sampaikan keberatan melalui prosedur yang telah ditentukan.</p>
<p>Kami siap melayani Anda dengan sepenuh hati.</p>';
            } elseif ($page['page_key'] == 'standar_prosedur_permohonan') {
                $defaultContent = '<h2>Prosedur Permohonan Informasi Publik</h2>
<ol>
<li><strong>Pengisian Formulir</strong> - Pemohon mengisi formulir permohonan informasi yang dapat diunduh dari portal PPID</li>
<li><strong>Penyerahan Formulir</strong> - Menyampaikan formulir yang telah diisi ke petugas PPID</li>
<li><strong>Pencatatan Permohonan</strong> - Petugas mencatat dan memberikan tanda terima permohonan</li>
<li><strong>Verifikasi Permohonan</strong> - PPID memverifikasi kelengkapan permohonan</li>
<li><strong>Pemrosesan Informasi</strong> - PPID memproses permohonan maksimal 10 (sepuluh) hari kerja</li>
<li><strong>Pemberian Informasi</strong> - Pemohon menerima informasi yang diminta</li>
</ol>
<h3>Formulir Permohonan</h3>
<p>Unduh formulir permohonan informasi melalui tautan di bawah ini.</p>';
            } elseif ($page['page_key'] == 'standar_prosedur_keberatan') {
                $defaultContent = '<h2>Prosedur Pengajuan Keberatan</h2>
<p>Pemohon informasi dapat mengajukan keberatan secara tertulis apabila:</p>
<ul>
<li>Permohonan informasi ditolak</li>
<li>Informasi yang diminta tidak disediakan</li>
<li>Tidak direspon dalam waktu 10 hari kerja</li>
<li>Informasi yang diberikan tidak sesuai dengan yang diminta</li>
</ul>
<ol>
<li>Mengisi formulir keberatan yang tersedia</li>
<li>Menyampaikan keberatan kepada atasan PPID</li>
<li>Atasan PPID memproses keberatan maksimal 30 hari kerja</li>
<li>Pemohon menerima keputusan atas keberatan yang diajukan</li>
</ol>';
            } elseif ($page['page_key'] == 'standar_prosedur_sengketa') {
                $defaultContent = '<h2>Prosedur Sengketa Informasi</h2>
<p>Apabila pemohon informasi tidak puas dengan keputusan keberatan, pemohon dapat mengajukan sengketa informasi melalui:</p>
<ol>
<li>Mengajukan permohonan penyelesaian sengketa ke Komisi Informasi Provinsi Jawa Timur</li>
<li>Komisi Informasi akan melakukan mediasi dan ajudikasi</li>
<li>Keputusan Komisi Informasi bersifat final dan mengikat</li>
</ol>
<p>Batas waktu pengajuan sengketa adalah 14 hari kerja setelah menerima keputusan keberatan.</p>';
            } elseif ($page['page_key'] == 'standar_jalur_waktu') {
                $defaultContent = '<h2>Jalur dan Waktu Layanan</h2>
<h3>Jalur Layanan</h3>
<ul>
<li>Datang langsung ke kantor PPID Kabupaten Sumenep</li>
<li>Melalui surat/email ke alamat resmi PPID</li>
<li>Melalui WhatsApp layanan informasi</li>
<li>Melalui portal website PPID</li>
</ul>
<h3>Waktu Layanan</h3>
<ul>
<li>Senin - Kamis : 08.00 - 15.00 WIB</li>
<li>Jumat : 08.00 - 14.00 WIB</li>
<li>Istirahat : 12.00 - 13.00 WIB</li>
</ul>
<p>Hari libur nasional tetap diliburkan.</p>';
            } elseif ($page['page_key'] == 'standar_biaya') {
                $defaultContent = '<h2>Biaya Layanan Informasi Publik</h2>
<p>Berdasarkan Peraturan Pemerintah dan Peraturan Daerah yang berlaku:</p>
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
<thead>
<tr style="background-color: #f3f4f6;">
<th>No</th>
<th>Jenis Layanan</th>
<th>Biaya</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Permohonan informasi</td>
<td>GRATIS</td>
</tr>
<tr>
<td>2</td>
<td>Penggandaan dokumen (fotokopi)</td>
<td>Rp 1.000,- per lembar</td>
</tr>
<tr>
<td>3</td>
<td>Penggandaan dokumen (print)</td>
<td>Rp 2.500,- per lembar</td>
</tr>
<tr>
<td>4</td>
<td>Penyimpanan data ke media (CD/DVD/Flashdisk)</td>
<td>Biaya media sesuai harga pasar</td>
</tr>
<tr>
<td>5</td>
<td>Pengiriman dokumen via pos</td>
<td>Biaya pengiriman sesuai tarif pos</td>
</tr>
</tbody>
</table>
<p>Catatan: Biaya dapat berubah sesuai dengan peraturan yang berlaku.</p>';
            } else {
                $defaultContent = '<p>Konten sedang dalam pengisian oleh administrator.</p>';
            }
            
            StaticPage::updateOrCreate(
                ['page_key' => $page['page_key']],
                [
                    'title' => $page['title'],
                    'content' => $defaultContent,
                    'updated_by' => $userSuperAdmin->id,
                ]
            );
        }

        $this->command->info('========================================');
        $this->command->info('Database Seeding Completed Successfully!');
        $this->command->info('========================================');
        $this->command->info('Users created: ' . User::count());
        $this->command->info('OPDs created: ' . Opd::count());
        $this->command->info('Villages created: ' . Village::count());
        $this->command->info('Categories created: ' . Category::count());
        $this->command->info('Sub Categories created: ' . SubCategory::count());
        $this->command->info('Static Pages created: ' . StaticPage::count());
        $this->command->info('========================================');
        
        $this->command->info('');
        $this->command->info('Default Login Credentials:');
        $this->command->info('Super Admin   : superadmin@ppid.sumenepkab.go.id / password');
        $this->command->info('PPID Utama    : ppid.utama@diskominfo.sumenepkab.go.id / password');
        $this->command->info('Operator DISKOMINFO : operator@diskominfo.sumenepkab.go.id / password');
        $this->command->info('Operator DISDIK     : operator@disdik.sumenepkab.go.id / password');
        $this->command->info('Pimpinan      : kadis@diskominfo.sumenepkab.go.id / password');
        $this->command->info('Masyarakat    : masyarakat@example.com / password');
        $this->command->info('========================================');
    }
}