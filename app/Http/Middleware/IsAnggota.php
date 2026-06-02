<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAnggota
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->role === 'anggota') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Halaman ini hanya untuk anggota perpustakaan.');
    }
}