<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
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

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
