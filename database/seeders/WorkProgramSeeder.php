<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkProgram;

class WorkProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = [
            [
                'title' => 'Konseling Sebaya (Peer Counseling)',
                'desc' => 'Program Konseling Sebaya merupakan inti dari layanan PIK-R REQUEST. Kami menyediakan ruang aman dan rahasia bagi remaja SMAN 1 Tasik Putri Puyu untuk mencurahkan isi hati dan permasalahan mereka. Layanan ini dipandu oleh konselor sebaya yang telah tersertifikasi dan dibekali dengan keterampilan mendengarkan secara aktif serta empati tinggi.',
                'desc2' => 'Sesi konseling dilakukan secara tatap muka maupun daring, bertujuan untuk membantu remaja menemukan solusi atas tantangan psikososial yang mereka hadapi, mulai dari masalah pertemanan, akademis, hingga perencanaan masa depan.',
                'image' => null,
                'order_index' => 1
            ],
            [
                'title' => 'Sosialisasi GenRe (Generasi Berencana)',
                'desc' => 'Melalui program Sosialisasi GenRe, kami secara aktif mengedukasi remaja mengenai pentingnya menjauhi tiga risiko utama (TRIAD KRR): Pernikahan Dini, Seks Bebas, dan NAPZA. Sosialisasi ini dikemas secara kreatif melalui kampanye digital, seminar interaktif, dan diskusi kelompok terfokus.',
                'desc2' => 'Kami percaya bahwa pemahaman yang benar mengenai kesehatan reproduksi dan perencanaan keluarga adalah kunci utama dalam melahirkan generasi yang berkualitas dan berdaya saing di masa depan.',
                'image' => null,
                'order_index' => 2
            ],
            [
                'title' => 'Life Skill Training (Pengembangan Diri)',
                'desc' => 'Life Skill Training dirancang untuk membekali anggota dengan berbagai kecakapan hidup yang aplikatif. Program ini meliputi pelatihan kepemimpinan, teknik komunikasi publik (public speaking), kreativitas digital, hingga workshop kewirausahaan sosial.',
                'desc2' => 'Dengan membekali remaja dengan berbagai keterampilan non-akademis, PIK-R REQUEST berharap setiap siswa tidak hanya cerdas secara intelektual, tetapi juga mandiri dan siap menghadapi tantangan di dunia nyata.',
                'image' => null,
                'order_index' => 3
            ],
            [
                'title' => 'Bakti Sosial & Aksi Komunitas',
                'desc' => 'Sebagai wujud kepedulian sosial, PIK-R REQUEST rutin menyelenggarakan aksi bakti sosial. Kegiatan ini mencakup kampanye kebersihan lingkungan sekolah, donasi buku, hingga kunjungan edukatif ke komunitas masyarakat sekitar.',
                'desc2' => 'Melalui aksi nyata ini, kami berupaya menumbuhkan rasa empati, gotong royong, dan tanggung jawab sosial pada setiap remaja sebagai bagian penting dari karakter Generasi Berencana.',
                'image' => null,
                'order_index' => 4
            ]
        ];

        foreach ($details as $item) {
            WorkProgram::create($item);
        }
    }
}
