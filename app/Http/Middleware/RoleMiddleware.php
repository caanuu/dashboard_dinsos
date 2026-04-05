<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        // Contoh penggunaan di route: role:admin,operator
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika role tidak cocok, tampilkan error 403 atau redirect
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk halaman ini.');
    }
}
