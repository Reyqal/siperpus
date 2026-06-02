{{-- resources/views/components/book-card.blade.php --}}
{{-- Props: $buku (Buku model) --}}
@props(['buku'])

<article class="group relative rounded-2xl overflow-hidden border transition-all duration-300 hover:-translate-y-1 hover:shadow-lg flex flex-col"
         style="background:#fff; border-color:#e0d9cf;">

{{-- Cover --}}
<div class="relative aspect-[3/4] w-full overflow-hidden"
     style="background: linear-gradient(135deg, #f2ede4 0%, #e8dfd0 100%);">

    {{-- Jika ada gambar cover --}}
    @if($buku->cover_url)
        <img src="{{ $buku->cover_url }}"
             alt="Cover {{ $buku->judul }}"
             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
        {{-- Overlay tipis saat hover --}}
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
    @else
        {{-- Placeholder jika belum ada cover --}}
        <div class="absolute inset-0 opacity-10"
             style="background-image: repeating-linear-gradient(45deg, #b8860b 0px, #b8860b 1px, transparent 1px, transparent 12px);"></div>
        <div class="relative h-full flex items-center justify-center">
            <div class="text-center px-4">
                <i class="ph-fill ph-book-open text-5xl mb-2" style="color:#b8860b; opacity:0.7;"></i>
                <p class="text-xs font-medium leading-tight line-clamp-2 font-display" style="color:#6b6457;">
                    {{ $buku->judul }}
                </p>
            </div>
        </div>
    @endif

        {{-- Stock badge --}}
        @if($buku->stok > 0)
            <span class="absolute top-3 right-3 text-xs font-semibold px-2 py-0.5 rounded-full"
                  style="background:#f0fdf4; color:#166534; border:1px solid #86efac;">
                Tersedia
            </span>
        @else
            <span class="absolute top-3 right-3 text-xs font-semibold px-2 py-0.5 rounded-full"
                  style="background:#fef2f2; color:#991b1b; border:1px solid #fca5a5;">
                Habis
            </span>
        @endif

        {{-- Category --}}
        @if($buku->kategori)
            <span class="absolute top-3 left-3 text-xs font-medium px-2 py-0.5 rounded-full"
                  style="background:rgba(184,134,11,0.15); color:#b8860b; border:1px solid rgba(184,134,11,0.3);">
                {{ $buku->kategori->nama }}
            </span>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4 flex flex-col flex-1">
        <h3 class="font-display font-semibold text-base leading-tight mb-1 line-clamp-2 group-hover:text-amber-700 transition-colors"
            style="color:#0f0f0f;">
            {{ $buku->judul }}
        </h3>
        <p class="text-sm mb-1 flex items-center gap-1" style="color:#6b6457;">
            <i class="ph ph-user text-xs"></i>
            {{ $buku->pengarang }}
        </p>
        <p class="text-xs mb-3 flex items-center gap-1" style="color:#6b6457;">
            <i class="ph ph-building-office text-xs"></i>
            {{ $buku->penerbit }} &middot; {{ $buku->tahun_terbit }}
        </p>

        @if($buku->deskripsi)
            <p class="text-xs leading-relaxed mb-4 line-clamp-3 flex-1" style="color:#6b6457;">
                {{ $buku->deskripsi }}
            </p>
        @else
            <div class="flex-1"></div>
        @endif

        <div class="flex items-center justify-between pt-3 border-t" style="border-color:#e0d9cf;">
            <span class="text-xs font-medium flex items-center gap-1" style="color:#6b6457;">
                <i class="ph ph-stack"></i>
                Stok: <strong style="color:#0f0f0f;">{{ $buku->stok }}</strong>
            </span>

            @auth
                @if($buku->stok > 0)
                    {{-- Anggota → route peminjaman biasa --}}
                    @if(auth()->user()->role === 'anggota')
                        <a href="{{ route('peminjaman.create', ['buku_id' => $buku->id]) }}"
                           class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-200 hover:opacity-90 flex items-center gap-1"
                           style="background:#b8860b; color:#fff;">
                            <i class="ph ph-book-bookmark"></i> Pinjam
                        </a>
                    {{-- Admin → route admin --}}
                    @elseif(auth()->user()->role === 'admin')
                    @endif
                @else
                    <span class="text-xs font-medium px-3 py-1.5 rounded-lg" style="background:#f2ede4; color:#6b6457;">
                        Tidak tersedia
                    </span>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-200 hover:opacity-90 flex items-center gap-1"
                   style="background:#b8860b; color:#fff;">
                    <i class="ph ph-sign-in"></i> Masuk dulu
                </a>
            @endauth
        </div>
    </div>
</article>