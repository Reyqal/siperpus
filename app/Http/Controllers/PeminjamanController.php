<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeminjamanRequest;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Daftar semua peminjaman — admin.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.buku'])
                                ->latest()
                                ->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Form tambah peminjaman baru — admin.
     */
    public function create()
    {
        $anggota = User::where('role', 'anggota')->get();
        $buku    = Buku::where('stok', '>', 0)->get();
        return view('admin.peminjaman.form', compact('anggota', 'buku'));
    }

    /**
     * Simpan peminjaman baru.
     */
    public function store(StorePeminjamanRequest $request)
    {
        $peminjaman = Peminjaman::create([
            'user_id'                  => $request->user_id,
            'tanggal_pinjam'           => $request->tanggal_pinjam,
            'tanggal_kembali_rencana'  => $request->tanggal_kembali_rencana,
            'status'                   => 'dipinjam',
        ]);

        foreach ($request->buku as $item) {
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'buku_id'       => $item['id'],
                'jumlah'        => $item['jumlah'],
            ]);

            // Kurangi stok buku
            Buku::find($item['id'])->decrement('stok', $item['jumlah']);
        }

        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Peminjaman berhasil dicatat.');
    }
    public function approve(Peminjaman $peminjaman)
{
    foreach ($peminjaman->detailPeminjaman as $detail) {

        if ($detail->buku->stok < $detail->jumlah) {
            return back()->with(
                'error',
                'Stok buku tidak mencukupi.'
            );
        }

        $detail->buku->decrement(
            'stok',
            $detail->jumlah
        );
    }

    $peminjaman->update([
        'status' => 'dipinjam'
    ]);

    return back()->with(
        'success',
        'Peminjaman berhasil disetujui.'
    );
}

public function tolak(Peminjaman $peminjaman)
{
    $peminjaman->update([
        'status' => 'ditolak'
    ]);

    return back()->with(
        'success',
        'Pengajuan peminjaman ditolak.'
    );
}

    /**
     * Kembalikan buku — ubah status peminjaman.
     */
    public function kembalikan(Peminjaman $peminjaman)
    {
        $today           = Carbon::today();
        $tanggalRencana  = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $denda           = 0;
        $status          = 'dikembalikan';

        if ($today->gt($tanggalRencana)) {
            $selisihHari = $today->diffInDays($tanggalRencana);
            $denda       = $selisihHari * 1000; // Rp 1.000/hari
            $status      = 'terlambat';
        }

        $peminjaman->update([
            'tanggal_kembali_aktual' => $today,
            'status'                  => $status,
            'denda'                   => $denda,
        ]);

        // Kembalikan stok buku
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->buku->increment('stok', $detail->jumlah);
        }

        $pesan = $status === 'terlambat'
            ? "Buku dikembalikan terlambat. Denda: Rp " . number_format($denda, 0, ',', '.')
            : 'Buku berhasil dikembalikan.';

        return redirect()->route('admin.peminjaman.index')->with('success', $pesan);
    }

    /**
     * Riwayat peminjaman untuk anggota yang sedang login.
     */
    public function history()
    {
        $peminjaman = Peminjaman::with(['detailPeminjaman.buku'])
                                ->where('user_id', Auth::id())
                                ->latest()
                                ->paginate(10);

        return view('peminjaman.history', compact('peminjaman'));
    }

    /**
     * Detail peminjaman — admin.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'detailPeminjaman.buku']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Hapus catatan peminjaman — admin.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil dihapus.');
    }
    // Form pinjam buku untuk ANGGOTA
public function anggotaCreate(Request $request)
{
    $buku = Buku::where('stok', '>', 0)->get();
    $selectedBuku = $request->buku_id ? Buku::find($request->buku_id) : null;
    return view('peminjaman.form', compact('buku', 'selectedBuku'));
}

// Simpan peminjaman dari ANGGOTA
public function anggotaStore(Request $request)
{
    $request->validate([
        'buku_id'                 => 'required|exists:buku,id',
        'tanggal_pinjam'          => 'required|date',
        'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
    ]);

    $peminjaman = Peminjaman::create([
        'user_id'                 => Auth::id(),
        'tanggal_pinjam'          => $request->tanggal_pinjam,
        'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
        'status'                  => 'menunggu',
    ]);

    DetailPeminjaman::create([
        'peminjaman_id' => $peminjaman->id,
        'buku_id'       => $request->buku_id,
        'jumlah'        => 1,
    ]);

    return redirect()
        ->route('peminjaman.history')
        ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
}
}
