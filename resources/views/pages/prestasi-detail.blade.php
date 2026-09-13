<x-layouts.app>
    <div x-data="{
        lightboxOpen: false,
        activePhoto: '',
        activeCaption: '',
        openLightbox(src, caption = '') {
            this.activePhoto = src;
            this.activeCaption = caption;
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = 'auto';
        }
    }">
        <!-- Page Header / Subtle Clean Breadcrumbs -->
        <div class="pt-36 sm:pt-40 pb-8 bg-slate-50 border-b border-slate-100/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ url('/') }}" class="hover:text-orange-500 transition-colors flex items-center gap-1.5">
                                <i class="fas fa-home text-[10px]"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-[8px] mx-2 text-slate-300"></i>
                                <a href="{{ route('prestasi') }}" class="hover:text-orange-500 transition-colors">Prestasi</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-[8px] mx-2 text-slate-300"></i>
                                <span class="text-slate-400 truncate max-w-[200px] sm:max-w-[320px]" title="{{ $achievement->title }}">
                                    {{ Str::limit($achievement->title, 32) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content Section -->
        <section class="py-12 lg:py-16 bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                    
                    <!-- Left Column: Prestasi Content (65% width) -->
                    <div class="lg:w-[65%] space-y-8">
                        
                        <!-- Badges Row -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3.5 py-1 bg-amber-50 text-amber-600 border border-amber-200/80 rounded-full text-xs font-extrabold shadow-xs flex items-center gap-1.5">
                                <i class="fas fa-trophy text-[10px]"></i> Prestasi Resmi
                            </span>
                            <span class="px-3.5 py-1 bg-blue-50 text-blue-700 border border-blue-200/80 rounded-full text-xs font-extrabold uppercase tracking-wider shadow-xs">
                                <i class="fas fa-award text-[10px] mr-1"></i> {{ $achievement->author ?? 'Tingkat Kabupaten' }}
                            </span>
                            @if($achievement->images->count() > 0)
                                <span class="px-3.5 py-1 bg-teal-50 text-teal-700 border border-teal-200/80 rounded-full text-xs font-extrabold shadow-xs flex items-center gap-1">
                                    <i class="fas fa-images text-[10px]"></i> {{ $achievement->images->count() + 1 }} Foto Dokumentasi
                                </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 leading-[1.25] tracking-tight">
                            {{ $achievement->title }}
                        </h1>

                        <!-- Author & Social Share Row -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100" x-data="{ copied: false }">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-[#1e3a5f] to-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-md">
                                    <i class="fas fa-award text-amber-300"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-extrabold text-slate-800">
                                        {{ $achievement->author ?? 'Pusat Informasi & Konseling Remaja' }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5 mt-0.5">
                                        <i class="far fa-calendar-alt text-orange-500"></i>
                                        <span>{{ $achievement->date ? $achievement->date->format('d F Y') : 'Tanggal Tidak Dicatat' }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Share Buttons -->
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mr-1">SHARE:</span>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($achievement->title . ' - ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all duration-300 shadow-sm" title="Bagikan ke WhatsApp">
                                    <i class="fab fa-whatsapp text-sm"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all duration-300 shadow-sm" title="Bagikan ke Facebook">
                                    <i class="fab fa-facebook-f text-sm"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($achievement->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all duration-300 shadow-sm" title="Bagikan ke Twitter">
                                    <i class="fab fa-twitter text-sm"></i>
                                </a>
                                <button @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                        class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all duration-300 shadow-sm cursor-pointer" 
                                        :title="copied ? 'Tersalin!' : 'Salin Tautan'">
                                    <i :class="copied ? 'fas fa-check text-emerald-500' : 'fas fa-link text-xs'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Main Image Banner (Clickable to Lightbox) -->
                        @php
                            $mainImg = $achievement->image;
                            if ($mainImg && !str_starts_with($mainImg, 'http')) {
                                $mainImg = asset($mainImg);
                            }
                        @endphp
                        <div class="relative rounded-2xl overflow-hidden shadow-xl shadow-slate-200/60 bg-slate-900 border border-slate-100 group cursor-pointer"
                             @click="openLightbox('{{ $mainImg ?: asset('assets/img/bg_utama.JPG') }}', '{{ addslashes($achievement->title) }}')">
                            <img src="{{ $mainImg ?: asset('assets/img/bg_utama.JPG') }}" alt="{{ $achievement->title }}" class="w-full h-auto max-h-[500px] object-cover group-hover:scale-105 transition-transform duration-700">
                            
                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-4 py-2 rounded-full bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-bold shadow flex items-center gap-2">
                                    <i class="fas fa-search-plus text-orange-500"></i> Klik untuk Memperbesar Foto
                                </span>
                            </div>
                        </div>

                        <!-- Key Event Details Grid Box (Like Kegiatan) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 sm:p-5 bg-gradient-to-br from-amber-50/80 to-amber-50/20 rounded-2xl border border-amber-100 flex items-start gap-3.5 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-amber-500/20">
                                    <i class="far fa-calendar-alt text-base"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-[10px] font-bold text-amber-800/60 uppercase tracking-widest block">Tanggal Penerimaan</span>
                                    <strong class="text-slate-800 font-extrabold text-xs sm:text-sm block mt-0.5 truncate">{{ $achievement->date ? $achievement->date->format('d F Y') : '-' }}</strong>
                                </div>
                            </div>

                            <div class="p-4 sm:p-5 bg-gradient-to-br from-blue-50/80 to-blue-50/20 rounded-2xl border border-blue-100 flex items-start gap-3.5 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-[#1e3a5f] text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-blue-600/20">
                                    <i class="fas fa-award text-base text-amber-400"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-[10px] font-bold text-blue-900/60 uppercase tracking-widest block">Penyelenggara Apresiasi</span>
                                    <strong class="text-slate-800 font-extrabold text-xs sm:text-sm block mt-0.5 truncate">{{ $achievement->author }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Story / Description -->
                        <div class="space-y-4 pt-2">
                            <h3 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                                <i class="fas fa-file-alt text-orange-500 text-base"></i>
                                <span>Keterangan & Ulasan Prestasi</span>
                            </h3>
                            <div class="text-slate-650 text-sm sm:text-base leading-relaxed space-y-4 font-normal">
                                {!! nl2br(e($achievement->description)) !!}
                            </div>
                        </div>

                        <!-- Multiple Documentation Photos Section -->
                        @if($achievement->images->count() > 0)
                        <div class="pt-6 border-t border-slate-100 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm font-bold border border-teal-100">
                                        <i class="fas fa-images"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-slate-900">Galeri Foto Dokumentasi</h3>
                                        <p class="text-xs text-slate-400 font-medium">Klik pada foto mana pun untuk melihat ukuran penuh</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-bold border border-teal-100">
                                    {{ $achievement->images->count() }} Foto Tambahan
                                </span>
                            </div>

                            <!-- Photo Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4 pt-2">
                                @foreach($achievement->images as $index => $photo)
                                    <div class="relative group rounded-2xl overflow-hidden border border-slate-200/80 bg-slate-50 aspect-video shadow-xs cursor-pointer"
                                         @click="openLightbox('{{ asset($photo->image_path) }}', 'Dokumentasi #{{ $index + 1 }}: {{ addslashes($achievement->title) }}')">
                                        <img src="{{ asset($photo->image_path) }}" alt="Foto Dokumentasi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        
                                        <!-- Hover Overlay -->
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <div class="w-9 h-9 rounded-full bg-white/95 text-slate-800 flex items-center justify-center shadow-lg transform scale-75 group-hover:scale-100 transition-transform">
                                                <i class="fas fa-expand text-xs"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Back to List Link -->
                        <div class="pt-8 border-t border-slate-100">
                            <a href="{{ route('prestasi') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold uppercase tracking-wider transition-all active:scale-95">
                                <i class="fas fa-arrow-left text-[10px]"></i>
                                <span>Kembali ke Semua Prestasi</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Sidebar (35% width) -->
                    <div class="lg:w-[35%] space-y-8">
                        
                        <!-- Prestasi Terbaru Widget (Matching Agenda Terbaru) -->
                        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                            <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                                <h3 class="text-base font-black text-slate-900">Prestasi Lainnya</h3>
                                <a href="{{ route('prestasi') }}" class="text-xs font-bold text-orange-500 hover:text-orange-600 transition-colors">
                                    Lihat Semua
                                </a>
                            </div>

                            <div class="space-y-6">
                                @forelse($relatedAchievements as $rel)
                                    <div class="space-y-2">
                                        <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                            {{ $rel->author ?? 'Apresiasi' }}
                                        </span>
                                        <a href="{{ route('prestasi.show', $rel->id) }}" class="block text-sm font-bold text-slate-800 hover:text-blue-600 transition-colors leading-snug line-clamp-2">
                                            {{ $rel->title }}
                                        </a>
                                        <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400">
                                            <i class="far fa-calendar-alt text-orange-400"></i>
                                            <span>{{ $rel->date ? $rel->date->format('M d, Y') : '-' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400">Belum ada prestasi lainnya.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Counseling CTA Widget -->
                        <div class="rounded-3xl p-6 bg-gradient-to-br from-[#1e3a5f] to-[#17385c] text-white shadow-xl space-y-4">
                            <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center text-teal-300 text-lg border border-white/15">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-extrabold tracking-tight">Ingin Konsultasi dengan Konselor Sebaya?</h4>
                                <p class="text-xs text-slate-200/90 leading-relaxed font-normal mt-1.5">
                                    Punya pertanyaan tentang GenRe atau ingin curhat aman dan terjaga? Tim konselor PIK-R REQUEST siap mendengarkan.
                                </p>
                            </div>
                            <a href="{{ route('konseling') }}" class="inline-flex items-center justify-center gap-2 w-full py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-md active:scale-95">
                                <span>Konsultasi Sekarang</span>
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Lightbox Modal (For Full Screen Photo Zoom) -->
        <div x-show="lightboxOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-8"
             @keydown.escape.window="closeLightbox()"
             style="display: none;">
            
            <!-- Close Button -->
            <button @click="closeLightbox()" class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition-all cursor-pointer z-10">
                <i class="fas fa-times"></i>
            </button>

            <!-- Lightbox Content -->
            <div class="max-w-4xl max-h-[85vh] flex flex-col items-center" @click.outside="closeLightbox()">
                <img :src="activePhoto" class="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl border border-white/10">
                <p class="text-white/80 text-xs sm:text-sm font-medium mt-4 text-center max-w-xl" x-text="activeCaption"></p>
            </div>
        </div>
    </div>
</x-layouts.app>
