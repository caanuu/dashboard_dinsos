<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // --- HALAMAN LOGIN ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // --- PROSES LOGIN ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // LOGIKA REDIRECT BERDASARKAN ROLE
            // 1. Jika Warga -> ke Dashboard Warga
            if ($user->role === 'warga') {
                return redirect()->route('warga.dashboard');
            }

            // 2. Jika Admin, Operator, atau Kadis -> ke Dashboard Admin
            if (in_array($user->role, ['admin', 'operator', 'kadis'])) {
                // Menggunakan route() agar URL otomatis menjadi /admin/dashboard
                return redirect()->route('dashboard');
            }

            // Default jika role tidak dikenali
            return redirect('/');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // --- HALAMAN REGISTER (KHUSUS WARGA) ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'warga', // Role otomatis warga
        ]);

        Auth::login($user); // Login otomatis setelah daftar

        return redirect()->route('warga.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang.');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
