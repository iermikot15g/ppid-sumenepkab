<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->text('address');
            $table->foreignId('province_id')->constrained();
            $table->foreignId('regency_id')->constrained();
            $table->foreignId('district_id')->constrained();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('education');
            $table->string('occupation');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};