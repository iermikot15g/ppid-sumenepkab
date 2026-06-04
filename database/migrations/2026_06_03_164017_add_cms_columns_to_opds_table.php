<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('opds', function (Blueprint $table) {
            // Tentang OPD
            $table->longText('tentang_content')->nullable()->after('short_name');
            $table->string('tentang_pdf')->nullable()->after('tentang_content');  // TAMBAHKAN
            
            // Tugas dan Fungsi
            $table->longText('tugas_fungsi_content')->nullable()->after('tentang_pdf');
            $table->string('tugas_fungsi_pdf')->nullable()->after('tugas_fungsi_content');
            
            // Struktur Organisasi
            $table->longText('struktur_content')->nullable()->after('tugas_fungsi_pdf');
            $table->string('struktur_pdf')->nullable()->after('struktur_content');
            
            // Dasar Hukum
            $table->longText('dasar_hukum_content')->nullable()->after('struktur_pdf');
            $table->string('dasar_hukum_pdf')->nullable()->after('dasar_hukum_content');
            
            // Google Maps Link
            $table->string('google_maps_link')->nullable()->after('address');
        });
    }

    public function down()
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn([
                'tentang_content',
                'tentang_pdf',  // TAMBAHKAN
                'tugas_fungsi_content',
                'tugas_fungsi_pdf',
                'struktur_content',
                'struktur_pdf',
                'dasar_hukum_content',
                'dasar_hukum_pdf',
                'google_maps_link'
            ]);
        });
    }
};