public function handle($request, Closure $next, ...$roles)
{
    // Cek apakah role user saat ini ada di dalam parameter $roles yang kita tulis di web.php
    if (in_array($request->user()->role, $roles)) {
        return $next($request);
    }

    abort(403, 'Anda tidak punya akses.');
}