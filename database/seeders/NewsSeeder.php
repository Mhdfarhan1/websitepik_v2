<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'PIK-R REQUEST Ajak Siswa Cegah Perundungan dan Wujudkan Lingkungan Inklusif',
                'content' => 'SMAN 1 Tasik Putri Puyu terus memperkuat komitmennya dalam menciptakan lingkungan sekolah yang aman, nyaman, inklusif, dan bebas dari tindakan kekerasan. Melalui program kerja sosialisasi pencegahan bullying, para siswa diajarkan untuk saling menghargai perbedaan, peduli terhadap sesama, dan berani bersuara menentang segala bentuk perundungan di lingkungan sekolah maupun luar sekolah.',
                'image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&q=80&w=1000',
                'published_at' => Carbon::parse('2026-05-08 09:00:00'),
            ],
            [
                'title' => 'Membuka Paket Pelatihan dan Pendampingan Konselor Sebaya',
                'content' => 'Dalam rangka meningkatkan kapasitas konseling remaja, PIK-R REQUEST secara resmi membuka paket pelatihan dan pendampingan bagi calon konselor sebaya baru. Pelatihan ini memuat materi komunikasi terapeutik dasar, pemecahan masalah remaja, serta bimbingan psikososial agar konselor sebaya dapat menjadi pendengar yang baik bagi teman-teman mereka.',
                'image' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&q=80&w=600',
                'published_at' => Carbon::parse('2026-05-08 10:30:00'),
            ],
            [
                'title' => 'Terima Kunjungan Studi Tiru, Bahas Penguatan Organisasi',
                'content' => 'PIK-R REQUEST menerima kunjungan studi tiru dari organisasi PIK-R tetangga. Kunjungan ini berfokus pada diskusi penguatan struktur keorganisasian, metode kampanye digital GenRe yang kreatif, serta studi banding mengenai administrasi pos konseling yang efektif.',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&q=80&w=600',
                'published_at' => Carbon::parse('2026-05-07 14:00:00'),
            ],
            [
                'title' => 'Sharing Session Beasiswa, Ajak Remaja Gabung Circle Positif',
                'content' => 'PIK-R REQUEST menyelenggarakan kegiatan sharing session seputar tips meraih beasiswa bagi siswa menengah. Di samping berbagi informasi akademis, kegiatan ini juga bertujuan mengajak para remaja untuk aktif di organisasi positif guna mengembangkan soft skill dan menjauhi pergaulan bebas.',
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=600',
                'published_at' => Carbon::parse('2026-05-07 16:30:00'),
            ],
        ];

        foreach ($news as $item) {
            News::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
