<?php

namespace App\Services;

use App\Models\PeerEducation;
use App\Models\Counseling;

class StatisticService
{
    /**
     * Get Statistik page settings
     */
    public function getSettings(): array
    {
        $path = storage_path('app/statistik_settings.json');
        $manualSettings = [];
        if (file_exists($path)) {
            $manualSettings = json_decode(file_get_contents($path), true) ?? [];
        }
        
        // Default values
        $settings = array_merge([
            'total_remaja' => 428,
            'total_remaja_trend' => '+12% dari bulan lalu',
            'sesi_konseling' => 156,
            'sesi_konseling_trend' => '100% Ditangani Profesional',
            'kegiatan_edukasi' => 32,
            'kegiatan_edukasi_trend' => '+5 kegiatan baru',
            
            // Demographics
            'demo_kelas_x' => 45,
            'demo_kelas_xi' => 35,
            'demo_kelas_xii' => 20,
            
            // Topics
            'topik_1_nama' => 'Akademik & Belajar',
            'topik_1_desc' => 'Manajemen waktu, motivasi',
            'topik_1_pct' => 38,
            
            'topik_2_nama' => 'Kesehatan Mental',
            'topik_2_desc' => 'Kecemasan, stres, bullying',
            'topik_2_pct' => 34,
            
            'topik_3_nama' => 'Hubungan Sosial',
            'topik_3_desc' => 'Keluarga, pertemanan, asmara',
            'topik_3_pct' => 28,

            // Target Edukasi
            'target_edukasi_tahunan' => 1000,
            
            // Background Image
            'statistik_bg' => '',
        ], $manualSettings);

        // --- DYNAMIC OVERRIDES (with fallback to manual settings if dynamic count is empty) ---
        
        // 1. Total Kegiatan Edukasi
        $dynamicEdu = PeerEducation::count();
        $settings['kegiatan_edukasi'] = $dynamicEdu > 0 ? $dynamicEdu : ($manualSettings['kegiatan_edukasi'] ?? 12);

        // 2. Total Remaja Teredukasi
        $dynamicRemaja = (int) PeerEducation::sum('participant_count');
        $settings['total_remaja'] = $dynamicRemaja > 0 ? $dynamicRemaja : ($manualSettings['total_remaja'] ?? 428);

        // 3. Sesi Konseling Sebaya
        $totalCounseling = Counseling::count();
        $settings['sesi_konseling'] = $totalCounseling > 0 ? $totalCounseling : ($manualSettings['sesi_konseling'] ?? 56);

        // 4. Topics Calculation (from Counseling)
        // Group by topic, count them, and calculate percentage
        if ($totalCounseling > 0) {
            $topics = Counseling::select('topic', \DB::raw('count(*) as total'))
                ->groupBy('topic')
                ->orderByDesc('total')
                ->limit(3)
                ->get();
            
            $descriptions = [
                'Akademik & Belajar' => 'Manajemen waktu, motivasi, prestasi',
                'Kesehatan Mental' => 'Kecemasan, stres, bullying, depresi',
                'Hubungan Sosial' => 'Keluarga, pertemanan, asmara, komunikasi',
                'Lainnya' => 'Topik lainnya'
            ];

            foreach ($topics as $index => $topicObj) {
                $num = $index + 1;
                $pct = round(($topicObj->total / $totalCounseling) * 100);
                $cleanTopic = html_entity_decode($topicObj->topic, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                
                $settings["topik_{$num}_nama"] = $cleanTopic;
                $settings["topik_{$num}_desc"] = $descriptions[$cleanTopic] ?? ($descriptions[$topicObj->topic] ?? 'Topik layanan');
                $settings["topik_{$num}_pct"] = $pct;
            }

            // Fallback for remaining topics if less than 3
            $defaultNames = ['Akademik & Belajar', 'Kesehatan Mental', 'Hubungan Sosial'];
            for ($i = $topics->count() + 1; $i <= 3; $i++) {
                $settings["topik_{$i}_nama"] = $manualSettings["topik_{$i}_nama"] ?? ($defaultNames[$i - 1] ?? 'Lainnya');
                $settings["topik_{$i}_desc"] = $manualSettings["topik_{$i}_desc"] ?? 'Edukasi dan bimbingan';
                $settings["topik_{$i}_pct"] = $manualSettings["topik_{$i}_pct"] ?? 20;
            }
        }

        // 5. Demographics Calculation (from Counseling)
        $totalWithClass = Counseling::whereNotNull('student_class')->count();
        if ($totalWithClass > 0) {
            $kelasX = Counseling::where('student_class', 'Kelas X')->count();
            $kelasXI = Counseling::where('student_class', 'Kelas XI')->count();
            $kelasXII = Counseling::where('student_class', 'Kelas XII')->count();
            
            $settings['demo_kelas_x'] = round(($kelasX / $totalWithClass) * 100);
            $settings['demo_kelas_xi'] = round(($kelasXI / $totalWithClass) * 100);
            $settings['demo_kelas_xii'] = round(($kelasXII / $totalWithClass) * 100);
        } else {
            $settings['demo_kelas_x'] = $manualSettings['demo_kelas_x'] ?? 45;
            $settings['demo_kelas_xi'] = $manualSettings['demo_kelas_xi'] ?? 35;
            $settings['demo_kelas_xii'] = $manualSettings['demo_kelas_xii'] ?? 20;
        }

        return $settings;
    }

    /**
     * Update Statistik page settings
     */
    public function updateSettings(array $data): void
    {
        $settings = $this->getSettings();
        
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $settings)) {
                $settings[$key] = $value;
            }
        }

        file_put_contents(storage_path('app/statistik_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));
    }
}
