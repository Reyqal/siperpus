@extends('layouts.app')

@section('title', 'Kelola Peminjaman — Admin')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color:#b8860b; letter-spacing:0.12em;">Manajemen</p>
            <h1 style="font-family:'Poppins',sans-serif; font-size:1.75rem; font-weight:700; color:#0f0f0f; line-height:1.2;">
                Data Peminjaman
            </h1>
            <p class="text-sm mt-1" style="color:#6b6457;">{{ $peminjaman->total() }} Kelola peminjaman</p>
        </div>
<a href="{{ route('admin.peminjaman.index') }}"
   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold transition hover:opacity-80 whitespace-nowrap"
   style="background:#0f0f0f; color:#faf8f4;">
    <i class="ph ph-check-circle"></i>
    Kelola Pengajuan
</a>
    </div>

    {{-- Stats --}}
    @php
        $allItems        = $peminjaman->getCollection();
        $jumlahDipinjam  = $allItems->where('status', 'dipinjam')->count();
        $jumlahKembali   = $allItems->where('status', 'dikembalikan')->count();
        $jumlahTerlambat = $allItems->where('status', 'terlambat')->count();
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="rounded-xl p-4" style="background:#fff; border:1px solid #e0d9cf;">
            <p class="text-xs uppercase tracking-wide font-semibold mb-1" style="color:#6b6457;">Total</p>
            <p class="text-2xl font-bold" style="color:#0f0f0f; font-family:'Poppins',sans-serif;">
                {{ $peminjaman->total() }}
            </p>
        </div>
        <div class="rounded-xl p-4" style="background:#fffbeb; border:1px solid #fde68a;">
            <p class="text-xs uppercase tracking-wide font-semibold mb-1" style="color:#92400e;">Dipinjam</p>
            <p class="text-2xl font-bold" style="color:#92400e; font-family:'Poppins',sans-serif;">
                {{ $jumlahDipinjam }}
            </p>
        </div>
        <div class="rounded-xl p-4" style="background:#f0fdf4; border:1px solid #86efac;">
            <p class="text-xs uppercase tracking-wide font-semibold mb-1" style="color:#166534;">Dikembalikan</p>
            <p class="text-2xl font-bold" style="color:#166534; font-family:'Poppins',sans-serif;">
                {{ $jumlahKembali }}
            </p>
        </div>
        <div class="rounded-xl p-4" style="background:#fef2f2; border:1px solid #fca5a5;">
            <p class="text-xs uppercase tracking-wide font-semibold mb-1" style="color:#991b1b;">Terlambat</p>
            <p class="text-2xl font-bold" style="color:#991b1b; font-family:'Poppins',sans-serif;">
                {{ $jumlahTerlambat }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    <div class="rounded-xl overflow-hidden" style="border:1px solid #e0d9cf;">
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#f2ede4; border-bottom:1px solid #e0d9cf;">
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">#</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Anggota</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden md:table-cell" style="color:#6b6457;">Buku</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden lg:table-cell" style="color:#6b6457;">Tgl Pinjam</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden lg:table-cell" style="color:#6b6457;">Tgl Kembali</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Status</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Aksi</th>
                </tr>
            </thead>
            <tbody style="background:#fff;">
                @forelse($peminjaman as $index => $item)
                    <tr class="transition-colors hover:bg-amber-50" style="border-bottom:1px solid #f2ede4;">
                        <td class="px-5 py-4" style="color:#a09880;">
                            {{ $peminjaman->firstItem() + $index }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                     style="background:#0f0f0f;">
                                    {{ strtoupper(substr($item->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium leading-snug" style="color:#0f0f0f;">{{ $item->user->name ?? '-' }}</p>
                                    <p class="text-xs" style="color:#6b6457;">{{ $item->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell">
                            @foreach($item->detailPeminjaman->take(2) as $detail)
                                <p class="text-xs leading-snug" style="color:#0f0f0f;">
                                    {{ $detail->buku->judul ?? '-' }}
                                    <span style="color:#a09880;">({{ $detail->jumlah }})</span>
                                </p>
                            @endforeach
                            @if($item->detailPeminjaman->count() > 2)
                                <p class="text-xs" style="color:#b8860b;">+{{ $item->detailPeminjaman->count() - 2 }} lainnya</p>
                            @endif
                        </td>
                        <td class="px-5 py-4 hidden lg:table-cell text-xs" style="color:#6b6457;">
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 hidden lg:table-cell text-xs" style="color:#6b6457;">
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-center">

    @if($item->status === 'menunggu')

        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
              style="background:#dbeafe; color:#1d4ed8;">
            Menunggu
        </span>

    @elseif($item->status === 'dipinjam')

        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
              style="background:#fffbeb; color:#92400e;">
            Dipinjam
        </span>

    @elseif($item->status === 'dikembalikan')

        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
              style="background:#f0fdf4; color:#166534;">
            Dikembalikan
        </span>

    @elseif($item->status === 'terlambat')

        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
              style="background:#fef2f2; color:#991b1b;">
            Terlambat
        </span>

    @elseif($item->status === 'ditolak')

        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
              style="background:#fee2e2; color:#b91c1c;">
            Ditolak
        </span>

    @else

        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
              style="background:#f2ede4; color:#6b6457;">
            {{ $item->status }}
        </span>

    @endif

</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.peminjaman.show', $item) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition hover:bg-gray-100 border border-gray-200"
                                   style="color:#0f0f0f;">
                                    <i class="ph ph-eye"></i>
                                    Detail
                                </a>
                                @if($item->status === 'menunggu')

<form action="{{ route('admin.peminjaman.approve', $item) }}"
      method="POST"
      onsubmit="return confirm('Setujui peminjaman ini?')">
    @csrf
    @method('PATCH')

    <button type="submit"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium"
            style="background:#166534; color:#fff;">
        <i class="ph ph-check"></i>
        Setujui
    </button>
</form>

<form action="{{ route('admin.peminjaman.tolak', $item) }}"
      method="POST"
      onsubmit="return confirm('Tolak peminjaman ini?')">
    @csrf
    @method('PATCH')

    <button type="submit"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium"
            style="background:#c0392b; color:#fff;">
        <i class="ph ph-x"></i>
        Tolak
    </button>
</form>

@endif
                                @if($item->status === 'dipinjam')
                                    <form action="{{ route('admin.peminjaman.kembalikan', $item) }}" method="POST"
                                          onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition hover:opacity-80"
                                                style="background:#0f0f0f; color:#faf8f4;">
                                            <i class="ph ph-arrow-u-up-left"></i>
                                            Kembalikan
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.peminjaman.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus data peminjaman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs transition hover:bg-red-50 border"
                                            style="color:#c0392b; border-color:#fecaca;">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <i class="ph ph-clipboard-text text-4xl mb-3 block" style="color:#e0d9cf;"></i>
                            <p class="font-medium" style="color:#6b6457;">Belum ada data peminjaman</p>
                            <a href="{{ route('admin.peminjaman.index') }}"
                               class="text-sm mt-1 inline-block hover:underline"
                               style="color:#b8860b;">kelola peminjaman pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($peminjaman->hasPages())
        <div class="flex justify-end">
            {{ $peminjaman->links() }}
        </div>
    @endif

</div>
@endsection