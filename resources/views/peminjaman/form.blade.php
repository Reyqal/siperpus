@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold font-display mb-2">
            Peminjaman Buku
        </h1>

        <p class="text-sm" style="color: var(--muted);">
            Pilih buku yang ingin dipinjam.
        </p>
    </div>

    {{-- Card --}}
    <div class="rounded-2xl shadow-sm border p-8"
         style="background:white; border-color:var(--border);">

        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Pilih Buku --}}
            <div>
                <label class="block text-sm font-semibold mb-2">
                    Pilih Buku
                </label>

                <select name="buku_id"
                        class="w-full px-4 py-3 rounded-xl border outline-none focus:ring-2"
                        style="border-color: var(--border);">

                    <option value="">-- Pilih Buku --</option>

                    @foreach($buku as $item)
                        <option value="{{ $item->id }}"
                            {{ old('buku_id', optional($selectedBuku)->id) == $item->id ? 'selected' : '' }}>
                            
                            {{ $item->judul }}
                            — Stok: {{ $item->stok }}

                        </option>
                    @endforeach

                </select>

                @error('buku_id')
                    <p class="text-sm text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tanggal Pinjam --}}
            <div>
                <label class="block text-sm font-semibold mb-2">
                    Tanggal Pinjam
                </label>

                <input type="date"
                       name="tanggal_pinjam"
                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                       class="w-full px-4 py-3 rounded-xl border outline-none focus:ring-2"
                       style="border-color: var(--border);">

                @error('tanggal_pinjam')
                    <p class="text-sm text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tanggal Kembali --}}
            <div>
                <label class="block text-sm font-semibold mb-2">
                    Tanggal Kembali
                </label>

                <input type="date"
                       name="tanggal_kembali_rencana"
                       value="{{ old('tanggal_kembali_rencana') }}"
                       class="w-full px-4 py-3 rounded-xl border outline-none focus:ring-2"
                       style="border-color: var(--border);">

                @error('tanggal_kembali_rencana')
                    <p class="text-sm text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-4 pt-4">

                <button type="submit"
                        class="px-6 py-3 rounded-xl text-white font-semibold transition hover:scale-[1.02]"
                        style="background: var(--gold);">
                    Pinjam Buku
                </button>

                <a href="{{ url()->previous() }}"
                   class="px-6 py-3 rounded-xl border font-medium transition hover:bg-gray-50"
                   style="border-color: var(--border);">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection