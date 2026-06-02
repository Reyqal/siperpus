<aside class="w-64 bg-gray-900 text-gray-300 min-h-screen flex flex-col" x-data="{ openMenu: null }">

    {{-- Logo --}}
    <div class="px-6 py-5 border-b border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-white font-bold text-lg">
            <i class="ph-fill ph-books text-2xl text-blue-400"></i>
            <span>Admin Panel</span>
        </a>
    </div>

    {{-- User Info --}}
    <div class="px-6 py-4 border-b border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-white text-sm font-medium leading-tight">{{ auth()->user()->name }}</p>
                <p class="text-gray-400 text-xs">Administrator</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-1">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                  {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
            <i class="ph ph-squares-four text-lg"></i>
            <span>Dashboard</span>
        </a>

        {{-- Buku --}}
        <a href="{{ route('admin.buku.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                  {{ request()->routeIs('admin.buku.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
            <i class="ph ph-books text-lg"></i>
            <span>Kelola Buku</span>
        </a>

        {{-- Peminjaman --}}
        <a href="{{ route('admin.peminjaman.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                  {{ request()->routeIs('admin.peminjaman.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
            <i class="ph ph-hand-coins text-lg"></i>
            <span>Peminjaman</span>
        </a>

    </nav>

    {{-- Logout --}}
    <div class="px-4 py-4 border-t border-gray-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm text-gray-300 hover:bg-red-700 hover:text-white transition">
                <i class="ph ph-sign-out text-lg"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>