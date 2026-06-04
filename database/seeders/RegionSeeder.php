<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;

class RegionSeeder extends Seeder
{
    public function run()
    {
        // Data provinsi, kabupaten, kecamatan dari file CSV
        // Ini hanya contoh untuk Jawa Timur dan Sumenep
        // Anda bisa menambahkan lebih banyak data sesuai file CSV Anda

        // ========== PROVINSI JAWA TIMUR ==========
        $jawaTimur = Province::firstOrCreate(
            ['code' => '35'],
            ['name' => 'Jawa Timur']
        );

        // ========== KABUPATEN SUMENEP ==========
        $sumenep = Regency::firstOrCreate(
            ['code' => '35.29', 'province_id' => $jawaTimur->id],
            ['name' => 'Kabupaten Sumenep']
        );

        // ========== KECAMATAN DI SUMENEP ==========
        $kecamatanList = [
            ['35.29.01', 'Kota Sumenep'],
            ['35.29.02', 'Kalianget'],
            ['35.29.03', 'Manding'],
            ['35.29.04', 'Talango'],
            ['35.29.05', 'Bluto'],
            ['35.29.06', 'Saronggi'],
            ['35.29.07', 'Lenteng'],
            ['35.29.08', 'Giligenting'],
            ['35.29.09', 'Guling'],
            ['35.29.10', 'Ganding'],
        ];

        foreach ($kecamatanList as $kec) {
            District::firstOrCreate(
                ['code' => $kec[0], 'regency_id' => $sumenep->id],
                ['name' => $kec[1]]
            );
        }

        $this->command->info('Data wilayah berhasil di-seed!');
    }
}