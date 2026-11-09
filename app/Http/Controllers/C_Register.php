<?php

namespace App\Http\Controllers;

use App\Models\M_User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class C_Register extends Controller
{
    private M_User $M_User;

    public function __construct()
    {
        $this->M_User = new M_User();
    }

    public function index(): View
    {
        return view('v_register');
    }

    public function register(Request $request): RedirectResponse
    {
        // Level selection is exposed on registration to satisfy the 4-role Pertemuan 12 practicum workflow.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'level' => ['required', 'integer', 'in:1,2,3,4'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'level.required' => 'Jenis akun wajib dipilih.',
            'level.in' => 'Jenis akun tidak valid.',
        ]);

        $this->M_User->registerData([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'level' => (int) $validated['level'],
        ]);

        return redirect()->route('login')->with('success', 'Registrasi akun berhasil. Silakan login.');
    }
}
