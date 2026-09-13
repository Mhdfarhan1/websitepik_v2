<x-layouts.dashboard title="Edit Profil Lengkap | Admin PIK-R">
    <div class="min-h-screen bg-slate-50/50 pb-20">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Edit Profil Lengkap</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Sesuaikan Informasi Profil Lengkap Organisasi dan Dokumen Legalitas</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('profil-lengkap') }}" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    <span>Lihat Halaman Publik</span>
                </a>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-5xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4 text-emerald-600 animate-fade-in-down shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('dashboard.complete-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- SECTION 1: HERO & BANNER BELAKANG (BISA DIATUR) -->
                <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm transition-all duration-300"
                     x-data="{
                         selectedColor: '{{ $settings->hero_bg_color ?: '#1e3a5f' }}',
                         heroTag: '{{ addslashes($settings->hero_tag ?: 'Complete Identity') }}',
                         heroTitle: '{{ addslashes($settings->hero_title ?: 'Profil Lengkap PIK-R REQUEST') }}',
                         heroDesc: '{{ addslashes($settings->hero_desc ?: 'Dokumen resmi identitas organisasi, landasan operasional, dan visi strategis Pusat Informasi dan Konseling Remaja SMAN 1 Tasik Putri Puyu.') }}'
                     }">
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 shrink-0">
                                    <i class="fas fa-image text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-800 leading-tight">Hero Banner & Latar Belakang Biru</h3>
                                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Atur Foto Banner, Warna Biru, Teks, dan Dokumen PDF</p>
                                </div>
                            </div>
                            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                <i class="fas fa-magic text-xs"></i> Kompresi Otomatis Aktif
                            </span>
                        </div>

                        <!-- Live Banner Preview Card -->
                        <div class="mb-8 rounded-2xl overflow-hidden border border-slate-200 relative p-8 text-white text-center shadow-inner transition-colors duration-300"
                             :style="'background-color: ' + selectedColor"
                             style="min-height: 200px;">
                            <div class="absolute inset-0 z-0">
                                <img id="hero-bg-preview-img" 
                                     src="{{ $settings->hero_bg ? asset($settings->hero_bg) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1600' }}" 
                                     alt="Banner Preview" 
                                     class="w-full h-full object-cover opacity-25">
                                <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/60"></div>
                            </div>
                            <div class="relative z-10 max-w-xl mx-auto py-4">
                                <span class="inline-block px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-teal-300 text-[10px] font-extrabold uppercase tracking-widest mb-3">
                                    <span x-text="heroTag || 'Complete Identity'"></span>
                                </span>
                                <h4 class="text-xl sm:text-2xl font-black text-white tracking-tight"
                                    x-text="heroTitle || 'Profil Lengkap PIK-R REQUEST'">
                                </h4>
                                <p class="text-slate-200 text-xs mt-2 line-clamp-2 opacity-90 font-medium leading-relaxed"
                                   x-text="heroDesc || 'Dokumen resmi identitas organisasi...'">
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column: Gambar Banner & Warna -->
                            <div class="space-y-6">
                                <!-- Upload Gambar Banner Belakang -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                                        <span>Gambar Banner Belakang (Hero Background)</span>
                                    </label>
                                    <input type="file" name="hero_bg" accept="image/*"
                                           onchange="const f = this.files[0]; if(f){ const r = new FileReader(); r.onload = (e) => document.getElementById('hero-bg-preview-img').src = e.target.result; r.readAsDataURL(f); }"
                                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl p-2">
                                    <p class="text-[10px] font-semibold text-slate-400 ml-1">
                                        Foto kamera resolusi tinggi otomatis dikompresi ke WebP tanpa membuat website lambat.
                                    </p>
                                </div>

                                <!-- Pengaturan Warna Latar Belakang Biru -->
                                <div class="space-y-3">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">
                                        Warna Latar Belakang Hero (Background Color)
                                    </label>
                                    
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="hero_bg_color" x-model="selectedColor"
                                               class="w-12 h-11 p-1 bg-white border border-slate-200 rounded-xl cursor-pointer shadow-sm">
                                        <input type="text" x-model="selectedColor" readonly
                                               class="w-28 bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-xs font-mono font-bold text-slate-700">
                                    </div>

                                    <!-- Quick Preset Colors -->
                                    <div class="flex flex-wrap items-center gap-2 pt-1">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mr-1">Preset Cepat:</span>
                                        <button type="button" @click="selectedColor = '#1e3a5f'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #1e3a5f;">Navy Classic</button>
                                        <button type="button" @click="selectedColor = '#17385c'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #17385c;">Ocean Deep</button>
                                        <button type="button" @click="selectedColor = '#1e3a8a'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #1e3a8a;">Royal Blue</button>
                                        <button type="button" @click="selectedColor = '#0f172a'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #0f172a;">Dark Slate</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Tag, Judul, PDF -->
                            <div class="space-y-6">
                                <!-- Tagline / Badge Kecil -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Badge / Tagline Kecil Atas</label>
                                    <input type="text" name="hero_tag" x-model="heroTag" placeholder="Contoh: Complete Identity"
                                           class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>

                                <!-- Judul Hero -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Judul Utama Hero (Title)</label>
                                    <input type="text" name="hero_title" x-model="heroTitle" required
                                           class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>

                                <!-- Berkas PDF -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Berkas Profil Lengkap (PDF)</label>
                                    <div class="space-y-2">
                                        <input type="file" name="pdf_file" accept=".pdf"
                                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl p-2">
                                        @if($settings->pdf_path)
                                            <div class="flex items-center gap-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg w-max">
                                                <i class="fas fa-file-pdf"></i>
                                                <a href="{{ asset($settings->pdf_path) }}" target="_blank" class="hover:underline">Lihat PDF Aktif Saat Ini</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Hero -->
                        <div class="space-y-2 mt-6 pt-4 border-t border-slate-100">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Deskripsi Hero (Subtitle)</label>
                            <textarea name="hero_desc" x-model="heroDesc" rows="3" required
                                      class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all leading-relaxed"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: BIOGRAFI PEMBINA -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300">
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100">
                                <i class="fas fa-user-tie text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800 leading-tight">Sekilas Biografi Pembina</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Kelola Teks Biografi Lengkap Pembina</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap & Gelar -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap & Gelar Pembina</label>
                                <input type="text" name="bio_name" value="{{ $settings->bio_name }}" required
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>

                            <!-- Foto Biografi -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Foto Biografi Pembina</label>
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200 overflow-hidden shrink-0 shadow-sm">
                                        @if($settings->bio_photo)
                                            <img src="{{ asset($settings->bio_photo) }}" alt="Foto Pembina" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-350">
                                                <i class="fas fa-user-tie text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" name="bio_photo" accept="image/*"
                                               class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        <p class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-wide">JPG, JPEG, PNG (Max 2MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paragraf Biografi -->
                        <div class="space-y-2 mt-6">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Paragraf Biografi Singkat</label>
                            <textarea name="bio_content" rows="4" required
                                      class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->bio_content }}</textarea>
                        </div>

                        <!-- Bidang Keahlian -->
                        <div class="space-y-2 mt-6">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Bidang Keahlian Pembina</label>
                            <textarea name="bio_expertise" rows="4" required
                                      class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->bio_expertise }}</textarea>
                        </div>

                        <!-- Harapan -->
                        <div class="space-y-2 mt-6">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Harapan Pembina Tentang PIK-R REQUEST</label>
                            <textarea name="bio_hopes" rows="4" required
                                      class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->bio_hopes }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: IDENTITAS ORGANISASI -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300">
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 border border-teal-100">
                                <i class="fas fa-fingerprint text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800 leading-tight">Identitas Resmi Organisasi</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Ubah Detail Profil Legalitas Organisasi</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Organisasi -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Organisasi</label>
                                <input type="text" name="org_name" value="{{ $settings->org_name }}" required
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>

                            <!-- Singkatan -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Singkatan / Akronim Motto</label>
                                <input type="text" name="org_abbreviation" value="{{ $settings->org_abbreviation }}" required
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>

                            <!-- Tahun Berdiri -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Tahun Berdiri</label>
                                <input type="text" name="org_year" value="{{ $settings->org_year }}" required
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>

                            <!-- Basis Organisasi -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Basis Tempat Organisasi</label>
                                <input type="text" name="org_base" value="{{ $settings->org_base }}" required
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>
                        </div>

                        <!-- Filosofi Nama -->
                        <div class="space-y-2 mt-6">
                            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Filosofi Singkatan Nama (Motto Detail)</label>
                            <textarea name="org_philosophy" rows="4" required
                                      class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->org_philosophy }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: LANDASAN HUKUM -->
                <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm transition-all duration-300">
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 border border-rose-100">
                                <i class="fas fa-gavel text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800 leading-tight">Landasan Operasional / Hukum</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Kelola Tiga Regulasi Utama Dasar Gerak Organisasi</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Landasan 1 -->
                            <div class="p-5 bg-slate-50/50 border border-slate-150 rounded-2xl space-y-4">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Landasan Hukum 1</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-1 space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Judul Regulasi</label>
                                        <input type="text" name="reg_1_title" value="{{ $settings->reg_1_title }}" required
                                               class="w-full bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Penjelasan Regulasi</label>
                                        <input type="text" name="reg_1_desc" value="{{ $settings->reg_1_desc }}" required
                                               class="w-full bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Landasan 2 -->
                            <div class="p-5 bg-slate-50/50 border border-slate-150 rounded-2xl space-y-4">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Landasan Hukum 2</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-1 space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Judul Regulasi</label>
                                        <input type="text" name="reg_2_title" value="{{ $settings->reg_2_title }}" required
                                               class="w-full bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Penjelasan Regulasi</label>
                                        <input type="text" name="reg_2_desc" value="{{ $settings->reg_2_desc }}" required
                                               class="w-full bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Landasan 3 -->
                            <div class="p-5 bg-slate-50/50 border border-slate-150 rounded-2xl space-y-4">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Landasan Hukum 3</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-1 space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Judul Regulasi</label>
                                        <input type="text" name="reg_3_title" value="{{ $settings->reg_3_title }}" required
                                               class="w-full bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Penjelasan Regulasi</label>
                                        <input type="text" name="reg_3_desc" value="{{ $settings->reg_3_desc }}" required
                                               class="w-full bg-white border-slate-200 border rounded-xl py-2.5 px-3 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-blue-500/10 transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
