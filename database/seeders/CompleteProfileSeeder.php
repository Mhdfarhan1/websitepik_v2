<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompleteProfileSetting;

class CompleteProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompleteProfileSetting::firstOrCreate(
            ['id' => 1],
            [
                'hero_title' => 'Profil Lengkap PIK-R REQUEST',
                'hero_desc' => 'Dokumen resmi identitas organisasi, landasan operasional, dan visi strategis Pusat Informasi dan Konseling Remaja SMAN 1 Tasik Putri Puyu.',
                'pdf_path' => null,
                
                // Biography
                'bio_name' => 'Ir. Bambang Hendrawan, ST., MSM., CIPMP., CISCP.',
                'bio_photo' => null,
                'bio_content' => 'adalah seorang profesional dengan latar belakang akademik yang luas dan pengalaman yang mendalam di bidang teknik dan manajemen. Beliau menyelesaikan pendidikan Sarjana Teknik (ST.) dan melanjutkan studi Magister Sains Manajemen (MSM). Selain itu, beliau juga memegang sertifikasi profesional internasional seperti Certified International Project Management Professional (CIPMP) dan Certified International Supply Chain Professional (CISCP), yang menunjukkan keahliannya dalam manajemen proyek dan rantai pasok.',
                'bio_expertise' => 'Ir. Bambang Hendrawan memiliki keahlian di bidang teknik, manajemen, dan manajemen proyek serta rantai pasok. Dengan latar belakang pendidikan dan sertifikasi yang kuat, beliau telah memimpin berbagai proyek dan inisiatif yang berfokus pada peningkatan efisiensi operasional dan pengembangan sistem manajemen yang efektif. Keahliannya dalam manajemen rantai pasok juga telah membantu banyak organisasi dalam mengoptimalkan proses mereka, meningkatkan produktivitas, dan mengurangi biaya operasional.',
                'bio_hopes' => 'Sebagai Pembina PIK-R REQUEST, Ir. Bambang Hendrawan memiliki harapan besar untuk menjadikan organisasi ini sebagai pusat informasi dan konseling remaja unggulan di Indonesia yang tidak hanya diakui di tingkat nasional tetapi juga internasional. Beliau berkomitmen untuk memperkuat kemitraan antara PIK-R dengan berbagai pihak terkait, memastikan bahwa program-program yang dijalankan mampu memberikan dampak nyata bagi remaja. Selain itu, beliau berfokus pada pengembangan kurikulum edukasi yang adaptif dan inovatif, yang dapat memenuhi kebutuhan remaja di era digital serta mendukung pertumbuhan karakter generasi muda yang berencana.',
                
                // Identity
                'org_name' => 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu',
                'org_abbreviation' => 'REMAJA QUALITY, ENERGETIC, SMART, & TALENTED',
                'org_year' => '2021',
                'org_base' => 'SMAN 1 Tasik Putri Puyu, Kepulauan Meranti',
                'org_philosophy' => '"REQUEST bukan sekadar permintaan, melainkan akronim dari Remaja Quality, Energetic, Smart, & Talented. Nama ini mencerminkan harapan kami agar setiap remaja yang bergabung dapat bertransformasi menjadi pribadi yang berkualitas, penuh energi positif, cerdas dalam bertindak, dan mampu mengoptimalkan talenta mereka untuk masa depan yang berencana."',
                
                // Regulations
                'reg_1_title' => 'UU No. 52 Tahun 2009',
                'reg_1_desc' => 'Tentang Perkembangan Kependudukan dan Pembangunan Keluarga sebagai payung hukum utama program GenRe.',
                'reg_2_title' => 'Peraturan BKKBN',
                'reg_2_desc' => 'Pedoman Pengelolaan Pusat Informasi dan Konseling Remaja (PIK-R) untuk standar pelayanan nasional.',
                'reg_3_title' => 'SK Kepala Sekolah',
                'reg_3_desc' => 'Surat Keputusan Penetapan Pengurus PIK-R REQUEST oleh Kepala SMAN 1 Tasik Putri Puyu sebagai legalitas internal.',
            ]
        );
    }
}
