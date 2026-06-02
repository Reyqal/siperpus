<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dashboard admin — statistik ringkasan.
     */
    public function index()
    {
        $totalBuku       = Buku::count();
        $totalAnggota    = User::where('role', 'anggota')->count();
        $totalPeminjaman = Peminjaman::count();
        $dipinjam        = Peminjaman::where('status', 'dipinjam')->count();
        $terlambat       = Peminjaman::where('status', 'terlambat')->count();

        $peminjamanTerbaru = Peminjaman::with(['user', 'detailPeminjaman.buku'])
                                       ->latest()
                                       ->take(5)
                                       ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'totalPeminjaman',
            'dipinjam',
            'terlambat',
            'peminjamanTerbaru'
        ));
    }
}