@extends('layouts.app')

@section('title', 'Kelola Buku — Admin')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color:#b8860b; letter-spacing:0.12em;">Manajemen</p>
            <h1 style="font-family:'Poppins',sans-serif; font-size:1.75rem; font-weight:700; color:#0f0f0f; line-height:1.2;">
                Koleksi Buku
            </h1>
            <p class="text-sm mt-1" style="color:#6b6457;">{{ $buku->total() }} buku terdaftar dalam sistem</p>
        </div>
        <a href="{{ route('admin.buku.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold transition hover:opacity-80 whitespace-nowrap"
           style="background:#0f0f0f; color:#faf8f4;">
            <i class="ph ph-plus"></i>
            Tambah Buku
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.buku.index') }}" class="flex gap-2">
        <div class="relative flex-1">
            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm" style="color:#6b6457;"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari judul, pengarang, ISBN..."
                   class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg outline-none border border-gray-200 focus:ring-2 focus:ring-amber-200 transition"
                   style="background:#fff; color:#0f0f0f;">
        </div>
        <button type="submit"
                class="px-4 py-2.5 rounded-lg text-sm font-medium transition hover:opacity-80"
                style="background:#0f0f0f; color:#faf8f4;">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('admin.buku.index') }}"
               class="px-4 py-2.5 rounded-lg text-sm font-medium transition hover:bg-gray-100 border border-gray-200"
               style="color:#6b6457;">
                Reset
            </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="rounded-xl overflow-hidden" style="border:1px solid #e0d9cf;">
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#f2ede4; border-bottom:1px solid #e0d9cf;">
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">#</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Judul & Pengarang</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden md:table-cell" style="color:#6b6457;">Kategori</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden lg:table-cell" style="color:#6b6457;">ISBN</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Stok</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Aksi</th>
                </tr>
            </thead>
            <tbody style="background:#fff;">
                @forelse($buku as $index => $item)
                    <tr class="transition-colors hover:bg-amber-50" style="border-bottom:1px solid #f2ede4;">
                        <td class="px-5 py-4" style="color:#a09880;">
                            {{ $buku->firstItem() + $index }}
                        </td>
                        <td class="px-5 py-4">
                            <p class="font-semibold leading-snug" style="color:#0f0f0f;">{{ $item->judul }}</p>
                            <p class="text-xs mt-0.5" style="color:#6b6457;">{{ $item->pengarang }}</p>
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium"
                                  style="background:#f2ede4; color:#6b6457;">
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 hidden lg:table-cell text-xs" style="color:#6b6457;">
                            {{ $item->isbn ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($item->stok > 5)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold"
                                      style="background:#f0fdf4; color:#166534;">{{ $item->stok }}</span>
                            @elseif($item->stok > 0)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold"
                                      style="background:#fffbeb; color:#92400e;">{{ $item->stok }}</span>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold"
                                      style="background:#fef2f2; color:#991b1b;">{{ $item->stok }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.buku.edit', $item) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition hover:bg-gray-100 border border-gray-200"
                                   style="color:#0f0f0f;">
                                    <i class="ph ph-pencil-simple"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.buku.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition hover:bg-red-50 border"
                                            style="color:#c0392b; border-color:#fecaca;">
                                        <i class="ph ph-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <i class="ph ph-books text-4xl mb-3 block" style="color:#e0d9cf;"></i>
                            <p class="font-medium" style="color:#6b6457;">Belum ada buku terdaftar</p>
                            <a href="{{ route('admin.buku.create') }}"
                               class="text-sm mt-1 inline-block hover:underline"
                               style="color:#b8860b;">Tambah buku pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($buku->hasPages())
        <div class="flex justify-end">
            {{ $buku->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection