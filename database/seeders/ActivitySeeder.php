<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first() ?? User::first();
        $adminId = $admin ? $admin->id : null;

        $activities = [
            [
                'title' => 'Sosialisasi Kesehatan Reproduksi Remaja & BAHAYA Triad KRR',
                'description' => 'Kegiatan sosialisasi interaktif bagi siswa SMA Negeri 1 Tasik Putri Puyu mengenai pentingnya menjaga kesehatan reproduksi dan pencegahan pernikahan dini.',
                'event_date' => now()->addDays(5)->format('Y-m-d'),
                'time_start' => '08:30',
                'time_end' => '11:30',
                'location' => 'Aula Utama SMAN 1 Tasik Putri Puyu',
                'category' => 'Sosialisasi & Edukasi',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Workshop Pendidik Sebaya (Peer Educator Training)',
                'description' => 'Pelatihan kepemimpinan dan teknik konseling dasar bagi calon konselor sebaya PIK-R REQUEST agar siap mendampingi teman sebaya.',
                'event_date' => now()->addDays(12)->format('Y-m-d'),
                'time_start' => '09:00',
                'time_end' => '15:00',
                'location' => 'Ruang Laboratorium Komputer SMAN 1',
                'category' => 'Pelatihan & Workshop',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Peringatan Hari Remaja Internasional & Kampanye GenRe',
                'description' => 'Aksi bersama kampanye Generasi Berencana, pentas seni kreatif remaja, serta pelayanan cek kesehatan gratis bagi seluruh civitas sekolah.',
                'event_date' => now()->addDays(20)->format('Y-m-d'),
                'time_start' => '07:30',
                'time_end' => '12:00',
                'location' => 'Lapangan Utama Sekolah',
                'category' => 'Kampanye Publik',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Konseling Sebaya Kelompok: "Mental Health & Stress Management"',
                'description' => 'Sesi curhat terbuka dan berbagi kiat mengelola stres ujian bersama konselor sebaya PIK-R.',
                'event_date' => now()->subDays(3)->format('Y-m-d'),
                'time_start' => '13:00',
                'time_end' => '15:00',
                'location' => 'Ruang Konseling PIK-R',
                'category' => 'Layanan Konseling',
                'status' => 'completed',
            ],
        ];

        foreach ($activities as $data) {
            Activity::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, ['created_by' => $adminId])
            );
        }
    }
}
