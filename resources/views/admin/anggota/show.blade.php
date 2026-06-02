@extends('layouts.app')

@section('title', 'Detail Anggota — ' . $user->name)

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.anggota.index') }}"
           class="p-2 rounded-lg hover:bg-gray-100 transition"
           style="color:#6b6457;">
            <i class="ph ph-arrow-left text-lg"></i>
        </a>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color:#b8860b;">Detail Anggota</p>
            <h1 style="font-family:'Poppins',sans-serif; font-size:1.75rem; font-weight:700; color:#0f0f0f;">
                {{ $user->name }}
            </h1>
        </div>
    </div>

    {{-- Info Anggota --}}
    <div class="rounded-xl p-6 flex items-center gap-5" style="border:1px solid #e0d9cf; background:#fff;">
        <div class="w-16 h-16 rounded-full flex items-center justify-center font-bold text-2xl text-white flex-shrink-0"
             style="background:#0f0f0f;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 flex-1">
            <div>
                <p class="text-xs uppercase tracking-wide mb-1" style="color:#6b6457;">Nama</p>
                <p class="font-semibold" style="color:#0f0f0f;">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide mb-1" style="color:#6b6457;">Email</p>
                <p class="font-semibold" style="color:#0f0f0f;">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide mb-1" style="color:#6b6457;">Bergabung</p>
                <p class="font-semibold" style="color:#0f0f0f;">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="rounded-xl p-5 text-center" style="border:1px solid #e0d9cf; background:#fff;">
            <p class="text-2xl font-bold" style="color:#0f0f0f;">{{ $peminjaman->total() }}</p>
            <p class="text-xs mt-1" style="color:#6b6457;">Total Pinjam</p>
        </div>
        <div class="rounded-xl p-5 text-center" style="border:1px solid #e0d9cf; background:#fff;">
            <p class="text-2xl font-bold" style="color:#92400e;">
                {{ $peminjaman->getCollection()->where('status', 'dipinjam')->count() }}
            </p>
            <p class="text-xs mt-1" style="color:#6b6457;">Sedang Dipinjam</p>
        </div>
        <div class="rounded-xl p-5 text-center" style="border:1px solid #e0d9cf; background:#fff;">
            <p class="text-2xl font-bold" style="color:#166534;">
                {{ $peminjaman->getCollection()->where('status', 'dikembalikan')->count() }}
            </p>
            <p class="text-xs mt-1" style="color:#6b6457;">Dikembalikan</p>
        </div>
    </div>

    {{-- Tabel Riwayat Peminjaman --}}
    <div>
        <h2 class="text-base font-semibold mb-3" style="color:#0f0f0f;">Riwayat Peminjaman</h2>
        <div class="rounded-xl overflow-hidden" style="border:1px solid #e0d9cf;">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background:#f2ede4; border-bottom:1px solid #e0d9cf;">
                        <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">#</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Buku</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden md:table-cell" style="color:#6b6457;">Tgl Pinjam</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden md:table-cell" style="color:#6b6457;">Tgl Kembali</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Status</th>
                    </tr>
                </thead>
                <tbody style="background:#fff;">
                    @forelse($peminjaman as $index => $item)
                        <tr class="hover:bg-amber-50 transition-colors" style="border-bottom:1px solid #f2ede4;">
                            <td class="px-5 py-4" style="color:#a09880;">
                                {{ $peminjaman->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    {{-- Cover Buku --}}
                                    @if($item->detailPeminjaman->first()?->buku?->cover)
                                        <img src="{{ asset('storage/' . $item->detailPeminjaman->first()->buku->cover) }}"
                                             class="w-10 h-12 object-cover rounded"
                                             alt="cover">
                                    @else
                                        <div class="w-10 h-12 rounded flex items-center justify-center"
                                             style="background:#f2ede4;">
                                            <i class="ph ph-book text-lg" style="color:#6b6457;"></i>
                                        </div>
                                    @endif

                                    {{-- Judul & Pengarang --}}
                                    <div>
                                        <p class="font-medium" style="color:#0f0f0f;">
                                            {{ $item->detailPeminjaman->first()?->buku?->judul ?? '-' }}
                                            @if($item->detailPeminjaman->count() > 1)
                                                <span class="text-xs" style="color:#b8860b;">
                                                    +{{ $item->detailPeminjaman->count() - 1 }} lainnya
                                                </span>
                                            @endif
                                        </p>
                                        <p class="text-xs" style="color:#6b6457;">
                                            {{ $item->detailPeminjaman->first()?->buku?->pengarang ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell text-xs" style="color:#6b6457;">
                                {{ $item->tanggal_pinjam->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell text-xs" style="color:#6b6457;">
                                {{ $item->tanggal_kembali_aktual ? $item->tanggal_kembali_aktual->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($item->status === 'dipinjam')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                          style="background:#fffbeb; color:#92400e;">Dipinjam</span>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                          style="background:#f0fdf4; color:#166534;">Dikembalikan</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                          style="background:#fef2f2; color:#991b1b;">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <i class="ph ph-books text-4xl mb-3 block" style="color:#e0d9cf;"></i>
                                <p class="font-medium" style="color:#6b6457;">Belum ada riwayat peminjaman</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($peminjaman->hasPages())
            <div class="flex justify-end mt-4">
                {{ $peminjaman->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection