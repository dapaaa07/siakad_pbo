<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class M_User extends Model
{
    protected $table = 'users';

    public function allData(): Collection
    {
        return DB::table('users')
            ->select('id', 'name', 'email', 'level', 'created_at')
            ->orderBy('id')
            ->get();
    }

    public function registerData(array $data): void
    {
        $now = now();
        DB::table('users')->insert(array_merge($data, [
            'created_at' => $data['created_at'] ?? $now,
            'updated_at' => $data['updated_at'] ?? $now,
        ]));
    }

    /**
     * @return array<string, int>
     */
    public function yearlyRegistrations(): array
    {
        $dates = DB::table('users')->pluck('created_at');
        $counts = [];
        foreach ($dates as $createdAt) {
            $year = $createdAt ? substr((string) $createdAt, 0, 4) : date('Y');
            $counts[$year] = ($counts[$year] ?? 0) + 1;
        }
        ksort($counts);

        return $counts;
    }

    /**
     * @return array<string, int>
     */
    public function levelBreakdown(): array
    {
        $labels = [
            1 => 'Admin',
            2 => 'User',
            3 => 'Mahasiswa',
            4 => 'Dosen',
        ];
        $counts = array_fill_keys(array_values($labels), 0);

        $rows = DB::table('users')
            ->select('level', DB::raw('COUNT(*) as total'))
            ->groupBy('level')
            ->get();

        foreach ($rows as $row) {
            $label = $labels[(int) $row->level] ?? 'Lainnya';
            $counts[$label] = ($counts[$label] ?? 0) + (int) $row->total;
        }

        return $counts;
    }
}
