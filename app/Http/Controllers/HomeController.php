<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;

class HomeController extends Controller
{
    /**
     * Halaman utama publik — daftar buku yang tersedia.
     */
    public function index()
    {
        $buku = Buku::with('kategori')
                    ->where('stok', '>', 0)
                    ->latest()
                    ->paginate(12);

        $kategori = KategoriBuku::all();

        return view('home', compact('buku', 'kategori'));
    }
}