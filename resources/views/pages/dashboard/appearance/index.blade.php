<x-layouts.dashboard title="Tampilan & Visual | Admin PIK-R">
    <div class="min-h-screen bg-slate-50/50 pb-20">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Tampilan & Visual</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">SESUAIKAN IDENTITAS VISUAL DAN TEMA WEBSITE ANDA</p>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4 text-emerald-600 animate-fade-in-down shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('dashboard.appearance.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- 1. Hero Section Landing Page -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 relative">
                    <div class="p-8 lg:p-12">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100">
                                <i class="fas fa-home text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">Hero Section Landing Page</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Ubah Teks & Gambar Utama di Halaman Depan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <!-- Hero Title -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Utama (Title)</label>
                                    <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'PIK-R REQUEST' }}" 
                                           class="bg-slate-50 border-slate-100 border rounded-xl py-3.5 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>

                                <!-- Hero Subtitle -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Sub Judul (Subtitle)</label>
                                    <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? 'SMA Negeri 1 Tasik Putri Puyu' }}" 
                                           class="bg-slate-50 border-slate-100 border rounded-xl py-3.5 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>
                            </div>

                            <!-- Hero Background Image -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Gambar Latar Belakang (Background)</label>
                                <div class="flex flex-col sm:flex-row items-center gap-6">
                                    <div class="w-32 h-20 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden relative shadow-sm">
                                        <img src="{{ asset($settings['hero_bg'] ?? 'assets/img/bg_utama.JPG') }}" class="w-full h-full object-cover" alt="Hero BG">
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" name="hero_bg" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer w-full">
                                        <p class="text-[10px] font-bold text-slate-400 mt-2 ml-1">Format JPG/PNG (MAX 2MB). Gambar disarankan lanskap.</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <!-- 2. Section Tentang Kami & Video Profil -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 relative">
                    <div class="p-8 lg:p-12">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100">
                                <i class="fas fa-play-circle text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">Section Tentang Kami & Video Profil</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Ubah Teks, Statistik & Informasi Video Profil</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left: General & Video Texts -->
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Tag Kecil</label>
                                        <input type="text" name="about_tag" value="{{ $settings['about_tag'] ?? 'Video Profil Organisasi' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Bagian 1</label>
                                        <input type="text" name="about_title_1" value="{{ $settings['about_title_1'] ?? 'Mengenal' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Bagian 2 (Biru)</label>
                                        <input type="text" name="about_title_2" value="{{ $settings['about_title_2'] ?? 'PIK-R REQUEST' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Bagian 3 (Oranye)</label>
                                        <input type="text" name="about_title_3" value="{{ $settings['about_title_3'] ?? 'Lebih Dekat' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Deskripsi Penjelasan</label>
                                    <textarea name="about_desc" rows="3" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings['about_desc'] ?? '' }}</textarea>
                                </div>

                                <div class="space-y-4 border-t border-slate-50 pt-4">
                                    <h4 class="text-xs font-bold text-slate-700">Data Statistik (4 Item)</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] text-slate-400 font-bold">Stat 1 (Nilai & Label)</label>
                                            <div class="flex gap-2">
                                                <input type="text" name="about_stat1_val" placeholder="e.g. 4" value="{{ $settings['about_stat1_val'] ?? '4' }}" class="w-16 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700 text-center">
                                                <input type="text" name="about_stat1_lbl" placeholder="Pilar" value="{{ $settings['about_stat1_lbl'] ?? 'Pilar Utama' }}" class="flex-1 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700">
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] text-slate-400 font-bold">Stat 2 (Nilai & Label)</label>
                                            <div class="flex gap-2">
                                                <input type="text" name="about_stat2_val" placeholder="50" value="{{ $settings['about_stat2_val'] ?? '50' }}" class="w-16 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700 text-center">
                                                <input type="text" name="about_stat2_lbl" placeholder="Anggota" value="{{ $settings['about_stat2_lbl'] ?? 'Anggota' }}" class="flex-1 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] text-slate-400 font-bold">Stat 3 (Nilai & Label)</label>
                                            <div class="flex gap-2">
                                                <input type="text" name="about_stat3_val" placeholder="20" value="{{ $settings['about_stat3_val'] ?? '20' }}" class="w-16 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700 text-center">
                                                <input type="text" name="about_stat3_lbl" placeholder="Kegiatan" value="{{ $settings['about_stat3_lbl'] ?? 'Kegiatan' }}" class="flex-1 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700">
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] text-slate-400 font-bold">Stat 4 (Nilai & Label)</label>
                                            <div class="flex gap-2">
                                                <input type="text" name="about_stat4_val" placeholder="5" value="{{ $settings['about_stat4_val'] ?? '5' }}" class="w-16 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700 text-center">
                                                <input type="text" name="about_stat4_lbl" placeholder="Tahun" value="{{ $settings['about_stat4_lbl'] ?? 'Tahun' }}" class="flex-1 bg-slate-50 border-slate-100 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Video Profile Settings -->
                            <div class="space-y-6 bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                                <h4 class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                    <i class="fab fa-youtube text-red-500 text-sm"></i>
                                    Pengaturan Video Profil & Card
                                </h4>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Link Video YouTube</label>
                                    <input type="text" name="about_video_url" placeholder="https://www.youtube.com/watch?v=..." value="{{ $settings['about_video_url'] ?? '' }}" class="bg-white border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Video (Card)</label>
                                        <input type="text" name="about_video_title" value="{{ $settings['about_video_title'] ?? 'VIDEO PROFIL PIK-R REQUEST' }}" class="bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Subjudul Video (Card)</label>
                                        <input type="text" name="about_video_subtitle" value="{{ $settings['about_video_subtitle'] ?? 'SMAN 1 Tasik Putri Puyu' }}" class="bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Periode Video (Card)</label>
                                        <input type="text" name="about_video_period" value="{{ $settings['about_video_period'] ?? 'Periode 2024-2025' }}" class="bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Thumbnail Video Cover</label>
                                    <div class="flex flex-col sm:flex-row items-center gap-4">
                                        <div class="w-32 h-20 rounded-xl bg-white border border-slate-200 overflow-hidden relative shadow-sm shrink-0">
                                            @if(isset($settings['about_video_thumbnail']) && str_starts_with($settings['about_video_thumbnail'], 'http'))
                                                <img src="{{ $settings['about_video_thumbnail'] }}" class="w-full h-full object-cover" alt="Video Thumbnail">
                                            @else
                                                <img src="{{ asset($settings['about_video_thumbnail'] ?? 'assets/img/bg_utama.JPG') }}" class="w-full h-full object-cover" alt="Video Thumbnail">
                                            @endif
                                        </div>
                                        <div class="flex-1 w-full">
                                            <input type="file" name="about_video_thumbnail" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer w-full">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Section Galeri & Kegiatan -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 relative">
                    <div class="p-8 lg:p-12">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-650 border border-teal-100">
                                <i class="fas fa-images text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">Section Galeri & Kegiatan</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Ubah Teks & Informasi Bagian Galeri Beranda</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul 1 (Kuning)</label>
                                <input type="text" name="gallery_title_1" value="{{ $settings['gallery_title_1'] ?? 'Galeri' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul 2 (Putih)</label>
                                <input type="text" name="gallery_title_2" value="{{ $settings['gallery_title_2'] ?? 'Kegiatan' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>
                        </div>

                        <div class="space-y-2 mt-6">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Deskripsi Penjelasan</label>
                            <textarea name="gallery_desc" rows="3" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings['gallery_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu memiliki beragam karya dan potret kegiatan yang dihasilkan dari program edukasi, konseling sebaya, dan pembinaan kecakapan hidup (life skill).' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 4. Section Prestasi PIK-R -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 relative">
                    <div class="p-8 lg:p-12">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500 border border-rose-100">
                                <i class="fas fa-trophy text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">Section Prestasi PIK-R</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Ubah Teks & Informasi Bagian Prestasi Beranda</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul 1 (Kuning)</label>
                                <input type="text" name="achievement_title_1" value="{{ $settings['achievement_title_1'] ?? 'Prestasi' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul 2 (Hitam/Gelap)</label>
                                <input type="text" name="achievement_title_2" value="{{ $settings['achievement_title_2'] ?? 'PIK-R' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>
                        </div>

                        <div class="space-y-2 mt-6">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Deskripsi Penjelasan</label>
                            <textarea name="achievement_desc" rows="3" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings['achievement_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu terus mengukir prestasi dan apresiasi di tingkat kabupaten hingga provinsi sebagai pusat informasi dan edukasi remaja yang aktif, inovatif, dan berprestasi.' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. Skema Warna Utama -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 relative">
                    <div class="p-8 lg:p-12">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100">
                                <i class="fas fa-palette text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">Skema Warna Brand</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Tentukan warna identitas digital anda</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <!-- Primary Color -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Warna Primer</label>
                                <div class="flex items-center gap-4">
                                    <input type="color" value="{{ $settings['primary_color'] ?? '#2563eb' }}" id="primary_picker" class="w-16 h-16 rounded-2xl cursor-pointer border-4 border-slate-50 bg-white shadow-sm overflow-hidden">
                                    <div class="flex-1">
                                        <input type="text" name="primary_color" id="primary_text" value="{{ $settings['primary_color'] ?? '#2563eb' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all uppercase">
                                        <p class="text-[10px] font-bold text-slate-400 mt-2 ml-1">Gunakan format HEX (e.g. #2563EB)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Secondary Color -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Warna Sekunder</label>
                                <div class="flex items-center gap-4">
                                    <input type="color" value="{{ $settings['secondary_color'] ?? '#64748b' }}" id="secondary_picker" class="w-16 h-16 rounded-2xl cursor-pointer border-4 border-slate-50 bg-white shadow-sm overflow-hidden">
                                    <div class="flex-1">
                                        <input type="text" name="secondary_color" id="secondary_text" value="{{ $settings['secondary_color'] ?? '#64748b' }}" class="bg-slate-50 border-slate-100 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all uppercase">
                                        <p class="text-[10px] font-bold text-slate-400 mt-2 ml-1">Warna aksen teks & elemen pendukung</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme Toggle -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Mode Visual Dasar</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="button" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-[#1e3a8a] bg-blue-50/30 text-[#1e3a8a] transition-all">
                                        <i class="fas fa-sun text-lg mb-2"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Terang</span>
                                    </button>
                                    <button type="button" class="flex flex-col items-center justify-center p-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-400 hover:border-slate-350 transition-all">
                                        <i class="fas fa-moon text-lg mb-2"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Gelap</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Logo & Branding -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Main Logo -->
                    <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 relative p-8 lg:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                                <i class="fas fa-image text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-md font-bold text-slate-800 leading-tight">Logo Utama</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PNG, JPG (MAX 2MB)</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="h-44 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col items-center justify-center relative overflow-hidden">
                                <img src="{{ asset($settings['logo'] ?? 'assets/img/logo_utama.png') }}" class="h-20 w-auto object-contain z-10" alt="Current Logo">
                            </div>
                            <div>
                                <input type="file" name="logo" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer w-full">
                            </div>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 mt-4 text-center italic">Disarankan menggunakan background transparan (PNG)</p>
                    </div>

                    <!-- Favicon -->
                    <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 relative p-8 lg:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 border border-rose-100">
                                <i class="fas fa-globe text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-md font-bold text-slate-800 leading-tight">Favicon Website</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ICO, PNG (MAX 500KB)</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="h-44 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center relative overflow-hidden">
                                <img src="{{ asset($settings['favicon'] ?? 'assets/img/logo_utama.png') }}" class="w-12 h-12 object-contain" alt="Favicon">
                            </div>
                            <div>
                                <input type="file" name="favicon" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer w-full">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Tipografi & Gaya Visual -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300 p-8 lg:p-12">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100">
                            <i class="fas fa-font text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 leading-tight">Tipografi & Gaya Visual</h3>
                            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Personalisasi gaya teks dan sudut elemen</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-4">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Keluarga Font Utama</label>
                            <select name="font" class="appearance-none bg-slate-50 border-slate-100 border rounded-xl py-4 px-5 text-xs font-bold text-slate-700 w-full focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all cursor-pointer">
                                <option value="inter" {{ ($settings['font'] ?? 'inter') === 'inter' ? 'selected' : '' }}>Inter (Default Modern)</option>
                                <option value="poppins" {{ ($settings['font'] ?? '') === 'poppins' ? 'selected' : '' }}>Poppins (Geometric & Friendly)</option>
                                <option value="outfit" {{ ($settings['font'] ?? '') === 'outfit' ? 'selected' : '' }}>Outfit (Sharp & Premium)</option>
                                <option value="roboto" {{ ($settings['font'] ?? '') === 'roboto' ? 'selected' : '' }}>Roboto (Clean & Familiar)</option>
                            </select>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kelengkungan Sudut (Border Radius)</label>
                            <div class="flex items-center gap-6">
                                <input type="range" name="border_radius" min="0" max="40" value="{{ $settings['border_radius'] ?? '32' }}" id="border_radius_slider" class="flex-1 accent-[#1e3a8a] h-1.5 bg-slate-100 rounded-lg appearance-none cursor-pointer">
                                <span id="border_radius_label" class="w-12 text-xs font-bold text-slate-800 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 text-center">{{ $settings['border_radius'] ?? '32' }}px</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col md:flex-row items-center justify-end gap-4 pt-6">
                    <button type="reset" class="w-full md:w-auto px-10 py-4 rounded-xl font-bold text-[11px] text-slate-500 uppercase tracking-[0.2em] hover:bg-slate-100 transition-all">
                        Reset Default
                    </button>
                    <button type="submit" class="w-full md:w-auto px-12 py-4 rounded-xl font-bold text-[11px] text-white bg-[#1e3a8a] uppercase tracking-[0.2em] shadow-xl shadow-[#1e3a8a]/20 hover:bg-[#1a337a] hover:translate-y-[-2px] transition-all active:translate-y-[0px]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bind Range Slider Label
            const slider = document.getElementById('border_radius_slider');
            const label = document.getElementById('border_radius_label');
            if (slider && label) {
                slider.addEventListener('input', function() {
                    label.textContent = this.value + 'px';
                });
            }

            // Bind Color Pickers and Text Inputs
            const primaryPicker = document.getElementById('primary_picker');
            const primaryText = document.getElementById('primary_text');
            if (primaryPicker && primaryText) {
                primaryPicker.addEventListener('input', function() {
                    primaryText.value = this.value.toUpperCase();
                });
                primaryText.addEventListener('input', function() {
                    if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                        primaryPicker.value = this.value;
                    }
                });
            }

            const secondaryPicker = document.getElementById('secondary_picker');
            const secondaryText = document.getElementById('secondary_text');
            if (secondaryPicker && secondaryText) {
                secondaryPicker.addEventListener('input', function() {
                    secondaryText.value = this.value.toUpperCase();
                });
                secondaryText.addEventListener('input', function() {
                    if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                        secondaryPicker.value = this.value;
                    }
                });
            }
        });
    </script>
    @endpush
</x-layouts.dashboard>
