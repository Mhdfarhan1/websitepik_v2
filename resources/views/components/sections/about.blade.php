<!-- Tentang Kami & Statistik -->
<section id="tentang" class="py-14 sm:py-20 lg:py-24 bg-[#f8fafc] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            
            <!-- Left Column: Text & Stats -->
            <div data-aos="fade-right" class="order-2 lg:order-1">
                <!-- Tag -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 mb-4 sm:mb-6 w-max border border-slate-200">
                    <div class="w-3.5 h-3.5 rounded-full bg-[#f59e0b] flex items-center justify-center text-white text-[7px]">
                        <i class="fas fa-play ml-0.5"></i>
                    </div>
                    <span class="text-[11px] sm:text-[12px] font-bold text-[#1e293b]">{{ $appearance['about_tag'] ?? 'Video Profil Organisasi' }}</span>
                </div>

                <!-- Heading -->
                <h2 class="text-2xl sm:text-3xl lg:text-[2.75rem] font-extrabold leading-[1.2] mb-4 sm:mb-6 tracking-tight">
                    <span class="font-serif text-[#1e293b] font-bold">{{ $appearance['about_title_1'] ?? 'Mengenal' }} </span>
                    <span class="text-[#386b99] font-sans">{{ $appearance['about_title_2'] ?? 'PIK-R REQUEST' }}</span><br/>
                    <span class="text-[#f59e0b] font-sans">{{ $appearance['about_title_3'] ?? 'Lebih Dekat' }}</span>
                </h2>
                
                <p class="text-slate-500 mb-6 sm:mb-10 leading-relaxed text-xs sm:text-[15px] max-w-lg">
                    {{ $appearance['about_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu adalah wadah inovatif bagi remaja. Sebagai pusat informasi dan konseling, kami membangun ekosistem yang suportif dan kreatif. Dari pemberian materi hingga praktik nyata yang mengubah cara remaja menghadapi tantangan di era modern.' }}
                </p>

                <!-- Stats Row -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-8 sm:mb-10" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 text-center shadow-xs hover:shadow-md transition-shadow">
                        <h3 class="text-2xl sm:text-[2.5rem] leading-none font-extrabold text-[#1e3a8a] mb-1.5 counter" data-target="{{ $appearance['about_stat1_val'] ?? 4 }}">0</h3>
                        <p class="text-[10px] sm:text-[11px] font-semibold text-slate-500">{{ $appearance['about_stat1_lbl'] ?? 'Pilar Utama' }}</p>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 text-center shadow-xs hover:shadow-md transition-shadow">
                        <h3 class="text-2xl sm:text-[2.5rem] leading-none font-extrabold text-[#1e3a8a] mb-1.5 counter" data-target="{{ $appearance['about_stat2_val'] ?? 50 }}">0</h3>
                        <p class="text-[10px] sm:text-[11px] font-semibold text-slate-500">{{ $appearance['about_stat2_lbl'] ?? 'Anggota' }}</p>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 text-center shadow-xs hover:shadow-md transition-shadow">
                        <h3 class="text-2xl sm:text-[2.5rem] leading-none font-extrabold text-[#1e3a8a] mb-1.5 counter" data-target="{{ $appearance['about_stat3_val'] ?? 20 }}">0</h3>
                        <p class="text-[10px] sm:text-[11px] font-semibold text-slate-500">{{ $appearance['about_stat3_lbl'] ?? 'Kegiatan' }}</p>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 text-center shadow-xs hover:shadow-md transition-shadow">
                        <h3 class="text-2xl sm:text-[2.5rem] leading-none font-extrabold text-[#1e3a8a] mb-1.5 counter" data-target="{{ $appearance['about_stat4_val'] ?? 5 }}">0</h3>
                        <p class="text-[10px] sm:text-[11px] font-semibold text-slate-500">{{ $appearance['about_stat4_lbl'] ?? 'Tahun' }}</p>
                    </div>
                </div>

                <!-- Button -->
                <a href="{{ $appearance['about_video_url'] ?? '#video' }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center bg-[#7ebcd8] hover:bg-[#60a3c1] text-white px-7 py-3 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all shadow-md group text-center">
                    Tonton Video
                    <i class="fas fa-arrow-right ml-2.5 text-[9px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- Right Column: Video Thumbnail -->
            <div class="relative order-1 lg:order-2" data-aos="fade-left">
                @php
                    $videoUrl = $appearance['about_video_url'] ?? '#video';
                @endphp
                <a href="{{ $videoUrl }}" target="_blank" class="block aspect-[16/10] rounded-[1.5rem] overflow-hidden shadow-2xl relative group cursor-pointer bg-slate-900 border-[6px] border-white">
                    <!-- Image -->
                    @if(isset($appearance['about_video_thumbnail']) && str_starts_with($appearance['about_video_thumbnail'], 'http'))
                        <img src="{{ $appearance['about_video_thumbnail'] }}" alt="Video Profil PIK-R" class="object-cover w-full h-full opacity-60 group-hover:scale-105 transition-transform duration-700">
                    @else
                        <img src="{{ asset($appearance['about_video_thumbnail'] ?? 'assets/img/bg_utama.JPG') }}" alt="Video Profil PIK-R" class="object-cover w-full h-full opacity-60 group-hover:scale-105 transition-transform duration-700">
                    @endif
                    
                    <!-- Overlay gradients -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a192f] via-[#0a192f]/20 to-[#0a192f]/80"></div>
                    
                    <!-- Top Left Info (Fake YouTube style) -->
                    <div class="absolute top-5 left-5 right-5 flex items-start gap-3 z-10">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="font-extrabold text-[#386b99] text-lg">R</span>
                        </div>
                        <div class="text-white drop-shadow-md pt-0.5">
                            <h4 class="font-bold text-sm tracking-wide leading-tight">{{ $appearance['about_video_title'] ?? 'VIDEO PROFIL PIK-R REQUEST' }}</h4>
                            <p class="text-[10px] text-white/80 font-medium mt-0.5">{{ $appearance['about_video_subtitle'] ?? 'SMAN 1 Tasik Putri Puyu' }}</p>
                        </div>
                    </div>

                    <!-- Center Play Button -->
                    <div class="absolute inset-0 flex items-center justify-center z-10">
                        <div class="w-[68px] h-[46px] bg-[#ff0000] rounded-[14px] flex items-center justify-center text-white text-xl shadow-xl group-hover:bg-[#cc0000] group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-play ml-1"></i>
                        </div>
                    </div>

                    <!-- Bottom Text -->
                    <div class="absolute bottom-5 inset-x-5 flex items-center justify-between z-10 text-white drop-shadow-md">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-share text-lg opacity-80 hover:opacity-100 transition-opacity"></i>
                            <i class="far fa-clock text-lg opacity-80 hover:opacity-100 transition-opacity"></i>
                            <h3 class="font-bold text-xl tracking-widest text-white/90 ml-2 hidden sm:block">{{ $appearance['about_video_period'] ?? 'Periode 2024-2025' }}</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-semibold">Tonton di</span>
                            <i class="fab fa-youtube text-[28px]"></i>
                        </div>
                    </div>
                </a>
                
                <!-- Decorative blur -->
                <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-[#386b99]/20 rounded-full blur-3xl -z-10"></div>
            </div>

        </div>
    </div>
</section>
