@props([
    'tribute' => null,
    'allEditions' => []
])

@php
    $allEditions = $allEditions ?? [];
    $figures = $tribute ? $tribute->figures : [];
    $posterUrl = ($tribute && $tribute->poster_image) ? asset($tribute->poster_image) : null;
@endphp

<!-- Tribute & Hall of Fame Section (Multi-Edition / Generasi) -->
<section id="jejak-bakti" 
         class="py-16 sm:py-24 relative overflow-hidden bg-gradient-to-b from-[#0b1727] via-[#0f243e] to-[#17385c] text-white"
         x-data="{
             lightboxOpen: false,
             activeFigureIndex: 0,
             appreciationCount: {{ (int)($tribute ? $tribute->appreciation_count : 0) }},
             hasAppreciated: false,
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
                         edition_id: {{ $tribute ? $tribute->id : 'null' }}
                     })
                 }).then(res => res.json()).then(data => {
                     if(data.count) this.appreciationCount = data.count;
                 }).catch(err => console.log(err));

                 if (window.Swal) {
                     Swal.fire({
                         icon: 'success',
                         title: 'Terima Kasih!',
                         text: 'Rasa bangga & apresiasi kamu telah terkirim untuk para Duta GenRe!',
                         timer: 2200,
                         showConfirmButton: false,
                         customClass: {
                             popup: 'rounded-2xl shadow-xl'
                         }
                     });
                 }
             }
         }">
    
    <!-- Background Ambient Glow & Patterns -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-amber-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-[32rem] h-[32rem] bg-blue-500/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[radial-gradient(#ffffff08_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none opacity-40"></div>

    <div class="max-w-[88rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-amber-500/20 via-amber-400/10 to-amber-500/20 border border-amber-400/40 text-amber-300 text-xs font-black uppercase tracking-widest mb-4 shadow-sm backdrop-blur-md">
                <i class="fas fa-crown text-[11px] text-amber-400 animate-bounce"></i>
                <span>{{ $tribute->badge_title ?: 'PANGGUNG KEHORMATAN & REKAM JEJAK' }}</span>
            </div>

            <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight mb-3">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-amber-200 via-amber-400 to-amber-100">
                    {{ $tribute->title ?: 'Proud Moments Duta GenRe' }}
                </span>
            </h2>

            <!-- Periode & Subtitle -->
            <div class="flex items-center justify-center gap-2 flex-wrap text-xs sm:text-sm font-bold text-amber-400/90 tracking-wider mb-4">
                <span>{{ $tribute->subtitle ?: 'Kabupaten Kepulauan Meranti' }}</span>
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                <span class="px-2.5 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-black">Periode {{ $tribute->period }}</span>
            </div>

            <!-- Multi-Edition Period Selector (Dropdown) -->
            @if(count($allEditions) > 1)
                <div class="flex items-center justify-center gap-2 mt-4 pt-1">
                    <label for="home-period-select" class="text-xs font-bold text-slate-300 uppercase tracking-wider mr-1">
                        Pilih Periode:
                    </label>
                    <div class="relative">
                        <select id="home-period-select"
                                onchange="if(this.value) window.location.href = this.value"
                                class="appearance-none bg-white/10 hover:bg-white/15 border border-white/25 focus:border-amber-400 focus:outline-none rounded-xl pl-4 pr-9 py-1.5 text-xs font-extrabold text-amber-300 transition-all cursor-pointer shadow-md">
                            @foreach($allEditions as $ed)
                                <option value="{{ route('jejak-bakti', ['periode' => $ed->period]) }}" 
                                        {{ $ed->id === $tribute->id ? 'selected' : '' }}
                                        class="bg-[#17385c] text-white py-1">
                                    Periode {{ $ed->period }} {{ $ed->is_featured ? '★ [Utama]' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-amber-300">
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            @endif

            <div class="w-20 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto rounded-full mt-5"></div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            
            <!-- Left Column: The Poster (3D Tilt & Glassmorphism Frame) -->
            <div class="lg:col-span-5 flex flex-col items-center" data-aos="fade-right">
                <div class="relative group w-full max-w-md mx-auto">
                    @if($posterUrl)
                        <!-- Ambient Glow Behind Poster -->
                        <div class="absolute -inset-1.5 bg-gradient-to-tr from-amber-500/30 via-orange-500/20 to-blue-500/30 rounded-[2.5rem] blur-xl opacity-75 group-hover:opacity-100 transition-all duration-700"></div>

                        <!-- Poster Container Frame -->
                        <div class="relative rounded-[2rem] p-3 sm:p-4 bg-gradient-to-b from-white/15 via-white/5 to-white/10 backdrop-blur-xl border border-white/20 shadow-2xl transition-all duration-500 transform group-hover:-translate-y-2">
                            
                            <!-- Poster Image -->
                            <div class="relative rounded-2xl overflow-hidden shadow-inner bg-slate-950 aspect-[3/4] cursor-pointer"
                                 @click="lightboxOpen = true">
                                <img src="{{ $posterUrl }}" 
                                     alt="{{ $tribute ? $tribute->title : 'Poster' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                
                                <!-- Overlay on Hover -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between p-6">
                                    <span class="self-end px-3 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-bold flex items-center gap-1.5 border border-white/30">
                                        <i class="fas fa-search-plus text-amber-300"></i>
                                        <span>Perbesar Poster</span>
                                    </span>
                                    
                                    <div class="text-center text-white">
                                        <p class="text-xs font-black uppercase tracking-wider text-amber-400">Dedikasi & Apresiasi</p>
                                        <p class="text-sm font-bold text-slate-100 mt-0.5">Duta GenRe SMAN 1 Tasik Putri Puyu</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Bar Under Poster -->
                            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between gap-3 px-1">
                                <button @click="lightboxOpen = true" 
                                        class="inline-flex items-center gap-2 text-xs font-bold text-amber-300 hover:text-amber-200 transition-colors">
                                    <i class="fas fa-expand text-[11px]"></i>
                                    <span>Lihat Full HD</span>
                                </button>

                                <a href="{{ $posterUrl }}" download="Poster-Duta-Genre-{{ str_replace(' ', '-', $tribute->period) }}.jpg" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-[11px] font-bold border border-white/20 transition-all active:scale-95">
                                    <i class="fas fa-download text-[10px] text-amber-400"></i>
                                    <span>Unduh Poster</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="relative rounded-[2rem] p-8 bg-white/5 backdrop-blur-xl border border-dashed border-white/20 shadow-2xl flex flex-col items-center justify-center text-center aspect-[3/4] w-full">
                            <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-amber-400 mb-4 shadow-inner">
                                <i class="fas fa-image text-3xl text-amber-300"></i>
                            </div>
                            <h4 class="font-bold text-white text-base">Poster Belum Diunggah</h4>
                            <p class="text-xs text-slate-400 mt-2 max-w-xs leading-relaxed">
                                Poster resmi untuk periode {{ $tribute ? $tribute->period : '' }} belum diunggah oleh admin.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Tribute Narrative, Figures Cards, and Reactions -->
            <div class="lg:col-span-7 space-y-6" data-aos="fade-left">
                
                <!-- Surat & Narasi Apresiasi -->
                <div class="p-6 sm:p-7 rounded-3xl bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 p-1.5 flex items-center justify-center text-amber-400 text-lg shrink-0 mt-0.5 overflow-hidden">
                            @if($tribute && $tribute->school_logo)
                                <img src="{{ asset($tribute->school_logo) }}" alt="Logo" class="w-full h-full object-contain">
                            @else
                                <i class="fas fa-quote-left"></i>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-sm font-black uppercase tracking-wider text-amber-300">Penghargaan & Jasa Pengabdian (Periode {{ $tribute->period }})</h3>
                            @if($tribute->appreciation_quote)
                                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-normal whitespace-pre-line">
                                    {{ $tribute->appreciation_quote }}
                                </p>
                                <p class="text-[11px] font-bold text-amber-400/80 pt-1">
                                    — {{ $tribute->institution_name ?: 'Pembina & Seluruh Pengurus PIK-R REQUEST' }}
                                </p>
                            @else
                                <p class="text-slate-400 text-xs italic">
                                    Belum ada narasi apresiasi yang ditambahkan untuk periode ini.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Figure Cards for This Edition -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between px-1">
                        <span class="text-xs font-black uppercase tracking-wider text-white/80">Tokoh & Duta Kehormatan:</span>
                        <span class="text-[11px] text-amber-400 font-bold">Pilih sosok untuk membaca pesan</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @forelse($figures as $idx => $fig)
                            <div @click="activeFigureIndex = {{ $idx }}"
                                 :class="activeFigureIndex === {{ $idx }} ? 'ring-2 ring-amber-400 bg-white/15 shadow-lg' : 'bg-white/5 hover:bg-white/10 border-white/10'"
                                 class="p-4 rounded-2xl border backdrop-blur-md cursor-pointer transition-all duration-300 group/card">
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-gradient-to-tr from-amber-600 to-amber-400 flex items-center justify-center font-black text-white text-xs shrink-0 shadow-md">
                                        @if($fig->photo)
                                            <img src="{{ asset($fig->photo) }}" alt="{{ $fig->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($fig->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-extrabold text-xs text-white truncate group-hover/card:text-amber-300 transition-colors">{{ $fig->name }}</h4>
                                        <p class="text-[10px] text-amber-400/90 font-bold truncate">{{ $fig->honor_title }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-6 text-white/50 text-xs">
                                Data profil duta untuk periode ini sedang disiapkan oleh admin.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Detail Profile Panel of Active Figure -->
                @if(count($figures) > 0)
                    @foreach($figures as $idx => $fig)
                        <div x-show="activeFigureIndex === {{ $idx }}" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-white/10 to-white/5 border border-white/15 backdrop-blur-md space-y-3">
                            
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-[10px] font-black uppercase tracking-wider">
                                        {{ $fig->honor_title }}
                                    </span>
                                    @if($fig->period)
                                        <span class="text-[11px] text-slate-300 font-semibold">Tahun {{ $fig->period }}</span>
                                    @endif
                                </div>

                                @if($fig->instagram)
                                    <a href="https://instagram.com/{{ ltrim($fig->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-pink-400 hover:text-pink-300 font-bold">
                                        <i class="fab fa-instagram"></i>
                                        <span>{{ '@' . ltrim($fig->instagram, '@') }}</span>
                                    </a>
                                @endif
                            </div>

                            @if($fig->quote)
                                <div class="text-xs sm:text-sm italic text-amber-100/90 leading-relaxed pl-3 border-l-2 border-amber-400">
                                    "{{ $fig->quote }}"
                                </div>
                            @endif

                            @if($fig->contribution)
                                <div class="text-[11px] text-slate-300 leading-relaxed pt-1">
                                    <strong class="text-white font-bold">Jejak & Kontribusi:</strong> {{ $fig->contribution }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

                <!-- Bottom Interactive Action Bar -->
                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <!-- Like / Apresiasi Button -->
                    <button @click="appreciate()" 
                            :class="hasAppreciated ? 'bg-rose-600 text-white' : 'bg-white/10 hover:bg-rose-500/20 text-white border-white/20 hover:border-rose-400'"
                            class="px-5 py-3 rounded-2xl border font-black text-xs uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-2.5 shadow-lg active:scale-95 group">
                        <i class="fas fa-heart text-rose-400 group-hover:scale-125 transition-transform" :class="hasAppreciated ? 'text-white' : ''"></i>
                        <span>Beri Rasa Bangga</span>
                        <span class="px-2 py-0.5 rounded-full bg-white/20 text-[11px] font-bold ml-1" x-text="appreciationCount"></span>
                    </button>

                    <div class="flex items-center justify-between sm:justify-end gap-3">
                        @if($tribute && $tribute->story_content)
                            <a href="{{ route('jejak-bakti', ['periode' => $tribute->period, 'baca' => 'kisah']) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs uppercase tracking-wider transition-all shadow-md">
                                <i class="fas fa-book-open text-xs"></i>
                                <span>Baca Kisah Lengkap</span>
                            </a>
                        @endif

                        <!-- Link to Complete Tribute Page -->
                        <a href="{{ route('jejak-bakti', ['periode' => $tribute ? $tribute->period : '']) }}" class="inline-flex items-center justify-center gap-2 text-xs font-bold text-amber-400 hover:text-amber-300 transition-colors uppercase tracking-wider py-2">
                            <span>Museum Arsip</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

    @if($posterUrl)
    <!-- Fullscreen Lightbox Modal for Poster -->
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
            <img src="{{ $posterUrl }}" 
                 alt="{{ $tribute ? $tribute->title : 'Poster' }}" 
                 class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl border border-white/20">
            <p class="text-white/80 text-xs sm:text-sm font-semibold mt-3 text-center">
                {{ $tribute ? $tribute->title : '' }} — Periode {{ $tribute ? $tribute->period : '' }}
            </p>
        </div>
    </div>
    @endif

</section>
