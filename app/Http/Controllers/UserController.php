<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada

class UserController extends Controller
{
    public function index()
    {
        // Pastikan view mengarah ke folder yang benar
        $users = User::all();
        return view('admin.applications.users.index', compact('users'));
    }

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

    public function destroy(User $user)
    {
        // PERBAIKAN: Gunakan Auth::id() menggantikan auth()->id() agar tidak error di editor
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna dihapus.');
    }
}
