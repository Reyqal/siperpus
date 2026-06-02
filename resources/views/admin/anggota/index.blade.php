@extends('layouts.app')

@section('title', 'Data Anggota — Admin')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color:#b8860b; letter-spacing:0.12em;">Manajemen</p>
            <h1 style="font-family:'Poppins',sans-serif; font-size:1.75rem; font-weight:700; color:#0f0f0f; line-height:1.2;">
                Data Anggota
            </h1>
            <p class="text-sm mt-1" style="color:#6b6457;">{{ $anggota->total() }} anggota terdaftar</p>
        </div>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.anggota.index') }}" class="flex gap-2">
        <div class="relative flex-1 max-w-sm">
            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm" style="color:#6b6457;"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama atau email..."
                   class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg outline-none border border-gray-200 focus:ring-2 focus:ring-amber-200 transition"
                   style="background:#fff; color:#0f0f0f;">
        </div>
        <button type="submit"
                class="px-4 py-2.5 rounded-lg text-sm font-medium transition hover:opacity-80"
                style="background:#0f0f0f; color:#faf8f4;">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('admin.anggota.index') }}"
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
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Anggota</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden md:table-cell" style="color:#6b6457;">Bergabung</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-xs uppercase tracking-wide hidden lg:table-cell" style="color:#6b6457;">Total Pinjam</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Aktif</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-xs uppercase tracking-wide" style="color:#6b6457;">Aksi</th>
                </tr>
            </thead>
            <tbody style="background:#fff;">
                @forelse($anggota as $index => $user)
                    <tr class="hover:bg-amber-50 transition-colors" style="border-bottom:1px solid #f2ede4;">
                        <td class="px-5 py-4" style="color:#a09880;">
                            {{ $anggota->firstItem() + $index }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm text-white flex-shrink-0"
                                     style="background:#0f0f0f;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium leading-snug" style="color:#0f0f0f;">{{ $user->name }}</p>
                                    <p class="text-xs" style="color:#6b6457;">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell text-xs" style="color:#6b6457;">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 hidden lg:table-cell text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold"
                                  style="background:#f2ede4; color:#6b6457;">
                                {{ $user->peminjaman_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if(($user->peminjaman->where('status', 'dipinjam')->count()) > 0)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                      style="background:#fffbeb; color:#92400e;">Meminjam</span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold"
                                      style="background:#f0fdf4; color:#166534;">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.anggota.show', $user->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition hover:opacity-80"
                               style="background:#0f0f0f; color:#faf8f4;">
                                <i class="ph ph-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <i class="ph ph-users text-4xl mb-3 block" style="color:#e0d9cf;"></i>
                            <p class="font-medium" style="color:#6b6457;">Belum ada anggota terdaftar</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($anggota->hasPages())
        <div class="flex justify-end">
            {{ $anggota->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection