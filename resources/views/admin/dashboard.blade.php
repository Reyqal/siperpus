@extends('layouts.app')

@section('title', 'Dashboard — Admin')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color:#b8860b; letter-spacing:0.12em;">Selamat datang</p>
        <h1 style="font-family:'Poppins',sans-serif; font-size:1.875rem; font-weight:700; color:#0f0f0f;">
            Dashboard Admin
        </h1>
        <p class="text-sm mt-1" style="color:#6b6457;">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="rounded-xl p-5 col-span-1" style="background:#4A2E15;">
            <i class="ph-fill ph-books text-2xl mb-3 block" style="color:#d5b07c;"></i>
            <p class="text-3xl font-bold mb-1" style="font-family:'Poppins',sans-serif; color:#faf8f4;">{{ $totalBuku }}</p>
            <p class="text-xs font-medium uppercase tracking-wide" style="color:#d5b07c;">Total Buku</p>
        </div>
        <div class="rounded-xl p-5 col-span-1" style="background:#fff; border:1px solid #e0d9cf;">
            <i class="ph-fill ph-users text-2xl mb-3 block" style="color:#b8860b;"></i>
            <p class="text-3xl font-bold mb-1" style="font-family:'Poppins',sans-serif; color:#0f0f0f;">{{ $totalAnggota }}</p>
            <p class="text-xs font-medium uppercase tracking-wide" style="color:#6b6457;">Anggota</p>
        </div>
        <div class="rounded-xl p-5 col-span-1" style="background:#fff; border:1px solid #e0d9cf;">
            <i class="ph-fill ph-clipboard-text text-2xl mb-3 block" style="color:#b8860b;"></i>
            <p class="text-3xl font-bold mb-1" style="font-family:'Poppins',sans-serif; color:#0f0f0f;">{{ $totalPeminjaman }}</p>
            <p class="text-xs font-medium uppercase tracking-wide" style="color:#6b6457;">Total Pinjam</p>
        </div>
        <div class="rounded-xl p-5 col-span-1" style="background:#fffbeb; border:1px solid #fde68a;">
            <i class="ph-fill ph-book-open text-2xl mb-3 block" style="color:#92400e;"></i>
            <p class="text-3xl font-bold mb-1" style="font-family:'Poppins',sans-serif; color:#92400e;">{{ $dipinjam }}</p>
            <p class="text-xs font-medium uppercase tracking-wide" style="color:#92400e;">Sedang Dipinjam</p>
        </div>
        <div class="rounded-xl p-5 col-span-1" style="background:#fef2f2; border:1px solid #fca5a5;">
            <i class="ph-fill ph-warning text-2xl mb-3 block" style="color:#991b1b;"></i>
            <p class="text-3xl font-bold mb-1" style="font-family:'Poppins',sans-serif; color:#991b1b;">{{ $terlambat }}</p>
            <p class="text-xs font-medium uppercase tracking-wide" style="color:#991b1b;">Terlambat</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <a href="{{ route('admin.buku.create') }}"
           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition hover:opacity-80"
           style="background:#fff; border:1px solid #e0d9cf;">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#f2ede4;">
                <i class="ph ph-plus" style="color:#b8860b;"></i>
            </div>
            <span class="text-sm font-medium" style="color:#0f0f0f;">Tambah Buku</span>
        </a>
        <a href="{{ route('admin.peminjaman.index') }}"
           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition hover:opacity-80"
           style="background:#fff; border:1px solid #e0d9cf;">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#f2ede4;">
                <i class="ph ph-note-pencil" style="color:#b8860b;"></i>
            </div>
            <span class="text-sm font-medium" style="color:#0f0f0f;">kelola Peminjaman</span>
        </a>
        <a href="{{ route('admin.buku.index') }}"
           class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition hover:opacity-80"
           style="background:#fff; border:1px solid #e0d9cf;">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#f2ede4;">
                <i class="ph ph-books" style="color:#b8860b;"></i>
            </div>
            <span class="text-sm font-medium" style="color:#0f0f0f;">Kelola Buku</span>
        </a>
        <a href="{{ route('admin.anggota.index') }}"
        class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition hover:opacity-80"
        style="background:#fff; border:1px solid #e0d9cf;">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#f2ede4;">
                <i class="ph ph-users" style="color:#b8860b;"></i>
            </div>
            <span class="text-sm font-medium" style="color:#0f0f0f;">Kelola Anggota</span>
        </a>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 style="font-family:'Poppins',sans-serif; font-size:1.25rem; font-weight:600; color:#0f0f0f;">
                Peminjaman Terbaru
            </h2>
            <a href="{{ route('admin.peminjaman.index') }}"
               class="text-xs font-medium hover:underline"
               style="color:#b8860b;">Lihat semua</a>
        </div>

        <div class="rounded-xl overflow-hidden" style="border:1px solid #e0d9cf;">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background:#f2ede4; border-bottom:1px solid #e0d9cf;">
                        <th class="text-left px-5 py-3 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Anggota</th>
                        <th class="text-left px-5 py-3 font-semibold text-xs uppercase tracking-wide hidden md:table-cell" style="color:#6b6457;">Buku</th>
                        <th class="text-left px-5 py-3 font-semibold text-xs uppercase tracking-wide hidden lg:table-cell" style="color:#6b6457;">Tgl Pinjam</th>
                        <th class="text-center px-5 py-3 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Status</th>
                        <th class="text-right px-5 py-3 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="background:#fff;">
                    @forelse($peminjamanTerbaru as $item)
                        <tr class="hover:bg-amber-50 transition-colors" style="border-bottom:1px solid #f2ede4;">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                         style="background:#0f0f0f;">
                                        {{ strtoupper(substr($item->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="font-medium" style="color:#0f0f0f;">{{ $item->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs" style="color:#6b6457;">
                                    {{ $item->detailPeminjaman->first()->buku->judul ?? '-' }}
                                    @if($item->detailPeminjaman->count() > 1)
                                        <span style="color:#b8860b;">+{{ $item->detailPeminjaman->count() - 1 }} lainnya</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-5 py-3.5 hidden lg:table-cell text-xs" style="color:#6b6457;">
                                {{ $item->tanggal_pinjam->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($item->status === 'dipinjam')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                          style="background:#fffbeb; color:#92400e;">Dipinjam</span>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                          style="background:#f0fdf4; color:#166534;">Dikembalikan</span>
                                @elseif($item->status === 'terlambat')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                          style="background:#fef2f2; color:#991b1b;">Terlambat</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('admin.peminjaman.show', $item) }}"
                                   class="text-xs font-medium hover:underline"
                                   style="color:#b8860b;">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-sm" style="color:#6b6457;">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection