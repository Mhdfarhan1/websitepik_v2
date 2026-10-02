<x-layouts.app title="{{ $setting->page_title ?? 'Jejak Rasa — Kata yang Belum Sempat Terucap' }} | PIK-R REQUEST">
    @php
        $messagesJson = $messages->values()->map(function($m) {
            return [
                'id' => $m->id,
                'sender_name' => $m->sender_name,
                'sender_role' => $m->sender_role,
                'recipient_name' => $m->recipient_name,
                'generation' => $m->generation,
                'category' => $m->category,
                'category_label' => $m->category_label,
                'category_color' => $m->category_color,
                'message' => $m->message,
                'paper_theme' => $m->paper_theme,
                'hug_count' => $m->hug_count,
                'is_pinned' => (bool)$m->is_pinned,
                'created_at_human' => $m->created_at ? $m->created_at->translatedFormat('d F Y') : '',
            ];
        })->toArray();

        $silentMomentsJson = $silentMoments->values()->map(function($sm) {
            return [
                'id' => $sm->id,
                'title' => $sm->title,
                'subtitle' => $sm->subtitle,
                'period' => $sm->period,
                'photo' => $sm->photo ? asset($sm->photo) : null,
                'narrative' => $sm->narrative,
            ];
        })->toArray();

        $farewellLettersJson = $farewellLetters->values()->map(function($fl) {
            return [
                'id' => $fl->id,
                'generation_title' => $fl->generation_title,
                'period' => $fl->period,
                'author_representative' => $fl->author_representative,
                'cover_photo' => $fl->cover_photo ? asset($fl->cover_photo) : null,
                'excerpt' => $fl->excerpt,
                'letter_content' => $fl->letter_content,
            ];
        })->toArray();
    @endphp

    <div class="relative min-h-screen pt-20 bg-slate-50 selection:bg-amber-500 selection:text-white"
         x-data="jejakRasaApp(@js($messagesJson), @js($silentMomentsJson), @js($farewellLettersJson))">

        <!-- ==================== HEADER BANNER HERO (PERSIS SAMA DENGAN JEJAK NAKHODA & JEJAK BAKTI) ==================== -->
        <div class="relative overflow-hidden border-b border-slate-200">
            <!-- Background Image with Theme Gradient Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ $setting->banner_image ? asset($setting->banner_image) : asset('assets/img/bg_utama.JPG') }}" 
                     alt="Jejak Rasa Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-[#17385c]/95 via-[#17385c]/90 to-[#1e40af]/85 backdrop-blur-[2px]"></div>
            </div>

            <div class="relative z-10 max-w-5xl mx-auto px-4 py-16 sm:py-24 text-center text-white">
                <!-- Badge Pill (Sama persis dengan Jejak Nakhoda) -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/20 border border-amber-300/40 text-amber-300 text-[11px] font-extrabold uppercase tracking-widest mb-4">
                    <i class="fas fa-feather-pointed text-[10px]"></i>
                    <span>{{ $setting->badge_title ?? 'BILIK NOSTALGIA & SUASANA HATI' }}</span>
                </div>
                
                <!-- Page Title -->
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-4">
                    {{ $setting->page_title ?? 'Jejak Rasa — Kata yang Belum Sempat Terucap' }}
                </h1>
                
                <!-- Subtitle (Kutipan Resmi) -->
                <p class="text-sm sm:text-base text-amber-300/90 font-bold max-w-2xl mx-auto leading-relaxed">
                    {{ $setting->subtitle ?? 'Panggung suara hati, permohonan maaf, rasa terima kasih, dan sudut sekretariat yang kini telah sunyi bagi seluruh keluarga besar PIK-R REQUEST SMAN 1 Tasik Putri Puyu.' }}
                </p>

                <!-- Floating Instagram-Style Background Music Pill on Hero (Identik dengan Jejak Nakhoda) -->
                @if($setting->audio_file && $setting->is_audio_active)
                    <div class="mt-8 flex items-center justify-center gap-2">
                        <button @click="toggleAudio()" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white text-xs font-bold transition-all cursor-pointer shadow-lg active:scale-95 group backdrop-blur-md">
                            <i class="fas fa-music text-[11px] text-amber-400" :class="audioPlaying ? 'animate-bounce' : ''"></i>
                            <span class="tracking-tight font-extrabold">
                                {{ $setting->audio_title ?: 'Alunan Kenangan & Rindu' }}
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

                    <audio id="jejak-rasa-audio-player"
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

        <!-- ==================== STICKY BAR: INFO & FILOSOFI (SAMA DENGAN JEJAK NAKHODA) ==================== -->
        <div class="sticky top-16 sm:top-20 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs py-3 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs font-black">
                        <i class="fas fa-feather-pointed text-amber-700"></i>
                    </span>
                    <span class="text-xs sm:text-sm font-extrabold text-slate-800 tracking-tight">
                        Untaian Jejak Rasa: <span class="text-blue-600 font-black">{{ count($messages) }} Surat & Catatan Tersimpan</span>
                    </span>
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <i class="fas fa-quote-left text-amber-500 text-[10px]"></i>
                    <span class="italic text-slate-600 font-medium">"Kisah masa abu-abu mungkin telah usai, namun jejak rasanya tertinggal abadi."</span>
                </div>

            </div>
        </div>

        <!-- ==================== MAIN CONTENT CONTAINER ==================== -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

            <!-- Section Navigation Tabs -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
                
                <!-- Tab Buttons (Clean White & Navy Style) -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                    <button @click="activeTab = 'letters'"
                            :class="activeTab === 'letters' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 font-bold'"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all flex items-center gap-2 shrink-0 cursor-pointer">
                        <i class="fas fa-envelope-open-text text-amber-400"></i>
                        <span>Kata Tak Terucap</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black"
                              :class="activeTab === 'letters' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'"
                              x-text="messages.length"></span>
                    </button>

                    <button @click="activeTab = 'moments'"
                            :class="activeTab === 'moments' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 font-bold'"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all flex items-center gap-2 shrink-0 cursor-pointer">
                        <i class="fas fa-camera-retro text-amber-400"></i>
                        <span>Ruang yang Kini Sunyi</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black"
                              :class="activeTab === 'moments' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'"
                              x-text="silentMoments.length"></span>
                    </button>

                    <button @click="activeTab = 'farewells'"
                            :class="activeTab === 'farewells' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 font-bold'"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all flex items-center gap-2 shrink-0 cursor-pointer">
                        <i class="fas fa-scroll text-amber-400"></i>
                        <span>Surat Pamit Angkatan</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black"
                              :class="activeTab === 'farewells' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'"
                              x-text="farewellLetters.length"></span>
                    </button>
                </div>

                <!-- Right Sub-Title -->
                <div class="text-right hidden lg:block">
                    <span class="text-xs font-black uppercase tracking-wider text-blue-600">Bilik Kenangan Abadi</span>
                    <p class="text-[11px] text-slate-500 font-medium">PIK-R REQUEST SMAN 1 Tasik Putri Puyu</p>
                </div>
            </div>

            <!-- ==================== TAB 1: KATA YANG TAK SEMPAT TERUCAP ==================== -->
            <div x-show="activeTab === 'letters'" class="space-y-8">
                
                <!-- Filter & Search Controls (Clean Light Card) -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-sm space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        
                        <!-- Search Input -->
                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" 
                                   x-model="searchQuery" 
                                   placeholder="Cari nama sahabat, angkatan, atau kutipan kenangan..."
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-[#17385c] focus:ring-2 focus:ring-blue-500/10 text-xs text-slate-800 placeholder-slate-400 transition-all font-medium">
                        </div>

                        <!-- Generation Filter -->
                        <div class="w-full md:w-64">
                            <select x-model="selectedGeneration" 
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-[#17385c] text-xs font-bold text-slate-800 cursor-pointer">
                                <option value="all">Semua Angkatan / Generasi</option>
                                @foreach($generations as $gen)
                                    <option value="{{ $gen }}">{{ $gen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Category Pills -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 no-scrollbar text-xs pt-1">
                        <button @click="selectedCategory = 'all'" 
                                :class="selectedCategory === 'all' ? 'bg-[#17385c] text-white font-extrabold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold'"
                                class="px-3.5 py-1.5 rounded-xl transition-all shrink-0 cursor-pointer">
                            Semua Rasa
                        </button>
                        <button @click="selectedCategory = 'terima_kasih'" 
                                :class="selectedCategory === 'terima_kasih' ? 'bg-amber-500 text-white font-extrabold shadow-xs' : 'bg-amber-50 text-amber-800 border border-amber-200 font-bold'"
                                class="px-3.5 py-1.5 rounded-xl transition-all shrink-0 cursor-pointer">
                            ❤️ Terima Kasih
                        </button>
                        <button @click="selectedCategory = 'maaf'" 
                                :class="selectedCategory === 'maaf' ? 'bg-rose-600 text-white font-extrabold shadow-xs' : 'bg-rose-50 text-rose-800 border border-rose-200 font-bold'"
                                class="px-3.5 py-1.5 rounded-xl transition-all shrink-0 cursor-pointer">
                            🥀 Permohonan Maaf
                        </button>
                        <button @click="selectedCategory = 'rindu'" 
                                :class="selectedCategory === 'rindu' ? 'bg-sky-600 text-white font-extrabold shadow-xs' : 'bg-sky-50 text-sky-800 border border-sky-200 font-bold'"
                                class="px-3.5 py-1.5 rounded-xl transition-all shrink-0 cursor-pointer">
                            🌙 Rindu Masa Putih Abu-Abu
                        </button>
                        <button @click="selectedCategory = 'pesan_adik'" 
                                :class="selectedCategory === 'pesan_adik' ? 'bg-emerald-600 text-white font-extrabold shadow-xs' : 'bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold'"
                                class="px-3.5 py-1.5 rounded-xl transition-all shrink-0 cursor-pointer">
                            🌱 Pesan untuk Adik Kelas
                        </button>
                        <button @click="selectedCategory = 'catatan_pembina'" 
                                :class="selectedCategory === 'catatan_pembina' ? 'bg-purple-600 text-white font-extrabold shadow-xs' : 'bg-purple-50 text-purple-800 border border-purple-200 font-bold'"
                                class="px-3.5 py-1.5 rounded-xl transition-all shrink-0 cursor-pointer">
                            🪴 Catatan & Doa Pembina
                        </button>
                    </div>
                </div>

                <!-- Cards Grid (Clean White Style Matching Jejak Nakhoda) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    <template x-for="item in filteredMessages" :key="item.id">
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                            
                            <div class="p-6 sm:p-7 space-y-4">
                                <!-- Top Tag & Pin -->
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider"
                                          :class="getCategoryBadgeClass(item.category)"
                                          x-text="item.category_label"></span>

                                    <template x-if="item.is_pinned">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-extrabold">
                                            <i class="fas fa-thumbtack text-[9px] text-amber-600"></i>
                                            <span>Disematkan</span>
                                        </span>
                                    </template>
                                </div>

                                <!-- Recipient Details -->
                                <div>
                                    <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors leading-snug"
                                        x-text="item.recipient_name"></h3>
                                    <template x-if="item.generation">
                                        <p class="text-[11px] font-bold text-slate-400 mt-0.5" x-text="item.generation"></p>
                                    </template>
                                </div>

                                <!-- Message Quote Box (Sama Persis dengan Quote Box di Jejak Bakti) -->
                                <div class="bg-amber-50/60 p-4 rounded-2xl border border-amber-100/80 text-slate-700 text-xs sm:text-sm leading-relaxed relative flex flex-col justify-between">
                                    <i class="fas fa-quote-left text-amber-400/40 absolute top-2.5 right-3 text-sm"></i>
                                    <p class="whitespace-pre-line line-clamp-5 text-slate-700 font-medium italic relative z-10" x-text="item.message"></p>

                                    <template x-if="item.message.length > 200">
                                        <div class="mt-3 pt-2 border-t border-amber-200/60 flex items-center justify-between">
                                            <button @click="openLetterDetail(item)"
                                                    class="inline-flex items-center gap-1 text-[11px] font-extrabold text-blue-600 hover:text-blue-800 hover:underline cursor-pointer">
                                                <span>Baca Selengkapnya</span>
                                                <i class="fas fa-arrow-right text-[9px]"></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Footer Sender & Hug Interaction -->
                            <div class="px-6 sm:px-7 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                                <div class="min-w-0 pr-2">
                                    <p class="font-extrabold text-slate-800 text-xs truncate" x-text="item.sender_name"></p>
                                    <template x-if="item.sender_role">
                                        <p class="text-[10px] text-slate-400 truncate" x-text="item.sender_role"></p>
                                    </template>
                                </div>

                                <!-- Hug Reaction Button -->
                                <button @click="sendHug(item)"
                                        :class="hasHugged(item.id) ? 'bg-rose-600 text-white' : 'bg-white hover:bg-rose-50 text-slate-600 hover:text-rose-600 border border-slate-200'"
                                        class="shrink-0 px-3 py-1.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-1.5 cursor-pointer shadow-xs active:scale-95 group/hug"
                                        title="Kirim rasa haru / pelukan hangat untuk surat ini">
                                    <i class="fas fa-heart text-[11px]" :class="hasHugged(item.id) ? 'text-white' : 'text-rose-500 group-hover/hug:scale-125 transition-transform'"></i>
                                    <span x-text="item.hug_count"></span>
                                    <span class="text-[10px] hidden sm:inline" x-text="hasHugged(item.id) ? 'Terpeluk' : 'Peluk'"></span>
                                </button>
                            </div>

                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <div x-show="filteredMessages.length === 0" class="py-16 text-center bg-white rounded-3xl border border-slate-200">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-700">Belum Ada Surat yang Cocok</h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Coba ganti kata kunci pencarian atau kategori rasa untuk melihat surat lainnya.</p>
                </div>

            </div>

            <!-- ==================== TAB 2: RUANG YANG KINI SUNYI ==================== -->
            <div x-show="activeTab === 'moments'" class="space-y-10" style="display: none;">
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-blue-600">Dokumentasi & Kilas Balik</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Ruang yang Kini Sunyi</h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">Potret dan kenangan di balik pintu sekretariat yang dulu riuh dengan tawa, kini menyisakan jejak langkah kita</p>
                </div>

                <div class="space-y-8 max-w-5xl mx-auto">
                    <template x-for="(moment, idx) in silentMoments" :key="moment.id">
                        <div class="bg-white rounded-3xl sm:rounded-[2.5rem] border border-slate-200/80 shadow-md p-6 sm:p-10 flex flex-col md:flex-row gap-8 items-center group">
                            
                            <!-- Moment Photo Frame -->
                            <div class="w-full md:w-5/12 aspect-[4/3] rounded-2xl sm:rounded-3xl overflow-hidden bg-slate-900 border-4 border-amber-400/20 relative shrink-0 shadow-lg flex items-center justify-center">
                                <template x-if="moment.photo">
                                    <img :src="moment.photo" :alt="moment.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                </template>
                                <template x-if="!moment.photo">
                                    <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-[#17385c] text-white">
                                        <i class="fas fa-door-closed text-4xl mb-3 text-amber-400"></i>
                                        <span class="text-xs font-black">Ruang Sekretariat PIK-R</span>
                                        <span class="text-[10px] text-amber-300 mt-1">SMAN 1 Tasik Putri Puyu</span>
                                    </div>
                                </template>
                                <div class="absolute bottom-3 left-3 px-3 py-1 rounded-lg bg-black/70 backdrop-blur-sm text-[10px] font-black text-amber-300">
                                    <span x-text="moment.period || 'Momen Abadi'"></span>
                                </div>
                            </div>

                            <!-- Narrative Content -->
                            <div class="w-full md:w-7/12 space-y-4">
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-black uppercase tracking-wider inline-block mb-1.5" x-text="'Momen #' + (idx + 1)"></span>
                                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight" x-text="moment.title"></h3>
                                    <template x-if="moment.subtitle">
                                        <p class="text-xs font-semibold text-slate-500 mt-1" x-text="moment.subtitle"></p>
                                    </template>
                                </div>

                                <div class="p-5 rounded-2xl bg-amber-50/50 border border-amber-100/80 text-xs sm:text-sm text-slate-700 leading-relaxed italic">
                                    <p class="whitespace-pre-line" x-text="moment.narrative"></p>
                                </div>
                            </div>

                        </div>
                    </template>
                </div>

            </div>

            <!-- ==================== TAB 3: SURAT PAMIT ANGKATAN ==================== -->
            <div x-show="activeTab === 'farewells'" class="space-y-10" style="display: none;">
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-black uppercase tracking-wider text-blue-600">Wasiat & Pesan Purna Tugas</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Surat Pamit Demisioner</h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">Surat terbuka resmi dari generasi yang telah purna tugas saat menyerahkan estafet kepemimpinan kepada generasi baru</p>
                </div>

                <div class="space-y-8 max-w-4xl mx-auto">
                    <template x-for="farewell in farewellLetters" :key="farewell.id">
                        <div class="bg-white rounded-3xl sm:rounded-[2.5rem] border border-slate-200/80 p-6 sm:p-10 shadow-lg space-y-6">
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-black uppercase tracking-wider inline-block mb-1.5" x-text="farewell.period"></span>
                                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight" x-text="farewell.generation_title"></h3>
                                    <p class="text-xs font-semibold text-slate-500 mt-0.5" x-text="'Oleh: ' + (farewell.author_representative || 'Pengurus Demisioner')"></p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl shrink-0">
                                    <i class="fas fa-feather-alt text-amber-600"></i>
                                </div>
                            </div>

                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-700 leading-relaxed font-serif">
                                <p class="whitespace-pre-line" x-text="farewell.letter_content"></p>
                            </div>

                            <div class="flex items-center justify-between text-xs text-slate-400 pt-2 border-t border-slate-100">
                                <span>Tersimpan abadi di Bilik Jejak Rasa</span>
                                <span class="font-extrabold text-[#17385c]">PIK-R REQUEST SMAN 1 Tasik Putri Puyu</span>
                            </div>

                        </div>
                    </template>
                </div>

            </div>

        </div>

        <!-- ==================== MODAL BACA DETAIL SURAT ==================== -->
        <div x-show="detailModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @keydown.escape.window="detailModalOpen = false"
             class="fixed inset-0 z-[120] bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto"
             style="display: none;">
            
            <div @click.away="detailModalOpen = false" 
                 class="relative w-full max-w-2xl bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden my-8">
                
                <template x-if="selectedLetter">
                    <div class="p-6 sm:p-10 space-y-6">
                        <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                            <div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider inline-block mb-1.5"
                                      :class="getCategoryBadgeClass(selectedLetter.category)"
                                      x-text="selectedLetter.category_label"></span>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900" x-text="selectedLetter.recipient_name"></h3>
                                <template x-if="selectedLetter.generation">
                                    <p class="text-xs font-bold text-slate-400 mt-0.5" x-text="selectedLetter.generation"></p>
                                </template>
                            </div>
                            <button @click="detailModalOpen = false" class="text-slate-400 hover:text-slate-700 p-2 cursor-pointer">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Letter Content -->
                        <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-100/80 text-sm sm:text-base leading-relaxed whitespace-pre-line text-slate-700 italic font-medium"
                             x-text="selectedLetter.message"></div>

                        <!-- Footer -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-extrabold text-slate-900" x-text="'Dari: ' + selectedLetter.sender_name"></p>
                                <template x-if="selectedLetter.sender_role">
                                    <p class="text-xs text-slate-400" x-text="selectedLetter.sender_role"></p>
                                </template>
                            </div>

                            <button @click="sendHug(selectedLetter)"
                                    :class="hasHugged(selectedLetter.id) ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-700'"
                                    class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2 cursor-pointer">
                                <i class="fas fa-heart text-xs" :class="hasHugged(selectedLetter.id) ? 'text-white' : 'text-rose-500'"></i>
                                <span x-text="selectedLetter.hug_count + ' Pelukan'"></span>
                            </button>
                        </div>
                    </div>
                </template>

            </div>
        </div>

    </div>

    <!-- Alpine.js Application -->
    <script>
        function jejakRasaApp(initialMessages, initialSilentMoments, initialFarewells) {
            return {
                messages: initialMessages,
                silentMoments: initialSilentMoments,
                farewellLetters: initialFarewells,
                activeTab: 'letters',
                searchQuery: '',
                selectedGeneration: 'all',
                selectedCategory: 'all',
                detailModalOpen: false,
                selectedLetter: null,

                // Audio player state
                audioElement: null,
                audioPlaying: false,
                audioMuted: false,

                // Local hugs storage
                huggedIds: JSON.parse(localStorage.getItem('hugged_letters') || '[]'),

                init() {
                    this.audioElement = document.getElementById('jejak-rasa-audio-player');
                    if (this.audioElement) {
                        this.audioElement.volume = 0.5;
                    }
                },

                toggleAudio() {
                    if (!this.audioElement) return;
                    if (this.audioPlaying) {
                        this.audioElement.pause();
                        this.audioPlaying = false;
                    } else {
                        this.audioElement.play().then(() => {
                            this.audioPlaying = true;
                        }).catch(() => {
                            this.audioPlaying = false;
                        });
                    }
                },

                toggleMute() {
                    if (!this.audioElement) return;
                    this.audioMuted = !this.audioMuted;
                    this.audioElement.muted = this.audioMuted;
                },

                get filteredMessages() {
                    return this.messages.filter(m => {
                        const matchCat = (this.selectedCategory === 'all') || (m.category === this.selectedCategory);
                        const matchGen = (this.selectedGeneration === 'all') || (m.generation === this.selectedGeneration);
                        const q = this.searchQuery.toLowerCase().trim();
                        const matchSearch = !q || 
                            m.message.toLowerCase().includes(q) ||
                            m.recipient_name.toLowerCase().includes(q) ||
                            m.sender_name.toLowerCase().includes(q) ||
                            (m.sender_role && m.sender_role.toLowerCase().includes(q));
                        return matchCat && matchGen && matchSearch;
                    });
                },

                openLetterDetail(item) {
                    this.selectedLetter = item;
                    this.detailModalOpen = true;
                },

                hasHugged(id) {
                    return this.huggedIds.includes(id);
                },

                sendHug(item) {
                    if (this.hasHugged(item.id)) return;

                    fetch(`/api/jejak-rasa/${item.id}/peluk`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            item.hug_count = data.hug_count;
                            this.huggedIds.push(item.id);
                            localStorage.setItem('hugged_letters', JSON.stringify(this.huggedIds));
                        }
                    })
                    .catch(err => console.error(err));
                },

                getCategoryBadgeClass(category) {
                    switch(category) {
                        case 'terima_kasih': return 'bg-amber-50 text-amber-800 border border-amber-200';
                        case 'maaf': return 'bg-rose-50 text-rose-800 border border-rose-200';
                        case 'rindu': return 'bg-sky-50 text-sky-800 border border-sky-200';
                        case 'pesan_adik': return 'bg-emerald-50 text-emerald-800 border border-emerald-200';
                        case 'catatan_pembina': return 'bg-purple-50 text-purple-800 border border-purple-200';
                        default: return 'bg-slate-100 text-slate-700 border border-slate-200';
                    }
                }
            };
        }
    </script>
</x-layouts.app>
