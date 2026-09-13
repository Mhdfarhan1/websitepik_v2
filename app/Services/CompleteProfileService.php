<?php

namespace App\Services;

use App\Models\CompleteProfileSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class CompleteProfileService
{
    /**
     * Get settings, create default row if empty.
     */
    public function getSettings(): CompleteProfileSetting
    {
        $setting = CompleteProfileSetting::first();

        if (!$setting) {
            $setting = CompleteProfileSetting::create([
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
            ]);
        }

        return $setting;
    }

    /**
     * Update settings.
     */
    public function updateSettings(array $data): CompleteProfileSetting
    {
        $setting = $this->getSettings();

        // Handle Hero Banner Background Upload
        if (isset($data['hero_bg']) && $data['hero_bg'] instanceof UploadedFile) {
            $this->deleteFile($setting->hero_bg);
            $data['hero_bg'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['hero_bg'],
                directory: 'uploads/profile',
                maxWidth: 1920,
                quality: 80
            );
        }

        // Handle Photo Upload
        if (isset($data['bio_photo']) && $data['bio_photo'] instanceof UploadedFile) {
            $this->deleteFile($setting->bio_photo);
            $data['bio_photo'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['bio_photo'],
                directory: 'uploads/profile',
                maxWidth: 1200,
                quality: 82
            );
        }

        // Handle PDF Document Upload
        if (isset($data['pdf_file']) && $data['pdf_file'] instanceof UploadedFile) {
            $this->deleteFile($setting->pdf_path);
            $data['pdf_path'] = $this->uploadFile($data['pdf_file'], 'uploads/documents');
        }

        $setting->update($data);
        return $setting;
    }

    /**
     * Upload file to target directory.
     */
    private function uploadFile(UploadedFile $file, string $folder): string
    {
        $uploadPath = public_path($folder);

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = 'doc_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        return $folder . '/' . $filename;
    }

    /**
     * Delete file from public directory.
     */
    private function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
