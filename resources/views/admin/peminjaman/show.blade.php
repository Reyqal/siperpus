@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold font-display mb-2">
                Detail Peminjaman
            </h1>

            <p class="text-sm" style="color: var(--muted);">
                Informasi lengkap data peminjaman buku.
            </p>
        </div>

        <a href="{{ route('admin.peminjaman.index') }}"
           class="px-5 py-3 rounded-xl border font-medium transition hover:bg-gray-50"
           style="border-color: var(--border);">
            Kembali
        </a>
    </div>

    {{-- Informasi Peminjam --}}
    <div class="rounded-2xl border shadow-sm p-6 mb-6"
         style="background:white; border-color:var(--border);">

        <h2 class="text-xl font-bold mb-5">
            Informasi Peminjam
        </h2>

        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm mb-1" style="color: var(--muted);">
                    Nama Anggota
                </p>

                <p class="font-semibold">
                    {{ $peminjaman->user->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm mb-1" style="color: var(--muted);">
                    Status
                </p>

                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($peminjaman->status == 'dipinjam')
                        bg-yellow-100 text-yellow-700
                    @elseif($peminjaman->status == 'dikembalikan')
                        bg-green-100 text-green-700
                    @else
                        bg-red-100 text-red-700
                    @endif
                ">
                    {{ ucfirst($peminjaman->status) }}
                </span>
            </div>

            <div>
                <p class="text-sm mb-1" style="color: var(--muted);">
                    Tanggal Pinjam
                </p>

                <p class="font-semibold">
                    {{ $peminjaman->tanggal_pinjam }}
                </p>
            </div>

            <div>
                <p class="text-sm mb-1" style="color: var(--muted);">
                    Rencana Kembali
                </p>

                <p class="font-semibold">
                    {{ $peminjaman->tanggal_kembali_rencana }}
                </p>
            </div>

            <div>
                <p class="text-sm mb-1" style="color: var(--muted);">
                    Tanggal Kembali Aktual
                </p>

                <p class="font-semibold">
                    {{ $peminjaman->tanggal_kembali_aktual ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm mb-1" style="color: var(--muted);">
                    Denda
                </p>

                <p class="font-semibold text-red-600">
                    Rp {{ number_format($peminjaman->denda ?? 0, 0, ',', '.') }}
                </p>
            </div>

        </div>

    </div>

    {{-- Daftar Buku --}}
    <div class="rounded-2xl border shadow-sm p-6"
         style="background:white; border-color:var(--border);">

        <h2 class="text-xl font-bold mb-5">
            Buku Dipinjam
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>
                    <tr style="background: var(--cream);">
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Judul Buku</th>
                        <th class="px-4 py-3 text-left">Pengarang</th>
                        <th class="px-4 py-3 text-left">Jumlah</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($peminjaman->detailPeminjaman as $detail)

                        <tr class="border-t" style="border-color: var(--border);">
                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $detail->buku->judul ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $detail->buku->pengarang ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $detail->jumlah }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                Tidak ada buku dipinjam.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection