<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiakadSeeder extends Seeder
{
    public function run(): void
    {
        $passwordHash = Hash::make('password');

        DB::table('users')->upsert([
            [
                'name' => 'Administrator SIAKAD',
                'email' => 'admin@siakad.test',
                'password' => $passwordHash,
                'level' => 1,
                'created_at' => '2024-09-01 08:00:00',
                'updated_at' => '2024-09-01 08:00:00',
            ],
            [
                'name' => 'Staf Akademik',
                'email' => 'user@siakad.test',
                'password' => $passwordHash,
                'level' => 2,
                'created_at' => '2025-02-10 09:00:00',
                'updated_at' => '2025-02-10 09:00:00',
            ],
            [
                'name' => 'Daffa Riyadhul',
                'email' => 'mahasiswa@siakad.test',
                'password' => $passwordHash,
                'level' => 3,
                'created_at' => '2025-09-05 10:00:00',
                'updated_at' => '2025-09-05 10:00:00',
            ],
            [
                'name' => 'Erick Febriyanto',
                'email' => 'dosen@siakad.test',
                'password' => $passwordHash,
                'level' => 4,
                'created_at' => '2026-01-15 08:30:00',
                'updated_at' => '2026-01-15 08:30:00',
            ],
        ], ['email'], ['name', 'password', 'level', 'updated_at']);

        DB::table('tb_dosen')->upsert([
            [
                'id_dosen' => 'PEG0001',
                'nip' => '199001262019031025',
                'nama_dosen' => 'Mohammad Iqbal, S.Kom., M.T.',
                'mata_kuliah' => 'Pemrograman Berorientasi Objek',
                'foto_dosen' => 'PEG0001.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dosen' => 'PEG0002',
                'nip' => '198801052019031001',
                'nama_dosen' => 'Tri Herdiawan Apandi, S.ST., M.T.',
                'mata_kuliah' => 'Data Mining',
                'foto_dosen' => 'PEG0002.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dosen' => 'PEG0003',
                'nip' => '199104122020121008',
                'nama_dosen' => 'Erick Febriyanto, S.Kom., M.TI.',
                'mata_kuliah' => 'Pemrograman Web',
                'foto_dosen' => 'PEG0003.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['id_dosen'], ['nip', 'nama_dosen', 'mata_kuliah', 'foto_dosen', 'updated_at']);

        DB::table('tb_mahasiswa')->upsert([
            [
                'nim' => '10603001',
                'nama' => 'Daffa Riyadhul',
                'jurusan' => 'Teknologi Informasi dan Komputer',
                'prodi' => 'D4 Teknologi Rekayasa Perangkat Lunak',
                'ttl' => 'Subang, 14 Mei 2005',
                'alamat' => 'Jl. Brigjen Katamso No. 37, Dangdeur, Subang',
                'agama' => 'Islam',
                'tingkat' => 2,
                'semester' => 3,
                'nomor_handphone' => '081234567890',
                'foto_mahasiswa' => '10603001.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '10603002',
                'nama' => 'Nabil Andhika Rabbani',
                'jurusan' => 'Teknologi Informasi dan Komputer',
                'prodi' => 'D3 Sistem Informasi',
                'ttl' => 'Bandung, 22 Agustus 2005',
                'alamat' => 'Jl. Otista No. 18, Karanganyar, Subang',
                'agama' => 'Islam',
                'tingkat' => 2,
                'semester' => 3,
                'nomor_handphone' => '081345678901',
                'foto_mahasiswa' => '10603002.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '10603003',
                'nama' => 'Siti Rahmawati',
                'jurusan' => 'Teknologi Informasi dan Komputer',
                'prodi' => 'D4 Teknologi Rekayasa Perangkat Lunak',
                'ttl' => 'Purwakarta, 03 November 2004',
                'alamat' => 'Jl. Veteran No. 12, Sukamelang, Subang',
                'agama' => 'Islam',
                'tingkat' => 3,
                'semester' => 5,
                'nomor_handphone' => '081567890123',
                'foto_mahasiswa' => '10603003.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['nim'], ['nama', 'jurusan', 'prodi', 'ttl', 'alamat', 'agama', 'tingkat', 'semester', 'nomor_handphone', 'foto_mahasiswa', 'updated_at']);

        DB::table('tb_invoice')->upsert([
            [
                'no_invoice' => 'INV-2026-001',
                'nim' => '10603001',
                'semester_akademik' => 'Ganjil 2026/2027',
                'tanggal_terbit' => '2026-08-15',
                'jatuh_tempo' => '2026-09-05',
                'nominal_ukt' => 3500000,
                'biaya_praktikum' => 450000,
                'status_pembayaran' => 'Lunas',
                'metode_pembayaran' => 'Virtual Account Bank Mandiri',
                'catatan' => 'Simulasi tagihan UKT awal untuk keperluan demonstrasi cetak modul Pertemuan 12.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_invoice' => 'INV-2026-002',
                'nim' => '10603002',
                'semester_akademik' => 'Ganjil 2026/2027',
                'tanggal_terbit' => '2026-08-16',
                'jatuh_tempo' => '2026-09-05',
                'nominal_ukt' => 3000000,
                'biaya_praktikum' => 350000,
                'status_pembayaran' => 'Menunggu Pembayaran',
                'metode_pembayaran' => 'Virtual Account BRI',
                'catatan' => 'Simulasi tagihan UKT awal untuk keperluan demonstrasi cetak modul Pertemuan 12.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['no_invoice'], ['nim', 'semester_akademik', 'tanggal_terbit', 'jatuh_tempo', 'nominal_ukt', 'biaya_praktikum', 'status_pembayaran', 'metode_pembayaran', 'catatan', 'updated_at']);
    }
}
