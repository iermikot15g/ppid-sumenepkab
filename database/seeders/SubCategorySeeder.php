<?php
// database/seeders/SubCategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Informasi Berkala (category_id = 1)
        $berkala = Category::where('slug', 'informasi-berkala')->first();
        if ($berkala) {
            $subs = [
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
            
            foreach ($subs as $sub) {
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
            $subs = [
                ['name' => 'Informasi bencana alam', 'slug' => 'bencana-alam', 'sort_order' => 1],
                ['name' => 'Informasi keadaan bencana nonalam', 'slug' => 'bencana-nonalam', 'sort_order' => 2],
                ['name' => 'Informasi bencana sosial', 'slug' => 'bencana-sosial', 'sort_order' => 3],
                ['name' => 'Informasi tentang jenis, persebaran dan daerah yang menjadi sumber penyakit yang berpotensi menular', 'slug' => 'sumber-penyakit-menular', 'sort_order' => 4],
                ['name' => 'Informasi tentang racun pada bahan makanan yang dikonsumsi oleh masyarakat', 'slug' => 'racun-bahan-makanan', 'sort_order' => 5],
                ['name' => 'Informasi tentang rencana gangguan terhadap utilitas publik', 'slug' => 'gangguan-utilitas-publik', 'sort_order' => 6],
                ['name' => 'Informasi Serta Merta Lainnya', 'slug' => 'informasi-serta-merta-lainnya', 'sort_order' => 7],
            ];
            
            foreach ($subs as $sub) {
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
            $subs = [
                ['name' => 'Daftar Informasi Publik', 'slug' => 'daftar-informasi-publik', 'sort_order' => 1],
                ['name' => 'Informasi tentang peraturan, keputusan, dan/atau kebijakan Badan Publik', 'slug' => 'peraturan-keputusan-kebijakan', 'sort_order' => 2],
                ['name' => 'Informasi Setiap Saat Lainnya', 'slug' => 'informasi-setiap-saat-lainnya', 'sort_order' => 3],
            ];
            
            foreach ($subs as $sub) {
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
            $subs = [
                ['name' => 'Daftar Informasi yang Dikecualikan', 'slug' => 'daftar-informasi-dikecualikan', 'sort_order' => 1],
                ['name' => 'Informasi Dikecualikan Lainnya', 'slug' => 'informasi-dikecualikan-lainnya', 'sort_order' => 2],
            ];
            
            foreach ($subs as $sub) {
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
    }
}