<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_invoice', function (Blueprint $table) {
            $table->string('no_invoice', 30)->primary();
            $table->string('nim', 20);
            $table->string('semester_akademik', 50);
            $table->date('tanggal_terbit');
            $table->date('jatuh_tempo');
            $table->unsignedBigInteger('nominal_ukt');
            $table->unsignedBigInteger('biaya_praktikum')->default(0);
            $table->string('status_pembayaran', 30);
            $table->string('metode_pembayaran', 50);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('tb_mahasiswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_invoice');
    }
};
