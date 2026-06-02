<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $anggota = User::where('role', 'anggota')
            ->withCount('peminjaman')
            ->with('peminjaman')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->paginate(10);

        return view('admin.anggota.index', compact('anggota'));
    }

    public function show(User $user)
    {
        $peminjaman = $user->peminjaman()
            ->with('detailPeminjaman.buku')
            ->latest()
            ->paginate(10);

        return view('admin.anggota.show', compact('user', 'peminjaman'));
    }
}