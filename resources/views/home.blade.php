{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Beranda — Pustaka Digital')

@section('content')

{{-- Hero Section --}}
<section class="relative mb-14 rounded-3xl overflow-hidden px-8 py-14 md:px-16 md:py-20"
         style="background: linear-gradient(135deg, #1a1208 0%, #2d1f0a 60%, #3d2c10 100%);">

    {{-- Decorative pattern --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none"
         style="background-image: radial-gradient(circle at 20% 50%, #b8860b 0%, transparent 50%), radial-gradient(circle at 80% 20%, #d4a41f 0%, transparent 40%);"></div>
    <div class="absolute inset-0 opacity-5"
         style="background-image: repeating-linear-gradient(45deg, #b8860b 0px, #b8860b 1px, transparent 1px, transparent 20px);"></div>

    <div class="relative max-w-2xl">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold mb-6"
             style="background:rgba(184,134,11,0.2); color:#d4a41f; border:1px solid rgba(184,134,11,0.4);">
            <i class="ph-fill ph-star"></i>
            Perpustakaan Digital
        </div>
        <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight mb-5" style="color:#faf8f4;">
            Sudah Baca Buku Hari Ini?<br>
            <span style="color:#b8860b;">Sedikit Halaman, Sejuta Makna.</span>
        </h1>
        <p class="text-base leading-relaxed mb-8 max-w-lg" style="color:#c8bfaf;">
            Tidak perlu langsung tamat. Cukup luangkan waktu 5 menit hari ini untuk menyegarkan pikiranmu.
        </p>
        <div class="flex flex-wrap gap-3">
            @guest
                <a href="{{ route('register') }}"
                   class="px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5"
                   style="background:#b8860b; color:#fff;">
                    <i class="ph ph-user-plus mr-1"></i> Daftar Gratis
                </a>
                <a href="{{ route('login') }}"
                   class="px-6 py-3 rounded-xl font-semibold text-sm border transition-all duration-200 hover:bg-white/10"
                   style="border-color:rgba(255,255,255,0.3); color:#faf8f4;">
                    <i class="ph ph-sign-in mr-1"></i> Masuk
                </a>
            @else
                {{-- Tombol untuk ANGGOTA --}}
                @if(auth()->user()->role === 'anggota')
                    <a href="{{ route('peminjaman.create') }}"
                       class="px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5"
                       style="background:#b8860b; color:#fff;">
                        <i class="ph ph-book-open mr-1"></i> Pinjam Buku
                    </a>
                    <a href="{{ route('peminjaman.history') }}"
                       class="px-6 py-3 rounded-xl font-semibold text-sm border transition-all duration-200 hover:bg-white/10"
                       style="border-color:rgba(255,255,255,0.3); color:#faf8f4;">
                        <i class="ph ph-clock-clockwise mr-1"></i> Riwayat Saya
                    </a>

                {{-- Tombol untuk ADMIN --}}
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5"
                       style="background:#b8860b; color:#fff;">
                        <i class="ph ph-gauge mr-1"></i> Dashboard Admin
                    </a>
<a href="{{ route('admin.peminjaman.index') }}"
   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold transition hover:opacity-80 whitespace-nowrap"
   style="background:#0f0f0f; color:#faf8f4;">
    <i class="ph ph-list"></i>
    Kelola Peminjaman
</a>
                @endif
            @endauth
        </div>
    </div>

    {{-- Stats --}}
    <div class="absolute right-8 bottom-8 hidden lg:flex gap-6">
        <div class="text-center">
            <p class="font-display text-3xl font-bold" style="color:#b8860b;">1000+</p>
            <p class="text-xs" style="color:#c8bfaf;">Koleksi Buku</p>
        </div>
        <div class="w-px" style="background:rgba(255,255,255,0.1);"></div>
        <div class="text-center">
            <p class="font-display text-3xl font-bold" style="color:#b8860b;">500+</p>
            <p class="text-xs" style="color:#c8bfaf;">Anggota Aktif</p>
        </div>
    </div>
</section>

{{-- Filter & Search --}}
<section class="mb-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-display text-2xl font-semibold" style="color:#0f0f0f;">Koleksi Buku</h2>
            <p class="text-sm mt-0.5" style="color:#6b6457;">
                Menampilkan {{ $buku->total() }} buku tersedia
            </p>
        </div>

        {{-- Category filter --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('home') }}"
               class="px-3 py-1.5 rounded-full text-xs font-medium border transition-all duration-200
                      {{ !request('kategori') ? 'text-white border-amber-700' : 'hover:bg-amber-50' }}"
               style="{{ !request('kategori') ? 'background:#b8860b; border-color:#b8860b;' : 'border-color:#e0d9cf; color:#6b6457;' }}">
                Semua
            </a>
            @foreach($kategori as $kat)
                <a href="{{ route('home', ['kategori' => $kat->id]) }}"
                   class="px-3 py-1.5 rounded-full text-xs font-medium border transition-all duration-200
                          {{ request('kategori') == $kat->id ? 'text-white border-amber-700' : 'hover:bg-amber-50' }}"
                   style="{{ request('kategori') == $kat->id ? 'background:#b8860b; border-color:#b8860b;' : 'border-color:#e0d9cf; color:#6b6457;' }}">
                    {{ $kat->nama }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Book Grid --}}
    @if($buku->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @foreach($buku as $item)
                <x-book-card :buku="$item" />
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10 flex justify-center">
            {{ $buku->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <i class="ph ph-books text-6xl mb-4 block" style="color:#e0d9cf;"></i>
            <p class="font-display text-xl font-semibold mb-2" style="color:#6b6457;">Belum ada buku tersedia</p>
            <p class="text-sm" style="color:#6b6457;">Coba pilih kategori lain atau kunjungi lagi nanti.</p>
        </div>
    @endif
</section>

@endsection
