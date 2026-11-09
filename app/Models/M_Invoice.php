<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class M_Invoice extends Model
{
    protected $table = 'tb_invoice';
    protected $primaryKey = 'no_invoice';
    public $incrementing = false;
    protected $keyType = 'string';

    public function allInvoices(): Collection
    {
        return DB::table('tb_invoice')
            ->join('tb_mahasiswa', 'tb_invoice.nim', '=', 'tb_mahasiswa.nim')
            ->select(
                'tb_invoice.*',
                'tb_mahasiswa.nama',
                'tb_mahasiswa.jurusan',
                'tb_mahasiswa.prodi',
                'tb_mahasiswa.alamat',
                'tb_mahasiswa.nomor_handphone'
            )
            ->orderByDesc('tb_invoice.tanggal_terbit')
            ->get();
    }

    public function findInvoice(string $no_invoice): ?object
    {
        return DB::table('tb_invoice')
            ->join('tb_mahasiswa', 'tb_invoice.nim', '=', 'tb_mahasiswa.nim')
            ->select(
                'tb_invoice.*',
                'tb_mahasiswa.nama',
                'tb_mahasiswa.jurusan',
                'tb_mahasiswa.prodi',
                'tb_mahasiswa.alamat',
                'tb_mahasiswa.nomor_handphone'
            )
            ->where('tb_invoice.no_invoice', $no_invoice)
            ->first();
    }
}
