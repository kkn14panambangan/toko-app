<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login sebagai admin
        if (!session('admin_logged_in') || session('user_role') !== 'admin') {
            return redirect('/admin/login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        return $next($request);
    }
}