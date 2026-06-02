{{-- resources/views/peminjaman/history.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Peminjaman — Pustaka Digital')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <h1 class="font-display text-3xl font-bold mb-1" style="color:#0f0f0f;">Riwayat Peminjaman</h1>
    <p class="text-sm" style="color:#6b6457;">
        Semua buku yang pernah kamu pinjam dari Pustaka Digital
    </p>
</div>

{{-- Stats Row --}}
@if(isset($peminjaman) && $peminjaman->count())
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    @php
        $total     = $peminjaman->total();
        $aktif     = $peminjaman->where('status', 'dipinjam')->count();
        $terlambat = $peminjaman->where('status', 'terlambat')->count();
        $selesai   = $peminjaman->where('status', 'dikembalikan')->count();
    @endphp

    @foreach([
        ['label' => 'Total Pinjam',   'value' => $total,     'icon' => 'ph-fill ph-book-bookmark', 'color' => '#b8860b', 'bg' => 'rgba(184,134,11,0.1)'],
        ['label' => 'Aktif',          'value' => $aktif,     'icon' => 'ph-fill ph-clock',         'color' => '#7c3aed', 'bg' => 'rgba(124,58,237,0.1)'],
        ['label' => 'Terlambat',      'value' => $terlambat, 'icon' => 'ph-fill ph-warning',       'color' => '#c0392b', 'bg' => 'rgba(192,57,43,0.1)'],
        ['label' => 'Selesai',        'value' => $selesai,   'icon' => 'ph-fill ph-check-circle',  'color' => '#166534', 'bg' => '#f0fdf4'],
    ] as $s)
        <div class="rounded-2xl border p-4 flex items-center gap-3" style="background:#fff; border-color:#e0d9cf;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $s['bg'] }};">
                <i class="{{ $s['icon'] }}" style="color:{{ $s['color'] }};"></i>
            </div>
            <div>
                <p class="font-display text-xl font-bold" style="color:#0f0f0f;">{{ $s['value'] }}</p>
                <p class="text-xs" style="color:#6b6457;">{{ $s['label'] }}</p>
            </div>
        </div>
    @endforeach
</div>
@endif

{{-- Peminjaman List --}}
@forelse($peminjaman ?? [] as $item)
    <div class="rounded-2xl border mb-4 overflow-hidden transition hover:shadow-sm" style="background:#fff; border-color:#e0d9cf;">

        {{-- Header row --}}
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3"
             style="border-color:#f2ede4; background:#faf8f4;">

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#f2ede4;">
                    <i class="ph ph-receipt text-lg" style="color:#b8860b;"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#0f0f0f;">Peminjaman #{{ $item->id }}</p>
                    <p class="text-xs" style="color:#6b6457;">
                        Dipinjam: {{ $item->tanggal_pinjam->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                {{-- Due date --}}
                <span class="text-xs px-2 py-1 rounded-lg flex items-center gap-1"
                      style="background:#f2ede4; color:#6b6457;">
                    <i class="ph ph-calendar-check"></i>
                    Kembali: {{ $item->tanggal_kembali_rencana->format('d M Y') }}
                </span>

                {{-- Status badge --}}
                @php
                    $statusMap = [
                        'dipinjam'     => ['bg' => 'rgba(124,58,237,0.1)', 'color' => '#7c3aed', 'label' => 'Sedang Dipinjam', 'icon' => 'ph-fill ph-clock'],
                        'terlambat'    => ['bg' => 'rgba(192,57,43,0.1)',  'color' => '#c0392b', 'label' => 'Terlambat',       'icon' => 'ph-fill ph-warning-circle'],
                        'dikembalikan' => ['bg' => '#f0fdf4',              'color' => '#166534', 'label' => 'Dikembalikan',    'icon' => 'ph-fill ph-check-circle'],
                        'menunggu'     => ['bg' => 'rgba(219,234,254,0.1)', 'color' => '#1d4ed8', 'label' => 'Menunggu Persetujuan', 'icon' => 'ph-fill ph-hourglass'],
                        'ditolak'      => ['bg' => 'rgba(239,68,68,0.1)', 'color' => '#ef4444', 'label' => 'Ditolak',           'icon' => 'ph-fill ph-x-circle'],
                    ];
                    $s = $statusMap[$item->status] ?? ['bg' => '#f2ede4', 'color' => '#6b6457', 'label' => ucfirst($item->status), 'icon' => 'ph ph-info'];
                @endphp
                <span class="text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1"
                      style="background:{{ $s['bg'] }}; color:{{ $s['color'] }};">
                    <i class="{{ $s['icon'] }}"></i>
                    {{ $s['label'] }}
                </span>
            </div>
        </div>

        {{-- Books in this peminjaman --}}
        <div class="px-5 py-4">
            @forelse($item->detailPeminjaman ?? [] as $detail)
                <div class="flex items-center gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-b' : '' }}"
                     style="{{ !$loop->last ? 'border-color:#f2ede4;' : '' }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                         style="background:linear-gradient(135deg, #f2ede4, #e8dfd0);">
                        <i class="ph-fill ph-book text-lg" style="color:#b8860b; opacity:0.7;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate" style="color:#0f0f0f;">
                            {{ $detail->buku->judul ?? 'Buku tidak ditemukan' }}
                        </p>
                        <p class="text-xs" style="color:#6b6457;">
                            {{ $detail->buku->pengarang ?? '-' }}
                            @if($detail->buku->kategori)
                                &middot; {{ $detail->buku->kategori->nama }}
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-center py-4" style="color:#6b6457;">Tidak ada detail buku.</p>
            @endforelse
        </div>

        {{-- Denda row --}}
        @if($item->denda && $item->denda > 0)
            <div class="px-5 py-3 border-t flex items-center justify-between"
                 style="border-color:#f2ede4; background:#fef2f2;">
                <span class="text-xs flex items-center gap-1" style="color:#c0392b;">
                    <i class="ph-fill ph-warning-circle"></i> Denda keterlambatan
                </span>
                <span class="text-sm font-semibold" style="color:#c0392b;">
                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                </span>
            </div>
        @endif

        @if($item->tanggal_kembali_aktual)
            <div class="px-5 py-3 border-t flex items-center justify-between"
                 style="border-color:#f2ede4; background:#f0fdf4;">
                <span class="text-xs flex items-center gap-1" style="color:#166534;">
                    <i class="ph-fill ph-check-circle"></i> Dikembalikan pada
                </span>
                <span class="text-xs font-semibold" style="color:#166534;">
                    {{ $item->tanggal_kembali_aktual->format('d M Y') }}
                </span>
            </div>
        @endif
    </div>
@empty
    <div class="text-center py-20 rounded-3xl border" style="background:#fff; border-color:#e0d9cf;">
        <i class="ph ph-book-open text-6xl block mb-4" style="color:#e0d9cf;"></i>
        <p class="font-display text-xl font-semibold mb-2" style="color:#6b6457;">Belum Ada Riwayat</p>
        <p class="text-sm mb-6" style="color:#6b6457;">Kamu belum pernah meminjam buku. Yuk mulai baca!</p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 transition"
           style="background:#b8860b; color:#fff;">
            <i class="ph ph-books"></i> Jelajahi Buku
        </a>
    </div>
@endforelse

{{-- Pagination --}}
@if(isset($peminjaman) && $peminjaman->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $peminjaman->links() }}
    </div>
@endif

@endsection