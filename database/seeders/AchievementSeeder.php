<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'Juara 1 PIK-R Percontohan Tingkat Kabupaten Kepulauan Meranti',
                'description' => 'PIK-R REQUEST berhasil dinobatkan sebagai PIK-R Percontohan atas konsistensi dalam menyelenggarakan program edukasi GenRe dan layanan konseling sebaya yang inovatif bagi para remaja.',
                'image' => 'https://images.unsplash.com/photo-1561489422-45de3d015e3e?auto=format&fit=crop&q=80&w=800',
                'author' => 'admin',
                'date' => Carbon::parse('2026-01-21'),
            ],
            [
                'title' => 'Penghargaan Duta GenRe Putra & Putri 2024',
                'description' => 'Anggota PIK-R REQUEST secara rutin berpartisipasi dan meraih prestasi dalam ajang Pemilihan Duta GenRe. Prestasi ini membuktikan bahwa kader-kader kami memiliki kualitas kepemimpinan dan wawasan yang mumpuni.',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800',
                'author' => 'admin',
                'date' => Carbon::parse('2025-11-13'),
            ],
            [
                'title' => 'Terpilih sebagai Peserta Jambore Ajang Kreativitas Remaja',
                'description' => 'Kami meraih apresiasi dalam kategori pengembangan media edukasi kreatif melalui kampanye digital dan alat peraga edukatif yang efektif dalam menjangkau audiens remaja.',
                'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=800',
                'author' => 'admin',
                'date' => Carbon::parse('2025-10-16'),
            ],
        ];

        foreach ($achievements as $item) {
            Achievement::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
