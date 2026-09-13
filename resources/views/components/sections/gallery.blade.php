@props([
    'galleryList' => []
])

<!-- Galeri & Kegiatan (Harmonized Modern Layout with Lightbox) -->
<section class="py-14 sm:py-20 lg:py-24 relative overflow-hidden bg-gradient-to-r from-[#17385c] via-[#21517a] to-[#7bb3ce]"
         x-data="{
             lightboxOpen: false,
             activePhoto: '',
             activeCaption: '',
             activeIndex: 0,
             photos: [
                 @foreach($galleryList as $item)
                     @php
                         $imgUrl = $item->image ?? '';
                         if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                             $imgUrl = asset($imgUrl);
                         }
                     @endphp
                     {
                         src: '{{ $imgUrl ?: asset('assets/img/bg_utama.JPG') }}',
                         caption: '{{ addslashes($item->title ?? 'Dokumentasi Kegiatan') }}'
                     },
                 @endforeach
             ],
             openLightbox(index) {
                 if (this.photos[index]) {
                     this.activeIndex = index;
                     this.activePhoto = this.photos[index].src;
                     this.activeCaption = this.photos[index].caption;
                     this.lightboxOpen = true;
                     document.body.style.overflow = 'hidden';
                 }
             },
             closeLightbox() {
                 this.lightboxOpen = false;
                 document.body.style.overflow = 'auto';
             },
             nextPhoto() {
                 if (this.photos.length <= 1) return;
                 this.activeIndex = (this.activeIndex + 1) % this.photos.length;
                 this.activePhoto = this.photos[this.activeIndex].src;
                 this.activeCaption = this.photos[this.activeIndex].caption;
             },
             prevPhoto() {
                 if (this.photos.length <= 1) return;
                 this.activeIndex = (this.activeIndex - 1 + this.photos.length) % this.photos.length;
                 this.activePhoto = this.photos[this.activeIndex].src;
                 this.activeCaption = this.photos[this.activeIndex].caption;
             }
         }">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-8 items-center">
            
            <!-- Left Text Section -->
            <div class="lg:w-[32%] w-full text-white pl-0 lg:pl-6 text-center lg:text-left" data-aos="fade-right">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold uppercase tracking-wider mb-4 border border-amber-400/30">
                    <i class="fas fa-camera text-[10px]"></i>
                    <span>Dokumentasi</span>
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-[2.5rem] font-black mb-3 sm:mb-5 tracking-tight leading-tight">
                    <span class="text-[#f59e0b]">{{ $appearance['gallery_title_1'] ?? 'Galeri' }}</span> & {{ $appearance['gallery_title_2'] ?? 'Kegiatan' }}
                </h2>
                <p class="text-white/85 text-xs sm:text-[14px] leading-relaxed mb-6 sm:mb-8 pr-0 lg:pr-4 max-w-xl mx-auto lg:mx-0">
                    {{ $appearance['gallery_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu memiliki beragam karya dan potret kegiatan yang dihasilkan dari program edukasi, konseling sebaya, dan pembinaan kecakapan hidup (life skill).' }}
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                    <a href="{{ route('gallery.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 hover:text-white px-7 py-3.5 rounded-xl font-bold shadow-lg transition-all text-xs sm:text-[14px] hover:shadow-amber-500/30">
                        <span>Semua Galeri</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Right Images Section -->
            <div class="lg:w-[68%] w-full relative group" data-aos="fade-left">
                <!-- Navigation Arrows -->
                @if(count($galleryList) > 0)
                <button id="prev-gallery" class="absolute left-2 lg:-left-5 top-[45%] -translate-y-1/2 z-30 w-11 h-11 bg-white/95 backdrop-blur-md rounded-full shadow-2xl flex items-center justify-center text-slate-800 hover:bg-white hover:scale-110 active:scale-95 transition-all opacity-0 group-hover:opacity-100 hidden lg:flex border border-slate-200">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
                <button id="next-gallery" class="absolute right-2 lg:-right-5 top-[45%] -translate-y-1/2 z-30 w-11 h-11 bg-white/95 backdrop-blur-md rounded-full shadow-2xl flex items-center justify-center text-slate-800 hover:bg-white hover:scale-110 active:scale-95 transition-all opacity-0 group-hover:opacity-100 hidden lg:flex border border-slate-200">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
                @endif

                <!-- Scrollable Container -->
                <div id="gallery-slider" class="flex flex-nowrap gap-5 overflow-x-auto pb-4 pt-1 snap-x snap-mandatory scrollbar-hide items-center justify-start scroll-smooth">
                    @forelse($galleryList as $index => $gallery)
                        @php
                            $imgSrc = $gallery->image ?? '';
                            if ($imgSrc && !str_starts_with($imgSrc, 'http')) {
                                $imgSrc = asset($imgSrc);
                            }
                            $imgSrc = $imgSrc ?: asset('assets/img/bg_utama.JPG');
                        @endphp
                        
                        <div @click="openLightbox({{ $index }})"
                             class="flex-none w-[280px] sm:w-[320px] h-[370px] sm:h-[400px] relative snap-center rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 shrink-0 cursor-pointer bg-slate-900 border border-white/20 group/card">
                            
                            <img src="{{ $imgSrc }}" 
                                 alt="{{ $gallery->title ?? 'Galeri Kegiatan' }}" 
                                 class="w-full h-full object-cover group-hover/card:scale-108 transition-transform duration-700 ease-out"
                                 loading="lazy">
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent flex flex-col justify-between p-5">
                                <div class="flex justify-between items-start">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-black/50 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-wider border border-white/20">
                                        <i class="fas fa-camera text-amber-400 text-[9px]"></i>
                                        <span>Potret</span>
                                    </span>
                                    <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity border border-white/30 text-xs">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-400 mb-1">Momen Kegiatan</p>
                                    <h4 class="font-bold text-white text-sm sm:text-base leading-snug line-clamp-2">{{ $gallery->title ?: 'Dokumentasi Kegiatan' }}</h4>
                                </div>
                            </div>
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
                <div class="flex justify-center lg:justify-start lg:pl-[5%] gap-2 mt-4">
                    @foreach($galleryList as $index => $gallery)
                        <div class="w-2 h-2 rounded-full {{ $index === 0 ? 'bg-amber-400 scale-125' : 'bg-white/30' }} cursor-pointer transition-all duration-300 hover:bg-white/60" data-slide-index="{{ $index }}"></div>
                    @endforeach
                </div>
                @endif

                <!-- Mobile Swipe Hint -->
                <div class="lg:hidden flex items-center justify-center gap-2 mt-4 text-white/70 text-[11px] font-bold uppercase tracking-widest">
                    <i class="fas fa-arrows-left-right animate-pulse text-amber-400"></i>
                    <span>Geser atau sentuh foto untuk melihat</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Fullscreen Interactive Lightbox Modal for Homepage -->
    <div x-show="lightboxOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md flex items-center justify-center p-4 sm:p-8 select-none"
         @keydown.escape.window="closeLightbox()"
         @keydown.arrow-right.window="nextPhoto()"
         @keydown.arrow-left.window="prevPhoto()"
         style="display: none;">
        
        <!-- Top Controls -->
        <div class="absolute top-4 sm:top-6 inset-x-4 sm:inset-x-8 flex items-center justify-between z-20 pointer-events-none">
            <div class="pointer-events-auto bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/15 text-white text-xs font-bold font-mono">
                <span x-text="activeIndex + 1"></span> / <span x-text="photos.length"></span>
            </div>

            <div class="pointer-events-auto flex items-center gap-2">
                <a :href="activePhoto" download target="_blank" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition-all cursor-pointer border border-white/15" title="Buka gambar asli">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <button @click="closeLightbox()" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center text-base transition-all cursor-pointer border border-white/15" title="Tutup (Esc)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Arrows (Left / Right) -->
        <button x-show="photos.length > 1" 
                @click="prevPhoto()" 
                class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-lg transition-all cursor-pointer z-20 border border-white/15 hover:scale-110 active:scale-95"
                title="Foto Sebelumnya (Panah Kiri)">
            <i class="fas fa-chevron-left"></i>
        </button>

        <button x-show="photos.length > 1" 
                @click="nextPhoto()" 
                class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-lg transition-all cursor-pointer z-20 border border-white/15 hover:scale-110 active:scale-95"
                title="Foto Selanjutnya (Panah Kanan)">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Lightbox Center Content -->
        <div class="max-w-5xl max-h-[90vh] flex flex-col items-center justify-center w-full z-10" @click.outside="closeLightbox()">
            <div class="relative max-h-[75vh] sm:max-h-[80vh] flex items-center justify-center">
                <img :src="activePhoto" 
                     :alt="activeCaption"
                     class="max-w-full max-h-[75vh] sm:max-h-[80vh] object-contain rounded-2xl shadow-2xl border border-white/10 transition-all duration-300">
            </div>

            <!-- Caption -->
            <div class="mt-4 text-center max-w-2xl px-4">
                <h4 class="text-white text-sm sm:text-base font-bold leading-snug drop-shadow" x-text="activeCaption"></h4>
                <p class="text-white/50 text-[11px] font-semibold mt-1">Gunakan panah keyboard (← / →) untuk berpindah foto atau Esc untuk menutup.</p>
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
