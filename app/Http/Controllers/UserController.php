<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Penting: Import Rule untuk validasi email unik

class UserController extends Controller
{
    // Method untuk list user di halaman Admin (JANGAN DIHAPUS)
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Method untuk create user dari halaman Admin (JANGAN DIHAPUS)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    // Method destroy (JANGAN DIHAPUS)
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna dihapus.');
    }

    // --- TAMBAHAN BARU: FITUR EDIT PROFILE ---

    /**
     * Menampilkan halaman edit profile
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // Email harus unik, kecuali milik user itu sendiri
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            // Password opsional (nullable), harus minimal 6 kar dan dikonfirmasi
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update Data Dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // Update Password hanya jika kolom password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
