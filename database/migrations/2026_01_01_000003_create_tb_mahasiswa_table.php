<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_mahasiswa', function (Blueprint $table) {
            $table->string('nim', 20)->primary();
            $table->string('nama', 100);
            $table->string('jurusan', 100);
            $table->string('prodi', 100);
            $table->string('ttl', 100);
            $table->text('alamat');
            $table->string('agama', 100);
            $table->integer('tingkat');
            $table->integer('semester');
            $table->string('nomor_handphone', 20);
            $table->string('foto_mahasiswa', 200);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_mahasiswa');
    }
};
