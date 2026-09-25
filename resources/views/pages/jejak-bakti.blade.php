<x-layouts.app title="Jejak Bakti & Museum Duta GenRe | PIK-R REQUEST">
    @php
        $figuresDataJson = ($activeEdition && $activeEdition->figures) ? $activeEdition->figures->values()->map(function($f) {
            return [
                'id' => $f->id,
                'name' => $f->name,
                'honor_title' => $f->honor_title,
                'period' => $f->period,
                'badge_color' => $f->badge_color ?? 'amber',
                'photo' => $f->photo ? asset($f->photo) : null,
                'quote' => trim($f->quote ?? '', " \t\n\r\0\x0B\"'“”"),
                'contribution' => $f->contribution,
                'instagram' => $f->instagram ? ltrim($f->instagram, '@') : null,
            ];
        })->toArray() : [];
    @endphp

    <div class="relative min-h-screen pt-20 bg-slate-50" x-data="jejakBaktiApp()">
        
        <!-- Header Banner -->
        <div class="relative overflow-hidden border-b border-slate-200">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('assets/img/bg_utama.JPG') }}" alt="Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-[#17385c]/95 via-[#17385c]/90 to-[#1e40af]/85 backdrop-blur-[2px]"></div>
            </div>

            <div class="relative z-10 max-w-5xl mx-auto px-4 py-16 sm:py-24 text-center text-white">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/20 border border-amber-300/40 text-amber-300 text-[11px] font-extrabold uppercase tracking-widest mb-4">
                    <i class="fas fa-crown text-[10px]"></i>
                    <span>{{ $activeEdition->badge_title ?? 'PANGGUNG KEHORMATAN & REKAM JEJAK' }}</span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-4">
                    Jejak Bakti & Rekam Jejak Duta GenRe
                </h1>
                
                <p class="text-sm sm:text-base text-amber-300/90 font-bold max-w-2xl mx-auto">
                    Museum apresiasi abadi bagi para kader dan duta yang telah mendedikasikan waktu, bakat, dan semangat terbaiknya untuk PIK-R REQUEST SMAN 1 Tasik Putri Puyu.
                </p>

                <div class="w-20 h-1 bg-amber-400 mx-auto mt-6 rounded-full"></div>
            </div>
        </div>

        <!-- Period Selector Navigation Bar (Dropdown) -->
        <div class="sticky top-16 sm:top-20 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm py-3 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-4">
                
                <!-- Left: Label & Dropdown -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <div class="flex items-center justify-between sm:justify-start gap-2">
                        <label for="public-period-select" class="text-[11px] sm:text-xs font-black uppercase text-slate-500 tracking-wider flex items-center gap-1.5 shrink-0">
                            <i class="fas fa-crown text-amber-500"></i>
                            <span>Pilih Periode / Generasi:</span>
                        </label>
                        
                        <!-- Badges on Mobile (top right) -->
                        <div class="flex sm:hidden items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px]">
                                {{ count($editions) }} Periode
                            </span>
                            @if($activeEdition && $activeEdition->is_featured)
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-black text-[9px] uppercase tracking-wider">
                                    Beranda
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Full Width Select on Mobile, Fixed Width on Desktop -->
                    <div class="relative w-full sm:w-80">
                        <select id="public-period-select" 
                                onchange="if(this.value) window.location.href = this.value"
                                class="w-full appearance-none bg-slate-50 hover:bg-slate-100 border border-slate-300 focus:border-[#17385c] focus:ring-2 focus:ring-blue-500/20 rounded-xl pl-3.5 pr-10 py-2.5 text-xs font-extrabold text-slate-800 transition-all cursor-pointer shadow-xs">
                            @foreach($editions as $ed)
                                <option value="{{ route('jejak-bakti', ['periode' => $ed->period]) }}" 
                                        {{ ($activeEdition && $activeEdition->id === $ed->id) ? 'selected' : '' }}>
                                    Periode {{ $ed->period }} {{ $ed->is_featured ? '★ [Utama di Beranda]' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Right: Badges on Desktop -->
                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 font-bold text-[11px]">
                        {{ count($editions) }} Periode Terarsip
                    </span>
                    @if($activeEdition && $activeEdition->is_featured)
                        <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-extrabold text-[10px] uppercase tracking-wider">
                            ★ Sorotan Beranda
                        </span>
                    @endif
                </div>

            </div>
        </div>

        @if($activeEdition)
            <!-- Main Content Body for Active Edition -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-16 space-y-10 sm:space-y-16">
                
                <!-- Poster Showcase & Official Tribute Letter -->
                <div class="bg-white rounded-3xl sm:rounded-[2.5rem] border border-slate-200/80 shadow-xl overflow-hidden p-5 sm:p-10 lg:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                        
                        <!-- Left: Poster Display with High-Res Frame -->
                        <div class="lg:col-span-5 flex flex-col items-center">
                            @if($activeEdition->poster_image)
                                <div class="relative group w-full max-w-md mx-auto">
                                    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl border-4 border-amber-400/20 bg-slate-950 flex items-center justify-center p-2 cursor-pointer group"
                                         @click="lightboxOpen = true">
                                        <img src="{{ asset($activeEdition->poster_image) }}" 
                                             alt="{{ $activeEdition->title }}" 
                                             class="w-full h-auto max-h-[620px] object-contain rounded-xl sm:rounded-2xl group-hover:scale-[1.02] transition-transform duration-500">
                                        
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-5 text-white text-center rounded-2xl"
                                             @click="lightboxOpen = true">
                                            <span class="inline-flex items-center justify-center gap-1.5 text-xs font-bold text-amber-300">
                                                <i class="fas fa-search-plus"></i> Klik untuk melihat resolusi penuh
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Buttons under poster -->
                                    <div class="mt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
                                        <button @click="lightboxOpen = true" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all">
                                            <i class="fas fa-expand text-[11px] text-blue-600"></i>
                                            <span>Lihat Ukuran Penuh</span>
                                        </button>

                                        <a href="{{ asset($activeEdition->poster_image) }}" download="Poster-Duta-Genre-{{ str_replace(' ', '-', $activeEdition->period) }}.jpg" target="_blank"
                                           class="px-4 py-2.5 bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-800 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-sm">
                                            <i class="fas fa-download text-[11px] text-amber-600"></i>
                                            <span>Unduh Poster HD</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="w-full max-w-md mx-auto aspect-[3/4] sm:min-h-[460px] rounded-2xl sm:rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center p-8 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 mb-4 shadow-xs">
                                        <i class="fas fa-image text-3xl text-slate-300"></i>
                                    </div>
                                    <h4 class="font-extrabold text-slate-700 text-sm sm:text-base">Poster Belum Diunggah</h4>
                                    <p class="text-xs text-slate-400 mt-2 max-w-xs leading-relaxed">
                                        Poster resmi penghargaan periode <span class="font-bold text-slate-600">{{ $activeEdition->period }}</span> belum diunggah.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Right: Official Gratitude Letter -->
                        <div class="lg:col-span-7 space-y-6">
                            <div class="space-y-2">
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[11px] font-black uppercase tracking-wider inline-block">
                                    Arsip Generasi: Periode {{ $activeEdition->period }}
                                </span>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                                    {{ $activeEdition->title }}
                                </h2>
                                <p class="text-xs sm:text-sm font-semibold text-slate-400">{{ $activeEdition->subtitle }}</p>

                                @if($activeEdition->audio_file)
                                    <!-- Instagram-Style Music Tag under Title -->
                                    <div class="pt-1.5 flex items-center gap-2">
                                        <button @click="toggleAudio()" 
                                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-slate-200 border border-slate-200/80 text-slate-800 text-xs font-bold transition-all cursor-pointer shadow-2xs active:scale-95 group">
                                            <i class="fas fa-music text-[11px] text-amber-500" :class="audioPlaying ? 'animate-bounce' : ''"></i>
                                            <span class="tracking-tight font-extrabold text-slate-800">
                                                {{ $activeEdition->audio_title ?: 'Musik Kenangan' }}
                                                @if($activeEdition->audio_artist)
                                                    <span class="text-slate-400 font-medium"> • {{ $activeEdition->audio_artist }}</span>
                                                @endif
                                            </span>
                                            <!-- Instagram Equalizer Bars -->
                                            <div class="flex items-end gap-0.5 h-3 ml-1">
                                                <span class="w-0.5 bg-amber-500 rounded-full transition-all duration-300" :class="audioPlaying ? 'animate-pulse h-3' : 'h-1'"></span>
                                                <span class="w-0.5 bg-amber-500 rounded-full transition-all duration-300" :class="audioPlaying ? 'animate-pulse h-2' : 'h-2'"></span>
                                                <span class="w-0.5 bg-amber-500 rounded-full transition-all duration-300" :class="audioPlaying ? 'animate-pulse h-3.5' : 'h-1.5'"></span>
                                            </div>
                                            <!-- Play / Pause Icon -->
                                            <span class="ml-1 text-[10px] text-slate-400 group-hover:text-slate-700">
                                                <i class="fas" :class="audioPlaying ? 'fa-pause' : 'fa-play'"></i>
                                            </span>
                                        </button>
                                        
                                        <!-- Mute Button -->
                                        <button @click="toggleMute()" 
                                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 border border-slate-200/80 text-slate-500 text-xs transition-colors cursor-pointer"
                                                :title="audioMuted ? 'Bunyikan' : 'Bisukan'">
                                            <i class="fas" :class="audioMuted ? 'fa-volume-mute text-rose-500' : 'fa-volume-up'"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            @if($activeEdition->appreciation_quote)
                                <div class="p-6 rounded-2xl bg-amber-50/50 border border-amber-100/80 text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                                    <p class="font-medium whitespace-pre-line">
                                        {{ $activeEdition->appreciation_quote }}
                                    </p>
                                    <p class="text-xs text-slate-500 italic">
                                        "Prestasi bukan sekadar piala atau selempang yang terkalung, melainkan keteladanan budi pekerti, kepedulian tulus terhadap sesama remaja, dan dedikasi tanpa pamrih yang kalian torehkan untuk almamater tercinta."
                                    </p>
                                </div>
                            @else
                                <div class="p-8 rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-slate-400 text-xs sm:text-sm text-center space-y-2">
                                    <i class="fas fa-quote-left text-slate-300 text-2xl block mx-auto"></i>
                                    <p class="font-semibold text-slate-600">Narasi Apresiasi Belum Diisi</p>
                                    <p class="text-xs text-slate-400 max-w-md mx-auto">Catatan atau surat ucapan terima kasih untuk generasi periode {{ $activeEdition->period }} belum ditambahkan oleh pengurus.</p>
                                </div>
                            @endif

                            @if($activeEdition->story_content)
                                <!-- Story / Detail Teaser Banner -->
                                <div @click="storyModalOpen = true" 
                                     class="p-4 sm:p-5 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-amber-500/10 via-amber-400/5 to-white border border-amber-300/80 hover:border-amber-400 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 sm:gap-4 cursor-pointer group shadow-2xs hover:shadow-md">
                                    <div class="flex items-start sm:items-center gap-3 min-w-0">
                                        <div class="w-10 h-10 rounded-2xl bg-[#17385c] text-white flex items-center justify-center text-sm shadow-xs shrink-0 group-hover:scale-105 transition-transform mt-0.5 sm:mt-0">
                                            <i class="fas fa-feather-alt text-amber-400"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-amber-900 bg-amber-200/80 px-2 py-0.5 rounded-md">Kisah Lengkap</span>
                                                <span class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Rekam Jejak Duta</span>
                                            </div>
                                            <h4 class="text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#17385c] transition-colors leading-snug line-clamp-2">
                                                {{ $activeEdition->story_title ?: 'Catatan & Kisah Inspiratif Perjalanan Duta' }}
                                            </h4>
                                        </div>
                                    </div>
                                    
                                    <div class="flex sm:shrink-0 justify-end w-full sm:w-auto pt-1 sm:pt-0">
                                        <div class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2.5 rounded-xl bg-[#17385c] group-hover:bg-[#102742] text-white text-xs font-black uppercase tracking-wider transition-all shadow-sm">
                                            <span class="text-white">Baca Kisah</span>
                                            <i class="fas fa-arrow-right text-[10px] text-white group-hover:translate-x-1 transition-transform"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Quote Attribution -->
                            <div class="flex items-center gap-3.5 sm:gap-4 pt-1">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-white border border-slate-200 p-1.5 flex items-center justify-center shadow-md shrink-0 overflow-hidden">
                                    @if($activeEdition->school_logo)
                                        <img src="{{ asset($activeEdition->school_logo) }}" alt="Logo Sekolah" class="w-full h-full object-contain">
                                    @else
                                        <div class="w-full h-full rounded-xl bg-[#17385c] text-white flex items-center justify-center font-bold text-base sm:text-lg shadow-inner">
                                            <i class="fas fa-heart text-amber-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-slate-800 text-sm sm:text-base">
                                        {{ $activeEdition->institution_name ?: 'Keluarga Besar PIK–R REQUEST' }}
                                    </h4>
                                    <p class="text-xs text-slate-500 font-medium">
                                        {{ $activeEdition->institution_subtext ?: 'SMAN 1 Tasik Putri Puyu — Kabupaten Kepulauan Meranti' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Reaction & Detail Action Buttons -->
                            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                                <button @click="appreciate()" 
                                        :class="hasAppreciated ? 'bg-rose-600 text-white' : 'bg-[#17385c] hover:bg-[#102742] text-white'"
                                        class="w-full sm:w-auto px-6 py-3.5 rounded-2xl font-black text-xs uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-2.5 shadow-lg active:scale-95 cursor-pointer">
                                    <i class="fas fa-heart text-rose-400" :class="hasAppreciated ? 'text-white' : ''"></i>
                                    <span class="text-white">Kirim Rasa Bangga & Terima Kasih</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-white/20 text-white text-[11px] font-bold ml-1" x-text="appreciationCount"></span>
                                </button>

                                @if($activeEdition->story_content)
                                    <button @click="storyModalOpen = true" 
                                            class="w-full sm:w-auto px-5 py-3.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-2 shadow-md hover:shadow-lg active:scale-95 cursor-pointer group">
                                        <i class="fas fa-book-open text-white group-hover:scale-110 transition-transform"></i>
                                        <span class="text-white">Lihat Detail Cerita</span>
                                    </button>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Individual Profiles of Figures in this Edition -->
                <div class="space-y-6 sm:space-y-8">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs font-black uppercase tracking-wider text-blue-600">Tokoh Kehormatan Periode {{ $activeEdition->period }}</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Sosok Yang Mengharumkan Nama Sekolah</h2>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Kenali sosok, dedikasi, serta pesan inspiratif mereka untuk adik-adik kelas</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                        @forelse($activeEdition->figures as $fig)
                            @php
                                $rawQuote = trim($fig->quote ?? '');
                                $cleanQuote = trim($rawQuote, " \t\n\r\0\x0B\"'“”");
                                $isLongQuote = mb_strlen($cleanQuote) > 130;
                            @endphp
                            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                                <div class="p-5 sm:p-7 space-y-4 sm:space-y-5">
                                    <!-- Top Tag -->
                                    <div class="flex items-center justify-between">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                            @if($fig->badge_color === 'amber') bg-amber-50 text-amber-700 border border-amber-200
                                            @elseif($fig->badge_color === 'sky') bg-sky-50 text-sky-700 border border-sky-200
                                            @elseif($fig->badge_color === 'rose') bg-rose-50 text-rose-700 border border-rose-200
                                            @elseif($fig->badge_color === 'emerald') bg-emerald-50 text-emerald-700 border border-emerald-200
                                            @else bg-purple-50 text-purple-700 border border-purple-200 @endif">
                                            {{ $fig->honor_title }}
                                        </span>

                                        @if($fig->period)
                                            <span class="text-xs font-bold text-slate-400">{{ $fig->period }}</span>
                                        @endif
                                    </div>

                                    <!-- Photo / Avatar & Name -->
                                    <div class="flex items-center gap-4">
                                        <button type="button" 
                                                @click="openFigureDetail({{ $loop->index }})"
                                                class="w-16 h-16 rounded-2xl overflow-hidden bg-gradient-to-tr from-[#17385c] to-blue-600 flex items-center justify-center font-black text-white text-xl shrink-0 shadow-md group-hover:scale-105 transition-transform text-left cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500/40"
                                                title="Klik untuk melihat profil {{ $fig->name }}">
                                            @if($fig->photo)
                                                <img src="{{ asset($fig->photo) }}" alt="{{ $fig->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span>{{ strtoupper(substr($fig->name, 0, 2)) }}</span>
                                            @endif
                                        </button>
                                        <div class="min-w-0">
                                            <button type="button" 
                                                    @click="openFigureDetail({{ $loop->index }})"
                                                    class="font-extrabold text-slate-900 text-lg group-hover:text-blue-600 transition-colors text-left truncate block max-w-full cursor-pointer focus:outline-none hover:underline"
                                                    title="Klik untuk melihat profil {{ $fig->name }}">
                                                {{ $fig->name }}
                                            </button>
                                            <p class="text-xs font-semibold text-slate-400 mt-0.5 truncate">{{ $fig->honor_title }}</p>
                                            @if($fig->instagram)
                                                <a href="https://instagram.com/{{ ltrim($fig->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-pink-600 font-bold hover:underline mt-1">
                                                    <i class="fab fa-instagram"></i>
                                                    <span>{{ '@' . ltrim($fig->instagram, '@') }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quotes -->
                                    @if($cleanQuote)
                                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-slate-600 text-xs sm:text-sm italic leading-relaxed relative flex flex-col justify-between transition-colors hover:bg-slate-100/70 hover:border-slate-200">
                                            <i class="fas fa-quote-left text-slate-300 absolute top-2.5 right-3 text-sm"></i>
                                            
                                            @if($isLongQuote)
                                                <div>
                                                    <p class="line-clamp-3 text-slate-600 font-normal">
                                                        “{{ $cleanQuote }}”
                                                    </p>
                                                    <div class="mt-3 pt-2.5 border-t border-slate-200/80 flex items-center justify-between">
                                                        <button type="button" 
                                                                @click="openFigureDetail({{ $loop->index }})"
                                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#17385c] hover:text-blue-700 text-xs font-extrabold transition-all cursor-pointer shadow-2xs group/btn active:scale-95">
                                                            <i class="fas fa-book-reader text-amber-500 text-xs"></i>
                                                            <span>Lihat Detail Cerita</span>
                                                            <i class="fas fa-arrow-right text-[10px] text-blue-500 group-hover/btn:translate-x-0.5 transition-transform"></i>
                                                        </button>
                                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kisah Lengkap</span>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-slate-600 font-normal">
                                                    “{{ $cleanQuote }}”
                                                </p>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Jasa & Kontribusi -->
                                    @if($fig->contribution)
                                        <div class="space-y-1">
                                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block">Jasa & Advokasi:</span>
                                            <p class="text-xs text-slate-600 leading-relaxed font-medium line-clamp-2">{{ $fig->contribution }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="px-7 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-500">
                                    <span>Kader Inspiratif PIK-R REQUEST</span>
                                    <button type="button" 
                                            @click="openFigureDetail({{ $loop->index }})" 
                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-extrabold hover:underline cursor-pointer">
                                        <span>{{ $isLongQuote ? 'Detail Cerita' : 'Lihat Profil' }}</span>
                                        <i class="fas fa-chevron-right text-[9px]"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-3xl border border-slate-200">
                                <p class="text-xs font-medium">Belum ada profil duta yang ditambahkan di periode ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Throwback Memories Gallery of this Edition -->
                @if(count($activeEdition->memories) > 0)
                    <div class="space-y-8 pt-8 border-t border-slate-200">
                        <div class="text-center max-w-2xl mx-auto space-y-2">
                            <span class="text-xs font-black uppercase tracking-wider text-amber-600">Dokumentasi & Kenangan</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kilas Balik Momen Perjuangan ({{ $activeEdition->period }})</h2>
                            <p class="text-xs sm:text-sm text-slate-500 font-medium">Potret kenangan proses karantina, pembinaan, hingga penganugerahan piala</p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                            @foreach($activeEdition->memories as $mem)
                                <div class="group relative rounded-2xl overflow-hidden bg-slate-950 aspect-square shadow-md border border-slate-100">
                                    <img src="{{ asset($mem->image) }}" alt="{{ $mem->title }}" class="w-full h-full object-cover group-hover:scale-108 transition-all duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent flex flex-col justify-end p-4 text-white">
                                        <h4 class="font-bold text-xs sm:text-sm leading-snug">{{ $mem->title }}</h4>
                                        @if($mem->caption)
                                            <p class="text-[11px] text-white/75 mt-1 line-clamp-2">{{ $mem->caption }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            @if($activeEdition && $activeEdition->story_content)
            <div x-show="storyModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @keydown.escape.window="storyModalOpen = false"
                 class="fixed inset-0 z-[120] bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3.5 sm:p-5 md:p-6 overflow-hidden"
                 style="display: none;">
                
                <div @click.away="storyModalOpen = false" 
                     class="relative w-full max-w-3xl bg-white rounded-3xl sm:rounded-[2rem] shadow-2xl border border-slate-200/80 flex flex-col max-h-[84vh] sm:max-h-[88vh] overflow-hidden my-auto">
                    
                    <!-- Modal Header -->
                    <div class="px-4 sm:px-8 py-3.5 sm:py-4 border-b border-slate-100 bg-slate-50/95 backdrop-blur-sm flex items-center justify-between gap-3 shrink-0">
                        <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#17385c] text-white flex items-center justify-center text-xs sm:text-sm shadow-xs shrink-0">
                                <i class="fas fa-feather-alt text-amber-400"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-amber-100/90 text-amber-900 text-[10px] font-black uppercase tracking-wider">
                                    <i class="fas fa-crown text-[9px] text-amber-600"></i>
                                    <span>Arsip {{ $activeEdition->period }}</span>
                                </div>
                                <p class="text-xs sm:text-sm font-bold text-slate-800 truncate">
                                    Catatan & Rekam Jejak Duta
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            @if($activeEdition->audio_file)
                                <!-- Desktop audio pill -->
                                <button @click="toggleAudio()" 
                                        class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white hover:bg-slate-100 border border-slate-200 text-[11px] font-bold text-slate-700 transition-colors shadow-2xs cursor-pointer"
                                        :title="audioPlaying ? 'Jeda Musik' : 'Putar Musik'">
                                    <i class="fas fa-music text-[10px] text-amber-500" :class="audioPlaying ? 'animate-bounce' : ''"></i>
                                    <span x-text="audioPlaying ? 'Musik Berputar' : 'Putar Musik'"></span>
                                    <div class="flex items-end gap-0.5 h-2.5">
                                        <span class="w-0.5 bg-amber-500 rounded-full" :class="audioPlaying ? 'animate-pulse h-2.5' : 'h-1'"></span>
                                        <span class="w-0.5 bg-amber-500 rounded-full" :class="audioPlaying ? 'animate-pulse h-1.5' : 'h-1.5'"></span>
                                    </div>
                                </button>

                                <!-- Mobile audio compact button -->
                                <button @click="toggleAudio()" 
                                        class="sm:hidden w-8 h-8 rounded-full bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-xs cursor-pointer shadow-2xs"
                                        :title="audioPlaying ? 'Jeda Musik' : 'Putar Musik'">
                                    <i class="fas fa-music" :class="audioPlaying ? 'animate-bounce' : ''"></i>
                                </button>
                            @endif

                            <!-- Prominent, Always-Visible Close Button -->
                            <button @click="storyModalOpen = false" 
                                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-rose-50 border border-slate-200/90 text-slate-500 hover:text-rose-600 flex items-center justify-center transition-all cursor-pointer shrink-0 shadow-2xs active:scale-95"
                                    aria-label="Tutup Modal"
                                    title="Tutup (Esc)">
                                <i class="fas fa-times text-xs sm:text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Scrollable Reader Content -->
                    <div class="p-5 sm:p-8 md:p-10 overflow-y-auto space-y-6 text-slate-700 font-normal leading-relaxed text-sm sm:text-base overscroll-contain">
                        
                        <!-- Article Header -->
                        <div class="space-y-3 pb-5 border-b border-slate-100">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-200/60 text-amber-800 text-[11px] font-black uppercase tracking-wider">
                                <i class="fas fa-book-open text-amber-600 text-[10px]"></i>
                                <span>Kisah Perjalanan & Inspirasi</span>
                            </div>
                            <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 tracking-tight leading-snug">
                                {{ $activeEdition->story_title ?: 'Kisah & Rekam Jejak Perjalanan Duta GenRe' }}
                            </h2>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs text-slate-500 font-medium pt-1">
                                <span class="flex items-center gap-1.5 font-bold text-slate-700">
                                    <i class="fas fa-calendar-alt text-amber-500"></i>
                                    <span>Periode {{ $activeEdition->period }}</span>
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1.5">
                                    <i class="fas fa-school text-blue-600"></i>
                                    <span>{{ $activeEdition->institution_name ?: 'Keluarga Besar PIK-R REQUEST' }}</span>
                                </span>
                                @if($activeEdition->subtitle)
                                    <span>•</span>
                                    <span class="text-slate-400">{{ $activeEdition->subtitle }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Story Text with preserved line breaks -->
                        <div class="prose prose-slate max-w-none text-slate-700 text-[14px] sm:text-[15.5px] leading-relaxed sm:leading-loose whitespace-pre-line font-medium space-y-4">
                            {{ $activeEdition->story_content }}
                        </div>

                        <!-- Bottom Attribution Card -->
                        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 bg-slate-50/80 p-4 sm:p-5 rounded-2xl border border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-xs shrink-0 overflow-hidden">
                                    @if($activeEdition->school_logo)
                                        <img src="{{ asset($activeEdition->school_logo) }}" alt="Logo" class="w-full h-full object-contain">
                                    @else
                                        <i class="fas fa-heart text-amber-500 text-lg"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-slate-800 text-xs sm:text-sm">
                                        {{ $activeEdition->institution_name ?: 'Keluarga Besar PIK–R REQUEST' }}
                                    </h4>
                                    <p class="text-[11px] text-slate-500 font-medium">
                                        {{ $activeEdition->institution_subtext ?: 'SMAN 1 Tasik Putri Puyu — Kabupaten Kepulauan Meranti' }}
                                    </p>
                                </div>
                            </div>

                            <button @click="storyModalOpen = false" 
                                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#17385c] hover:bg-[#102742] text-white text-xs font-black uppercase tracking-wider transition-all shadow-md active:scale-95 cursor-pointer text-center">
                                Selesai Membaca
                            </button>
                        </div>

                    </div>

                </div>
            </div>
            @endif

            <!-- Interactive Figure Story & Profile Detail Modal -->
            <div x-show="figureModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @keydown.escape.window="figureModalOpen = false"
                 @keydown.arrow-left.window="if(figureModalOpen) prevFigure()"
                 @keydown.arrow-right.window="if(figureModalOpen) nextFigure()"
                 class="fixed inset-0 z-[125] bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3.5 sm:p-5 md:p-6 overflow-hidden"
                 style="display: none;">
                
                <div @click.away="figureModalOpen = false" 
                     class="relative w-full max-w-xl bg-white rounded-[2rem] sm:rounded-[2.25rem] shadow-2xl border border-slate-200/80 flex flex-col max-h-[82vh] sm:max-h-[86vh] overflow-hidden my-auto">
                    
                    <!-- Modal Header with Prestige Gradient -->
                    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-[#17385c] to-blue-950 text-white pt-5 pb-4 px-5 sm:px-6 shrink-0 border-b border-white/10">
                        <!-- Decorative background glow -->
                        <div class="absolute -top-12 -right-12 w-40 h-40 bg-amber-400/15 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>

                        <!-- Top row: Badges & Close Button with Safe Spacing -->
                        <div class="relative z-10 flex items-center justify-between gap-2.5 mb-3.5">
                            <div class="flex items-center gap-1.5 flex-wrap min-w-0">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30 truncate shadow-2xs">
                                    <i class="fas fa-crown text-[9px] text-amber-400 shrink-0"></i>
                                    <span class="truncate" x-text="selectedFigure?.honor_title"></span>
                                </span>
                                <template x-if="selectedFigure?.period">
                                    <span class="px-2.5 py-1 rounded-full bg-white/10 text-slate-300 text-[10px] font-bold tracking-wide shrink-0"
                                          x-text="'Tahun ' + selectedFigure.period">
                                    </span>
                                </template>
                            </div>

                            <button @click="figureModalOpen = false" 
                                    type="button"
                                    class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 active:scale-90 text-white flex items-center justify-center transition-all cursor-pointer shrink-0 shadow-sm"
                                    title="Tutup (Esc)">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>

                        <!-- Figure Profile Header Info -->
                        <div class="relative z-10 flex items-center gap-3.5 sm:gap-4">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 rounded-2xl overflow-hidden shadow-xl ring-2 ring-amber-400/40 bg-gradient-to-tr from-[#17385c] to-blue-600 flex items-center justify-center font-black text-white text-lg sm:text-xl">
                                <template x-if="selectedFigure?.photo">
                                    <img :src="selectedFigure.photo" :alt="selectedFigure.name" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!selectedFigure?.photo">
                                    <span x-text="selectedFigure?.name ? selectedFigure.name.substring(0, 2).toUpperCase() : ''"></span>
                                </template>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-base sm:text-xl font-black text-white leading-tight truncate" x-text="selectedFigure?.name"></h3>
                                <p class="text-[11px] sm:text-xs text-amber-300 font-semibold mt-0.5 truncate" x-text="selectedFigure?.honor_title"></p>
                                
                                <template x-if="selectedFigure?.instagram">
                                    <div class="mt-1.5">
                                        <a :href="'https://instagram.com/' + selectedFigure.instagram" target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-pink-500/20 hover:bg-pink-500/30 text-pink-300 border border-pink-400/30 text-[10px] font-bold transition-all shadow-2xs">
                                            <i class="fab fa-instagram text-[10px]"></i>
                                            <span x-text="'@' + selectedFigure.instagram"></span>
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Scrollable Reader Content with Pristine Spaced Typography -->
                    <div class="p-4 sm:p-6 overflow-y-auto space-y-4 text-slate-700 overscroll-contain pb-8">
                        
                        <!-- Top Tabs Switcher (Only if figure has BOTH quote and contribution) -->
                        <template x-if="selectedFigure?.quote && selectedFigure?.contribution">
                            <div class="p-1 bg-slate-100/90 rounded-2xl border border-slate-200/80 flex items-center gap-1 shadow-2xs">
                                <button type="button" 
                                        @click="activeModalTab = 'quote'"
                                        :class="activeModalTab === 'quote' ? 'bg-white text-[#17385c] font-black shadow-xs' : 'text-slate-500 hover:text-slate-800 font-bold'"
                                        class="flex-1 py-2 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                                    <i class="fas fa-feather-alt text-amber-500 text-xs"></i>
                                    <span>Pesan & Kisah</span>
                                </button>
                                <button type="button" 
                                        @click="activeModalTab = 'contribution'"
                                        :class="activeModalTab === 'contribution' ? 'bg-white text-[#17385c] font-black shadow-xs' : 'text-slate-500 hover:text-slate-800 font-bold'"
                                        class="flex-1 py-2 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                                    <i class="fas fa-medal text-amber-500 text-xs"></i>
                                    <span>Jasa & Kontribusi</span>
                                </button>
                            </div>
                        </template>

                        <!-- Kisah & Refleksi Section (Shown if activeTab === 'quote' or if no contribution) -->
                        <template x-if="selectedFigure?.quote && (activeModalTab === 'quote' || !selectedFigure?.contribution)">
                            <div class="bg-slate-50/90 rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-2xs space-y-3.5">
                                <div class="flex items-center justify-between pb-3 border-b border-slate-200/70">
                                    <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-[#17385c]">
                                        <span class="w-6 h-6 rounded-lg bg-blue-100 text-[#17385c] flex items-center justify-center text-xs">
                                            <i class="fas fa-feather-alt text-amber-500"></i>
                                        </span>
                                        <span>Kisah & Pesan Inspiratif</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-500 bg-white border border-slate-200/80 px-2 py-0.5 rounded-full uppercase tracking-wider">
                                        Refleksi
                                    </span>
                                </div>

                                <div class="text-amber-500/60 text-lg font-serif leading-none pt-1">
                                    <i class="fas fa-quote-left"></i>
                                </div>

                                <!-- Airy Paragraphs with high readability -->
                                <div class="space-y-4 text-slate-700 text-[14px] sm:text-[15px] font-normal leading-[1.85] sm:leading-[1.95] tracking-[0.015em]">
                                    <template x-for="(para, pIdx) in formatParagraphs(selectedFigure?.quote)" :key="pIdx">
                                        <p class="text-slate-700" x-text="para"></p>
                                    </template>
                                </div>

                                <div class="text-right text-amber-500/40 text-base font-serif leading-none pt-1">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </template>

                        <!-- Jasa & Kontribusi Section (Shown if activeTab === 'contribution' or if no quote) -->
                        <template x-if="selectedFigure?.contribution && (activeModalTab === 'contribution' || !selectedFigure?.quote)">
                            <div class="bg-gradient-to-b from-amber-50/50 via-white to-slate-50/60 rounded-2xl p-5 sm:p-6 border border-amber-200/80 shadow-2xs space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-amber-200/60">
                                    <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-amber-900">
                                        <span class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-600 flex items-center justify-center text-xs">
                                            <i class="fas fa-medal"></i>
                                        </span>
                                        <span>Jasa, Advokasi & Kontribusi</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-amber-800/80 bg-amber-100/80 px-2 py-0.5 rounded-full uppercase tracking-wider">
                                        Rekam Jejak
                                    </span>
                                </div>

                                <!-- Airy Paragraphs with high readability -->
                                <div class="space-y-4 text-slate-700 text-[14px] sm:text-[15px] font-normal leading-[1.85] sm:leading-[1.95] tracking-[0.015em]">
                                    <template x-for="(para, pIdx) in formatParagraphs(selectedFigure?.contribution)" :key="pIdx">
                                        <p class="text-slate-700" x-text="para"></p>
                                    </template>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- Modal Footer Navigation & Actions -->
                    <div class="px-4 sm:px-6 py-3.5 bg-slate-50/95 border-t border-slate-100 flex items-center justify-between gap-3 shrink-0">
                        <!-- Left: Navigation (if multiple figures) -->
                        <div class="flex items-center gap-1.5 min-w-0">
                            <template x-if="figuresList.length > 1">
                                <div class="flex items-center gap-1.5">
                                    <button type="button" 
                                            @click="prevFigure()" 
                                            class="px-2.5 sm:px-3 py-1.5 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold transition-all shadow-2xs active:scale-95 cursor-pointer flex items-center gap-1"
                                            title="Sosok Sebelumnya (Panah Kiri)">
                                        <i class="fas fa-chevron-left text-[9px]"></i>
                                        <span class="text-[11px]">Sebelumnya</span>
                                    </button>
                                    <button type="button" 
                                            @click="nextFigure()" 
                                            class="px-2.5 sm:px-3 py-1.5 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold transition-all shadow-2xs active:scale-95 cursor-pointer flex items-center gap-1"
                                            title="Sosok Selanjutnya (Panah Kanan)">
                                        <span class="text-[11px]">Selanjutnya</span>
                                        <i class="fas fa-chevron-right text-[9px]"></i>
                                    </button>
                                </div>
                            </template>
                            <template x-if="figuresList.length <= 1">
                                <span class="text-[11px] font-bold text-slate-400 flex items-center gap-1.5 truncate">
                                    <i class="fas fa-award text-amber-500 shrink-0"></i>
                                    <span class="truncate">Duta GenRe SMAN 1 TPP</span>
                                </span>
                            </template>
                        </div>

                        <!-- Right: Close Button -->
                        <button type="button" 
                                @click="figureModalOpen = false" 
                                class="px-6 py-2.5 rounded-xl bg-[#17385c] hover:bg-[#102742] text-white text-xs font-black uppercase tracking-wider transition-all shadow-sm active:scale-95 cursor-pointer shrink-0">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>

            @if($activeEdition->poster_image)
            <!-- Fullscreen Lightbox Modal -->
            <div x-show="lightboxOpen" 
                 x-transition.opacity
                 @keydown.escape.window="lightboxOpen = false"
                 class="fixed inset-0 z-[120] bg-black/95 backdrop-blur-md flex items-center justify-center p-4 sm:p-8"
                 style="display: none;">
                
                <button @click="lightboxOpen = false" 
                        class="absolute top-5 right-5 sm:top-8 sm:right-8 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all cursor-pointer">
                    <i class="fas fa-times text-lg"></i>
                </button>

                <div @click.away="lightboxOpen = false" class="relative max-w-4xl max-h-[90vh] flex flex-col items-center">
                    <img src="{{ asset($activeEdition->poster_image) }}" 
                         alt="{{ $activeEdition->title }}" 
                         class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl border border-white/20">
                    <p class="text-white/80 text-xs sm:text-sm font-semibold mt-3 text-center">
                        {{ $activeEdition->title }} — Periode {{ $activeEdition->period }}
                    </p>
                </div>
            </div>
            @endif
        @else
            <div class="max-w-md mx-auto py-24 text-center text-slate-400">
                <i class="fas fa-crown text-5xl mb-3 text-slate-300"></i>
                <p class="text-sm font-medium">Belum ada edisi penghargaan yang diarsipkan.</p>
            </div>
        @endif

        @if($activeEdition && $activeEdition->audio_file)
            <!-- Hidden Audio Element for Background Music -->
            <audio id="tribute-audio-player" 
                   src="{{ asset($activeEdition->audio_file) }}" 
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
        function jejakBaktiApp() {
            return {
                lightboxOpen: false,
                storyModalOpen: {{ request('baca') === 'kisah' ? 'true' : 'false' }},
                figureModalOpen: false,
                selectedFigureIndex: 0,
                activeModalTab: 'quote',
                figuresList: @js($figuresDataJson),
                get selectedFigure() {
                    return this.figuresList[this.selectedFigureIndex] || null;
                },
                openFigureDetail(idx) {
                    this.selectedFigureIndex = idx;
                    const fig = this.figuresList[idx];
                    if (fig && !fig.quote && fig.contribution) {
                        this.activeModalTab = 'contribution';
                    } else {
                        this.activeModalTab = 'quote';
                    }
                    this.figureModalOpen = true;
                },
                nextFigure() {
                    if (this.figuresList.length > 0) {
                        this.selectedFigureIndex = (this.selectedFigureIndex + 1) % this.figuresList.length;
                        const fig = this.figuresList[this.selectedFigureIndex];
                        if (fig && !fig.quote && fig.contribution) {
                            this.activeModalTab = 'contribution';
                        } else if (fig && fig.quote && !fig.contribution) {
                            this.activeModalTab = 'quote';
                        }
                    }
                },
                prevFigure() {
                    if (this.figuresList.length > 0) {
                        this.selectedFigureIndex = (this.selectedFigureIndex - 1 + this.figuresList.length) % this.figuresList.length;
                        const fig = this.figuresList[this.selectedFigureIndex];
                        if (fig && !fig.quote && fig.contribution) {
                            this.activeModalTab = 'contribution';
                        } else if (fig && fig.quote && !fig.contribution) {
                            this.activeModalTab = 'quote';
                        }
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
                },
                appreciationCount: {{ (int)($activeEdition ? $activeEdition->appreciation_count : 0) }},
                hasAppreciated: false,
                audioPlaying: false,
                audioMuted: false,
                playerMinimized: false,
                init() {
                    this.$nextTick(() => {
                        this.initAutoplay();
                    });
                },
                initAutoplay() {
                    const audio = document.getElementById('tribute-audio-player');
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
                    const audio = document.getElementById('tribute-audio-player');
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
                    const audio = document.getElementById('tribute-audio-player');
                    if (!audio) return;
                    audio.muted = !audio.muted;
                    this.audioMuted = audio.muted;
                },
                appreciate() {
                    if (this.hasAppreciated) return;
                    this.hasAppreciated = true;
                    this.appreciationCount++;
                    
                    fetch('{{ route('tributes.appreciate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            edition_id: {{ $activeEdition ? $activeEdition->id : 'null' }}
                        })
                    }).then(res => res.json()).then(data => {
                        if(data.count) this.appreciationCount = data.count;
                    }).catch(err => console.log(err));

                    if (window.Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terima Kasih Banyak!',
                            text: 'Dukungan & rasa bangga kamu untuk para Duta GenRe telah terkirim!',
                            timer: 2300,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'rounded-2xl shadow-xl'
                            }
                        });
                    }
                }
            };
        }
    </script>
</x-layouts.app>
