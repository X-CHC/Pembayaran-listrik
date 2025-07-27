<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $admin = session('admin');
        if (!$admin) {
            return redirect()->route('login.admin');
        }

        $level = $admin['id_level'] ?? null;
        $route = $request->route();
        $routeName = $route ? $route->getName() : '';
        $uri = $request->path();

        // LVL001: superadmin, akses semua
        if ($level === 'LVL001') {
            return $next($request);
        }

        // LVL002: tidak boleh akses user & level
        if ($level === 'LVL002') {
            // Cek route name atau URI
            if (
                str_starts_with($routeName, 'user.') ||
                str_starts_with($routeName, 'level.') ||
                str_contains($uri, 'user') ||
                str_contains($uri, 'level')
            ) {
                abort(403, 'Akses ditolak untuk fitur admin/level');
            }
            return $next($request);
        }

        // LVL003: hanya boleh akses pelanggan & pembayaran
        if ($level === 'LVL003') {
            // Hanya boleh akses pelanggan & pembayaran
            if (!(
                str_starts_with($routeName, 'pelanggan.') ||
                str_starts_with($routeName, 'pembayaran.') ||
                $uri === 'dashboard-admin' ||
                $uri === '/' // allow root redirect
            )) {
                abort(403, 'Akses ditolak untuk fitur ini');
            }
            return $next($request);
        }

        // Default: tolak
        abort(403, 'Akses ditolak');
    }
}
