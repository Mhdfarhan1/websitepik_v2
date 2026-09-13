@props([
    'galleryList' => []
])

<!-- Galeri & Kegiatan (New Layout matching Screenshot) -->
<section class="py-14 sm:py-20 lg:py-24 relative overflow-hidden bg-gradient-to-r from-[#17385c] via-[#21517a] to-[#7bb3ce]">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-8 items-center">
            
            <!-- Left Text Section -->
            <div class="lg:w-[35%] w-full text-white pl-0 lg:pl-10 text-center lg:text-left" data-aos="fade-right">
                <h2 class="text-2xl sm:text-3xl lg:text-[2.5rem] font-bold mb-3 sm:mb-6 tracking-tight leading-tight">
                    <span class="text-[#f59e0b]">{{ $appearance['gallery_title_1'] ?? 'Galeri' }}</span> & {{ $appearance['gallery_title_2'] ?? 'Kegiatan' }}
                </h2>
                <p class="text-white/90 text-xs sm:text-[15px] leading-relaxed mb-6 sm:mb-8 pr-0 lg:pr-4 max-w-xl mx-auto lg:mx-0">
                    {{ $appearance['gallery_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu memiliki beragam karya dan potret kegiatan yang dihasilkan dari program edukasi, konseling sebaya, dan pembinaan kecakapan hidup (life skill).' }}
                </p>
                <a href="{{ route('gallery.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#f59e0b] hover:bg-[#d97706] text-white px-7 py-3.5 rounded-xl font-semibold shadow-lg transition-all text-xs sm:text-[14px]">
                    <span>Lihat Galeri & Kegiatan Lainnya</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Right Images Section -->
            <div class="lg:w-[65%] w-full relative group" data-aos="fade-left">
                <!-- Navigation Arrows -->
                @if(count($galleryList) > 0)
                <button id="prev-gallery" class="absolute left-2 lg:-left-6 top-[45%] -translate-y-1/2 z-30 w-12 h-12 bg-white/90 backdrop-blur-md rounded-full shadow-xl flex items-center justify-center text-slate-800 hover:bg-white hover:scale-110 transition-all opacity-0 group-hover:opacity-100 hidden lg:flex">
                    <i class="fas fa-chevron-left text-lg"></i>
                </button>
                <button id="next-gallery" class="absolute right-2 lg:-right-6 top-[45%] -translate-y-1/2 z-30 w-12 h-12 bg-white/90 backdrop-blur-md rounded-full shadow-xl flex items-center justify-center text-slate-800 hover:bg-white hover:scale-110 transition-all opacity-0 group-hover:opacity-100 hidden lg:flex">
                    <i class="fas fa-chevron-right text-lg"></i>
                </button>
                @endif

                <!-- Scrollable Container -->
                <div id="gallery-slider" class="flex flex-nowrap gap-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide items-center justify-start scroll-smooth">
                    @forelse($galleryList as $index => $gallery)
                        @php
                            $isWide = ($index % 2 === 1);
                            $isPolaroid = ($index % 3 === 0);
                            
                            $widthClass = $isWide ? 'w-[340px] md:w-[480px]' : 'w-[240px] md:w-[280px]';
                            $cardStyle = $isPolaroid 
                                ? 'bg-white p-2 border border-slate-100 shadow-2xl' 
                                : 'shadow-2xl';
                            $imgStyle = $isPolaroid ? 'rounded-lg' : '';
                        @endphp
                        
                        <div class="flex-none {{ $widthClass }} h-[360px] md:h-[400px] relative snap-center rounded-xl overflow-hidden {{ $cardStyle }} shrink-0">
                            @if(str_starts_with($gallery->image ?? '', 'http'))
                                <img src="{{ $gallery->image }}" alt="{{ $gallery->title ?? 'Galeri' }}" class="w-full h-full object-cover {{ $imgStyle }}">
                            @else
                                <img src="{{ asset($gallery->image ?? 'assets/img/bg_utama.JPG') }}" alt="{{ $gallery->title ?? 'Galeri' }}" class="w-full h-full object-cover {{ $imgStyle }}">
                            @endif
                            
                            @if($gallery->title)
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent p-6 pt-12 flex flex-col justify-end text-white">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-[#f59e0b] mb-1">Potret Kegiatan</p>
                                    <h4 class="font-bold text-sm md:text-base leading-snug">{{ $gallery->title }}</h4>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-20 text-white/60 w-full">
                            <p class="text-sm font-medium">Belum ada foto galeri.</p>
                        </div>
                    @endforelse
                    
                    <div class="flex-none w-4 md:w-8"></div>
                </div>
                
                <!-- Dots Indicators -->
                @if(count($galleryList) > 0)
                <div class="flex justify-center lg:justify-start lg:pl-[15%] gap-2 mt-4">
                    @foreach($galleryList as $index => $gallery)
                        <div class="w-2 h-2 rounded-full {{ $index === 0 ? 'bg-slate-900' : 'bg-slate-900/30' }} cursor-pointer transition-all duration-300 hover:bg-slate-900/50" data-slide-index="{{ $index }}"></div>
                    @endforeach
                </div>
                @endif

                <!-- Mobile Swipe Hint -->
                <div class="lg:hidden flex items-center justify-center gap-2 mt-6 text-white/60 text-[10px] font-bold uppercase tracking-widest">
                    <i class="fas fa-arrows-left-right animate-pulse"></i>
                    <span>Geser untuk melihat</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Scrollbar hiding styles -->
<style>
    #gallery-slider::-webkit-scrollbar {
        display: none;
    }
    #gallery-slider {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<!-- Slider JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('gallery-slider');
        const prevBtn = document.getElementById('prev-gallery');
        const nextBtn = document.getElementById('next-gallery');
        const dots = document.querySelectorAll('[data-slide-index]');

        if (!slider) return;

        const scrollAmount = 350;

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        }

        // Active dots highlight on scroll
        slider.addEventListener('scroll', () => {
            if (dots.length === 0) return;
            const scrollLeft = slider.scrollLeft;
            const maxScrollLeft = slider.scrollWidth - slider.clientWidth;
            const scrollPercentage = scrollLeft / (maxScrollLeft || 1);
            const activeIndex = Math.min(
                Math.round(scrollPercentage * (dots.length - 1)),
                dots.length - 1
            );

            dots.forEach((dot, idx) => {
                if (idx === activeIndex) {
                    dot.classList.add('bg-slate-900');
                    dot.classList.remove('bg-slate-900/30');
                } else {
                    dot.classList.add('bg-slate-900/30');
                    dot.classList.remove('bg-slate-900');
                }
            });
        });

        // Dot click scroll
        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-slide-index'));
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                const targetScroll = maxScroll * (idx / (dots.length - 1 || 1));
                slider.scrollTo({ left: targetScroll, behavior: 'smooth' });
            });
        });
    });
</script>
