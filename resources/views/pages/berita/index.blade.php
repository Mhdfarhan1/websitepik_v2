<x-layouts.app>
    <!-- Page Header / Hero News Carousel Style -->
    <div class="pt-[140px] md:pt-[220px] pb-12 md:pb-24 bg-slate-900 min-h-[70vh] lg:h-screen relative overflow-hidden">
        <!-- Background Layer -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/img/bg_berita.JPG') }}" alt="Hero Background" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>

        <!-- Main Content Area -->
        <div class="relative z-10 w-full max-w-7xl mx-auto h-full flex flex-col px-4">
            <!-- Top Label -->
            <div class="mb-6 md:mb-8" data-aos="fade-down">
                <h2 class="text-2xl md:text-4xl font-extrabold tracking-tight">
                    <span class="text-white">Rilis</span> <span class="text-[#f59e0b]">Berita</span>
                </h2>
            </div>

            <!-- News Slider Item -->
            @if(count($newsList) > 0)
            <div class="relative flex-1 rounded-2xl lg:rounded-3xl overflow-hidden shadow-2xl group border border-white/20 min-h-[400px] md:min-h-0">
                <!-- News Image -->
                @if(str_starts_with($newsList[0]->image ?? '', 'http'))
                    <img src="{{ $newsList[0]->image }}" alt="News Image" class="absolute inset-0 w-full h-full object-cover">
                @else
                    <img src="{{ asset($newsList[0]->image ?? 'assets/img/bg_utama.JPG') }}" alt="News Image" class="absolute inset-0 w-full h-full object-cover">
                @endif
                
                <!-- Floating Info Box (Bottom on Mobile, Right on Desktop) -->
                <div class="absolute bottom-0 md:inset-y-0 right-0 w-full lg:w-[42%] bg-black/70 md:bg-black/60 backdrop-blur-xl p-6 md:p-12 flex flex-col justify-center" data-aos="fade-left">
                    <span class="px-3 py-1 bg-amber-500/20 text-amber-400 text-[9px] font-black uppercase tracking-widest rounded-full border border-amber-500/30 w-fit mb-4">BERITA SOROTAN</span>
                    <h3 class="text-lg md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-4 md:mb-6">
                        {{ $newsList[0]->title }}
                    </h3>
                    
                    <div class="flex items-center gap-6 text-white/50 text-[10px] font-bold uppercase tracking-widest mb-4">
                        <div class="flex items-center gap-2">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ $newsList[0]->published_at ? $newsList[0]->published_at->format('M d, Y') : '' }}</span>
                        </div>
                    </div>

                    <p class="text-white/70 text-[13px] leading-relaxed mb-8 line-clamp-4 font-light">
                        {{ Str::limit(strip_tags($newsList[0]->content), 180) }}
                    </p>

                    <a href="{{ route('news.show', $newsList[0]->slug) }}" class="inline-flex items-center justify-center bg-[#7ebcd8] hover:bg-[#60a3c1] text-white px-8 py-2.5 rounded-lg font-bold text-[11px] uppercase tracking-widest transition-all w-fit shadow-md">
                        SELENGKAPNYA
                    </a>
                </div>
            </div>
            @else
            <div class="text-center py-20 bg-slate-800/40 rounded-2xl border border-slate-800">
                <p class="text-slate-400 font-medium">Belum ada berita yang diterbitkan.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- News Filter / Category Bar (Final Refined Scrollable) -->
    <div class="bg-white border-b border-slate-100 sticky top-0 md:top-[80px] z-40 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between py-3 md:py-0 gap-4">
                
                <!-- Categories: Fully Scrollable Container -->
                <div class="w-full md:w-auto overflow-x-auto no-scrollbar touch-pan-x">
                    <div class="flex items-center gap-2 md:gap-8 whitespace-nowrap min-w-max md:h-20 py-2 md:py-0">
                        <a href="#" class="px-5 py-2.5 md:px-0 md:py-0 md:h-20 flex items-center text-[10px] md:text-[11px] font-extrabold text-blue-600 bg-blue-50 md:bg-transparent rounded-full md:rounded-none border border-blue-100 md:border-none md:border-b-2 md:border-blue-500 uppercase tracking-widest">
                            SEMUA BERITA
                        </a>
                        <a href="#" class="px-5 py-2.5 md:px-0 md:py-0 md:h-20 flex items-center text-[10px] md:text-[11px] font-extrabold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors rounded-full md:rounded-none">
                            KEGIATAN
                        </a>
                        <a href="#" class="px-5 py-2.5 md:px-0 md:py-0 md:h-20 flex items-center text-[10px] md:text-[11px] font-extrabold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors rounded-full md:rounded-none">
                            EDUKASI
                        </a>
                        <a href="#" class="px-5 py-2.5 md:px-0 md:py-0 md:h-20 flex items-center text-[10px] md:text-[11px] font-extrabold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors rounded-full md:rounded-none">
                            PRESTASI
                        </a>
                        <a href="#" class="px-5 py-2.5 md:px-0 md:py-0 md:h-20 flex items-center text-[10px] md:text-[11px] font-extrabold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors rounded-full md:rounded-none">
                            ARTIKEL
                        </a>
                    </div>
                </div>
                
                <!-- Search Box -->
                <div class="relative w-full md:w-auto md:min-w-[280px] mb-2 md:mb-0">
                    <input type="text" placeholder="Cari berita..." class="w-full bg-slate-50 border border-slate-100 rounded-xl py-2.5 pl-10 pr-4 text-[11px] focus:ring-2 focus:ring-blue-100 focus:border-blue-200 transition-all outline-none text-slate-600 placeholder:text-slate-400">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Hide scrollbar but allow scrolling */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>

    <!-- Main News Grid -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(count($newsList) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @foreach ($newsList as $news)
                <!-- News Card with Overlay -->
                <a href="{{ route('news.show', $news->slug) }}" class="relative group h-[300px] md:h-[350px] rounded-lg overflow-hidden shadow-md border border-slate-100" data-aos="fade-up">
                    @if(str_starts_with($news->image ?? '', 'http'))
                        <img src="{{ $news->image }}" alt="Berita" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @else
                        <img src="{{ asset($news->image ?? 'assets/img/bg_utama.JPG') }}" alt="Berita" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    
                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                        <h3 class="text-white font-bold text-lg md:text-xl leading-snug mb-3 group-hover:text-orange-400 transition-colors">
                            {{ $news->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-white/80 text-xs mb-4">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ $news->published_at ? $news->published_at->format('M d, Y') : '' }}</span>
                        </div>
                        <div class="text-white text-[10px] font-bold uppercase tracking-widest flex items-center gap-2">
                            READ MORE 
                            <i class="fas fa-arrow-right text-[8px]"></i>
                        </div>
                    </div>
                </a>
                @endforeach

            </div>

            <!-- Pagination (Centered on Mobile) -->
            <div class="mt-12 md:mt-20">
                {{ $newsList->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <p class="text-slate-400 font-medium">Belum ada berita lainnya.</p>
            </div>
            @endif
        </div>
    </section>
</x-layouts.app>