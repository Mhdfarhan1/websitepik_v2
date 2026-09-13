<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laporan = [
            [
                'title' => 'Laporan Kinerja Tahunan',
                'desc' => 'Laporan Kinerja Tahunan menyajikan ringkasan seluruh pencapaian organisasi selama satu tahun periode kepengurusan. Di dalamnya mencakup evaluasi program kerja, tingkat partisipasi anggota, hingga efektivitas layanan konseling.',
                'desc2' => 'Dokumen ini merupakan bentuk pertanggungjawaban kami kepada sekolah dan instansi pembina terkait kemajuan dan dampak yang telah dihasilkan bagi remaja di SMAN 1 Tasik Putri Puyu.',
                'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&q=80&w=1200'
            ],
            [
                'title' => 'Laporan Kegiatan & Dokumentasi',
                'desc' => 'Laporan ini disusun setelah setiap kegiatan besar selesai dilaksanakan. Berisi detail pelaksanaan, rincian peserta, dokumentasi foto, serta testimoni dari para peserta kegiatan edukasi maupun bakti sosial.',
                'desc2' => 'Kami memastikan setiap aksi nyata terekam dengan baik sebagai bahan pembelajaran dan arsip sejarah perkembangan PIK-R REQUEST dari waktu ke waktu.',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&q=80&w=1200'
            ],
            [
                'title' => 'Transparansi & Tata Kelola',
                'desc' => 'Kami menjunjung tinggi nilai integritas dan keterbukaan informasi. Laporan tata kelola mencakup struktur organisasi yang aktif, standar operasional prosedur (SOP) layanan, serta pemanfaatan sumber daya organisasi.',
                'desc2' => 'Keterbukaan ini bertujuan untuk membangun kepercayaan di antara anggota, orang tua siswa, dan pihak sekolah terhadap integritas PIK-R REQUEST sebagai lembaga konseling terpercaya.',
                'image' => 'https://images.unsplash.com/photo-1454165833767-02a521773b64?auto=format&fit=crop&q=80&w=1200'
            ]
        ];

        foreach ($laporan as $index => $item) {
            Report::create([
                'title' => $item['title'],
                'desc' => $item['desc'],
                'desc2' => $item['desc2'],
                'image' => $item['image'],
                'document' => null,
                'order_index' => $index,
            ]);
        }
    }
}
