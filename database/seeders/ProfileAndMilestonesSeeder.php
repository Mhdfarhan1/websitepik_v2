<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfileSetting;
use App\Models\HistoryMilestone;

class ProfileAndMilestonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Profile setting
        ProfileSetting::firstOrCreate(
            ['id' => 1],
            [
                'sejarah_title' => 'Sejarah PIK-R',
                'pembina_name' => 'Bambang Hendrawan, ST., MSM.',
                'pembina_period' => 'Periode 2024-2029',
                'pembina_photo' => null,
                'pembina_pantun' => "Jalan-jalan ke Pulau Galang,\nSinggah sebentar membeli ikan,\nSelamat datang di PIK-R REQUEST,\nWadah inspirasi, penuh harapan.",
                'pembina_speech' => "Saya ucapkan selamat datang di platform digital PIK-R REQUEST SMAN 1 Tasik Putri Puyu. Sebagai wadah informasi dan konseling remaja, kami berkomitmen untuk menciptakan ekosistem yang suportif bagi setiap siswa. Kehadiran platform ini diharapkan dapat memperkuat literasi kesehatan reproduksi, perencanaan masa depan, serta menjadi lokomotif perubahan positif bagi generasi muda di Kepulauan Meranti.\n\nMari bersama kita wujudkan remaja yang sehat, cerdas, ceria, dan berencana demi Indonesia Emas 2045 yang lebih gemilang.",
                'about_title' => 'Tentang PIK-R REQUEST',
                'about_content' => "PIK-R REQUEST SMAN 1 Tasik Putri Puyu merupakan satu-satunya Pusat Informasi dan Konseling Remaja yang menjadi barometer pengembangan Generasi Berencana (GenRe) di wilayah pesisir Kepulauan Meranti. Selain menjadi wadah curhat yang suportif bagi siswa, kami juga focus pada pengembangan kecakapan hidup (life skills) dan edukasi pencegahan perilaku berisiko.\n\nMelalui pendekatan yang inovatif dan berbasis teman sebaya, PIK-R REQUEST bertransformasi menjadi lokomotif perubahan sosial yang positif, membekali remaja dengan pengetahuan kesehatan reproduksi dan perencanaan masa depan yang matang demi mewujudkan Indonesia Emas 2045.",
                'about_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ]
        );

        // 2. Milestones
        $milestones = [
            [
                'year' => 2021,
                'title' => 'Pembentukan Resmi',
                'description' => 'Peresmian PIK-R REQUEST di SMAN 1 Tasik Putri Puyu sebagai bagian dari jaringan GenRe Kabupaten Kepulauan Meranti.'
            ],
            [
                'year' => 2022,
                'title' => 'Sertifikasi Konselor',
                'description' => 'Angkatan pertama Pendidik Sebaya dan Konselor Sebaya resmi tersertifikasi dan mulai menjalankan layanan aktif.'
            ],
            [
                'year' => 2023,
                'title' => 'PIK-R Percontohan',
                'description' => 'Mendapatkan apresiasi sebagai PIK-R Percontohan Tingkat Kabupaten atas inovasi program edukasi yang dijalankan.'
            ],
            [
                'year' => 2024,
                'title' => 'Transformasi Digital',
                'description' => 'Peluncuran platform website PIK-R REQUEST untuk memperluas jangkauan layanan informasi secara online.'
            ]
        ];

        foreach ($milestones as $milestone) {
            HistoryMilestone::firstOrCreate(
                ['year' => $milestone['year']],
                $milestone
            );
        }
    }
}
