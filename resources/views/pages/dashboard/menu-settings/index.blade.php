<x-layouts.dashboard title="Hak Akses Menu | Admin PIK-R">
    @php
        $groups = [
            'Beranda & Utama' => [
                'dashboard' => ['icon' => 'fas fa-th-large', 'label' => 'Dashboard'],
            ],
            'Data Master' => [
                'user_management' => ['icon' => 'fas fa-users-cog', 'label' => 'Manajemen Akun (Grup)'],
                'akun_pembina' => ['icon' => 'fas fa-user-tie', 'label' => 'Daftar Akun Pembina'],
                'akun_ketua' => ['icon' => 'fas fa-user-graduate', 'label' => 'Daftar Akun Ketua'],
            ],
            'Media & Informasi' => [
                'berita' => ['icon' => 'fas fa-newspaper', 'label' => 'Berita & Artikel'],
                'kegiatan' => ['icon' => 'fas fa-calendar-star', 'label' => 'Kegiatan'],
                'galeri' => ['icon' => 'fas fa-images', 'label' => 'Media Visual'],
                'prestasi' => ['icon' => 'fas fa-trophy', 'label' => 'Pencapaian Prestasi'],
                'testimoni' => ['icon' => 'fas fa-comment-dots', 'label' => 'Testimoni Pengguna'],
                'pendaftaran' => ['icon' => 'fas fa-user-plus', 'label' => 'Pendaftaran Anggota'],
            ],
            'Edukasi & Layanan' => [
                'proker' => ['icon' => 'fas fa-book-reader', 'label' => 'Program Kerja'],
                'edukasi_sebaya' => ['icon' => 'fas fa-graduation-cap', 'label' => 'Edukasi Sebaya'],
            ],
            'Profil & Institusi' => [
                'sejarah' => ['icon' => 'fas fa-history', 'label' => 'Sejarah PIK-R'],
                'visi_misi' => ['icon' => 'fas fa-bullseye', 'label' => 'Visi & Misi'],
                'struktur' => ['icon' => 'fas fa-sitemap', 'label' => 'Struktur Organisasi'],
                'profil_lengkap' => ['icon' => 'fas fa-id-card', 'label' => 'Profil Lengkap'],
                'laporan' => ['icon' => 'fas fa-file-signature', 'label' => 'Laporan Berkala'],
                'tautan_penting' => ['icon' => 'fas fa-link', 'label' => 'Tautan Penting'],
            ],
            'Komunikasi' => [
                'mitra' => ['icon' => 'fas fa-handshake', 'label' => 'Jejaring Mitra'],
                'faq' => ['icon' => 'fas fa-question-circle', 'label' => 'FAQ & Kontak'],
            ],
            'Sistem & Kustomisasi' => [
                'tampilan' => ['icon' => 'fas fa-palette', 'label' => 'Tampilan (Warna & Logo)'],
                'pengaturan' => ['icon' => 'fas fa-cog', 'label' => 'Pengaturan Global'],
            ],
        ];
        $settingsByKey = $settings->keyBy('menu_key');
    @endphp

    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Konfigurasi Hak Akses</h2>
        <p class="text-slate-400 text-[10px] font-bold mt-1 uppercase tracking-[0.2em]">Kontrol Visibilitas Fitur Berdasarkan Peran</p>
    </div>

    <form action="{{ route('dashboard.menu-settings.update') }}" method="POST" class="space-y-6 pb-32">
        @csrf
        @method('PUT')

        @foreach($groups as $groupName => $items)
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                    <h3 class="text-[11px] font-black text-slate-700 uppercase tracking-[0.15em]">{{ $groupName }}</h3>
                </div>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ count($items) }} Fitur</span>
            </div>

            <div class="divide-y divide-slate-50">
                @foreach($items as $key => $info)
                @php $setting = $settingsByKey[$key] ?? null; @endphp
                @if($setting)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/30 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center text-slate-400">
                            <i class="{{ $info['icon'] }} text-base"></i>
                        </div>
                        <div>
                            <span class="text-xs font-black text-slate-800 block">{{ $info['label'] }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">{{ $key }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-12">
                        <!-- Pembina Access -->
                        <div class="flex flex-col items-center gap-1.5">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Pembina</span>
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="settings[{{ $key }}][pembina]" value="1" class="sr-only peer" {{ $setting->pembina_visible ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-[24px] peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500 transition-all shadow-inner"></div>
                            </label>
                        </div>

                        <!-- Ketua Access -->
                        <div class="flex flex-col items-center gap-1.5">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Ketua</span>
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="settings[{{ $key }}][ketua]" value="1" class="sr-only peer" {{ $setting->ketua_visible ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-[24px] peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-orange-500 transition-all shadow-inner"></div>
                            </label>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="fixed bottom-8 right-8 z-[100]">
            <button type="submit" class="flex items-center gap-3 px-6 py-3.5 bg-[#1e40af] hover:bg-blue-800 text-white rounded-xl shadow-2xl shadow-blue-900/40 transition-all active:scale-95 group">
                <i class="fas fa-save text-base group-hover:rotate-12 transition-transform"></i>
                <span class="font-black text-[11px] uppercase tracking-widest">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</x-layouts.dashboard>
