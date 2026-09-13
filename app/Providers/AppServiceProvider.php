<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $path = storage_path('app/appearance_settings.json');
            $settings = [];
            if (file_exists($path)) {
                $settings = json_decode(file_get_contents($path), true);
            }
            // fallback defaults
            $settings = array_merge([
                'hero_title' => 'PIK-R REQUEST',
                'hero_subtitle' => 'SMA Negeri 1 Tasik Putri Puyu',
                'hero_bg' => 'assets/img/bg_utama.JPG',
                'primary_color' => '#2563eb',
                'secondary_color' => '#64748b',
                'logo' => 'assets/img/logo_utama.png',
                'favicon' => 'assets/img/logo_utama.png',
                'font' => 'inter',
                'border_radius' => '32',
                
                // About section
                'about_tag' => 'Video Profil Organisasi',
                'about_title_1' => 'Mengenal',
                'about_title_2' => 'PIK-R REQUEST',
                'about_title_3' => 'Lebih Dekat',
                'about_desc' => 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu adalah wadah inovatif bagi remaja. Sebagai pusat informasi dan konseling, kami membangun ekosistem yang suportif dan kreatif. Dari pemberian materi hingga praktik nyata yang mengubah cara remaja menghadapi tantangan di era modern.',
                'about_stat1_val' => '4',
                'about_stat1_lbl' => 'Pilar Utama',
                'about_stat2_val' => '50',
                'about_stat2_lbl' => 'Anggota',
                'about_stat3_val' => '20',
                'about_stat3_lbl' => 'Kegiatan',
                'about_stat4_val' => '5',
                'about_stat4_lbl' => 'Tahun',
                'about_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'about_video_title' => 'VIDEO PROFIL PIK-R REQUEST',
                'about_video_subtitle' => 'SMAN 1 Tasik Putri Puyu',
                'about_video_period' => 'Periode 2024-2025',
                'about_video_thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            ], $settings);
            
            $view->with('appearance', $settings);
        });
    }
}
