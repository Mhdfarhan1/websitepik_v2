<?php

namespace App\Services;

use App\Models\ProfileSetting;
use App\Models\HistoryMilestone;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ProfileService
{
    /**
     * Get profile settings, creates default row if empty.
     */
    public function getProfileSetting(): ProfileSetting
    {
        $setting = ProfileSetting::first();

        if (!$setting) {
            $setting = ProfileSetting::create([
                'sejarah_title' => 'Sejarah PIK-R',
                'pembina_name' => 'Bambang Hendrawan, ST., MSM.',
                'pembina_period' => 'Periode 2024-2029',
                'pembina_photo' => null,
                'pembina_pantun' => "Jalan-jalan ke Pulau Galang,\nSinggah sebentar membeli ikan,\nSelamat datang di PIK-R REQUEST,\nWadah inspirasi, penuh harapan.",
                'pembina_speech' => "Saya ucapkan selamat datang di platform digital PIK-R REQUEST SMAN 1 Tasik Putri Puyu. Sebagai wadah informasi dan konseling remaja, kami berkomitmen untuk menciptakan ekosistem yang suportif bagi setiap siswa. Kehadiran platform ini diharapkan dapat memperkuat literasi kesehatan reproduksi, perencanaan masa depan, serta menjadi lokomotif perubahan positif bagi generasi muda di Kepulauan Meranti.\n\nMari bersama kita wujudkan remaja yang sehat, cerdas, ceria, dan berencana demi Indonesia Emas 2045 yang lebih gemilang.",
                'about_title' => 'Tentang PIK-R REQUEST',
                'about_content' => "PIK-R REQUEST SMAN 1 Tasik Putri Puyu merupakan satu-satunya Pusat Informasi dan Konseling Remaja yang menjadi barometer pengembangan Generasi Berencana (GenRe) di wilayah pesisir Kepulauan Meranti. Selain menjadi wadah curhat yang suportif bagi siswa, kami juga focus pada pengembangan kecakapan hidup (life skills) dan edukasi pencegahan perilaku berisiko.\n\nMelalui pendekatan yang inovatif dan berbasis teman sebaya, PIK-R REQUEST bertransformasi menjadi lokomotif perubahan sosial yang positif, membekali remaja dengan pengetahuan kesehatan reproduksi dan perencanaan masa depan yang matang demi mewujudkan Indonesia Emas 2045.",
                'about_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'visi_text' => 'Menjadi wadah inovatif bagi remaja SMAN 1 Tasik Putri Puyu dalam mewujudkan Generasi Berencana yang sehat, cerdas, ceria, dan berakhlak mulia melalui pusat informasi dan konseling yang suportif.',
                'misi_text' => 'PIK-R REQUEST adalah memberikan layanan informasi dan konseling remaja yang berkualitas, mengembangkan potensi life skills anggota, serta membangun kesadaran akan pentingnya perencanaan masa depan bagi setiap remaja.',
                'pilar_1_title' => 'Kesehatan Reproduksi',
                'pilar_1_desc' => 'Memberikan pemahaman mendalam tentang pentingnya menjaga kesehatan reproduksi bagi remaja sebagai bekal masa depan.',
                'pilar_2_title' => 'Life Skills (Kecakapan Hidup)',
                'pilar_2_desc' => 'Mengembangkan berbagai keterampilan hidup mulai dari soft skills hingga kreativitas untuk kemandirian remaja.',
                'pilar_3_title' => 'Penyiapan Kehidupan Berkeluarga',
                'pilar_3_desc' => 'Edukasi mengenai perencanaan kehidupan berkeluarga yang matang dan bertanggung jawab bagi generasi muda.',
                'pilar_4_title' => 'Pencegahan Perilaku Berisiko',
                'pilar_4_desc' => 'Sosialisasi aktif untuk mencegah pernikahan dini, seks bebas, dan penyalahgunaan NAPZA di kalangan remaja.',
                'renstra_text' => 'Rencana Strategis Periode 2024-2029 PIK-R REQUEST',
                'tujuan_text' => "Meningkatkan kualitas informasi dan layanan konseling bagi remaja.\nMembangun wadah kreativitas yang mendukung pengembangan life skills.\nMewujudkan remaja yang sehat, cerdas, ceria, dan berencana.\nMendorong terciptanya lingkungan sekolah yang aman dan suportif.",
                'sasaran_text' => "Optimalisasi peran pendidik sebaya dan konselor sebaya.\nPerluasan jangkauan edukasi GenRe kepada seluruh siswa.\nPengembangan program life skills yang inovatif dan aplikatif.\nPenguatan kolaborasi dengan mitra sekolah dan instansi luar.\nPeningkatan kualitas publikasi kegiatan di berbagai platform media.\nPenerapan evaluasi program berbasis data dan feedback anggota.\nMewujudkan PIK-R percontohan yang unggul and berprestasi."
            ]);
        }

        return $setting;
    }

    /**
     * Update profile settings.
     */
    public function updateProfileSetting(array $data): ProfileSetting
    {
        $setting = $this->getProfileSetting();

        if (isset($data['pembina_photo']) && $data['pembina_photo'] instanceof UploadedFile) {
            // Delete old photo if it exists
            $this->deletePhoto($setting->pembina_photo);
            $data['pembina_photo'] = $this->uploadPhoto($data['pembina_photo']);
        }

        $setting->update($data);
        return $setting;
    }

    /**
     * Get all history milestones ordered by year.
     */
    public function getAllMilestones()
    {
        return HistoryMilestone::orderBy('year', 'asc')->get();
    }

    /**
     * Add a milestone.
     */
    public function addMilestone(array $data): HistoryMilestone
    {
        return HistoryMilestone::create($data);
    }

    /**
     * Update a milestone.
     */
    public function updateMilestone(int $id, array $data): HistoryMilestone
    {
        $milestone = HistoryMilestone::findOrFail($id);
        $milestone->update($data);
        return $milestone;
    }

    /**
     * Delete a milestone.
     */
    public function deleteMilestone(int $id): bool
    {
        $milestone = HistoryMilestone::findOrFail($id);
        return $milestone->delete();
    }

    /**
     * Upload and automatically compress photo to WebP.
     */
    private function uploadPhoto(UploadedFile $file): string
    {
        return app(ImageCompressionService::class)->compressAndUpload(
            file: $file,
            directory: 'uploads/profile',
            maxWidth: 1200,
            quality: 82
        );
    }

    /**
     * Delete photo from storage.
     */
    private function deletePhoto(?string $path): void
    {
        app(ImageCompressionService::class)->delete($path);
    }
}
