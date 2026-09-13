<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppearanceController extends Controller
{
    private function getSettings()
    {
        $path = storage_path('app/appearance_settings.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [
            'hero_title' => 'PIK-R REQUEST',
            'hero_subtitle' => 'SMA Negeri 1 Tasik Putri Puyu',
            'hero_bg' => 'assets/img/bg_utama.JPG',
            'primary_color' => '#2563eb',
            'secondary_color' => '#64748b',
            'logo' => 'assets/img/logo_utama.png',
            'favicon' => 'assets/img/logo_utama.png',
            'font' => 'inter',
            'border_radius' => '32',
        ];
    }

    public function index()
    {
        $settings = $this->getSettings();
        return view('pages.dashboard.appearance.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = $this->getSettings();

        // Handle directories
        $uploadPath = public_path('uploads/appearance');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Handle background image upload
        if ($request->hasFile('hero_bg')) {
            $settings['hero_bg'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('hero_bg'),
                directory: 'uploads/appearance',
                maxWidth: 1920,
                quality: 80
            );
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $settings['logo'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('logo'),
                directory: 'uploads/appearance',
                maxWidth: 800,
                quality: 85,
                convertToWebp: false // Keep PNG/SVG for logos if transparency needed
            );
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $settings['favicon'] = 'uploads/appearance/' . $filename;
        }

        // Handle texts and selections
        $settings['hero_title'] = $request->input('hero_title', $settings['hero_title']);
        $settings['hero_subtitle'] = $request->input('hero_subtitle', $settings['hero_subtitle']);
        $settings['primary_color'] = $request->input('primary_color', $settings['primary_color']);
        $settings['secondary_color'] = $request->input('secondary_color', $settings['secondary_color']);
        $settings['font'] = $request->input('font', $settings['font']);
        $settings['border_radius'] = $request->input('border_radius', $settings['border_radius']);

        // Handle about section
        $settings['about_tag'] = $request->input('about_tag', $settings['about_tag'] ?? 'Video Profil Organisasi');
        $settings['about_title_1'] = $request->input('about_title_1', $settings['about_title_1'] ?? 'Mengenal');
        $settings['about_title_2'] = $request->input('about_title_2', $settings['about_title_2'] ?? 'PIK-R REQUEST');
        $settings['about_title_3'] = $request->input('about_title_3', $settings['about_title_3'] ?? 'Lebih Dekat');
        $settings['about_desc'] = $request->input('about_desc', $settings['about_desc'] ?? '');
        $settings['about_stat1_val'] = $request->input('about_stat1_val', $settings['about_stat1_val'] ?? '4');
        $settings['about_stat1_lbl'] = $request->input('about_stat1_lbl', $settings['about_stat1_lbl'] ?? 'Pilar Utama');
        $settings['about_stat2_val'] = $request->input('about_stat2_val', $settings['about_stat2_val'] ?? '50');
        $settings['about_stat2_lbl'] = $request->input('about_stat2_lbl', $settings['about_stat2_lbl'] ?? 'Anggota');
        $settings['about_stat3_val'] = $request->input('about_stat3_val', $settings['about_stat3_val'] ?? '20');
        $settings['about_stat3_lbl'] = $request->input('about_stat3_lbl', $settings['about_stat3_lbl'] ?? 'Kegiatan');
        $settings['about_stat4_val'] = $request->input('about_stat4_val', $settings['about_stat4_val'] ?? '5');
        $settings['about_stat4_lbl'] = $request->input('about_stat4_lbl', $settings['about_stat4_lbl'] ?? 'Tahun');
        $settings['about_video_url'] = $request->input('about_video_url', $settings['about_video_url'] ?? '');
        $settings['about_video_title'] = $request->input('about_video_title', $settings['about_video_title'] ?? 'VIDEO PROFIL PIK-R REQUEST');
        $settings['about_video_subtitle'] = $request->input('about_video_subtitle', $settings['about_video_subtitle'] ?? 'SMAN 1 Tasik Putri Puyu');
        $settings['about_video_period'] = $request->input('about_video_period', $settings['about_video_period'] ?? 'Periode 2024-2025');

        // Handle about video thumbnail upload
        if ($request->hasFile('about_video_thumbnail')) {
            $settings['about_video_thumbnail'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('about_video_thumbnail'),
                directory: 'uploads/appearance',
                maxWidth: 1280,
                quality: 80
            );
        }

        // Handle gallery section settings
        $settings['gallery_title_1'] = $request->input('gallery_title_1', $settings['gallery_title_1'] ?? 'Galeri');
        $settings['gallery_title_2'] = $request->input('gallery_title_2', $settings['gallery_title_2'] ?? 'Kegiatan');
        $settings['gallery_desc'] = $request->input('gallery_desc', $settings['gallery_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu memiliki beragam karya dan potret kegiatan yang dihasilkan dari program edukasi, konseling sebaya, dan pembinaan kecakapan hidup (life skill).');

        // Handle achievements section settings
        $settings['achievement_title_1'] = $request->input('achievement_title_1', $settings['achievement_title_1'] ?? 'Prestasi');
        $settings['achievement_title_2'] = $request->input('achievement_title_2', $settings['achievement_title_2'] ?? 'PIK-R');
        $settings['achievement_desc'] = $request->input('achievement_desc', $settings['achievement_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu terus mengukir prestasi dan apresiasi di tingkat kabupaten hingga provinsi sebagai pusat informasi dan edukasi remaja yang aktif, inovatif, dan berprestasi.');

        file_put_contents(storage_path('app/appearance_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));

        return back()->with('success', 'Tampilan berhasil diperbarui!');
    }
}
