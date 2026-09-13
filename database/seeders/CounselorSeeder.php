<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counselor;

class CounselorSeeder extends Seeder
{
    public function run(): void
    {
        $counselors = [
            [
                'name' => 'Siti Rahmawati',
                'role_type' => 'konselor_sebaya',
                'class_or_title' => 'Siswa XI IPA 1 - Konselor Sebaya Terlatih',
                'bio_motto' => 'Siap mendengar curhat dan memberikan solusi teman sebaya tanpa judgement.',
                'order_index' => 1,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'role_type' => 'pendidik_sebaya',
                'class_or_title' => 'Siswa XI IPS 2 - Pendidik Sebaya GenRe',
                'bio_motto' => 'Edukasi kesehatan reproduksi remaja yang interaktif dan menyenangkan.',
                'order_index' => 2,
            ],
            [
                'name' => 'Nabila Putri',
                'role_type' => 'keduanya',
                'class_or_title' => 'Siswa XII IPA 2 - Konselor & Pendidik Sebaya',
                'bio_motto' => 'Mendampingi teman-teman dalam menjaga kesehatan emosional dan mental.',
                'order_index' => 3,
            ],
            [
                'name' => 'Rizky Pratama',
                'role_type' => 'konselor_sebaya',
                'class_or_title' => 'Siswa XI IPA 3 - Konselor Sebaya BKKBN',
                'bio_motto' => 'Ruang aman untuk berkonsultasi seputar perencanaan karir dan masa depan.',
                'order_index' => 4,
            ],
        ];

        foreach ($counselors as $item) {
            Counselor::create($item);
        }
    }
}
