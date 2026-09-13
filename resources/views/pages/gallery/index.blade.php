<x-layouts.app>
    <div x-data="{
        lightboxOpen: false,
        activePhoto: '',
        activeCaption: '',
        activeIndex: 0,
        photos: [
            @foreach($galleryList as $idx => $item)
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

        <!-- Page Header / Hero Banner -->
        <div class="pt-[140px] md:pt-[190px] pb-14 md:pb-20 bg-gradient-to-r from-[#132c4a] via-[#17385c] to-[#1e40af] relative overflow-hidden text-white">
            <!-- Background Image overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('assets/img/bg_berita.JPG') }}" alt="Gallery BG" class="w-full h-full object-cover opacity-15">
                <div class="absolute inset-0 bg-gradient-to-b from-[#132c4a]/80 via-transparent to-[#132c4a]"></div>
            </div>

            <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Breadcrumbs -->
                <nav class="flex justify-center text-xs font-bold text-blue-200/80 uppercase tracking-widest mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li>
                            <a href="{{ url('/') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1.5">
                                <i class="fas fa-home text-[10px]"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li><span class="text-white/40">/</span></li>
                        <li class="text-amber-400 font-extrabold">Galeri & Kegiatan</li>
                    </ol>
                </nav>

                <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-4 text-white" data-aos="fade-up">
                    Galeri & <span class="text-[#f59e0b]">Kegiatan</span>
                </h1>
                <p class="text-blue-100/90 text-xs sm:text-base max-w-2xl mx-auto font-normal leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                    Dokumentasi potret kegiatan, kreativitas, edukasi sebaya, dan momen kebersamaan pengurus serta anggota PIK-R REQUEST SMAN 1 Tasik Putri Puyu.
                </p>
            </div>
        </div>

        <!-- Gallery Grid Section -->
        <section class="py-16 sm:py-24 bg-slate-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                @if(count($galleryList) > 0)
                    <!-- Filter / Stats Bar -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-200/80">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-xs font-black uppercase tracking-wider text-slate-700">Semua Dokumentasi</span>
                            <span class="text-[11px] font-bold text-slate-400 bg-white px-2.5 py-0.5 rounded-full border border-slate-200">
                                {{ $galleryList->total() }} Foto
                            </span>
                        </div>
                        <p class="text-xs font-semibold text-slate-400 flex items-center gap-1.5">
                            <i class="fas fa-mouse-pointer text-blue-500 text-[10px]"></i>
                            <span>Klik pada foto untuk melihat ukuran penuh</span>
                        </p>
                    </div>

                    <!-- Uniform, Consistent, Beautiful Grid Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-7">
                        @foreach($galleryList as $index => $gallery)
                            @php
                                $imgSrc = $gallery->image ?? '';
                                if ($imgSrc && !str_starts_with($imgSrc, 'http')) {
                                    $imgSrc = asset($imgSrc);
                                }
                                $imgSrc = $imgSrc ?: asset('assets/img/bg_utama.JPG');
                            @endphp
                            
                            <div @click="openLightbox({{ $index }})" 
                                 class="group bg-white rounded-2xl border border-slate-200/80 hover:border-blue-400/60 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 overflow-hidden flex flex-col justify-between cursor-pointer"
                                 data-aos="fade-up" 
                                 data-aos-delay="{{ ($index % 4) * 80 }}">
                                
                                <!-- Image Container -->
                                <div class="relative overflow-hidden aspect-[4/3] w-full bg-slate-100 shrink-0">
                                    <img src="{{ $imgSrc }}" 
                                         alt="{{ $gallery->title ?? 'Galeri Kegiatan' }}" 
                                         class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 ease-out"
                                         loading="lazy">
                                    
                                    <!-- Hover Zoom Icon Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-base border border-white/30 shadow-xl transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>

                                    <!-- Top Pill Badge -->
                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-black/50 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-wider border border-white/20 shadow-sm">
                                            <i class="fas fa-camera text-amber-400 text-[9px]"></i>
                                            <span>Momen</span>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Card Footer Description -->
                                <div class="p-5 flex flex-col justify-between flex-1">
                                    <div>
                                        <h3 class="font-bold text-sm sm:text-[15px] text-slate-800 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $gallery->title ?: 'Dokumentasi Kegiatan PIK-R REQUEST' }}
                                        </h3>
                                    </div>

                                    <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-400">
                                        <span class="flex items-center gap-1 text-[11px]">
                                            <i class="far fa-calendar-alt text-slate-400"></i>
                                            {{ $gallery->created_at ? $gallery->created_at->translatedFormat('d M Y') : 'Terbaru' }}
                                        </span>
                                        <span class="text-blue-600 font-extrabold text-[11px] group-hover:translate-x-1 transition-transform flex items-center gap-1">
                                            <span>Lihat</span>
                                            <i class="fas fa-arrow-right text-[9px]"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($galleryList->hasPages())
                        <div class="mt-16 flex justify-center">
                            {{ $galleryList->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-20 bg-white rounded-3xl border border-slate-200/80 shadow-sm max-w-xl mx-auto p-8">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 border border-blue-100">
                            <i class="fas fa-images text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 mb-1">Belum Ada Foto</h3>
                        <p class="text-slate-400 text-xs font-medium">Dokumentasi kegiatan PIK-R REQUEST akan segera ditampilkan di sini.</p>
                    </div>
                @endif

            </div>
        </section>

        <!-- Fullscreen Interactive Lightbox Modal -->
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

    </div>
</x-layouts.app>
