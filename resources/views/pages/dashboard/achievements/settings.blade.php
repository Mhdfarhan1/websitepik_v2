<x-layouts.dashboard title="Pengaturan Banner Prestasi | Admin PIK-R">
    <div class="min-h-screen bg-slate-50/50 pb-20">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.achievements.index') }}" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-center text-slate-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all cursor-pointer">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Pengaturan Banner Prestasi</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Sesuaikan Judul, Foto Background, Warna, dan Deskripsi Halaman Prestasi</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('prestasi') }}" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    <span>Lihat Halaman Publik</span>
                </a>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-5xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4 text-emerald-600 animate-fade-in-down shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('dashboard.achievements.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8"
                  x-data="{
                      selectedColor: '{{ $settings['hero_bg_color'] ?? '#1e3a5f' }}',
                      tag: '{{ addslashes($settings['hero_tag'] ?? 'Jejak Apresiasi & Prestasi') }}',
                      title1: '{{ addslashes($settings['hero_title_1'] ?? 'Capaian &') }}',
                      title2: '{{ addslashes($settings['hero_title_2'] ?? 'Prestasi') }}',
                      desc: '{{ addslashes($settings['hero_desc'] ?? '') }}'
                  }">
                @csrf

                <!-- MAIN CARD: BANNER HERO CUSTOMIZER -->
                <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100 shrink-0">
                                    <i class="fas fa-trophy text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-800 leading-tight">Hero Banner & Latar Belakang Prestasi</h3>
                                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Sesuaikan Tampilan Hero di Halaman Publik Prestasi</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                <i class="fas fa-magic text-xs"></i> Kompresi Otomatis Aktif
                            </span>
                        </div>

                        <!-- Interactive Live Banner Preview -->
                        <div class="mb-8 rounded-2xl overflow-hidden border border-slate-200 relative p-8 text-white shadow-inner transition-colors duration-300"
                             :style="'background-color: ' + selectedColor"
                             style="min-height: 240px;">
                            
                            @php
                                $bgUrl = $settings['hero_bg'] ?? '';
                                if($bgUrl && !str_starts_with($bgUrl, 'http')) {
                                    $bgUrl = asset($bgUrl);
                                }
                            @endphp

                            <!-- Background Image Overlay -->
                            <div class="absolute inset-0 z-0">
                                <img id="hero-preview-img" 
                                     src="{{ $bgUrl ?: 'https://images.unsplash.com/photo-1531545517246-167e1fd8b76c?auto=format&fit=crop&q=80&w=1600' }}" 
                                     alt="Banner Background Preview" 
                                     class="w-full h-full object-cover opacity-25">
                                <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-black/30"></div>
                            </div>

                            <!-- Content Overlay -->
                            <div class="relative z-10 max-w-xl">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-teal-300 text-[10px] font-extrabold uppercase tracking-widest mb-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                                    <span x-text="tag || 'Jejak Apresiasi & Prestasi'"></span>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                                    <span x-text="title1"></span>
                                    <span class="text-orange-500" x-text="title2"></span>
                                </h3>
                                <p class="text-slate-200 text-xs mt-3 line-clamp-3 leading-relaxed opacity-90 font-medium" x-text="desc"></p>
                                
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="px-3.5 py-1.5 bg-teal-400 text-white rounded-lg font-bold text-[11px] shadow">
                                        Lihat Jejak Juara <i class="fas fa-trophy text-[9px] ml-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Controls Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left: Image & Color -->
                            <div class="space-y-6">
                                <!-- Upload Hero Background -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                                        <span>Foto Background Hero Banner</span>
                                    </label>
                                    <input type="file" name="hero_bg" accept="image/*"
                                           onchange="const f = this.files[0]; if(f){ const r = new FileReader(); r.onload = (e) => document.getElementById('hero-preview-img').src = e.target.result; r.readAsDataURL(f); }"
                                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl p-2">
                                    <p class="text-[10px] font-semibold text-slate-400 ml-1">
                                        Foto otomatis dioptimasi dan dikompresi ke WebP resolusi tinggi tanpa membuat server berat.
                                    </p>
                                </div>

                                <!-- Color Picker & Presets -->
                                <div class="space-y-3">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">
                                        Warna Latar Belakang Banner (Background Overlay Color)
                                    </label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="hero_bg_color" x-model="selectedColor"
                                               class="w-12 h-11 p-1 bg-white border border-slate-200 rounded-xl cursor-pointer shadow-sm">
                                        <input type="text" x-model="selectedColor" readonly
                                               class="w-28 bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-xs font-mono font-bold text-slate-700">
                                    </div>

                                    <!-- Color Presets -->
                                    <div class="flex flex-wrap items-center gap-2 pt-1">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mr-1">Pilihan Warna:</span>
                                        <button type="button" @click="selectedColor = '#1e3a5f'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #1e3a5f;">Navy Classic</button>
                                        <button type="button" @click="selectedColor = '#17385c'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #17385c;">Ocean Deep</button>
                                        <button type="button" @click="selectedColor = '#1e3a8a'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #1e3a8a;">Royal Blue</button>
                                        <button type="button" @click="selectedColor = '#0f172a'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #0f172a;">Dark Slate</button>
                                        <button type="button" @click="selectedColor = '#064e3b'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-sm transition-transform hover:scale-105 cursor-pointer" style="background-color: #064e3b;">Forest Teal</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Tag & Titles -->
                            <div class="space-y-6">
                                <!-- Tagline / Badge -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Badge Tagline Kecil</label>
                                    <input type="text" name="hero_tag" x-model="tag" placeholder="Contoh: Jejak Apresiasi & Prestasi"
                                           class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>

                                <!-- Judul 1 & 2 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Judul 1 (Teks Putih)</label>
                                        <input type="text" name="hero_title_1" x-model="title1" placeholder="Contoh: Capaian &"
                                               class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Judul 2 (Sorotan Oranye)</label>
                                        <input type="text" name="hero_title_2" x-model="title2" placeholder="Contoh: Prestasi"
                                               class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Hero -->
                        <div class="space-y-2 mt-6 pt-4 border-t border-slate-100">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Deskripsi Lengkap Hero Banner</label>
                            <textarea name="hero_desc" x-model="desc" rows="3"
                                      class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all leading-relaxed"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: JUDUL SECTION PRESTASI & CTA -->
                <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center gap-4 mb-6 pb-4 border-b border-slate-100">
                            <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100 shrink-0">
                                <i class="fas fa-heading text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800 leading-tight">Judul Bagian Daftar Prestasi</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Judul yang Muncul di Atas Kartu Prestasi</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Kata Pertama (Teks Gelap)</label>
                                <input type="text" name="section_title_1" value="{{ $settings['section_title_1'] ?? 'Dedikasi' }}"
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Kata Kedua (Sorotan Oranye)</label>
                                <input type="text" name="section_title_2" value="{{ $settings['section_title_2'] ?? 'Tanpa Henti' }}"
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('dashboard.achievements.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                        Kembali ke Daftar Prestasi
                    </a>
                    <button type="submit" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-blue-500/10 transition-all cursor-pointer flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
