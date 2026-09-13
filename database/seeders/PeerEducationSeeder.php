<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PeerEducation;

class PeerEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edukasi = [
            [
                'title' => 'Siapa Itu Pendidik Sebaya?',
                'desc' => 'Pendidik Sebaya adalah garda terdepan PIK-R REQUEST yang bertugas menyebarluaskan informasi mengenai kesehatan reproduksi dan perencanaan masa depan. Mereka bukan hanya penyampai data, melainkan teman diskusi yang mengerti dinamika dan bahasa remaja saat ini.',
                'desc2' => 'Setiap Pendidik Sebaya telah melalui proses seleksi dan pelatihan intensif mengenai materi GenRe, teknik komunikasi efektif, hingga manajemen kelompok diskusi sebaya.',
                'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200'
            ],
            [
                'title' => 'Peran & Tanggung Jawab',
                'desc' => 'Peran utama kami adalah memberikan pengaruh positif (Positive Peer Influence) di sekolah. Kami aktif mengadakan diskusi santai, sosialisasi di kelas, hingga kampanye kreatif di media sosial mengenai bahaya TRIAD KRR dan pentingnya pendewasaan usia perkawinan.',
                'desc2' => 'Pendidik Sebaya juga bertugas mengidentifikasi teman yang membutuhkan layanan konseling dan merujuk mereka kepada Konselor Sebaya untuk penanganan lebih lanjut.',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=1200'
            ],
            [
                'title' => 'Modul & Materi Edukasi',
                'desc' => 'Kami menggunakan modul resmi "Tentang Kita" dari BKKBN yang telah disesuaikan dengan kebutuhan remaja SMAN 1 Tasik Putri Puyu. Materi meliputi pemahaman diri, kesehatan reproduksi, gizi remaja (Pencegahan Stunting), hingga perencanaan berkeluarga.',
                'desc2' => 'Penyampaian materi dilakukan dengan metode yang seru, seperti games, roleplay, dan penggunaan media audiovisual agar informasi lebih mudah diterima dan tidak membosankan.',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=1200'
            ]
        ];

        foreach ($edukasi as $index => $item) {
            PeerEducation::create([
                'title' => $item['title'],
                'desc' => $item['desc'],
                'desc2' => $item['desc2'],
                'image' => $item['image'],
                'order_index' => $index,
            ]);
        }
    }
}
