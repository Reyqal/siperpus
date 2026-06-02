<?php
// app/Models/Buku.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'kategori_id',
        'deskripsi',
        'cover',           // ← tambahan
    ];

    /**
     * URL cover: pakai file upload kalau ada, fallback ke placeholder.
     */
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return Storage::url($this->cover);
        }
        return '';   // kosong → blade pakai placeholder icon
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}