<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class C_Login extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect($this->redirectPathForLevel((int) Auth::user()->level));
        }

        return view('v_login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password tidak sesuai.']);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return redirect()
            ->intended($this->redirectPathForLevel((int) $user->level))
            ->with('login_success', 'Selamat datang, '.$user->name.'.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }

    private function redirectPathForLevel(int $level): string
    {
        return match ($level) {
            1 => '/home',
            2 => '/user',
            3 => '/mahasiswa',
            4 => '/dosen',
            default => '/home',
        };
    }
}
