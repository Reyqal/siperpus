{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar — Pustaka Digital')

@section('content')

<div class="min-h-[70vh] flex items-center justify-center py-8">
    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="rounded-3xl border overflow-hidden shadow-sm" style="background:#fff; border-color:#e0d9cf;">

            {{-- Header --}}
            <div class="px-8 py-8 border-b" style="border-color:#e0d9cf; background:linear-gradient(135deg, #f2ede4, #faf8f4);">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4" style="background:#b8860b;">
                    <i class="ph-fill ph-user-plus text-white text-2xl"></i>
                </div>
                <h1 class="font-display text-2xl font-bold mb-1" style="color:#0f0f0f;">Buat Akun Baru</h1>
                <p class="text-sm" style="color:#6b6457;">Daftar untuk mulai meminjam buku</p>
            </div>

            {{-- Form --}}
            <div class="px-8 py-8">

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="rounded-xl border px-4 py-3 mb-6 text-sm" style="background:#fef2f2; border-color:#fca5a5; color:#c0392b;">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="flex items-center gap-1">
                                    <i class="ph ph-warning-circle"></i> {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium mb-1.5" style="color:#0f0f0f;">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b6457;">
                                <i class="ph ph-user text-lg"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                   placeholder="Nama lengkap Anda"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border text-sm outline-none transition-all duration-200 focus:ring-2"
                                   style="border-color:{{ $errors->has('name') ? '#c0392b' : '#e0d9cf' }}; background:#faf8f4; color:#0f0f0f; --tw-ring-color: rgba(184,134,11,0.3);">
                        </div>
                        @error('name')
                            <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#c0392b;">
                                <i class="ph ph-warning-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium mb-1.5" style="color:#0f0f0f;">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b6457;">
                                <i class="ph ph-envelope text-lg"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="nama@email.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border text-sm outline-none transition-all duration-200 focus:ring-2"
                                   style="border-color:{{ $errors->has('email') ? '#c0392b' : '#e0d9cf' }}; background:#faf8f4; color:#0f0f0f; --tw-ring-color: rgba(184,134,11,0.3);">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#c0392b;">
                                <i class="ph ph-warning-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium mb-1.5" style="color:#0f0f0f;">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b6457;">
                                <i class="ph ph-lock text-lg"></i>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password" required
                                   placeholder="Minimal 8 karakter"
                                   class="w-full pl-10 pr-10 py-2.5 rounded-xl border text-sm outline-none transition-all duration-200 focus:ring-2"
                                   style="border-color:{{ $errors->has('password') ? '#c0392b' : '#e0d9cf' }}; background:#faf8f4; color:#0f0f0f; --tw-ring-color: rgba(184,134,11,0.3);">
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

                    {{-- Konfirmasi Password --}}
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium mb-1.5" style="color:#0f0f0f;">
                            Konfirmasi Kata Sandi
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b6457;">
                                <i class="ph ph-lock-key text-lg"></i>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password_confirmation" required
                                   placeholder="Ulangi password"
                                   class="w-full pl-10 pr-10 py-2.5 rounded-xl border text-sm outline-none transition-all duration-200 focus:ring-2"
                                   style="border-color:#e0d9cf; background:#faf8f4; color:#0f0f0f; --tw-ring-color: rgba(184,134,11,0.3);">
                            <button type="button" @click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                                    style="color:#6b6457;">
                                <i :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'" class="text-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full py-3 rounded-xl font-semibold text-sm transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5 flex items-center justify-center gap-2"
                            style="background:#b8860b; color:#fff;">
                        <i class="ph ph-user-plus"></i>
                        Daftar Sekarang
                    </button>
                </form>

                <p class="text-center text-sm mt-6" style="color:#6b6457;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color:#b8860b;">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        {{-- Decorative --}}
        <p class="text-center text-xs mt-6" style="color:#6b6457;">
            Dengan mendaftar, kamu menyetujui syarat dan ketentuan Pustaka Digital.
        </p>
    </div>
</div>

@endsection