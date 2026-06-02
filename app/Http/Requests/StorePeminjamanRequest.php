<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user && $user->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'user_id'                   => ['required', 'exists:users,id'],
            'tanggal_pinjam'            => ['required', 'date'],
            'tanggal_kembali_rencana'   => ['required', 'date', 'after:tanggal_pinjam'],
            'buku'                      => ['required', 'array', 'min:1'],
            'buku.*.id'                 => ['required', 'exists:buku,id'],
            'buku.*.jumlah'             => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'                  => 'Anggota wajib dipilih.',
            'user_id.exists'                    => 'Anggota yang dipilih tidak valid.',
            'tanggal_pinjam.required'           => 'Tanggal pinjam wajib diisi.',
            'tanggal_kembali_rencana.required'  => 'Tanggal rencana kembali wajib diisi.',
            'tanggal_kembali_rencana.after'     => 'Tanggal kembali harus setelah tanggal pinjam.',
            'buku.required'                     => 'Minimal pilih satu buku.',
            'buku.*.id.exists'                  => 'Buku yang dipilih tidak valid.',
            'buku.*.jumlah.min'                 => 'Jumlah pinjam minimal 1.',
        ];
    }
}