<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('buku')->insert([
            [
                'judul'        => 'Laravel: Up & Running',
                'pengarang'    => 'Matt Stauffer',
                'penerbit'     => "O'Reilly Media",
                'tahun_terbit' => 2023,
                'isbn'         => '978-1098153410',
                'stok'         => 5,
                'kategori_id'  => 3,
                'deskripsi'    => 'Panduan lengkap framework Laravel',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'judul'        => 'Clean Code',
                'pengarang'    => 'Robert C. Martin',
                'penerbit'     => 'Prentice Hall',
                'tahun_terbit' => 2008,
                'isbn'         => '978-0132350884',
                'stok'         => 3,
                'kategori_id'  => 3,
                'deskripsi'    => 'Panduan menulis kode yang bersih dan mudah dipahami',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'judul'        => 'Laskar Pelangi',
                'pengarang'    => 'Andrea Hirata',
                'penerbit'     => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'isbn'         => '978-9793062976',
                'stok'         => 7,
                'kategori_id'  => 1,
                'deskripsi'    => 'Novel inspiratif tentang semangat belajar anak Belitung',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'judul'        => 'Sapiens: A Brief History of Humankind',
                'pengarang'    => 'Yuval Noah Harari',
                'penerbit'     => 'Harper',
                'tahun_terbit' => 2015,
                'isbn'         => '978-0062316097',
                'stok'         => 4,
                'kategori_id'  => 2,
                'deskripsi'    => 'Sejarah singkat umat manusia dari zaman prasejarah',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}