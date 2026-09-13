<x-layouts.app>
    <div class="relative min-h-screen bg-slate-50/50">
        @php
            $heroBgColor = $settings['hero_bg_color'] ?? '#1e3a5f';
            $heroBg = $settings['hero_bg'] ?? 'https://images.unsplash.com/photo-1531545517246-167e1fd8b76c?auto=format&fit=crop&q=80&w=1600';
            if ($heroBg && !str_starts_with($heroBg, 'http')) {
                $heroBg = asset($heroBg);
            }
            $heroTag = $settings['hero_tag'] ?? 'Jejak Apresiasi & Prestasi';
            $heroTitle1 = $settings['hero_title_1'] ?? 'Capaian &';
            $heroTitle2 = $settings['hero_title_2'] ?? 'Prestasi';
            $heroDesc = $settings['hero_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu terus berkomitmen untuk memberikan dampak positif. Berbagai penghargaan dan apresiasi telah kami raih sebagai wujud dedikasi kami dalam mengedukasi generasi berencana.';
            $sectionTitle1 = $settings['section_title_1'] ?? 'Dedikasi';
            $sectionTitle2 = $settings['section_title_2'] ?? 'Tanpa Henti';
        @endphp

        <!-- Section 1: Hero Prestasi (Adjustable Background & Banner) -->
        <div class="relative w-full min-h-[480px] sm:min-h-[540px] flex items-center overflow-hidden pt-28 pb-16" style="background-color: {{ $heroBgColor }};">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ $heroBg }}" alt="Prestasi Background" class="w-full h-full object-cover object-center opacity-30">
                <!-- Precise Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-black/40"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/50"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl space-y-6 animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-teal-300 text-[11px] font-extrabold uppercase tracking-widest shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                        {{ $heroTag }}
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        {{ $heroTitle1 }} <span class="text-orange-500">{{ $heroTitle2 }}</span>
                    </h1>
                    
                    <p class="text-slate-200 text-sm sm:text-base leading-relaxed max-w-xl font-medium opacity-95">
                        {{ $heroDesc }}
                    </p>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="#daftar-prestasi" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-orange-500/25 flex items-center gap-2">
                            <span>Jelajahi Capaian Juara</span>
                            <i class="fas fa-arrow-down text-[10px]"></i>
                        </a>
                        <a href="{{ route('gallery.index') }}" class="px-6 py-3 bg-white/15 hover:bg-white/25 border border-white/30 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all backdrop-blur-sm flex items-center gap-2">
                            <i class="fas fa-camera text-[11px]"></i>
                            <span>Galeri Kegiatan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Daftar Prestasi (Compact Card Grid with Pagination) -->
        <div id="daftar-prestasi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <!-- Header Section -->
            <div class="text-center mb-12 sm:mb-16">
                <div class="inline-block mb-3">
                    <span class="text-xs font-black uppercase tracking-widest text-orange-500 bg-orange-50 px-3.5 py-1 rounded-full border border-orange-100">
                        Apresiasi & Rekam Jejak
                    </span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    {{ $sectionTitle1 }} <span class="text-orange-500">{{ $sectionTitle2 }}</span>
                </h2>
                <div class="w-16 h-1 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Compact Card Grid (3 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @forelse ($prestasiList as $item)
                <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group hover:-translate-y-1">
                    <!-- Image Cover Container -->
                    <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                        @php
                            $imgSrc = $item->image;
                            if ($imgSrc && !str_starts_with($imgSrc, 'http')) {
                                $imgSrc = asset($imgSrc);
                            }
                        @endphp
                        <img src="{{ $imgSrc ?: asset('assets/img/bg_utama.JPG') }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        
                        <!-- Category / Author Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/90 backdrop-blur-md text-orange-600 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-xs">
                                <i class="fas fa-award text-amber-500"></i> {{ $item->author ?? 'Apresiasi' }}
                            </span>
                        </div>

                        <!-- Photo Count Badge -->
                        @if($item->images->count() > 0)
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-black/60 backdrop-blur-md text-white rounded-full text-[10px] font-bold shadow-xs">
                                    <i class="fas fa-images"></i> +{{ $item->images->count() }} Foto
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2.5">
                            @if($item->date)
                                <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                                    <i class="far fa-calendar-alt text-orange-500"></i>
                                    <span>{{ $item->date->format('d M Y') }}</span>
                                </div>
                            @endif

                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors leading-snug line-clamp-2">
                                <a href="{{ route('prestasi.show', $item->id) }}">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            <p class="text-slate-500 text-xs sm:text-[13px] leading-relaxed line-clamp-3">
                                {{ $item->description }}
                            </p>
                        </div>

                        <!-- Footer Link -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('prestasi.show', $item->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-orange-500 hover:text-orange-600 uppercase tracking-wider group/link">
                                <span>Lihat Detail</span>
                                <i class="fas fa-arrow-right text-[10px] transition-transform group-hover/link:translate-x-1"></i>
                            </a>
                            <a href="{{ route('prestasi.show', $item->id) }}" class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-orange-500 group-hover:text-white text-slate-400 flex items-center justify-center text-xs transition-all">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20 bg-white border border-slate-200/80 rounded-3xl w-full max-w-xl mx-auto shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center mx-auto mb-4 text-2xl border border-amber-100">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-800">Belum Ada Prestasi yang Ditampilkan</h4>
                    <p class="text-slate-400 text-xs mt-1">Data capaian prestasi sedang dalam proses penginputan.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination Bar (6 per Page with Prev, 1, 2, 3, Next) -->
            @if(method_exists($prestasiList, 'hasPages'))
            <div class="mt-12 sm:mt-16 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-200/80 pt-8">
                <div class="flex items-center gap-2.5">
                    <div class="w-2.5 h-2.5 rounded-full bg-orange-500 shadow-[0_0_10px_rgba(249,115,22,0.5)]"></div>
                    <p class="text-xs font-bold text-slate-500">
                        Menampilkan <span class="text-slate-900 font-extrabold">{{ $prestasiList->firstItem() ?? 0 }} - {{ $prestasiList->lastItem() ?? 0 }}</span> dari <span class="text-slate-900 font-extrabold">{{ $prestasiList->total() }}</span> Total Capaian Prestasi
                    </p>
                </div>

                @if($prestasiList->hasPages())
                <div class="flex flex-wrap items-center justify-center gap-2">
                    {{-- Previous Page Link --}}
                    @if ($prestasiList->onFirstPage())
                        <span class="px-3.5 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 font-bold text-xs flex items-center gap-1.5 cursor-not-allowed select-none">
                            <i class="fas fa-chevron-left text-[10px]"></i>
                            <span>Sebelumnya</span>
                        </span>
                    @else
                        <a href="{{ $prestasiList->previousPageUrl() }}#daftar-prestasi" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all flex items-center gap-1.5 shadow-sm active:scale-95">
                            <i class="fas fa-chevron-left text-[10px]"></i>
                            <span>Sebelumnya</span>
                        </a>
                    @endif

                    {{-- Page Numbers (1, 2, 3...) --}}
                    <div class="flex items-center gap-1">
                        @foreach ($prestasiList->getUrlRange(1, $prestasiList->lastPage()) as $page => $url)
                            @if ($page == $prestasiList->currentPage())
                                <span class="w-9 h-9 rounded-xl bg-orange-500 text-white font-black text-xs flex items-center justify-center shadow-md shadow-orange-500/20 select-none">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}#daftar-prestasi" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-100 transition-all flex items-center justify-center shadow-sm active:scale-95">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>

                    {{-- Next Page Link --}}
                    @if ($prestasiList->hasMorePages())
                        <a href="{{ $prestasiList->nextPageUrl() }}#daftar-prestasi" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all flex items-center gap-1.5 shadow-sm active:scale-95">
                            <span>Selanjutnya</span>
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                    @else
                        <span class="px-3.5 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 font-bold text-xs flex items-center gap-1.5 cursor-not-allowed select-none">
                            <span>Selanjutnya</span>
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </span>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Section 3: Horizontal CTA Banner -->
        <div class="relative w-full overflow-hidden border-b-4 border-orange-500">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=1600" alt="CTA Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#1e3a5f]/90"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-6 py-12 sm:py-16">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-8">
                    <div class="text-white text-center sm:text-left space-y-2">
                        <h4 class="text-xl sm:text-2xl font-bold tracking-tight">
                            {{ $settings['cta_title'] ?? 'Ingin berkonsultasi atau bergabung dengan PIK-R REQUEST?' }}
                        </h4>
                        <p class="text-slate-200 text-sm sm:text-base font-medium opacity-90">
                            {{ $settings['cta_desc'] ?? 'Kami selalu terbuka untuk mendengarkan dan tumbuh bersama setiap remaja.' }}
                        </p>
                    </div>
                    
                    <div class="flex-shrink-0">
                        <a href="{{ route('konseling') }}" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-xl flex items-center gap-3">
                            <span>Hubungi Konselor Sebaya</span>
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
            opacity: 0;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</x-layouts.app>
