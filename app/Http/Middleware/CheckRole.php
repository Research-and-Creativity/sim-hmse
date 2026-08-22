<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Jika belum login, redirect ke halaman login
        if (! $user) {
            return redirect()->guest(route('login'));
        }

        // Periksa apakah role user terdaftar dalam parameter roles yang diizinkan (atau role admin yang memiliki akses penuh)
        if (in_array($user->role, $roles) || $user->role === 'admin') {
            return $next($request);
        }

        // Jika user sudah login namun role tidak sesuai, redirect ke dashboard masing-masing dengan flash error
        if (in_array($user->role, ['pembina', 'kaprodi']) || in_array($user->jabatan, ['pembina', 'kaprodi'])) {
            return redirect()
                ->route('pembina.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect()
            ->route('dashboard')
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}