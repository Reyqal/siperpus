{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Masuk — Pustaka Digital')

@section('content')

<div class="min-h-[70vh] flex items-center justify-center py-8">
    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="rounded-3xl border overflow-hidden shadow-sm" style="background:#fff; border-color:#e0d9cf;">

            {{-- Header --}}
            <div class="px-8 py-8 border-b" style="border-color:#e0d9cf; background:linear-gradient(135deg, #f2ede4, #faf8f4);">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4" style="background:#b8860b;">
                    <i class="ph-fill ph-books text-white text-2xl"></i>
                </div>
                <h1 class="font-display text-2xl font-bold mb-1" style="color:#0f0f0f;">Selamat Datang</h1>
                <p class="text-sm" style="color:#6b6457;">Masuk untuk mengakses perpustakaan digital</p>
            </div>

            {{-- Form --}}
            <div class="px-8 py-8">
                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    @php $emailBorder = $errors->has('email') ? '#c0392b' : '#e0d9cf'; @endphp
                    <div>
                        <label class="block text-sm font-medium mb-1.5" style="color:#0f0f0f;">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b6457;">
                                <i class="ph ph-envelope text-lg"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="nama@email.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border text-sm outline-none transition-all duration-200 focus:ring-2"
                                   style="border-color:{{ $emailBorder }}; background:#faf8f4; color:#0f0f0f; --tw-ring-color:rgba(184,134,11,0.3);">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#c0392b;">
                                <i class="ph ph-warning-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    @php $passwordBorder = $errors->has('password') ? '#c0392b' : '#e0d9cf'; @endphp
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium mb-1.5" style="color:#0f0f0f;">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b6457;">
                                <i class="ph ph-lock text-lg"></i>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password" required
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-10 py-2.5 rounded-xl border text-sm outline-none transition-all duration-200 focus:ring-2"
                                   style="border-color:{{ $passwordBorder }}; background:#faf8f4; color:#0f0f0f; --tw-ring-color:rgba(184,134,11,0.3);">
                            <button type="button" @click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                                    style="color:#6b6457;">
                                <i :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'" class="text-lg"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#c0392b;">
                                <i class="ph ph-warning-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember"
                               class="w-4 h-4 rounded border accent-amber-700"
                               style="border-color:#e0d9cf;">
                        <label for="remember" class="text-sm" style="color:#6b6457;">Ingat saya</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full py-3 rounded-xl font-semibold text-sm transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5 flex items-center justify-center gap-2"
                            style="background:#b8860b; color:#fff;">
                        <i class="ph ph-sign-in"></i>
                        Masuk ke Akun
                    </button>
                </form>

                <p class="text-center text-sm mt-6" style="color:#6b6457;">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color:#b8860b;">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-xs mt-6" style="color:#6b6457;">
            Dengan masuk, kamu menyetujui syarat dan ketentuan Pustaka Digital.
        </p>
    </div>
</div>

@endsection