@extends('layouts.app')

@section('title', isset($buku) ? 'Edit Buku — Admin' : 'Tambah Buku — Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs" style="color:#6b6457;">
        <a href="{{ route('admin.buku.index') }}" class="hover:underline" style="color:#b8860b;">Koleksi Buku</a>
        <i class="ph ph-caret-right text-xs"></i>
        <span>{{ isset($buku) ? 'Edit Buku' : 'Tambah Buku' }}</span>
    </nav>

    {{-- Header --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color:#b8860b; letter-spacing:0.12em;">
            {{ isset($buku) ? 'Perbarui Data' : 'Tambah Baru' }}
        </p>
        <h1 style="font-family:'Poppins',sans-serif; font-size:1.75rem; font-weight:700; color:#0f0f0f;">
            {{ isset($buku) ? $buku->judul : 'Buku Baru' }}
        </h1>
    </div>

    {{-- Form Card --}}
    <div class="rounded-xl p-6 space-y-5" style="background:#fff; border:1px solid #e0d9cf;">
        <form action="{{ isset($buku) ? route('admin.buku.update', $buku) : route('admin.buku.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if(isset($buku)) @method('PUT') @endif

            {{-- Judul --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                    Judul Buku <span style="color:#c0392b;">*</span>
                </label>
                <input type="text"
                       name="judul"
                       value="{{ old('judul', $buku->judul ?? '') }}"
                       placeholder="Masukkan judul buku"
                       class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-amber-200 {{ $errors->has('judul') ? 'border border-red-300' : 'border border-gray-200' }}"
                       style="background:#faf8f4; color:#0f0f0f;">
                @error('judul')
                    <p class="text-xs mt-1.5" style="color:#c0392b;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pengarang --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                    Pengarang <span style="color:#c0392b;">*</span>
                </label>
                <input type="text"
                       name="pengarang"
                       value="{{ old('pengarang', $buku->pengarang ?? '') }}"
                       placeholder="Nama pengarang"
                       class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-amber-200 {{ $errors->has('pengarang') ? 'border border-red-300' : 'border border-gray-200' }}"
                       style="background:#faf8f4; color:#0f0f0f;">
                @error('pengarang')
                    <p class="text-xs mt-1.5" style="color:#c0392b;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Penerbit & Tahun --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                        Penerbit
                    </label>
                    <input type="text"
                           name="penerbit"
                           value="{{ old('penerbit', $buku->penerbit ?? '') }}"
                           placeholder="Nama penerbit"
                           class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition border border-gray-200 focus:ring-2 focus:ring-amber-200"
                           style="background:#faf8f4; color:#0f0f0f;">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                        Tahun Terbit
                    </label>
                    <input type="number"
                           name="tahun_terbit"
                           value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}"
                           placeholder="{{ date('Y') }}"
                           min="1000"
                           max="{{ date('Y') }}"
                           class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition border border-gray-200 focus:ring-2 focus:ring-amber-200"
                           style="background:#faf8f4; color:#0f0f0f;">
                </div>
            </div>

            {{-- ISBN & Stok --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                        ISBN
                    </label>
                    <input type="text"
                           name="isbn"
                           value="{{ old('isbn', $buku->isbn ?? '') }}"
                           placeholder="978-xxx-xxx"
                           class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-amber-200 {{ $errors->has('isbn') ? 'border border-red-300' : 'border border-gray-200' }}"
                           style="background:#faf8f4; color:#0f0f0f;">
                    @error('isbn')
                        <p class="text-xs mt-1.5" style="color:#c0392b;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                        Stok <span style="color:#c0392b;">*</span>
                    </label>
                    <input type="number"
                           name="stok"
                           value="{{ old('stok', $buku->stok ?? 0) }}"
                           min="0"
                           class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-amber-200 {{ $errors->has('stok') ? 'border border-red-300' : 'border border-gray-200' }}"
                           style="background:#faf8f4; color:#0f0f0f;">
                    @error('stok')
                        <p class="text-xs mt-1.5" style="color:#c0392b;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                    Kategori <span style="color:#c0392b;">*</span>
                </label>
                <select name="kategori_id"
                        class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-amber-200 {{ $errors->has('kategori_id') ? 'border border-red-300' : 'border border-gray-200' }}"
                        style="background:#faf8f4; color:#0f0f0f;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', $buku->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-xs mt-1.5" style="color:#c0392b;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
                    Deskripsi
                </label>
                <textarea name="deskripsi"
                          rows="4"
                          placeholder="Deskripsi singkat tentang buku ini..."
                          class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition border border-gray-200 focus:ring-2 focus:ring-amber-200 resize-none"
                          style="background:#faf8f4; color:#0f0f0f;">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
            </div>
            {{-- Cover Buku --}}
<div>
    <label class="block text-xs font-semibold uppercase tracking-wide mb-1.5" style="color:#6b6457;">
        Cover Buku
        <span class="normal-case font-normal ml-1" style="color:#9c9488;">(jpg/png/webp, maks 2MB)</span>
    </label>

    {{-- Preview cover saat edit --}}
    @if(isset($buku) && $buku->cover_url)
        <div class="mb-3">
            <img src="{{ $buku->cover_url }}"
                 alt="Cover {{ $buku->judul }}"
                 class="h-40 w-28 object-cover rounded-lg border"
                 style="border-color:#e0d9cf;"
                 id="cover-preview">
            <p class="text-xs mt-1" style="color:#9c9488;">Cover saat ini. Upload baru untuk mengganti.</p>
        </div>
    @else
        <img src="" alt="" class="h-40 w-28 object-cover rounded-lg border hidden mb-3"
             style="border-color:#e0d9cf;" id="cover-preview">
    @endif

    <input type="file"
           name="cover"
           id="cover-input"
           accept="image/jpg,image/jpeg,image/png,image/webp"
           class="w-full px-4 py-2.5 rounded-lg text-sm border border-gray-200 outline-none transition focus:ring-2 focus:ring-amber-200"
           style="background:#faf8f4; color:#0f0f0f;">

    @error('cover')
        <p class="text-xs mt-1.5" style="color:#c0392b;">{{ $message }}</p>
    @enderror
</div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2" style="border-top:1px solid #f2ede4;">
                <a href="{{ route('admin.buku.index') }}"
                   class="px-5 py-2.5 rounded-lg text-sm font-medium transition hover:bg-gray-100 border border-gray-200"
                   style="color:#6b6457;">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-semibold transition hover:opacity-80"
                        style="background:#0f0f0f; color:#faf8f4;">
                    {{ isset($buku) ? 'Simpan Perubahan' : 'Tambah Buku' }}
                </button>
            </div>

        </form>
    </div>

</div>
@push('scripts')
<script>
    document.getElementById('cover-input').addEventListener('change', function () {
        const preview = document.getElementById('cover-preview');
        const file = this.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection