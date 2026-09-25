<x-layouts.dashboard title="Manajemen Jejak Bakti & Duta | Admin PIK-R">
    <div class="space-y-8" x-data="{ 
        activeTab: 'general',
        addEditionModalOpen: false,
        addFigureModalOpen: false,
        editFigureModalOpen: false,
        editFigureData: {
            id: null,
            name: '',
            honor_title: '',
            period: '',
            badge_color: 'amber',
            quote: '',
            contribution: '',
            instagram: '',
            order_index: 0,
            is_active: 1
        }
    }">
        
        <!-- Header Banner -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-gradient-to-r from-[#17385c] via-[#1e40af] to-[#3b82f6] p-7 sm:p-8 rounded-[28px] text-white shadow-xl shadow-blue-900/10 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-300/30 text-amber-300 text-[11px] font-bold uppercase tracking-wider">
                    <i class="fas fa-crown text-[10px]"></i>
                    <span>Museum & Arsip Multi-Generasi</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Jejak Bakti & Apresiasi Duta GenRe</h1>
                <p class="text-white/80 text-xs sm:text-sm font-medium max-w-2xl leading-relaxed">
                    Kelola arsip penghargaan tahunan. Tambah poster dan duta baru setiap tahun tanpa menghapus kenangan dan jasa generasi terdahulu.
                </p>
            </div>

            <!-- Stats Ribbon -->
            <div class="relative z-10 flex items-center gap-3 shrink-0 flex-wrap">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 px-4 py-3 rounded-2xl text-center min-w-[100px]">
                    <span class="block text-2xl font-black text-amber-300">{{ count($editions) }}</span>
                    <span class="text-[10px] uppercase font-bold text-white/70">Periode</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 px-4 py-3 rounded-2xl text-center min-w-[100px]">
                    <span class="block text-2xl font-black text-rose-300">{{ $selectedEdition ? number_format($selectedEdition->appreciation_count) : 0 }}</span>
                    <span class="text-[10px] uppercase font-bold text-white/70">Apresiasi ❤️</span>
                </div>
                <button @click="addEditionModalOpen = true" class="bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold px-5 py-3 rounded-2xl text-xs uppercase tracking-wider shadow-lg transition-all flex items-center gap-2">
                    <i class="fas fa-plus text-[10px]"></i>
                    <span>Tambah Periode Baru</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 shadow-sm text-emerald-800">
                <i class="fas fa-check-circle text-emerald-500 text-base"></i>
                <p class="text-xs font-bold">{{ session('success') }}</p>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl space-y-1 shadow-sm text-rose-800">
                <div class="flex items-center gap-2 font-bold text-xs">
                    <i class="fas fa-exclamation-triangle text-rose-500"></i>
                    <span>Terdapat kesalahan pengisian data:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-rose-600 pl-4 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Period Selector Ribbon (Dropdown) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center shrink-0 shadow-xs">
                    <i class="fas fa-calendar-alt text-base"></i>
                </div>
                <div>
                    <label for="period-dropdown" class="block text-[10px] font-black uppercase text-slate-400 tracking-wider">Pilih Periode / Generasi:</label>
                    <div class="relative mt-1">
                        <select id="period-dropdown" 
                                onchange="if(this.value) window.location.href = this.value"
                                class="w-full sm:w-auto sm:min-w-[320px] appearance-none bg-slate-50 hover:bg-slate-100/90 border border-slate-300 focus:border-[#17385c] focus:ring-2 focus:ring-blue-500/20 rounded-xl pl-4 pr-10 py-2.5 text-xs font-extrabold text-slate-800 transition-all cursor-pointer shadow-xs">
                            @foreach($editions as $ed)
                                <option value="{{ route('dashboard.tributes.index', ['edition_id' => $ed->id]) }}" 
                                        {{ ($selectedEdition && $selectedEdition->id === $ed->id) ? 'selected' : '' }}>
                                    Periode {{ $ed->period }} {{ $ed->is_featured ? '★ [Utama di Beranda]' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <button @click="addEditionModalOpen = true" class="px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold flex items-center gap-1.5 transition-colors border border-blue-200/60 shadow-xs">
                    <i class="fas fa-plus-circle text-xs"></i>
                    <span>Tambah Periode Baru</span>
                </button>
                <a href="{{ route('jejak-bakti', ['periode' => $selectedEdition ? $selectedEdition->period : '']) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold flex items-center gap-1.5 transition-colors border border-slate-200 shadow-xs">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    <span>Preview Publik</span>
                </a>
            </div>
        </div>

        @if($selectedEdition)
            <!-- Active Selected Edition Details & Management -->
            <div class="space-y-6">
                <!-- Edition Status Action Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-100 p-4 rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-500">Status di Beranda:</span>
                        @if($selectedEdition->is_featured)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black">
                                <i class="fas fa-check-circle text-emerald-600"></i>
                                <span>Sedang Ditampilkan Sebagai Sorotan Utama di Beranda</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200 text-slate-600 text-xs font-bold">
                                <span>Tersimpan di Arsip Museum</span>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        @if(!$selectedEdition->is_featured)
                            <form action="{{ route('dashboard.tributes.editions.feature', $selectedEdition->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-sm">
                                    <i class="fas fa-star text-amber-300"></i>
                                    <span>Jadikan Sorotan Utama Beranda</span>
                                </button>
                            </form>
                        @endif

                        @if(count($editions) > 1)
                            <form action="{{ route('dashboard.tributes.editions.destroy', $selectedEdition->id) }}" method="POST" onsubmit="return confirm('Hapus seluruh periode {{ $selectedEdition->period }} beserta tokoh dan fotonya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-xl text-xs font-bold transition-all">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                    <span>Hapus Periode Ini</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Tab Selector for Active Edition -->
                <div class="flex items-center gap-2 border-b border-slate-200 pb-3 overflow-x-auto">
                    <button @click="activeTab = 'general'" 
                            :class="activeTab === 'general' ? 'bg-[#17385c] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                            class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-image"></i>
                        <span>Poster & Info Periode ({{ $selectedEdition->period }})</span>
                    </button>
                    <button @click="activeTab = 'figures'" 
                            :class="activeTab === 'figures' ? 'bg-[#17385c] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                            class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-users"></i>
                        <span>Daftar Duta / Tokoh ({{ count($selectedEdition->figures) }})</span>
                    </button>
                    <button @click="activeTab = 'memories'" 
                            :class="activeTab === 'memories' ? 'bg-[#17385c] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                            class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-2 shrink-0">
                        <i class="fas fa-camera-retro"></i>
                        <span>Foto Kenangan & Kilas Balik ({{ count($selectedEdition->memories) }})</span>
                    </button>
                </div>

                <!-- TAB 1: POSTER & INFORMASI PERIODE INI -->
                <div x-show="activeTab === 'general'" x-transition class="space-y-6">
                    <form action="{{ route('dashboard.tributes.editions.update', $selectedEdition->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-[24px] border border-slate-100 shadow-sm space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div>
                                <h2 class="text-base font-extrabold text-slate-800">Poster & Informasi Periode {{ $selectedEdition->period }}</h2>
                                <p class="text-xs text-slate-400">Atur poster resmi, narasi apresiasi, dan teks judul untuk periode ini</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                            <!-- Sisi Kiri: Preview Poster -->
                            <div class="lg:col-span-4 space-y-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Poster Resmi Periode Ini</label>
                                <div class="relative group rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center p-3 text-center min-h-[380px]">
                                    @if($selectedEdition->poster_image)
                                        <img src="{{ asset($selectedEdition->poster_image) }}" alt="Poster Duta GenRe" class="w-full h-auto max-h-[460px] object-contain rounded-xl shadow-md">
                                    @else
                                        <div class="text-slate-400 p-6">
                                            <i class="fas fa-image text-5xl mb-2 text-slate-300"></i>
                                            <p class="text-xs font-medium">Belum ada poster diunggah</p>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="poster_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                    <p class="text-[11px] text-slate-400 mt-1.5"><i class="fas fa-info-circle mr-1"></i>Format PNG, JPG, atau WebP (Kompresi otomatis)</p>
                                </div>
                            </div>

                            <!-- Sisi Kanan: Form Teks & Narasi -->
                            <div class="lg:col-span-8 space-y-5">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tahun / Periode</label>
                                        <input type="text" name="period" value="{{ old('period', $selectedEdition->period) }}" required placeholder="Contoh: 2024 — 2025" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Badge Header</label>
                                        <input type="text" name="badge_title" value="{{ old('badge_title', $selectedEdition->badge_title) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Utama</label>
                                        <input type="text" name="title" value="{{ old('title', $selectedEdition->title) }}" required placeholder="Contoh: Proud Moments Duta GenRe" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Subjudul / Wilayah</label>
                                        <input type="text" name="subtitle" value="{{ old('subtitle', $selectedEdition->subtitle) }}" placeholder="Contoh: Kabupaten Kepulauan Meranti" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Surat & Narasi Apresiasi Pembina (Ringkasan / Kutipan Utama)</label>
                                    <textarea name="appreciation_quote" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs leading-relaxed focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Tuliskan ucapan terima kasih/apresiasi singkat yang tampil langsung pada kartu depan...">{{ old('appreciation_quote', $selectedEdition->appreciation_quote) }}</textarea>
                                    <p class="text-[11px] text-slate-400 mt-1"><i class="fas fa-info-circle mr-1"></i>Kutipan ini tampil di kartu utama halaman Jejak Bakti.</p>
                                </div>

                                <!-- Kisah & Catatan Panjang Perjalanan Duta (Lihat Detail / Cerita Panjang) -->
                                <div class="p-5 rounded-2xl bg-sky-50/50 border border-sky-200/80 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-sky-600 text-white flex items-center justify-center text-xs shadow-xs">
                                                <i class="fas fa-book-open"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Kisah Lengkap / Cerita Panjang Perjalanan Duta</h4>
                                                <p class="text-[11px] text-slate-500">Bisa bercerita panjang, multi-paragraf — Ditampilkan saat pengunjung mengklik tombol <strong>"Lihat Detail / Baca Kisah Lengkap"</strong></p>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-100 text-sky-800 uppercase tracking-wider">Fitur Detail</span>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Cerita / Kisah (Opsional)</label>
                                            <input type="text" name="story_title" value="{{ old('story_title', $selectedEdition->story_title) }}" placeholder="Contoh: Menapaki Jejak Juara: Perjuangan dan Kenangan Manis Duta GenRe 2024" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Isi Cerita Lengkap (Bisa bercerita panjang / beberapa paragraf)</label>
                                            <textarea name="story_content" rows="8" class="w-full px-3.5 py-3 rounded-xl border border-slate-200 text-xs leading-relaxed focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white" placeholder="Ceritakan bagaimana awal mula persiapan mereka, suka duka selama pembekalan dan karantina, perjuangan saat tampil di tingkat kabupaten, momen haru pengumuman pemenang, hingga pesan mendalam untuk generasi penerus PIK-R REQUEST...">{{ old('story_content', $selectedEdition->story_content) }}</textarea>
                                            <p class="text-[10px] text-slate-400 mt-1"><i class="fas fa-keyboard mr-1"></i>Tekan Enter untuk membuat baris / paragraf baru. Teks akan ditampilkan rapi dalam jendela baca khusus dengan musik kenangan.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logo Sekolah & Atribusi Pengirim -->
                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-school text-blue-600 text-sm"></i>
                                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Logo Sekolah & Atribusi Apresiasi</h4>
                                        </div>
                                        <span class="text-[11px] text-slate-400">Tampil di samping surat apresiasi</span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-5 items-center">
                                        <!-- Logo Preview & Input -->
                                        <div class="sm:col-span-5 flex items-center gap-4">
                                            <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 p-2 flex items-center justify-center shrink-0 shadow-xs">
                                                @if($selectedEdition->school_logo)
                                                    <img src="{{ asset($selectedEdition->school_logo) }}" alt="Logo Sekolah" class="w-full h-full object-contain">
                                                @else
                                                    <div class="w-full h-full rounded-xl bg-[#17385c] text-white flex items-center justify-center font-bold text-lg">
                                                        <i class="fas fa-heart text-amber-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="space-y-1 flex-1">
                                                <label class="block text-[11px] font-bold text-slate-700">Unggah Logo Sekolah</label>
                                                <input type="file" name="school_logo" accept="image/*" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                                @if($selectedEdition->school_logo)
                                                    <label class="inline-flex items-center gap-1.5 text-[11px] text-rose-600 font-semibold cursor-pointer mt-0.5">
                                                        <input type="checkbox" name="remove_school_logo" value="1" class="rounded text-rose-600 text-[11px]">
                                                        <span>Hapus logo ini</span>
                                                    </label>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Nama Lembaga & Subteks -->
                                        <div class="sm:col-span-7 space-y-3">
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Organisasi / Pengirim</label>
                                                <input type="text" name="institution_name" value="{{ old('institution_name', $selectedEdition->institution_name ?: 'Keluarga Besar PIK–R REQUEST') }}" placeholder="Contoh: Keluarga Besar PIK–R REQUEST" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Sekolah / Subjudul</label>
                                                <input type="text" name="institution_subtext" value="{{ old('institution_subtext', $selectedEdition->institution_subtext ?: 'SMAN 1 Tasik Putri Puyu — Kabupaten Kepulauan Meranti') }}" placeholder="Contoh: SMAN 1 Tasik Putri Puyu — Kabupaten Kepulauan Meranti" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Audio / Musik Kenangan Backsound -->
                                <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-music text-amber-600 text-sm"></i>
                                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Lagu / Backsound Kenangan Periode Ini</h4>
                                        </div>
                                        <span class="text-[11px] text-amber-700 font-semibold">Opsional (Pemutar Musik Melayang)</span>
                                    </div>

                                    <div class="space-y-4">
                                        <!-- Audio Player Preview if already uploaded -->
                                        @if($selectedEdition->audio_file)
                                            <div class="bg-white p-3.5 rounded-xl border border-amber-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-xs">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                                        <i class="fas fa-play text-xs"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-xs font-bold text-slate-800">{{ $selectedEdition->audio_title ?: 'Lagu Kenangan' }}</h5>
                                                        <p class="text-[11px] text-slate-500 font-medium">{{ $selectedEdition->audio_artist ?: 'Artis / Tanpa Nama' }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center gap-3">
                                                    <audio controls class="h-9 max-w-[240px]">
                                                        <source src="{{ asset($selectedEdition->audio_file) }}">
                                                        Browser Anda tidak mendukung audio.
                                                    </audio>
                                                    
                                                    <label class="inline-flex items-center gap-1.5 text-xs text-rose-600 font-bold cursor-pointer shrink-0 ml-2">
                                                        <input type="checkbox" name="remove_audio" value="1" class="rounded text-rose-600">
                                                        <span>Hapus Lagu</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                                            <div class="sm:col-span-5">
                                                <label class="block text-[11px] font-bold text-slate-700 mb-1">
                                                    {{ $selectedEdition->audio_file ? 'Ganti File Lagu (MP3, WAV, M4A)' : 'Unggah File Lagu (MP3, WAV, M4A)' }}
                                                </label>
                                                <input type="file" name="audio_file" accept="audio/*" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 cursor-pointer">
                                                <p class="text-[10px] text-slate-400 mt-1">Maks. 20MB. Format rekomendasi: .mp3</p>
                                            </div>
                                            <div class="sm:col-span-4">
                                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Lagu</label>
                                                <input type="text" name="audio_title" value="{{ old('audio_title', $selectedEdition->audio_title) }}" placeholder="Contoh: Mars GenRe Indonesia / Sampai Jumpa" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Penyanyi / Pengisi</label>
                                                <input type="text" name="audio_artist" value="{{ old('audio_artist', $selectedEdition->audio_artist) }}" placeholder="Contoh: BKKBN / Instrumental" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex justify-end">
                                    <button type="submit" class="bg-[#17385c] hover:bg-[#102742] text-white px-7 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                                        <i class="fas fa-save"></i>
                                        <span>Simpan Perubahan Periode</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TAB 2: DAFTAR DUTA PERIODE INI -->
                <div x-show="activeTab === 'figures'" x-transition class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
                        <div>
                            <h2 class="text-base font-extrabold text-slate-800">Daftar Duta & Kader Periode {{ $selectedEdition->period }}</h2>
                            <p class="text-xs text-slate-400">Tambahkan atau edit sosok yang berjasa di periode ini</p>
                        </div>
                        <button @click="addFigureModalOpen = true" class="bg-[#1e40af] hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all flex items-center gap-2 shrink-0">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Duta ke Periode Ini</span>
                        </button>
                    </div>

                    <!-- Grid Card Tokoh -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($selectedEdition->figures as $figure)
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-all">
                                <div class="p-6 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider 
                                            @if($figure->badge_color === 'amber') bg-amber-50 text-amber-600 border border-amber-200
                                            @elseif($figure->badge_color === 'sky') bg-sky-50 text-sky-600 border border-sky-200
                                            @elseif($figure->badge_color === 'rose') bg-rose-50 text-rose-600 border border-rose-200
                                            @elseif($figure->badge_color === 'emerald') bg-emerald-50 text-emerald-600 border border-emerald-200
                                            @else bg-purple-50 text-purple-600 border border-purple-200 @endif">
                                            {{ $figure->honor_title }}
                                        </span>
                                        
                                        <div class="flex items-center gap-1.5">
                                            <button @click="
                                                editFigureData = {
                                                    id: {{ $figure->id }},
                                                    name: '{{ addslashes($figure->name) }}',
                                                    honor_title: '{{ addslashes($figure->honor_title) }}',
                                                    period: '{{ addslashes($figure->period ?? '') }}',
                                                    badge_color: '{{ $figure->badge_color }}',
                                                    quote: '{{ addslashes($figure->quote ?? '') }}',
                                                    contribution: '{{ addslashes($figure->contribution ?? '') }}',
                                                    instagram: '{{ addslashes($figure->instagram ?? '') }}',
                                                    order_index: {{ $figure->order_index }},
                                                    is_active: {{ $figure->is_active ? 1 : 0 }}
                                                };
                                                editFigureModalOpen = true;
                                            " class="w-8 h-8 rounded-lg bg-slate-50 text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-all flex items-center justify-center">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>

                                            <form action="{{ route('dashboard.tributes.figures.destroy', $figure->id) }}" method="POST" onsubmit="return confirm('Hapus profil tokoh ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all flex items-center justify-center">
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gradient-to-tr from-slate-800 to-slate-600 border border-slate-200 flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-lg">
                                            @if($figure->photo)
                                                <img src="{{ asset($figure->photo) }}" alt="{{ $figure->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span>{{ strtoupper(substr($figure->name, 0, 2)) }}</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="font-black text-slate-800 text-base truncate">{{ $figure->name }}</h3>
                                            <p class="text-xs text-slate-400 font-semibold">{{ $figure->period ? 'Tahun ' . $figure->period : 'Duta Kehormatan' }}</p>
                                            @if($figure->instagram)
                                                <a href="https://instagram.com/{{ ltrim($figure->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-pink-600 font-bold hover:underline mt-0.5">
                                                    <i class="fab fa-instagram"></i>
                                                    <span>{{ '@' . ltrim($figure->instagram, '@') }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    @if($figure->quote)
                                        @php
                                            $adminCleanQuote = trim($figure->quote, " \t\n\r\0\x0B\"'“”");
                                        @endphp
                                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100 text-slate-600 text-xs italic leading-relaxed line-clamp-3" title="“{{ $adminCleanQuote }}”">
                                            “{{ $adminCleanQuote }}”
                                        </div>
                                    @endif

                                    @if($figure->contribution)
                                        <div>
                                            <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider block mb-1">Jasa & Kontribusi:</span>
                                            <p class="text-xs text-slate-600 leading-relaxed">{{ $figure->contribution }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="px-6 py-3 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-semibold">
                                    <span>Urutan tampil: <strong class="text-slate-700">{{ $figure->order_index }}</strong></span>
                                    <span class="{{ $figure->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                        <i class="fas fa-circle text-[8px] mr-1"></i>{{ $figure->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-2xl border border-slate-100">
                                <i class="fas fa-users-slash text-4xl mb-3 text-slate-300"></i>
                                <p class="text-xs font-semibold">Belum ada profil duta yang ditambahkan di periode {{ $selectedEdition->period }}.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- TAB 3: FOTO KENANGAN PERIODE INI -->
                <div x-show="activeTab === 'memories'" x-transition class="space-y-6">
                    <div class="bg-white p-6 sm:p-8 rounded-[24px] border border-slate-100 shadow-sm space-y-6">
                        <div>
                            <h2 class="text-base font-extrabold text-slate-800">Unggah Momen Kenangan Periode {{ $selectedEdition->period }}</h2>
                            <p class="text-xs text-slate-400">Tambahkan potret dokumentasi saat karantina atau penganugerahan piala di periode ini</p>
                        </div>

                        <form action="{{ route('dashboard.tributes.memories.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-slate-50 p-5 rounded-2xl border border-slate-200">
                            @csrf
                            <input type="hidden" name="tribute_edition_id" value="{{ $selectedEdition->id }}">
                            
                            <div class="md:col-span-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Foto Momen</label>
                                <input type="file" name="image" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-700 cursor-pointer">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Momen</label>
                                <input type="text" name="title" required placeholder="Contoh: Malam Penganugerahan" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Keterangan / Caption</label>
                                <input type="text" name="caption" placeholder="Contoh: Penyerahan piala Juara III" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit" class="w-full bg-[#1e40af] hover:bg-blue-800 text-white py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-1.5">
                                    <i class="fas fa-upload text-xs"></i>
                                    <span>Unggah</span>
                                </button>
                            </div>
                        </form>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 pt-4">
                            @forelse($selectedEdition->memories as $memory)
                                <div class="group relative rounded-xl overflow-hidden border border-slate-200 bg-slate-900 aspect-square shadow-sm">
                                    <img src="{{ asset($memory->image) }}" alt="{{ $memory->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-3 text-white">
                                        <p class="font-bold text-xs leading-tight">{{ $memory->title }}</p>
                                        @if($memory->caption)
                                            <p class="text-[10px] text-white/70 line-clamp-1 mt-0.5">{{ $memory->caption }}</p>
                                        @endif
                                    </div>
                                    <form action="{{ route('dashboard.tributes.memories.destroy', $memory->id) }}" method="POST" onsubmit="return confirm('Hapus foto kenangan ini?')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-rose-600 hover:bg-rose-700 text-white flex items-center justify-center shadow-lg">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="col-span-full py-12 text-center text-slate-400">
                                    <i class="fas fa-camera text-4xl mb-2 text-slate-300"></i>
                                    <p class="text-xs font-semibold">Belum ada foto kenangan di periode {{ $selectedEdition->period }}.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- MODAL 1: TAMBAH PERIODE / TAHUN BARU -->
        <div x-show="addEditionModalOpen" x-transition.opacity class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
            <div @click.away="addEditionModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 max-h-[90vh] overflow-y-auto shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-black text-slate-800 text-lg">Tambah Periode Penghargaan Baru</h3>
                        <p class="text-xs text-slate-400">Misal untuk Duta GenRe tahun berikutnya</p>
                    </div>
                    <button @click="addEditionModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-base"></i>
                    </button>
                </div>

                <form action="{{ route('dashboard.tributes.editions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tahun / Periode</label>
                        <input type="text" name="period" required placeholder="Contoh: 2025 — 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Judul Acara / Apresiasi</label>
                        <input type="text" name="title" placeholder="Contoh: Proud Moments Duta GenRe" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Subjudul / Wilayah</label>
                        <input type="text" name="subtitle" placeholder="Contoh: Kabupaten Kepulauan Meranti" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Upload Poster Resmi Periode Baru</label>
                        <input type="file" name="poster_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-700 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Upload Logo Sekolah / Organisasi (Opsional)</label>
                        <input type="file" name="school_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-700 cursor-pointer">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Unggah Lagu Kenangan (Opsional)</label>
                            <input type="file" name="audio_file" accept="audio/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-800 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Judul Lagu (Opsional)</label>
                            <input type="text" name="audio_title" placeholder="Contoh: Mars GenRe" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Surat & Narasi Apresiasi Singkat (Opsional)</label>
                        <textarea name="appreciation_quote" rows="3" placeholder="Tuliskan kutipan atau apresiasi pembina untuk periode ini..." class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div class="p-3.5 rounded-xl bg-sky-50 border border-sky-100 space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-sky-900">Kisah Lengkap / Cerita Panjang (Bisa diisi sekarang atau nanti)</label>
                        <input type="text" name="story_title" placeholder="Judul Kisah (Opsional)" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <textarea name="story_content" rows="4" placeholder="Ceritakan kisah perjuangan, proses seleksi, atau memoar lengkap untuk generasi ini..." class="w-full px-3 py-2 rounded-lg border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    </div>

                    <div class="pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" checked class="rounded text-blue-600">
                            <span class="text-xs font-bold text-slate-700">Jadikan Periode Ini Sorotan Utama di Beranda</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="addEditionModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50">Batal</button>
                        <button type="submit" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-bold text-xs shadow-md">Simpan Periode Baru</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL 2: TAMBAH DUTA / TOKOH KE PERIODE INI -->
        @if($selectedEdition)
        <div x-show="addFigureModalOpen" x-transition.opacity class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
            <div @click.away="addFigureModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 max-h-[90vh] overflow-y-auto shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-black text-slate-800 text-lg">Tambah Profil Duta</h3>
                        <p class="text-xs text-slate-400">Periode: <strong>{{ $selectedEdition->period }}</strong></p>
                    </div>
                    <button @click="addFigureModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-base"></i>
                    </button>
                </div>

                <form action="{{ route('dashboard.tributes.figures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="tribute_edition_id" value="{{ $selectedEdition->id }}">

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Contoh: M. FAUZAN" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Gelar / Gelar Kehormatan</label>
                            <input type="text" name="honor_title" required placeholder="Contoh: Duta Genre III" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tahun (Opsional)</label>
                            <input type="text" name="period" placeholder="Contoh: 2025" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Warna Badge</label>
                            <select name="badge_color" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="amber">Amber (Emas Juara)</option>
                                <option value="sky">Sky Blue (Biru Prestasi)</option>
                                <option value="rose">Rose (Merah Muda Influencer)</option>
                                <option value="emerald">Emerald (Hijau Inspirasi)</option>
                                <option value="purple">Purple (Ungu Kehormatan)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Instagram (Opsional)</label>
                            <input type="text" name="instagram" placeholder="Contoh: @username" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Foto Personal (Opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kutipan Inspirasi / Quote Kenangan</label>
                        <textarea name="quote" rows="2" placeholder="Kata-kata pesan/kesan untuk generasi PIK-R..." class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Jasa & Kontribusi</label>
                        <textarea name="contribution" rows="2" placeholder="Cerita perjuangan atau advokasi yang mereka bawa..." class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3 items-center pt-2">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Urutan Tampil</label>
                            <input type="number" name="order_index" value="0" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div class="pt-4">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="rounded text-blue-600">
                                <span class="text-xs font-bold text-slate-700">Tampilkan Tokoh</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="addFigureModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50">Batal</button>
                        <button type="submit" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-bold text-xs shadow-md">Simpan Tokoh</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- MODAL 3: EDIT DUTA / TOKOH -->
        <div x-show="editFigureModalOpen" x-transition.opacity class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
            <div @click.away="editFigureModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 max-h-[90vh] overflow-y-auto shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-black text-slate-800 text-lg">Edit Profil Duta</h3>
                    <button @click="editFigureModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-base"></i>
                    </button>
                </div>

                <form :action="'{{ url('dashboard/tributes/figures') }}/' + editFigureData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" x-model="editFigureData.name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Gelar / Kehormatan</label>
                            <input type="text" name="honor_title" x-model="editFigureData.honor_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tahun (Opsional)</label>
                            <input type="text" name="period" x-model="editFigureData.period" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Warna Badge</label>
                            <select name="badge_color" x-model="editFigureData.badge_color" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="amber">Amber (Emas Juara)</option>
                                <option value="sky">Sky Blue (Biru Prestasi)</option>
                                <option value="rose">Rose (Merah Muda Influencer)</option>
                                <option value="emerald">Emerald (Hijau Inspirasi)</option>
                                <option value="purple">Purple (Ungu Kehormatan)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Instagram (Opsional)</label>
                            <input type="text" name="instagram" x-model="editFigureData.instagram" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Ganti Foto Personal (Opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kutipan Inspirasi / Quote Kenangan</label>
                        <textarea name="quote" x-model="editFigureData.quote" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Jasa & Kontribusi</label>
                        <textarea name="contribution" x-model="editFigureData.contribution" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3 items-center pt-2">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Urutan Tampil</label>
                            <input type="number" name="order_index" x-model="editFigureData.order_index" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div class="pt-4">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" :checked="editFigureData.is_active == 1" class="rounded text-blue-600">
                                <span class="text-xs font-bold text-slate-700">Tampilkan Tokoh</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="editFigureModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50">Batal</button>
                        <button type="submit" class="bg-[#17385c] hover:bg-[#102742] text-white px-6 py-2.5 rounded-xl font-bold text-xs shadow-md">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.dashboard>
