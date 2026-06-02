<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBukuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_buku')->insert([
            [
                'nama_kategori' => 'Fiksi',
                'deskripsi'     => 'Buku-buku cerita fiksi dan novel',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Non-Fiksi',
                'deskripsi'     => 'Buku ilmu pengetahuan dan referensi',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Teknologi',
                'deskripsi'     => 'Buku pemrograman dan teknologi informasi',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Sains',
                'deskripsi'     => 'Buku ilmu alam dan sains terapan',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}