<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PelangganMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('pelanggan')) {
            return redirect()->route('login.pelanggan');
        }
        return $next($request);
    }
}
