<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class M_Dosen extends Model
{
    protected $table = 'tb_dosen';
    protected $primaryKey = 'id_dosen';
    public $incrementing = false;
    protected $keyType = 'string';

    public function allData(): Collection
    {
        return DB::table('tb_dosen')->orderBy('id_dosen')->get();
    }

    public function detailData(string $id_dosen): ?object
    {
        return DB::table('tb_dosen')->where('id_dosen', $id_dosen)->first();
    }

    public function generateId(): string
    {
        // Computed in PHP so sequential PEG parsing behaves identically on MySQL and SQLite.
        $ids = DB::table('tb_dosen')
            ->where('id_dosen', 'like', 'PEG%')
            ->pluck('id_dosen');

        $max = 0;
        foreach ($ids as $id) {
            $number = (int) substr((string) $id, 3);
            if ($number > $max) {
                $max = $number;
            }
        }

        return 'PEG'.str_pad((string) ($max + 1), 4, '0', STR_PAD_LEFT);
    }

    public function addData(array $data): void
    {
        $now = now();
        DB::table('tb_dosen')->insert(array_merge($data, [
            'created_at' => $data['created_at'] ?? $now,
            'updated_at' => $data['updated_at'] ?? $now,
        ]));
    }

    public function editData(string $id_dosen, array $data): void
    {
        DB::table('tb_dosen')->where('id_dosen', $id_dosen)->update(array_merge($data, [
            'updated_at' => now(),
        ]));
    }

    public function deleteData(string $id_dosen): void
    {
        DB::table('tb_dosen')->where('id_dosen', $id_dosen)->delete();
    }
}
