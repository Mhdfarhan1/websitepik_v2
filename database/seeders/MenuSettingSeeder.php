<?php

namespace Database\Seeders;

use App\Models\MenuSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['key' => 'dashboard', 'label' => 'Dashboard'],
            ['key' => 'user_management', 'label' => 'Manajemen Akun (Grup)'],
            ['key' => 'akun_pembina', 'label' => 'Akun Pembina'],
            ['key' => 'akun_ketua', 'label' => 'Akun Ketua'],
            ['key' => 'akun_anggota', 'label' => 'Akun Anggota'],
            ['key' => 'mahasiswa', 'label' => 'Mahasiswa'],
            ['key' => 'dosen', 'label' => 'Dosen'],
            ['key' => 'pengurus', 'label' => 'Pengurus'],
            ['key' => 'berita', 'label' => 'Berita'],
            ['key' => 'galeri', 'label' => 'Galeri'],
            ['key' => 'prestasi', 'label' => 'Prestasi'],
            ['key' => 'testimoni', 'label' => 'Testimoni'],
            ['key' => 'pendaftaran', 'label' => 'Pendaftaran Anggota'],
            ['key' => 'faq', 'label' => 'FAQ'],
            ['key' => 'mitra', 'label' => 'Mitra'],
            ['key' => 'kegiatan', 'label' => 'Kegiatan'],
            ['key' => 'tautan_penting', 'label' => 'Tautan Penting'],
            ['key' => 'tampilan', 'label' => 'Tampilan'],
            ['key' => 'pengaturan', 'label' => 'Pengaturan'],
            ['key' => 'visi_misi', 'label' => 'Visi & Misi'],
            ['key' => 'struktur', 'label' => 'Struktur Organisasi'],
            ['key' => 'sejarah', 'label' => 'Sejarah'],
            ['key' => 'proker', 'label' => 'Program Kerja'],
            ['key' => 'edukasi_sebaya', 'label' => 'Edukasi Sebaya'],
            ['key' => 'laporan', 'label' => 'Laporan'],
            ['key' => 'profil_lengkap', 'label' => 'Profil Lengkap'],
        ];

        foreach ($menus as $menu) {
            $isPublicForMember = $menu['key'] === 'dashboard';
            
            MenuSetting::updateOrCreate(
                ['menu_key' => $menu['key']],
                [
                    'menu_label' => $menu['label'],
                    'pembina_visible' => true,
                    'ketua_visible' => true,
                    'anggota_visible' => $isPublicForMember,
                ]
            );
        }
    }
}
