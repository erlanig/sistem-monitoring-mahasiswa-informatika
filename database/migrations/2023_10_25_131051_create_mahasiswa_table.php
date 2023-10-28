<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table){
            $table->increments('id_mhs');
            $table->string('NIM', 10);
            $table->string('fakultas', 50);
            $table->string('nama', 50);
            $table->string('email', 50);
            $table->string('alamat', 50);
            $table->string('no_HP', 15);
            $table->string('angkatan', 4);
            $table->string('status', 15);
            $table->string('jalur_masuk', 10);
            $table->binary('foto', 50);
            $table->string('kode_kota_kab', 4);
            $table->string('nama_doswal', 50);
            $table->string('persetujuan', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('mahasiswa');
    }
};
