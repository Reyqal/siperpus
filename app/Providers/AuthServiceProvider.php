<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate: hanya admin yang bisa mengelola buku
        Gate::define('manage-buku', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate: hanya admin yang bisa mengelola anggota
        Gate::define('manage-anggota', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate: admin dan anggota yang sudah login bisa meminjam
        Gate::define('buat-peminjaman', function (User $user) {
            return in_array($user->role, ['admin', 'anggota']);
        });

        // Gate: hanya admin yang bisa melihat semua peminjaman
        Gate::define('lihat-semua-peminjaman', function (User $user) {
            return $user->role === 'admin';
        });
    }
}