{{-- resources/views/components/navbar.blade.php --}}
<header x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="scrolled ? 'shadow-sm' : ''"
        class="sticky top-0 z-50 transition-shadow duration-300"
        style="background-color:#faf8f4; border-bottom:1px solid #e0d9cf;">

    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-transform group-hover:rotate-6"
                     style="background:#b8860b;">
                    <i class="ph-fill ph-books text-white text-lg"></i>
                </div>
                <span class="font-display text-lg font-semibold tracking-tight" style="color:#0f0f0f;">
                    Pustaka
                </span>
            </a>

            {{-- Desktop Nav + Auth Buttons (kanan) --}}
            <div class="hidden md:flex items-center gap-1">
                <nav class="flex items-center gap-1 mr-2">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-amber-50"
                       style="color:#6b6457;">
                        Beranda
                    </a>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-amber-50"
                               style="color:#6b6457;">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('peminjaman.history') }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-amber-50"
                               style="color:#6b6457;">
                                Riwayat Pinjam
                            </a>
                        @endif
                    @endauth
                </nav>

                {{-- Auth Buttons --}}
                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg border transition-all duration-200 hover:bg-amber-50"
                       style="border-color:#e0d9cf; color:#6b6457;">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200 hover:opacity-90"
                       style="background:#b8860b; color:#fff;">
                        Daftar
                    </a>
                @else
                    <div x-data="{ dropdown: false }" class="relative">
                        <button @click="dropdown = !dropdown"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg border transition-all duration-200 hover:bg-amber-50"
                                style="border-color:#e0d9cf; color:#6b6457;">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                 style="background:#b8860b;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <i class="ph ph-caret-down text-xs transition-transform" :class="dropdown ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="dropdown" x-cloak @click.outside="dropdown = false"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute right-0 mt-2 w-48 rounded-xl shadow-lg border py-1 z-50"
                             style="background:#faf8f4; border-color:#e0d9cf;">
                            <div class="px-4 py-2 border-b" style="border-color:#e0d9cf;">
                                <p class="text-xs font-medium" style="color:#6b6457;">Masuk sebagai</p>
                                <p class="text-sm font-semibold truncate" style="color:#0f0f0f;">{{ auth()->user()->name }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm transition-colors hover:bg-red-50 flex items-center gap-2"
                                        style="color:#c0392b;">
                                    <i class="ph ph-sign-out"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="open = !open" class="md:hidden p-2 rounded-lg" style="color:#6b6457;">
                <i class="ph ph-list text-2xl" x-show="!open"></i>
                <i class="ph ph-x text-2xl" x-show="open" x-cloak></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden border-t px-4 py-4 space-y-1"
         style="border-color:#e0d9cf; background:#faf8f4;">

        <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium" style="color:#6b6457;">
            <i class="ph ph-house"></i> Beranda
        </a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium" style="color:#6b6457;">
                    <i class="ph ph-gauge"></i> Dashboard Admin
                </a>
            @else
                <a href="{{ route('peminjaman.history') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium" style="color:#6b6457;">
                    <i class="ph ph-clock-clockwise"></i> Riwayat Peminjaman
                </a>
            @endif
            <div class="pt-2 border-t" style="border-color:#e0d9cf;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium w-full text-left" style="color:#c0392b;">
                        <i class="ph ph-sign-out"></i> Keluar
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium" style="color:#6b6457;">
                <i class="ph ph-sign-in"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium" style="color:#b8860b;">
                <i class="ph ph-user-plus"></i> Daftar
            </a>
        @endauth
    </div>
</header>