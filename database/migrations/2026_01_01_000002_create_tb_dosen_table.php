<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_dosen', function (Blueprint $table) {
            $table->string('id_dosen', 20)->primary();
            $table->string('nip', 200)->unique();
            $table->string('nama_dosen', 200);
            $table->string('mata_kuliah', 200);
            $table->string('foto_dosen', 200);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_dosen');
    }
};
