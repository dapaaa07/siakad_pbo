<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class M_Mahasiswa extends Model
{
    protected $table = 'tb_mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    public function allData(): Collection
    {
        return DB::table('tb_mahasiswa')->orderBy('nim')->get();
    }

    public function detailData(string $nim): ?object
    {
        return DB::table('tb_mahasiswa')->where('nim', $nim)->first();
    }

    public function suggestNim(): string
    {
        $prefix = '10603';
        $nims = DB::table('tb_mahasiswa')
            ->where('nim', 'like', $prefix.'%')
            ->pluck('nim');

        $max = 0;
        foreach ($nims as $nim) {
            if (ctype_digit((string) $nim)) {
                $suffix = (int) substr((string) $nim, strlen($prefix));
                if ($suffix > $max) {
                    $max = $suffix;
                }
            }
        }

        return $prefix.str_pad((string) ($max + 1), 3, '0', STR_PAD_LEFT);
    }

    public function addData(array $data): void
    {
        $now = now();
        DB::table('tb_mahasiswa')->insert(array_merge($data, [
            'created_at' => $data['created_at'] ?? $now,
            'updated_at' => $data['updated_at'] ?? $now,
        ]));
    }

    public function editData(string $nim, array $data): void
    {
        DB::table('tb_mahasiswa')->where('nim', $nim)->update(array_merge($data, [
            'updated_at' => now(),
        ]));
    }

    public function deleteData(string $nim): void
    {
        DB::table('tb_mahasiswa')->where('nim', $nim)->delete();
    }

    public function countByProdi(): Collection
    {
        return DB::table('tb_mahasiswa')
            ->select('prodi', DB::raw('COUNT(*) as total'))
            ->groupBy('prodi')
            ->orderByDesc('total')
            ->get();
    }
}
