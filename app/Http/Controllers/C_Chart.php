<?php

namespace App\Http\Controllers;

use App\Models\M_Mahasiswa;
use App\Models\M_User;
use Illuminate\View\View;

class C_Chart extends Controller
{
    private M_User $M_User;
    private M_Mahasiswa $M_Mahasiswa;

    public function __construct()
    {
        $this->M_User = new M_User();
        $this->M_Mahasiswa = new M_Mahasiswa();
    }

    public function index(): View
    {
        $yearlyUsers = $this->M_User->yearlyRegistrations();
        $levelBreakdown = $this->M_User->levelBreakdown();
        $prodiDistribution = $this->M_Mahasiswa->countByProdi();

        return view('v_chart', [
            'yearlyLabels' => array_keys($yearlyUsers),
            'yearlyCounts' => array_values($yearlyUsers),
            'levelLabels' => array_keys($levelBreakdown),
            'levelCounts' => array_values($levelBreakdown),
            'prodiLabels' => $prodiDistribution->pluck('prodi')->values()->all(),
            'prodiCounts' => $prodiDistribution->pluck('total')->map(fn ($v) => (int) $v)->values()->all(),
        ]);
    }
}
