<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Counseling;
use Carbon\Carbon;

class CounselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Counseling::create([
            'title' => 'Kecemasan Ujian Nasional',
            'topic' => 'Kesehatan Mental',
            'counselor_name' => 'Budi Santoso',
            'date' => Carbon::now()->subDays(5),
            'description' => 'Konseling terkait rasa cemas berlebih saat menghadapi ujian sekolah.',
            'status' => 'Selesai'
        ]);

        Counseling::create([
            'title' => 'Manajemen Waktu Belajar',
            'topic' => 'Akademik & Belajar',
            'counselor_name' => 'Rina Melati',
            'date' => Carbon::now()->subDays(2),
            'description' => 'Bantuan untuk membagi waktu antara belajar dan ekstrakurikuler.',
            'status' => 'Selesai'
        ]);

        Counseling::create([
            'title' => 'Konflik Pertemanan di Kelas',
            'topic' => 'Hubungan Sosial',
            'counselor_name' => 'Andi Wijaya',
            'date' => Carbon::now()->subDays(1),
            'description' => 'Penanganan konflik antar teman sebaya agar lingkungan kelas lebih kondusif.',
            'status' => 'Selesai'
        ]);
    }
}
