<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBukuRequest extends FormRequest
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
            'judul'        => 'required|string|max:255',
            'pengarang'    => 'required|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|digits:4|integer|min:1000|max:' . date('Y'),
            'isbn'         => 'nullable|string|max:20|unique:buku,isbn',
            'stok'         => 'required|integer|min:0',
            'kategori_id'  => 'required|exists:kategori_buku,id',
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'       => 'Judul buku wajib diisi.',
            'pengarang.required'   => 'Nama pengarang wajib diisi.',
            'stok.required'        => 'Stok buku wajib diisi.',
            'stok.min'             => 'Stok tidak boleh negatif.',
            'kategori_id.required' => 'Kategori buku wajib dipilih.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'isbn.unique'          => 'ISBN sudah digunakan oleh buku lain.',
            'cover.image'          => 'File cover harus berupa gambar.',
            'cover.mimes'          => 'File cover harus berupa file JPG, JPEG, PNG, atau WebP.',
            'cover.max'            => 'Ukuran file cover tidak boleh lebih dari 2MB.',
        ];
    }
}