<x-layouts.app title="{{ $setting->page_title ?? 'Jejak Nakhoda — Hall of Fame Ketua' }} | PIK-R REQUEST">
    @php
        $periods = $leaders->pluck('period')->filter()->unique()->values();
        $leadersJson = $leaders->values()->map(function($l) {
            return [
                'id' => $l->id,
                'name' => $l->name,
                'period' => $l->period,
                'generation' => $l->generation,
                'title_badge' => $l->title_badge,
                'status' => $l->status,
                'photo' => $l->photo ? asset($l->photo) : null,
                'quote' => trim($l->quote ?? '', " \t\n\r\0\x0B\"'“”"),
                'story' => $l->story,
                'experience' => $l->experience,
                'hope' => $l->hope,
                'instagram' => $l->instagram ? ltrim($l->instagram, '@') : null,
            ];
        })->toArray();
    @endphp

    <div class="relative min-h-screen pt-20 bg-slate-50" x-data="jejakKetuaApp()">
        
        <!-- Header Banner Hero -->
        <div class="relative overflow-hidden border-b border-slate-200">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('assets/img/bg_utama.JPG') }}" alt="Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-[#17385c]/95 via-[#17385c]/90 to-[#1e40af]/85 backdrop-blur-[2px]"></div>
            </div>

            <div class="relative z-10 max-w-5xl mx-auto px-4 py-16 sm:py-24 text-center text-white">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/20 border border-amber-300/40 text-amber-300 text-[11px] font-extrabold uppercase tracking-widest mb-4">
                    <i class="fas fa-crown text-[10px]"></i>
                    <span>{{ $setting->badge_title ?? 'ESTAFET KEPEMIMPINAN & DEDIKASI' }}</span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-4">
                    {{ $setting->page_title ?? 'Jejak Nakhoda PIK-R REQUEST' }}
                </h1>
                
                <p class="text-sm sm:text-base text-amber-300/90 font-bold max-w-2xl mx-auto leading-relaxed">
                    {{ $setting->subtitle ?? 'Panggung kehormatan dan rekam jejak para Ketua yang telah mendedikasikan waktu, jiwa, dan raganya menakhodai perjalanan PIK-R REQUEST dari masa ke masa.' }}
                </p>

                <!-- Floating / Instagram-Style Background Music Pill on Hero -->
                @if($setting->audio_file && $setting->is_audio_active)
                    <div class="mt-8 flex items-center justify-center gap-2">
                        <button @click="toggleAudio()" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white text-xs font-bold transition-all cursor-pointer shadow-lg active:scale-95 group backdrop-blur-md">
                            <i class="fas fa-music text-[11px] text-amber-400" :class="audioPlaying ? 'animate-bounce' : ''"></i>
                            <span class="tracking-tight font-extrabold">
                                {{ $setting->audio_title ?: 'Musik Kenangan Pemimpin' }}
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
                @endif

                <div class="w-20 h-1 bg-amber-400 mx-auto mt-6 rounded-full"></div>
            </div>
        </div>

        <!-- Sticky Bar: Total Nakhoda & Quick Philosophy -->
        <div class="sticky top-16 sm:top-20 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs py-3 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs font-black">
                        <i class="fas fa-compass"></i>
                    </span>
                    <span class="text-xs sm:text-sm font-extrabold text-slate-800 tracking-tight">
                        Estafet Kepemimpinan: <span class="text-blue-600 font-black">{{ count($leaders) }} Generasi Nakhoda</span>
                    </span>
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <i class="fas fa-quote-left text-amber-500 text-[10px]"></i>
                    <span class="italic text-slate-600 font-medium">"Satu nahkoda berganti, lentera pengabdian tak pernah padam."</span>
                </div>

            </div>
        </div>

        <!-- Main Content Grid of Leaders -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-black uppercase tracking-wider text-blue-600">Panggung Kehormatan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Para Nakhoda Masa ke Masa</h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                    Setiap periode melahirkan cerita, keteguhan hati, dan legacy berharga bagi keluarga besar PIK-R REQUEST SMAN 1 Tasik Putri Puyu
                </p>
            </div>

            <!-- Grid Leaders Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 items-stretch">
                @forelse($leaders as $leader)
                    @php
                        $cleanQuote = trim($leader->quote ?? '', " \t\n\r\0\x0B\"'“”");
                    @endphp
                    <div x-show="selectedPeriod === 'all' || selectedPeriod === '{{ $leader->period }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="bg-white rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                        
                        <!-- Top Photo Showcase with Fixed Proportion -->
                        <div class="p-4 sm:p-5 pb-0">
                            <!-- Top Status Row -->
                            <div class="flex items-center justify-between gap-2 mb-3.5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                    {{ $leader->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                    <i class="fas {{ $leader->status === 'aktif' ? 'fa-bolt text-emerald-500' : 'fa-crown text-amber-500' }} mr-1"></i>
                                    {{ $leader->title_badge }}
                                </span>
                                
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                    {{ $leader->period }}
                                </span>
                            </div>

                            <!-- Photo Container with fixed height, rounded corners, and crisp cropping -->
                            <div class="relative w-full h-64 sm:h-72 rounded-2xl overflow-hidden bg-slate-900 cursor-pointer group/photo shadow-sm border border-slate-100"
                                 @click="openLeaderDetail({{ $loop->index }})">
                                @if($leader->photo)
                                    <img src="{{ asset($leader->photo) }}" alt="{{ $leader->name }}" 
                                         class="w-full h-full object-cover object-top group-hover/photo:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-[#17385c] via-[#1e3a5f] to-blue-700 flex flex-col items-center justify-center text-white">
                                        <span class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center text-2xl font-black mb-2 shadow-inner">
                                            {{ strtoupper(substr($leader->name, 0, 2)) }}
                                        </span>
                                        <span class="text-xs font-bold text-amber-300 uppercase tracking-widest">{{ $leader->generation ?: 'Nakhoda' }}</span>
                                    </div>
                                @endif

                                <!-- Gradient overlay at bottom of photo with Name & Generation -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent flex flex-col justify-end p-4 sm:p-5 text-white">
                                    <span class="text-[10px] font-extrabold text-amber-300 uppercase tracking-widest">{{ $leader->generation ?: 'Nakhoda PIK-R' }}</span>
                                    <h3 class="text-base sm:text-lg font-black text-white leading-tight drop-shadow-sm truncate">
                                        {{ $leader->name }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body (Motto, Tags, & Social) -->
                        <div class="p-4 sm:p-5 pt-3.5 space-y-3.5 flex-1 flex flex-col justify-between">
                            <div class="space-y-3">
                                <!-- Instagram & Subtext -->
                                <div class="flex items-center justify-between text-xs">
                                    @if($leader->instagram)
                                        <a href="https://instagram.com/{{ ltrim($leader->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-pink-600 font-extrabold hover:underline">
                                            <i class="fab fa-instagram"></i>
                                            <span>{{ '@' . ltrim($leader->instagram, '@') }}</span>
                                        </a>
                                    @else
                                        <span class="text-[11px] font-bold text-slate-400">Ketua PIK-R REQUEST</span>
                                    @endif
                                    <span class="text-[10px] font-bold text-slate-400">SMAN 1 TPP</span>
                                </div>

                                <!-- Quote Snippet -->
                                @if($cleanQuote)
                                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 text-slate-600 text-xs italic leading-relaxed relative">
                                        <i class="fas fa-quote-left text-slate-300 absolute top-2 right-2.5 text-xs"></i>
                                        <p class="font-normal pr-4 line-clamp-2">“{{ $cleanQuote }}”</p>
                                    </div>
                                @endif

                                <!-- 3 Lembar Narasi Badges -->
                                <div class="flex flex-wrap items-center gap-1.5 text-[10px] font-bold text-slate-500">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700">
                                        <i class="fas fa-book-open text-[9px]"></i>
                                        <span>Kisah Perjalanan</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800">
                                        <i class="fas fa-lightbulb text-[9px]"></i>
                                        <span>Pengalaman</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700">
                                        <i class="fas fa-star text-[9px]"></i>
                                        <span>Pesan Harapan</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <button type="button" 
                                    @click="openLeaderDetail({{ $loop->index }})"
                                    class="w-full mt-2 py-3 px-4 rounded-xl bg-[#17385c] hover:bg-[#102742] text-white text-xs font-black uppercase tracking-wider transition-all shadow-md active:scale-95 flex items-center justify-center gap-2 cursor-pointer group/btn">
                                <span>Buka Lembar Kenangan</span>
                                <i class="fas fa-arrow-right text-[10px] text-amber-400 group-hover/btn:translate-x-1 transition-transform"></i>
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200">
                        <i class="fas fa-user-tie text-4xl text-slate-300 mb-3"></i>
                        <p class="text-sm font-semibold text-slate-600">Belum ada profil ketua yang diarsipkan.</p>
                        <p class="text-xs text-slate-400 mt-1">Data kepengurusan sedang dalam proses perapian.</p>
                    </div>
                @endforelse

                <!-- Filter Empty State (when selectedPeriod has 0 results) -->
                <div x-show="countFiltered() === 0" class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-slate-200" style="display: none;">
                    <i class="fas fa-search text-3xl text-slate-300 mb-2"></i>
                    <p class="text-sm font-semibold text-slate-600">Tidak ada data ketua untuk periode yang dipilih.</p>
                    <button type="button" @click="selectedPeriod = 'all'" class="mt-3 px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs transition-colors cursor-pointer">
                        Tampilkan Semua Periode
                    </button>
                </div>
            </div>

        </div>

        <!-- INTERACTIVE LEADER READER MODAL (3 TABS) -->
        <div x-show="leaderModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @keydown.escape.window="leaderModalOpen = false"
             @keydown.arrow-left.window="if(leaderModalOpen) prevLeader()"
             @keydown.arrow-right.window="if(leaderModalOpen) nextLeader()"
             class="fixed inset-0 z-[125] bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3.5 sm:p-5 md:p-6 overflow-hidden"
             style="display: none;">
            
            <div @click.away="leaderModalOpen = false" 
                 class="relative w-full max-w-2xl bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-2xl border border-slate-200/80 flex flex-col max-h-[85vh] sm:max-h-[88vh] overflow-hidden my-auto">
                
                <!-- Modal Header with Prestige Gradient -->
                <div class="relative overflow-hidden bg-gradient-to-r from-slate-950 via-[#17385c] to-blue-950 text-white pt-5 pb-4 px-5 sm:px-7 shrink-0 border-b border-white/10">
                    <!-- Glow decoration -->
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-amber-400/15 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Top row: Badges & Close Button -->
                    <div class="relative z-10 flex items-center justify-between gap-2.5 mb-3.5">
                        <div class="flex items-center gap-1.5 flex-wrap min-w-0">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30 truncate shadow-2xs">
                                <i class="fas fa-crown text-[9px] text-amber-400 shrink-0"></i>
                                <span class="truncate" x-text="selectedLeader?.title_badge"></span>
                            </span>
                            
                            <template x-if="selectedLeader?.generation">
                                <span class="px-2.5 py-1 rounded-full bg-white/10 text-slate-300 text-[10px] font-bold tracking-wide shrink-0"
                                      x-text="selectedLeader.generation">
                                </span>
                            </template>

                            <template x-if="selectedLeader?.period">
                                <span class="px-2.5 py-1 rounded-full bg-blue-500/20 text-blue-300 text-[10px] font-bold tracking-wide shrink-0"
                                      x-text="'Periode ' + selectedLeader.period">
                                </span>
                            </template>
                        </div>

                        <button @click="leaderModalOpen = false" 
                                type="button"
                                class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 active:scale-90 text-white flex items-center justify-center transition-all cursor-pointer shrink-0 shadow-sm"
                                title="Tutup (Esc)">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Leader Info -->
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 rounded-2xl overflow-hidden shadow-xl ring-2 ring-amber-400/40 bg-gradient-to-tr from-[#17385c] to-blue-600 flex items-center justify-center font-black text-white text-lg sm:text-xl">
                            <template x-if="selectedLeader?.photo">
                                <img :src="selectedLeader.photo" :alt="selectedLeader.name" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedLeader?.photo">
                                <span x-text="selectedLeader?.name ? selectedLeader.name.substring(0, 2).toUpperCase() : ''"></span>
                            </template>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-base sm:text-xl font-black text-white leading-tight truncate" x-text="selectedLeader?.name"></h3>
                            <p class="text-[11px] sm:text-xs text-amber-300 font-semibold mt-0.5 truncate" x-text="'Ketua PIK-R REQUEST ' + (selectedLeader?.period ? ('(' + selectedLeader.period + ')') : '')"></p>
                            
                            <template x-if="selectedLeader?.instagram">
                                <div class="mt-1.5">
                                    <a :href="'https://instagram.com/' + selectedLeader.instagram" target="_blank" 
                                       class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-pink-500/20 hover:bg-pink-500/30 text-pink-300 border border-pink-400/30 text-[10px] font-bold transition-all shadow-2xs">
                                        <i class="fab fa-instagram text-[10px]"></i>
                                        <span x-text="'@' + selectedLeader.instagram"></span>
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 3 Tabs Switcher -->
                <div class="p-2 sm:px-6 sm:pt-4 bg-white border-b border-slate-100 flex items-center gap-1.5 shrink-0">
                    <button type="button" 
                            @click="activeModalTab = 'story'"
                            :class="activeModalTab === 'story' ? 'bg-[#17385c] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                            class="flex-1 py-2 sm:py-2.5 px-2 sm:px-3 rounded-xl text-[11px] sm:text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fas fa-book-open text-amber-400 text-xs"></i>
                        <span class="truncate">Cerita Perjalanan</span>
                    </button>

                    <button type="button" 
                            @click="activeModalTab = 'experience'"
                            :class="activeModalTab === 'experience' ? 'bg-[#17385c] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                            class="flex-1 py-2 sm:py-2.5 px-2 sm:px-3 rounded-xl text-[11px] sm:text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fas fa-lightbulb text-amber-400 text-xs"></i>
                        <span class="truncate">Pengalaman</span>
                    </button>

                    <button type="button" 
                            @click="activeModalTab = 'hope'"
                            :class="activeModalTab === 'hope' ? 'bg-[#17385c] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                            class="flex-1 py-2 sm:py-2.5 px-2 sm:px-3 rounded-xl text-[11px] sm:text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fas fa-star text-amber-400 text-xs"></i>
                        <span class="truncate">Harapan & Pesan</span>
                    </button>
                </div>

                <!-- Modal Scrollable Reader Content -->
                <div class="p-5 sm:p-7 md:p-8 overflow-y-auto space-y-4 text-slate-700 leading-relaxed text-sm sm:text-base overscroll-contain pb-8">
                    
                    <!-- Quote banner if exists -->
                    <template x-if="selectedLeader?.quote">
                        <div class="p-4 bg-amber-50/70 border border-amber-200/80 rounded-2xl text-slate-700 italic text-xs sm:text-sm flex items-start gap-2.5 mb-2">
                            <i class="fas fa-quote-left text-amber-500 mt-1 shrink-0"></i>
                            <p class="font-medium" x-text="selectedLeader.quote"></p>
                        </div>
                    </template>

                    <!-- TAB 1: CERITA -->
                    <div x-show="activeModalTab === 'story'" class="space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                            <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">Kisah Perjalanan & Dinamika Kepemimpinan</h4>
                        </div>

                        <template x-if="selectedLeader?.story">
                            <div class="space-y-3.5 text-slate-700 text-[14px] sm:text-[15px] font-normal leading-[1.85] sm:leading-[1.95]">
                                <template x-for="(para, pIdx) in formatParagraphs(selectedLeader?.story)" :key="pIdx">
                                    <p class="text-slate-700" x-text="para"></p>
                                </template>
                            </div>
                        </template>
                        <template x-if="!selectedLeader?.story">
                            <div class="py-8 text-center text-slate-400 text-xs italic bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                Catatan cerita perjalanan belum ditambahkan untuk profil ini.
                            </div>
                        </template>
                    </div>

                    <!-- TAB 2: PENGALAMAN -->
                    <div x-show="activeModalTab === 'experience'" class="space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                            <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                                <i class="fas fa-lightbulb"></i>
                            </span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">Pengalaman, Momen Berkesan & Tantangan</h4>
                        </div>

                        <template x-if="selectedLeader?.experience">
                            <div class="space-y-3.5 text-slate-700 text-[14px] sm:text-[15px] font-normal leading-[1.85] sm:leading-[1.95]">
                                <template x-for="(para, pIdx) in formatParagraphs(selectedLeader?.experience)" :key="pIdx">
                                    <p class="text-slate-700" x-text="para"></p>
                                </template>
                            </div>
                        </template>
                        <template x-if="!selectedLeader?.experience">
                            <div class="py-8 text-center text-slate-400 text-xs italic bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                Catatan pengalaman dan tantangan belum ditambahkan untuk profil ini.
                            </div>
                        </template>
                    </div>

                    <!-- TAB 3: HARAPAN -->
                    <div x-show="activeModalTab === 'hope'" class="space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                            <span class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                                <i class="fas fa-star"></i>
                            </span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">Harapan & Pesan Estafet Masa Depan</h4>
                        </div>

                        <template x-if="selectedLeader?.hope">
                            <div class="space-y-3.5 text-slate-700 text-[14px] sm:text-[15px] font-normal leading-[1.85] sm:leading-[1.95]">
                                <template x-for="(para, pIdx) in formatParagraphs(selectedLeader?.hope)" :key="pIdx">
                                    <p class="text-slate-700" x-text="para"></p>
                                </template>
                            </div>
                        </template>
                        <template x-if="!selectedLeader?.hope">
                            <div class="py-8 text-center text-slate-400 text-xs italic bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                Catatan harapan dan pesan estafet belum ditambahkan untuk profil ini.
                            </div>
                        </template>
                    </div>

                </div>

                <!-- Modal Footer Navigation & Actions -->
                <div class="px-5 sm:px-7 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3 shrink-0">
                    <!-- Left: Prev / Next Buttons -->
                    <div class="flex items-center gap-1.5 min-w-0">
                        <template x-if="leadersList.length > 1">
                            <div class="flex items-center gap-1.5">
                                <button type="button" 
                                        @click="prevLeader()" 
                                        class="px-3 py-1.5 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold transition-all shadow-2xs active:scale-95 cursor-pointer flex items-center gap-1"
                                        title="Ketua Sebelumnya (Panah Kiri)">
                                    <i class="fas fa-chevron-left text-[9px]"></i>
                                    <span class="text-[11px]">Sebelumnya</span>
                                </button>
                                <button type="button" 
                                        @click="nextLeader()" 
                                        class="px-3 py-1.5 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold transition-all shadow-2xs active:scale-95 cursor-pointer flex items-center gap-1"
                                        title="Ketua Selanjutnya (Panah Kanan)">
                                    <span class="text-[11px]">Selanjutnya</span>
                                    <i class="fas fa-chevron-right text-[9px]"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- Right: Close Button -->
                    <button type="button" 
                            @click="leaderModalOpen = false" 
                            class="px-6 py-2.5 rounded-xl bg-[#17385c] hover:bg-[#102742] text-white text-xs font-black uppercase tracking-wider transition-all shadow-sm active:scale-95 cursor-pointer shrink-0">
                        Tutup
                    </button>
                </div>

            </div>
        </div>

        @if($setting->audio_file && $setting->is_audio_active)
            <!-- Hidden Audio Element for Background Music -->
            <audio id="leader-audio-player" 
                   src="{{ asset($setting->audio_file) }}" 
                   loop 
                   preload="auto"
                   autoplay
                   @ended="audioPlaying = false"
                   @pause="audioPlaying = false"
                   @play="audioPlaying = true">
            </audio>
        @endif

    </div>

    <!-- Script Component Definition for Alpine.js -->
    <script>
        function jejakKetuaApp() {
            return {
                selectedPeriod: 'all',
                leaderModalOpen: false,
                selectedLeaderIndex: 0,
                activeModalTab: 'story',
                leadersList: @js($leadersJson),
                audioPlaying: false,
                audioMuted: false,
                get selectedLeader() {
                    return this.leadersList[this.selectedLeaderIndex] || null;
                },
                countFiltered() {
                    if (this.selectedPeriod === 'all') return this.leadersList.length;
                    return this.leadersList.filter(l => l.period === this.selectedPeriod).length;
                },
                init() {
                    this.$nextTick(() => {
                        this.initAutoplay();
                    });
                },
                initAutoplay() {
                    const audio = document.getElementById('leader-audio-player');
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
                toggleAudio() {
                    const audio = document.getElementById('leader-audio-player');
                    if (!audio) return;
                    if (this.audioPlaying) {
                        audio.pause();
                        this.audioPlaying = false;
                    } else {
                        audio.play().then(() => {
                            this.audioPlaying = true;
                        }).catch(e => {
                            console.log('Audio error:', e);
                        });
                    }
                },
                toggleMute() {
                    const audio = document.getElementById('leader-audio-player');
                    if (!audio) return;
                    audio.muted = !audio.muted;
                    this.audioMuted = audio.muted;
                },
                openLeaderDetail(idx) {
                    this.selectedLeaderIndex = idx;
                    this.activeModalTab = 'story';
                    this.leaderModalOpen = true;
                },
                nextLeader() {
                    if (this.leadersList.length > 0) {
                        this.selectedLeaderIndex = (this.selectedLeaderIndex + 1) % this.leadersList.length;
                    }
                },
                prevLeader() {
                    if (this.leadersList.length > 0) {
                        this.selectedLeaderIndex = (this.selectedLeaderIndex - 1 + this.leadersList.length) % this.leadersList.length;
                    }
                },
                formatParagraphs(text) {
                    if (!text) return [];
                    let clean = text.trim().replace(/^["\s]+|["\s]+$/g, '');
                    if (clean.includes('\n')) {
                        let lines = clean.split(/\n+/).map(p => p.trim()).filter(p => p.length > 0);
                        if (lines.length > 1) {
                            return lines;
                        }
                    }
                    let sentences = clean.match(/[^.!?]+[.!?]+(\s|$)|[^.!?]+$/g);
                    if (!sentences || sentences.length <= 2) {
                        return [clean];
                    }
                    let paragraphs = [];
                    let current = '';
                    for (let i = 0; i < sentences.length; i++) {
                        current += (current ? ' ' : '') + sentences[i].trim();
                        if ((i % 2 === 1 || current.length > 200) && i < sentences.length - 1) {
                            paragraphs.push(current);
                            current = '';
                        }
                    }
                    if (current) {
                        paragraphs.push(current);
                    }
                    return paragraphs;
                }
            };
        }
    </script>
</x-layouts.app>
