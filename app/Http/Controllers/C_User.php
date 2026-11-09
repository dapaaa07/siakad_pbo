<?php

namespace App\Http\Controllers;

use App\Models\M_User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class C_User extends Controller
{
    private M_User $M_User;

    public function __construct()
    {
        $this->M_User = new M_User();
    }

    public function index(): View
    {
        $currentUser = Auth::user();
        $users = ((int) $currentUser->level === 1) ? $this->M_User->allData() : collect();

        return view('v_user', [
            'currentUser' => $currentUser,
            'users' => $users,
        ]);
    }
}
