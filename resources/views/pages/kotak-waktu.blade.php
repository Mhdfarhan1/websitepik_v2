<x-layouts.app title="{{ $setting->page_title ?? '🔐 Kotak Waktu PIK-R' }} | PIK-R REQUEST">
    @php
        $capsulesJson = $capsules->values()->map(function($c) {
            return [
                'id' => $c->id,
                'title' => $c->title,
                'slug' => $c->slug,
                'creator_generation' => $c->creator_generation,
                'created_date' => $c->formatted_created_date,
                'unlock_date' => $c->formatted_unlock_date,
                'unlock_datetime' => $c->formatted_unlock_date_time,
                'unlock_timestamp' => $c->unlock_timestamp_ms,
                'is_locked' => $c->is_locked,
                'seal_message' => $c->seal_message,
                'theme_color' => $c->theme_color,
                'letters_count' => $c->letters_count ?? $c->letters()->count(),
                'stories_count' => $c->stories_count ?? $c->stories()->count(),
                'photos_count' => $c->photos_count ?? $c->photos()->count(),
                'videos_count' => $c->videos_count ?? $c->videos()->count(),
            ];
        })->toArray();

        $activeCapsuleJson = $activeCapsule ? [
            'id' => $activeCapsule->id,
            'title' => $activeCapsule->title,
            'slug' => $activeCapsule->slug,
            'creator_generation' => $activeCapsule->creator_generation,
            'created_date' => $activeCapsule->formatted_created_date,
            'unlock_date' => $activeCapsule->formatted_unlock_date,
            'unlock_datetime' => $activeCapsule->formatted_unlock_date_time,
            'unlock_timestamp' => $activeCapsule->unlock_timestamp_ms,
            'is_locked' => $activeCapsule->is_locked,
            'seal_message' => $activeCapsule->seal_message,
            'theme_color' => $activeCapsule->theme_color,
            'letters_count' => $activeCapsule->letters->count(),
            'stories_count' => $activeCapsule->stories->count(),
            'photos_count' => $activeCapsule->photos->count(),
            'videos_count' => $activeCapsule->videos->count(),
        ] : null;

        $isAdmin = auth()->check();
    @endphp

    <div class="relative min-h-screen pt-20 bg-slate-50 selection:bg-amber-500 selection:text-white" 
         x-data="kotakWaktuApp(@js($capsulesJson), @js($activeCapsuleJson), @js($isAdmin))">

        <!-- ==================== HEADER BANNER HERO (SAMA DENGAN TEMA JEJAK NAKHODA) ==================== -->
        <div class="relative overflow-hidden border-b border-slate-200">
            <!-- Background Image with Theme Gradient Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ $setting->banner_image ? asset($setting->banner_image) : asset('assets/img/bg_utama.JPG') }}" 
                     alt="Kotak Waktu Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-[#17385c]/95 via-[#17385c]/90 to-[#1e40af]/85 backdrop-blur-[2px]"></div>
            </div>

            <div class="relative z-10 max-w-5xl mx-auto px-4 py-16 sm:py-24 text-center text-white">
                <!-- Badge Pill (Sama persis dengan Jejak Nakhoda) -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/20 border border-amber-300/40 text-amber-300 text-[11px] font-extrabold uppercase tracking-widest mb-4" data-aos="fade-down">
                    <i class="fas fa-hourglass-half text-[10px]"></i>
                    <span>{{ $setting->badge_title ?? 'RUANG ARSIP DIGITAL MASA DEPAN' }}</span>
                </div>

                <!-- Page Title -->
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-4" data-aos="fade-up" data-aos-delay="100">
                    {{ $setting->page_title ?? '🔐 Kotak Waktu PIK-R' }}
                </h1>

                <!-- Subtitle (Kutipan Resmi Sesuai Permintaan) -->
                <p class="text-sm sm:text-base text-amber-300/90 font-bold max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    {{ $setting->subtitle ?? '“Tidak semua cerita harus dibaca hari ini. Beberapa cerita sengaja kita tinggalkan untuk masa depan.”' }}
                </p>

                <!-- Floating Instagram-Style Background Music Pill on Hero (Identik dengan Jejak Nakhoda) -->
                @if($setting->audio_file && $setting->is_audio_active)
                    <div class="mt-8 flex items-center justify-center gap-2" data-aos="fade-up" data-aos-delay="300">
                        <button @click="toggleAudio()" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white text-xs font-bold transition-all cursor-pointer shadow-lg active:scale-95 group backdrop-blur-md">
                            <i class="fas fa-music text-[11px] text-amber-400" :class="audioPlaying ? 'animate-bounce' : ''"></i>
                            <span class="tracking-tight font-extrabold">
                                {{ $setting->audio_title ?: 'Melodi Penjaga Waktu' }}
                                @if($setting->audio_artist)
                                    <span class="text-white/60 font-medium"> • {{ $setting->audio_artist }}</span>
                                @endif
                            </span>
                            <!-- Instagram Equalizer Bars -->
                            <div class="flex items-end gap-0.5 h-3 ml-1.5">
                                <span class="w-0.5 bg-amber-400 rounded-full transition-all duration-300" :class="audioPlaying ? 'animate-pulse h-3' : 'h-1'"></span>
                                <span class="w-0.5 bg-amber-400 rounded-full transition-all duration-300" :class="audioPlaying ? 'animate-pulse h-2' : 'h-2'"></span>
                                <span class="w-0.5 bg-amber-400 rounded-full transition-all duration-300" :class="audioPlaying ? 'animate-pulse h-3.5' : 'h-1.5'"></span>
                            </div>
                            <!-- Play / Pause Icon -->
                            <span class="ml-1 text-[10px] text-white/70 group-hover:text-white">
                                <i class="fas" :class="audioPlaying ? 'fa-pause' : 'fa-play'"></i>
                            </span>
                        </button>

                        <!-- Mute Button -->
                        <button @click="toggleMute()" 
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white/80 text-xs transition-colors cursor-pointer backdrop-blur-md"
                                :title="audioMuted ? 'Bunyikan Musik' : 'Bisukan Musik'">
                            <i class="fas" :class="audioMuted ? 'fa-volume-mute text-rose-400' : 'fa-volume-up'"></i>
                        </button>
                    </div>

                    <audio id="time-capsule-audio-player"
                           src="{{ asset($setting->audio_file) }}"
                           loop
                           preload="auto"
                           @ended="audioPlaying = false"
                           @pause="audioPlaying = false"
                           @play="audioPlaying = true">
                    </audio>
                @endif

                <!-- Golden divider bar sama persis dengan Jejak Nakhoda -->
                <div class="w-20 h-1 bg-amber-400 mx-auto mt-6 rounded-full"></div>
            </div>
        </div>

        <!-- ==================== STICKY BAR: INFO & FILOSOFI ==================== -->
        <div class="sticky top-16 sm:top-20 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs py-3 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs font-black">
                        <i class="fas fa-box-archive"></i>
                    </span>
                    <span class="text-xs sm:text-sm font-extrabold text-slate-800 tracking-tight">
                        Brankas Waktu Digital: <span class="text-blue-600 font-black">{{ count($capsules) }} Edisi Kapsul Terdaftar</span>
                    </span>
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <i class="fas fa-quote-left text-amber-500 text-[10px]"></i>
                    <span class="italic text-slate-600 font-medium">"Menyimpan memori hari ini, membuka lentera inspirasi untuk generasi esok."</span>
                </div>

            </div>
        </div>

        <!-- ==================== MAIN CONTENT CONTAINER ==================== -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-10">

            <!-- Capsule Selector Pills (Clean White / Slate-100 Card) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-3 sm:p-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-slate-600 pl-1">
                    <i class="fas fa-clock-rotate-left text-amber-500"></i>
                    <span>PILIH EDISI KAPSUL:</span>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @forelse($capsules as $c)
                        <a href="{{ route('kotak-waktu', ['kapsul' => $c->slug]) }}"
                           class="px-4 py-2 rounded-xl text-xs font-black transition-all flex items-center gap-2
                                  {{ ($activeCapsule && $activeCapsule->id === $c->id)
                                     ? 'bg-[#17385c] text-white shadow-md ring-2 ring-[#17385c]/20'
                                     : 'bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900 border border-slate-200/60' }}">
                            <span>{{ $c->title }}</span>
                            @if($c->is_locked)
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider {{ ($activeCapsule && $activeCapsule->id === $c->id) ? 'bg-amber-400 text-slate-950' : 'bg-amber-100 text-amber-800' }}">
                                    🔒 Terkunci
                                </span>
                            @else
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider {{ ($activeCapsule && $activeCapsule->id === $c->id) ? 'bg-emerald-400 text-slate-950' : 'bg-emerald-100 text-emerald-800' }}">
                                    🔓 Terbuka
                                </span>
                            @endif
                        </a>
                    @empty
                        <span class="text-xs text-slate-400 py-1">Belum ada kapsul waktu yang dipublikasikan.</span>
                    @endforelse
                </div>
            </div>

            @if($activeCapsule)
                <!-- Admin Preview Toggle Bar (Discreet for logged-in management) -->
                @if($isAdmin)
                    <div class="bg-gradient-to-r from-purple-50 via-indigo-50 to-blue-50 border border-purple-200 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xs">
                        <div class="flex items-center gap-3 text-left">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 border border-purple-200 flex items-center justify-center text-purple-700 shrink-0">
                                <i class="fas fa-shield-halved text-base"></i>
                            </div>
                            <div>
                                <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                    Mode Pratinjau Pengurus (Admin Access)
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-purple-200 text-purple-800 font-black">Authorized</span>
                                </h4>
                                <p class="text-[11px] text-slate-600">
                                    Anda login sebagai pengurus. Aktifkan sakelar ini untuk membuka dan meninjau isi kotak waktu yang masih berstatus terkunci untuk publik.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="adminBypassLock" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                            <span class="text-xs font-bold" :class="adminBypassLock ? 'text-purple-700' : 'text-slate-500'" 
                                  x-text="adminBypassLock ? 'Buka Pratinjau' : 'Kunci Tertutup'"></span>
                        </div>
                    </div>
                @endif

                <!-- ==================== MAIN VAULT SHOWCASE CARD ==================== -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md p-6 sm:p-10 relative overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Left Details (Title, Generation, Metadata) -->
                        <div class="lg:col-span-7 space-y-6">
                            <!-- Status Chip -->
                            <div class="flex flex-wrap items-center gap-2">
                                <template x-if="isCapsuleLocked()">
                                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-300 shadow-xs">
                                        <i class="fas fa-lock text-[11px] text-amber-600"></i>
                                        <span>STATUS: 🔒 TERKUNCI</span>
                                    </span>
                                </template>
                                <template x-if="!isCapsuleLocked()">
                                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-300 shadow-xs">
                                        <i class="fas fa-lock-open text-[11px] text-emerald-600"></i>
                                        <span>STATUS: 🔓 TELAH TERBUKA</span>
                                    </span>
                                </template>
                                <span class="text-xs text-slate-500 font-bold px-1">
                                    Disegel dalam Brankas Digital PIK-R
                                </span>
                            </div>

                            <!-- Capsule Title -->
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-blue-600 block mb-1">
                                    EDISI DIGITAL TIME CAPSULE
                                </span>
                                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                                    {{ $activeCapsule->title }}
                                </h2>
                            </div>

                            <!-- Metadata Box (Exact fields requested by user) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <!-- Dibuat oleh -->
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1.5">
                                        <i class="fas fa-users-gear text-amber-500"></i> Dibuat oleh:
                                    </div>
                                    <div class="text-sm sm:text-base font-extrabold text-slate-900">
                                        {{ $activeCapsule->creator_generation }}
                                    </div>
                                </div>

                                <!-- Tanggal dibuat -->
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1.5">
                                        <i class="fas fa-calendar-check text-blue-500"></i> Tanggal dibuat:
                                    </div>
                                    <div class="text-sm sm:text-base font-extrabold text-slate-900">
                                        {{ $activeCapsule->formatted_created_date }}
                                    </div>
                                </div>

                                <!-- Akan dibuka -->
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 sm:col-span-2">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div>
                                            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1.5">
                                                <i class="fas fa-key text-amber-500"></i> Akan dibuka:
                                            </div>
                                            <div class="text-base sm:text-lg font-black text-[#17385c]">
                                                {{ $activeCapsule->formatted_unlock_date }}
                                            </div>
                                        </div>
                                        <div class="text-xs font-bold">
                                            @if($activeCapsule->is_locked)
                                                <span class="text-amber-700 bg-amber-100/70 px-2.5 py-1 rounded-full">Terkunci otomatis hingga jadwal tiba</span>
                                            @else
                                                <span class="text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-full">Telah melewati tanggal pembukaan</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Seal Message -->
                            @if($activeCapsule->seal_message)
                                <div class="p-4 sm:p-5 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-xs sm:text-sm text-slate-700 leading-relaxed italic relative">
                                    <i class="fas fa-quote-left text-amber-400/40 text-2xl absolute -top-3 left-4"></i>
                                    <p class="relative z-10 pl-3">
                                        {{ $activeCapsule->seal_message }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column (Countdown Vault Display) -->
                        <div class="lg:col-span-5 flex flex-col items-center justify-center">
                            <div class="w-full max-w-md p-6 sm:p-8 rounded-3xl bg-gradient-to-b from-[#17385c] via-[#153455] to-[#0f243a] text-white shadow-xl relative overflow-hidden text-center">
                                
                                <!-- Vault Icon / Animated Lock -->
                                <div class="relative w-20 h-20 mx-auto mb-5 flex items-center justify-center">
                                    <div class="absolute inset-0 rounded-full bg-white/10 blur-sm"
                                         :class="isCapsuleLocked() ? 'animate-pulse' : ''"></div>
                                    <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-3xl shadow-inner text-amber-400">
                                        <i :class="isCapsuleLocked() ? 'fas fa-lock' : 'fas fa-lock-open text-emerald-400'"></i>
                                    </div>
                                </div>

                                <!-- Countdown Header -->
                                <template x-if="isCapsuleLocked()">
                                    <div>
                                        <div class="text-[11px] font-black uppercase tracking-widest text-amber-400 mb-2">
                                            HITUNG MUNDUR MENUJU PEMBUKAAN
                                        </div>
                                        
                                        <!-- Ticking Countdown Grid -->
                                        <div class="grid grid-cols-4 gap-2 sm:gap-2.5 my-4">
                                            <div class="bg-white/10 border border-white/15 rounded-2xl p-2.5">
                                                <div class="text-xl sm:text-2xl font-black text-white" x-text="countdown.days">0</div>
                                                <div class="text-[9px] font-bold uppercase text-slate-300 tracking-wider">Hari</div>
                                            </div>
                                            <div class="bg-white/10 border border-white/15 rounded-2xl p-2.5">
                                                <div class="text-xl sm:text-2xl font-black text-white" x-text="countdown.hours">0</div>
                                                <div class="text-[9px] font-bold uppercase text-slate-300 tracking-wider">Jam</div>
                                            </div>
                                            <div class="bg-white/10 border border-white/15 rounded-2xl p-2.5">
                                                <div class="text-xl sm:text-2xl font-black text-white" x-text="countdown.minutes">0</div>
                                                <div class="text-[9px] font-bold uppercase text-slate-300 tracking-wider">Menit</div>
                                            </div>
                                            <div class="bg-white/10 border border-white/15 rounded-2xl p-2.5">
                                                <div class="text-xl sm:text-2xl font-black text-amber-400" x-text="countdown.seconds">0</div>
                                                <div class="text-[9px] font-bold uppercase text-slate-300 tracking-wider">Detik</div>
                                            </div>
                                        </div>

                                        <p class="text-[11px] text-slate-300 leading-relaxed mt-2 font-medium">
                                            Sistem secara otomatis mengunci seluruh dokumen & kenangan hingga waktu yang ditentukan tiba.
                                        </p>
                                    </div>
                                </template>

                                <template x-if="!isCapsuleLocked()">
                                    <div>
                                        <div class="text-xs font-black uppercase tracking-widest text-emerald-400 mb-1">
                                            SELAMAT DATANG DI MASA DEPAN!
                                        </div>
                                        <h3 class="text-lg font-black text-white mb-2">
                                            Kotak Waktu Telah Dibuka
                                        </h3>
                                        <p class="text-xs text-slate-300 leading-relaxed mb-4">
                                            Pesan, foto, dan cerita yang dititipkan oleh generasi pendahulu kini dapat Anda saksikan secara penuh.
                                        </p>
                                        <a href="#isi-kotak-waktu" 
                                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs transition-all shadow-md">
                                            <span>Jelajahi Arsip Kenangan</span>
                                            <i class="fas fa-arrow-down text-[10px]"></i>
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ==================== VAULT CONTENTS VIEW ==================== -->
                <div id="isi-kotak-waktu" class="space-y-10 scroll-mt-24">

                    <!-- IF LOCKED (and not in admin preview): Show Sealed Vault Teaser Screen -->
                    <div x-show="isCapsuleLocked()" x-transition class="relative">
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-8 sm:p-14 text-center shadow-md relative overflow-hidden">
                            <!-- Glowing Center Vault Icon -->
                            <div class="max-w-2xl mx-auto space-y-6">
                                <div class="w-20 h-20 mx-auto rounded-3xl bg-amber-100 border border-amber-200 flex items-center justify-center text-amber-700 text-3xl shadow-sm">
                                    <i class="fas fa-fingerprint"></i>
                                </div>

                                <div>
                                    <span class="text-xs font-black uppercase tracking-wider text-blue-600 block mb-2">
                                        BRANKAS ARSIP DIGITAL TERKUNCI
                                    </span>
                                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900">
                                        Konten Disegel Hingga {{ $activeCapsule->formatted_unlock_date }}
                                    </h3>
                                    <p class="text-sm text-slate-600 leading-relaxed max-w-xl mx-auto mt-3">
                                        Seluruh pesan rahasia, kronik cerita, rekaman video, serta potret kenangan dari <strong class="text-slate-900">{{ $activeCapsule->creator_generation }}</strong> telah terenkripsi dan disimpan dengan aman. Sistem akan membukanya secara serentak pada tanggal yang telah ditetapkan.
                                    </p>
                                </div>

                                <!-- Teaser Inventory Cards in Clean Light Colors -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                        <i class="fas fa-envelope-open-text text-amber-600 text-lg mb-1 block"></i>
                                        <div class="text-xl font-black text-slate-900">{{ $activeCapsule->letters->count() }}</div>
                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Surat Rahasia</div>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                        <i class="fas fa-book-bookmark text-blue-600 text-lg mb-1 block"></i>
                                        <div class="text-xl font-black text-slate-900">{{ $activeCapsule->stories->count() }}</div>
                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kisah Perjalanan</div>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                        <i class="fas fa-images text-emerald-600 text-lg mb-1 block"></i>
                                        <div class="text-xl font-black text-slate-900">{{ $activeCapsule->photos->count() }}</div>
                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Foto Arsip</div>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                        <i class="fas fa-video text-purple-600 text-lg mb-1 block"></i>
                                        <div class="text-xl font-black text-slate-900">{{ $activeCapsule->videos->count() }}</div>
                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Video Dokumenter</div>
                                    </div>
                                </div>

                                <div class="pt-2 flex items-center justify-center gap-2 text-xs text-slate-500 font-semibold">
                                    <i class="fas fa-shield-halved text-amber-500"></i>
                                    <span>Integritas Arsip Dijamin oleh PIK-R REQUEST SMAN 1 Tasik Putri Puyu</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- IF UNLOCKED (or in admin preview): Show All Contents Tabbed / Categorized -->
                    <div x-show="!isCapsuleLocked()" x-transition class="space-y-12">
                        
                        <!-- Celebration Alert Banner -->
                        <div class="p-5 sm:p-6 rounded-3xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-800 text-xl shrink-0">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                                <div>
                                    <h4 class="text-base sm:text-lg font-black text-slate-900">
                                        Selamat Membaca Surat dari Masa Lalu!
                                    </h4>
                                    <p class="text-xs sm:text-sm text-slate-600 font-medium">
                                        Kapsul waktu ini memuat pesan dan cerita berharga yang diwariskan khusus untuk generasi Anda.
                                    </p>
                                </div>
                            </div>
                            <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase tracking-wider border border-emerald-300 shrink-0">
                                Arsip Terbuka Penuh
                            </span>
                        </div>

                        <!-- 1. PESAN & SURAT UNTUK MASA DEPAN -->
                        <section class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-base">
                                        <i class="fas fa-feather-pointed"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl sm:text-2xl font-black text-slate-900">Surat & Pesan untuk Masa Depan</h3>
                                        <p class="text-xs text-slate-500 font-medium">Untaian kata dan pesan tulus yang dititipkan oleh pengurus terdahulu</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-xs font-extrabold text-slate-700">
                                    {{ $activeCapsule->letters->count() }} Surat
                                </span>
                            </div>

                            @if($activeCapsule->letters->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($activeCapsule->letters as $letter)
                                        <div class="rounded-3xl border border-slate-200/80 bg-white hover:border-amber-400/80 hover:shadow-xl transition-all p-6 flex flex-col justify-between group shadow-sm cursor-pointer"
                                             @click="openLetterModal(@js($letter))">
                                            <div class="space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                                        <i class="fas fa-stamp mr-1 text-amber-600"></i> Surat Resmi
                                                    </span>
                                                    <span class="text-[11px] text-slate-400 font-semibold">
                                                        {{ $activeCapsule->formatted_created_date }}
                                                    </span>
                                                </div>

                                                <h4 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-amber-600 transition-colors line-clamp-2">
                                                    {{ $letter->title }}
                                                </h4>

                                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-4 font-normal">
                                                    {{ $letter->content }}
                                                </p>
                                            </div>

                                            <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between">
                                                <div>
                                                    <div class="text-xs font-extrabold text-slate-900">
                                                        {{ $letter->author_name ?: 'Pengurus PIK-R' }}
                                                    </div>
                                                    <div class="text-[10px] text-slate-500 font-medium">
                                                        {{ $letter->author_role ?: 'Keluarga Besar REQUEST' }}
                                                    </div>
                                                </div>
                                                <button class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-[#17385c] group-hover:text-white flex items-center justify-center text-xs transition-all text-slate-600">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-8 text-center text-slate-400 bg-white rounded-2xl text-xs border border-slate-200">
                                    Belum ada surat tertulis di kotak waktu ini.
                                </div>
                            @endif
                        </section>

                        <!-- 2. CERITA & KISAH PERJALANAN -->
                        <section class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-base">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl sm:text-2xl font-black text-slate-900">Cerita & Rahasia di Balik Layar</h3>
                                        <p class="text-xs text-slate-500 font-medium">Catatan perjuangan dan dinamika kepengurusan yang tak tercatat di laporan resmi</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-xs font-extrabold text-slate-700">
                                    {{ $activeCapsule->stories->count() }} Cerita
                                </span>
                            </div>

                            @if($activeCapsule->stories->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($activeCapsule->stories as $story)
                                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-7 space-y-4 hover:border-blue-300 hover:shadow-xl transition-all shadow-sm">
                                            <div class="flex items-center justify-between">
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-800 border border-blue-200">
                                                    <i class="fas fa-bookmark mr-1 text-blue-600"></i> Kisah Kenangan
                                                </span>
                                                <span class="text-xs text-slate-500 font-bold">
                                                    Oleh: {{ $story->author_name ?: 'Alumni Pengurus' }}
                                                </span>
                                            </div>

                                            <h4 class="text-lg font-black text-slate-900">
                                                {{ $story->title }}
                                            </h4>

                                            <div class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line font-normal">
                                                {{ $story->content }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-8 text-center text-slate-400 bg-white rounded-2xl text-xs border border-slate-200">
                                    Belum ada cerita kenangan di kotak waktu ini.
                                </div>
                            @endif
                        </section>

                        <!-- 3. GALERI FOTO KENANGAN -->
                        <section class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-base">
                                        <i class="fas fa-camera-retro"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl sm:text-2xl font-black text-slate-900">Arsip Foto Kenangan</h3>
                                        <p class="text-xs text-slate-500 font-medium">Potret visual wajah-wajah penuh senyum di masa lalu</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-xs font-extrabold text-slate-700">
                                    {{ $activeCapsule->photos->count() }} Foto
                                </span>
                            </div>

                            @if($activeCapsule->photos->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($activeCapsule->photos as $photo)
                                        <div class="rounded-3xl border border-slate-200/80 bg-white overflow-hidden group shadow-sm hover:shadow-xl transition-all cursor-pointer"
                                             @click="openPhotoModal('{{ asset($photo->media_path) }}', '{{ addslashes($photo->title) }}', '{{ addslashes($photo->content ?? '') }}')">
                                            <div class="relative aspect-video overflow-hidden bg-slate-900">
                                                <img src="{{ asset($photo->media_path) }}" alt="{{ $photo->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-70"></div>
                                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                                    <span class="text-[10px] font-black uppercase tracking-wider text-amber-300 block mb-0.5">
                                                        {{ $photo->author_name ?: 'Foto Dokumentasi' }}
                                                    </span>
                                                    <h5 class="text-sm font-black line-clamp-1">
                                                        {{ $photo->title }}
                                                    </h5>
                                                </div>
                                            </div>
                                            @if($photo->content)
                                                <div class="p-4 text-xs text-slate-600 leading-relaxed font-medium">
                                                    {{ $photo->content }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-8 text-center text-slate-400 bg-white rounded-2xl text-xs border border-slate-200">
                                    Belum ada foto arsip di kotak waktu ini.
                                </div>
                            @endif
                        </section>

                        <!-- 4. VIDEO DOKUMENTASI -->
                        @if($activeCapsule->videos->count() > 0)
                            <section class="space-y-6">
                                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-800 flex items-center justify-center text-base">
                                            <i class="fas fa-clapperboard"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl sm:text-2xl font-black text-slate-900">Video Kenangan & Rekaman Masa Depan</h3>
                                            <p class="text-xs text-slate-500 font-medium">Rekaman suara dan visual langsung dari generasi pembuat kapsul</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-xs font-extrabold text-slate-700">
                                        {{ $activeCapsule->videos->count() }} Video
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($activeCapsule->videos as $video)
                                        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 space-y-4 shadow-sm hover:shadow-lg transition-all">
                                            <h4 class="text-base font-black text-slate-900 flex items-center gap-2">
                                                <i class="fas fa-play-circle text-purple-600"></i>
                                                <span>{{ $video->title }}</span>
                                            </h4>

                                            @if($video->media_path)
                                                <video controls class="w-full rounded-2xl bg-black aspect-video">
                                                    <source src="{{ asset($video->media_path) }}" type="video/mp4">
                                                    Browser Anda tidak mendukung pemutar video HTML5.
                                                </video>
                                            @elseif($video->external_url)
                                                <div class="aspect-video rounded-2xl overflow-hidden bg-black border border-slate-200">
                                                    @php
                                                        $embedUrl = $video->external_url;
                                                        if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                                                            $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                                                        } elseif (str_contains($embedUrl, 'youtu.be/')) {
                                                            $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $embedUrl);
                                                        }
                                                    @endphp
                                                    <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            @endif

                                            @if($video->content)
                                                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                                    {{ $video->content }}
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                    </div>
                </div>

            @else
                <div class="max-w-xl mx-auto px-4 py-20 text-center bg-white rounded-3xl border border-slate-200 shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-2xl mx-auto mb-4 border border-amber-200">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Belum Ada Kotak Waktu</h3>
                    <p class="text-xs text-slate-500 mt-2">Silakan tambahkan kotak waktu pertama melalui dashboard admin.</p>
                </div>
            @endif

        </div>

        <!-- ==================== MODALS ==================== -->
        <!-- Letter Modal (Clean Paper Styling) -->
        <div x-show="letterModalOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
             @keydown.escape.window="letterModalOpen = false">
            <div class="relative w-full max-w-2xl bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-2xl text-slate-900 max-h-[90vh] flex flex-col"
                 @click.outside="letterModalOpen = false">
                <!-- Close Button -->
                <button @click="letterModalOpen = false" 
                        class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-xs transition-colors">
                    <i class="fas fa-times"></i>
                </button>

                <!-- Modal Header -->
                <div class="pr-8 space-y-1 border-b border-slate-100 pb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-600">
                        SURAT DARI MASA LALU • DIBUKA DARI BRANKAS
                    </span>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900" x-text="activeLetter?.title"></h3>
                    <div class="text-xs text-slate-500 flex items-center gap-2 pt-1 font-semibold">
                        <span class="font-extrabold text-[#17385c]" x-text="activeLetter?.author_name || 'Pengurus'"></span>
                        <span>•</span>
                        <span x-text="activeLetter?.author_role || 'PIK-R REQUEST'"></span>
                    </div>
                </div>

                <!-- Modal Body (Letter Paper Aesthetic) -->
                <div class="overflow-y-auto py-5 space-y-4 my-2 text-sm sm:text-base leading-relaxed text-slate-700 font-serif whitespace-pre-line pr-2">
                    <p x-text="activeLetter?.content"></p>
                </div>

                <!-- Modal Footer -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span class="italic font-medium">Disimpan abadi dalam Kotak Waktu PIK-R</span>
                    <button @click="letterModalOpen = false" 
                            class="px-5 py-2 rounded-xl bg-[#17385c] hover:bg-[#1a4473] text-white font-bold transition-colors">
                        Tutup Surat
                    </button>
                </div>
            </div>
        </div>

        <!-- Photo Zoom Lightbox Modal -->
        <div x-show="photoModalOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/85 backdrop-blur-md"
             @keydown.escape.window="photoModalOpen = false">
            <div class="relative max-w-4xl w-full bg-slate-900 border border-white/20 rounded-3xl overflow-hidden shadow-2xl"
                 @click.outside="photoModalOpen = false">
                <button @click="photoModalOpen = false" 
                        class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center text-xs transition-colors">
                    <i class="fas fa-times"></i>
                </button>
                <div class="max-h-[75vh] bg-black flex items-center justify-center">
                    <img :src="activePhotoUrl" :alt="activePhotoTitle" class="max-h-[75vh] w-auto object-contain">
                </div>
                <div class="p-6 bg-slate-900 text-white space-y-1">
                    <h4 class="text-base font-black" x-text="activePhotoTitle"></h4>
                    <p class="text-xs text-slate-300" x-text="activePhotoCaption"></p>
                </div>
            </div>
        </div>

    </div>

    <!-- Alpine.js Application Logic -->
    <script>
        function kotakWaktuApp(capsules, activeCapsule, isAdmin) {
            return {
                capsules: capsules || [],
                activeCapsule: activeCapsule || null,
                isAdmin: !!isAdmin,
                adminBypassLock: false,

                // Audio player state
                audioPlaying: false,
                audioMuted: false,

                // Modals
                letterModalOpen: false,
                activeLetter: null,
                photoModalOpen: false,
                activePhotoUrl: '',
                activePhotoTitle: '',
                activePhotoCaption: '',

                // Countdown timer state
                countdown: {
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0
                },
                countdownInterval: null,

                init() {
                    this.updateCountdown();
                    this.countdownInterval = setInterval(() => {
                        this.updateCountdown();
                    }, 1000);

                    this.$nextTick(() => {
                        this.initAutoplay();
                    });
                },

                initAutoplay() {
                    const audio = document.getElementById('time-capsule-audio-player');
                    if (!audio) return;
                    audio.volume = 0.75;
                    
                    const playPromise = audio.play();
                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            this.audioPlaying = true;
                        }).catch(() => {
                            const startOnInteraction = () => {
                                audio.play().then(() => {
                                    this.audioPlaying = true;
                                }).catch(() => {});
                                window.removeEventListener('click', startOnInteraction);
                                window.removeEventListener('touchstart', startOnInteraction);
                                window.removeEventListener('scroll', startOnInteraction);
                                window.removeEventListener('keydown', startOnInteraction);
                            };
                            window.addEventListener('click', startOnInteraction, { once: true });
                            window.addEventListener('touchstart', startOnInteraction, { once: true });
                            window.addEventListener('scroll', startOnInteraction, { once: true });
                            window.addEventListener('keydown', startOnInteraction, { once: true });
                        });
                    }
                },

                isCapsuleLocked() {
                    if (this.isAdmin && this.adminBypassLock) {
                        return false;
                    }
                    if (!this.activeCapsule) return false;
                    return this.activeCapsule.is_locked;
                },

                updateCountdown() {
                    if (!this.activeCapsule || !this.activeCapsule.unlock_timestamp) {
                        return;
                    }

                    const now = new Date().getTime();
                    const target = this.activeCapsule.unlock_timestamp;
                    const diff = target - now;

                    if (diff <= 0) {
                        this.countdown.days = 0;
                        this.countdown.hours = 0;
                        this.countdown.minutes = 0;
                        this.countdown.seconds = 0;
                        this.activeCapsule.is_locked = false;
                        return;
                    }

                    this.countdown.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    this.countdown.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60));
                    this.countdown.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    this.countdown.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                },

                toggleAudio() {
                    const audio = document.getElementById('time-capsule-audio-player');
                    if (!audio) return;

                    if (this.audioPlaying) {
                        audio.pause();
                        this.audioPlaying = false;
                    } else {
                        audio.play().then(() => {
                            this.audioPlaying = true;
                        }).catch(e => {
                            console.error('Audio play error:', e);
                        });
                    }
                },

                toggleMute() {
                    const audio = document.getElementById('time-capsule-audio-player');
                    if (!audio) return;
                    this.audioMuted = !this.audioMuted;
                    audio.muted = this.audioMuted;
                },

                openLetterModal(letter) {
                    this.activeLetter = letter;
                    this.letterModalOpen = true;
                },

                openPhotoModal(url, title, caption) {
                    this.activePhotoUrl = url;
                    this.activePhotoTitle = title;
                    this.activePhotoCaption = caption;
                    this.photoModalOpen = true;
                }
            };
        }
    </script>
</x-layouts.app>
