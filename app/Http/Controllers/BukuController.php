<?php
// app/Http/Controllers/BukuController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->paginate(10);
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        $kategoris = KategoriBuku::all();
        return view('admin.buku.form', compact('kategoris'));
    }

    public function store(StoreBukuRequest $request)
    {
        $data = $request->validated();

        // Upload cover jika ada
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $kategoris = KategoriBuku::all();
        return view('admin.buku.form', compact('buku', 'kategoris'));
    }

    public function update(UpdateBukuRequest $request, Buku $buku)
    {
        $data = $request->validated();

        // Upload cover baru & hapus yang lama
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        } else {
            // Tidak ada file baru → pertahankan cover lama
            unset($data['cover']);
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        // Hapus file cover saat buku dihapus
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}