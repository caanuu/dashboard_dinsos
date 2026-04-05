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
<<<<<<< HEAD
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
=======
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('masyarakat/dashboard');
            }
        }
        
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
<<<<<<< HEAD
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
=======
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nik' => 'required|digits:16|unique:residents,nik',
            'no_kk' => 'required|digits:16',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
        ]);

        // Buat user masyarakat
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Hash::make($validated['password']),
            'role' => 'masyarakat',
        ]);

        // Buat data resident
        \App\Models\Resident::create([
            'nik' => $validated['nik'],
            'no_kk' => $validated['no_kk'],
            'nama_lengkap' => $validated['name'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'pekerjaan' => $request->pekerjaan ?? '-',
            'penghasilan' => $request->penghasilan ?? 0,
            'jumlah_tanggungan' => $request->jumlah_tanggungan ?? 0,
            'is_dtks' => false,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function showResetForm()
    {
        return view('auth.reset');
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'nik' => 'required|digits:16',
            'password' => 'required|min:6|confirmed',
        ]);

        // Cari user berdasarkan email
        $user = \App\Models\User::where('email', $validated['email'])->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Verifikasi NIK dari data resident
        $resident = \App\Models\Resident::where('nik', $validated['nik'])
            ->where('nama_lengkap', $user->name)
            ->first();

        if (!$resident) {
            return back()->withErrors(['nik' => 'NIK tidak sesuai dengan data yang terdaftar.']);
        }

        // Update password
        $user->update([
            'password' => \Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
