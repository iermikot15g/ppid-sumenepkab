<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Hapus foreign key constraint di user_profiles
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
        });

        // 2. Ubah kolom code di districts (perbesar kapasitas)
        Schema::table('districts', function (Blueprint $table) {
            $table->string('code', 10)->change();
        });

        // 3. Tambahkan kembali foreign key constraint
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
        });

        Schema::table('districts', function (Blueprint $table) {
            $table->string('code', 7)->change();
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }
};