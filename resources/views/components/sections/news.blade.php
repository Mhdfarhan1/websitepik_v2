@props([
    'newsList' => []
])
<!-- Berita Terkini (Bento Grid) -->
<section class="py-14 sm:py-20 lg:py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-10" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-[2.25rem] font-bold text-slate-900 tracking-tight">
                <span class="text-[#f59e0b]">Berita</span> Terkini
            </h2>
        </div>

        @if(count($newsList ?? []) > 0)
        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 lg:grid-rows-2 gap-4 h-auto lg:h-[500px]">
            
            <!-- Main Card (Spans 2 cols, 2 rows) -->
            @if(isset($newsList[0]))
            <a href="{{ route('news.show', $newsList[0]->slug) }}" class="lg:col-span-2 lg:row-span-2 relative rounded-2xl overflow-hidden group cursor-pointer shadow-xs min-h-[280px] sm:min-h-[340px] lg:min-h-0" data-aos="fade-up">
                @if(str_starts_with($newsList[0]->image ?? '', 'http'))
                    <img src="{{ $newsList[0]->image }}" alt="Berita 1" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <img src="{{ asset($newsList[0]->image ?? 'assets/img/bg_utama.JPG') }}" alt="Berita 1" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-5 sm:p-8 flex flex-col justify-end">
                    <h3 class="text-white font-bold text-lg sm:text-2xl lg:text-3xl leading-tight mb-2 sm:mb-4 group-hover:text-[#f59e0b] transition-colors line-clamp-2">{{ $newsList[0]->title }}</h3>
                    <div class="flex items-center gap-2 text-white/80 text-xs sm:text-sm mb-2 sm:mb-4">
                        <i class="far fa-calendar-alt text-amber-400"></i>
                        <span>{{ $newsList[0]->published_at ? $newsList[0]->published_at->format('M d, Y') : '' }}</span>
                    </div>
                    <p class="text-white/70 text-xs sm:text-sm line-clamp-2 hidden sm:block">{{ Str::limit(strip_tags($newsList[0]->content), 150) }}</p>
                </div>
            </a>
            @endif

            <!-- Tall Card (Spans 1 col, 2 rows) -->
            @if(isset($newsList[1]))
            <a href="{{ route('news.show', $newsList[1]->slug) }}" class="lg:col-span-1 lg:row-span-2 relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm min-h-[300px] lg:min-h-0" data-aos="fade-up" data-aos-delay="100">
                @if(str_starts_with($newsList[1]->image ?? '', 'http'))
                    <img src="{{ $newsList[1]->image }}" alt="Berita 2" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <img src="{{ asset($newsList[1]->image ?? 'assets/img/bg_utama.JPG') }}" alt="Berita 2" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                    <h3 class="text-white font-bold text-lg lg:text-xl leading-tight mb-3 group-hover:text-[#f59e0b] transition-colors">{{ $newsList[1]->title }}</h3>
                    <div class="flex items-center gap-2 text-white/80 text-xs">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $newsList[1]->published_at ? $newsList[1]->published_at->format('M d, Y') : '' }}</span>
                    </div>
                </div>
            </a>
            @endif

            <!-- Small Card Top (Spans 1 col, 1 row) -->
            @if(isset($newsList[2]))
            <a href="{{ route('news.show', $newsList[2]->slug) }}" class="lg:col-span-1 lg:row-span-1 relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm min-h-[200px] lg:min-h-0" data-aos="fade-up" data-aos-delay="200">
                @if(str_starts_with($newsList[2]->image ?? '', 'http'))
                    <img src="{{ $newsList[2]->image }}" alt="Berita 3" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <img src="{{ asset($newsList[2]->image ?? 'assets/img/bg_utama.JPG') }}" alt="Berita 3" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                    <h3 class="text-white font-bold text-md leading-snug mb-3 group-hover:text-[#f59e0b] transition-colors">{{ $newsList[2]->title }}</h3>
                    <div class="flex items-center gap-2 text-white/80 text-xs">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $newsList[2]->published_at ? $newsList[2]->published_at->format('M d, Y') : '' }}</span>
                    </div>
                </div>
            </a>
            @endif

            <!-- Small Card Bottom (Spans 1 col, 1 row) -->
            @if(isset($newsList[3]))
            <a href="{{ route('news.show', $newsList[3]->slug) }}" class="lg:col-span-1 lg:row-span-1 relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm min-h-[200px] lg:min-h-0" data-aos="fade-up" data-aos-delay="300">
                @if(str_starts_with($newsList[3]->image ?? '', 'http'))
                    <img src="{{ $newsList[3]->image }}" alt="Berita 4" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <img src="{{ asset($newsList[3]->image ?? 'assets/img/bg_utama.JPG') }}" alt="Berita 4" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                    <h3 class="text-white font-bold text-md leading-snug mb-3 group-hover:text-[#f59e0b] transition-colors">{{ $newsList[3]->title }}</h3>
                    <div class="flex items-center gap-2 text-white/80 text-xs">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $newsList[3]->published_at ? $newsList[3]->published_at->format('M d, Y') : '' }}</span>
                    </div>
                </div>
            </a>
            @endif

        </div>
        @else
        <div class="text-center py-12">
            <p class="text-slate-400 font-semibold">Belum ada berita yang diterbitkan.</p>
        </div>
        @endif

        <!-- View More Button -->
        <div class="mt-10 text-center">
            <a href="{{ url('/semua-berita') }}" class="inline-flex items-center gap-2 bg-[#76bad8] hover:bg-[#60a3c1] text-white px-7 py-3 rounded-md font-medium shadow-sm transition-colors text-[14px]">
                Lihat Berita Lainnya <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>
