@props([
    'achievementList' => []
])

<!-- Prestasi Section -->
<section class="py-14 sm:py-20 lg:py-24 bg-white relative border-t border-slate-100">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10 items-stretch">
            
            <!-- Left Column: Text & Button -->
            <div class="lg:w-[35%] flex flex-col justify-center" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-100 text-amber-600 text-[11px] font-bold uppercase tracking-widest mb-3 sm:mb-4 w-max">
                    <i class="fas fa-trophy text-[10px]"></i> Rekam Jejak Juara
                </div>

                <h2 class="text-2xl sm:text-3xl lg:text-[2.25rem] font-bold text-slate-900 mb-4 sm:mb-6 tracking-tight leading-tight">
                    <span class="text-[#f59e0b]">{{ $appearance['achievement_title_1'] ?? 'Prestasi' }}</span> {{ $appearance['achievement_title_2'] ?? 'PIK-R' }}
                </h2>
                
                <div class="bg-slate-50 p-5 sm:p-7 mb-6 sm:mb-8 rounded-2xl border border-slate-100 relative">
                    <p class="text-slate-600 leading-relaxed text-xs sm:text-sm lg:text-[15px] relative z-10 font-normal">
                        {{ $appearance['achievement_desc'] ?? 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu terus mengukir prestasi dan apresiasi di tingkat kabupaten hingga provinsi sebagai pusat informasi dan edukasi remaja yang aktif, inovatif, dan berprestasi.' }}
                    </p>
                </div>

                <div>
                    <a href="{{ route('prestasi') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 bg-[#1e3a5f] hover:bg-[#152a45] text-white px-7 py-3.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all text-xs uppercase tracking-wider group active:scale-95 text-center">
                        <span>Lihat Semua Prestasi</span>
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Right Column: Bento Grid of Achievements -->
            <div class="lg:w-[65%]" data-aos="fade-left">
                @if(count($achievementList) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 h-auto lg:h-[480px]">
                    
                    <!-- Main Card (Tall, Left) -->
                    @if(isset($achievementList[0]))
                    <a href="{{ route('prestasi.show', $achievementList[0]->id) }}" class="relative group overflow-hidden bg-slate-900 h-full min-h-[340px] lg:min-h-0 rounded-3xl border border-slate-100 shadow-md block">
                        @if(str_starts_with($achievementList[0]->image ?? '', 'http'))
                            <img src="{{ $achievementList[0]->image }}" alt="{{ $achievementList[0]->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-80">
                        @else
                            <img src="{{ asset($achievementList[0]->image ?? 'assets/img/bg_utama.JPG') }}" alt="{{ $achievementList[0]->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-80">
                        @endif
                        
                        <!-- Top Tag -->
                        <div class="absolute top-4 left-4 z-10">
                            <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-bold uppercase tracking-wider shadow-xs">
                                <i class="fas fa-award text-amber-500 mr-1"></i> {{ $achievementList[0]->author ?? 'Prestasi Utama' }}
                            </span>
                        </div>

                        <!-- Bottom overlay -->
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/85 to-transparent p-6 sm:p-7 flex flex-col justify-end min-h-[160px]">
                            <h3 class="text-white font-extrabold text-lg sm:text-xl leading-snug mb-3 group-hover:text-[#f59e0b] transition-colors line-clamp-2">
                                {{ $achievementList[0]->title }}
                            </h3>
                            <div class="flex items-center justify-between text-white/80 text-xs font-medium pt-2 border-t border-white/10">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-calendar-alt text-orange-400"></i>
                                    <span>{{ $achievementList[0]->date ? $achievementList[0]->date->format('d M Y') : '' }}</span>
                                </div>
                                <span class="text-orange-400 text-xs font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                    Detail <i class="fas fa-chevron-right text-[9px]"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endif

                    <!-- Right Stack (Two smaller cards) -->
                    <div class="grid grid-rows-2 gap-5 h-full">
                        <!-- Top Right Card -->
                        @if(isset($achievementList[1]))
                        <a href="{{ route('prestasi.show', $achievementList[1]->id) }}" class="relative group overflow-hidden bg-slate-900 h-full min-h-[200px] lg:min-h-0 rounded-3xl border border-slate-100 shadow-md block">
                            @if(str_starts_with($achievementList[1]->image ?? '', 'http'))
                                <img src="{{ $achievementList[1]->image }}" alt="{{ $achievementList[1]->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-80">
                            @else
                                <img src="{{ asset($achievementList[1]->image ?? 'assets/img/bg_utama.JPG') }}" alt="{{ $achievementList[1]->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-80">
                            @endif
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent p-5 sm:p-6 flex flex-col justify-end min-h-[120px]">
                                <h3 class="text-white font-bold text-sm sm:text-base leading-snug mb-2 group-hover:text-[#f59e0b] transition-colors line-clamp-2">
                                    {{ $achievementList[1]->title }}
                                </h3>
                                <div class="flex items-center justify-between text-white/75 text-[11px]">
                                    <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt text-orange-400"></i> {{ $achievementList[1]->date ? $achievementList[1]->date->format('d M Y') : '' }}</span>
                                    <span class="text-orange-400 font-bold">Detail →</span>
                                </div>
                            </div>
                        </a>
                        @endif

                        <!-- Bottom Right Card -->
                        @if(isset($achievementList[2]))
                        <a href="{{ route('prestasi.show', $achievementList[2]->id) }}" class="relative group overflow-hidden bg-slate-900 h-full min-h-[200px] lg:min-h-0 rounded-3xl border border-slate-100 shadow-md block">
                            @if(str_starts_with($achievementList[2]->image ?? '', 'http'))
                                <img src="{{ $achievementList[2]->image }}" alt="{{ $achievementList[2]->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-80">
                            @else
                                <img src="{{ asset($achievementList[2]->image ?? 'assets/img/bg_utama.JPG') }}" alt="{{ $achievementList[2]->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-80">
                            @endif
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent p-5 sm:p-6 flex flex-col justify-end min-h-[120px]">
                                <h3 class="text-white font-bold text-sm sm:text-base leading-snug mb-2 group-hover:text-[#f59e0b] transition-colors line-clamp-2">
                                    {{ $achievementList[2]->title }}
                                </h3>
                                <div class="flex items-center justify-between text-white/75 text-[11px]">
                                    <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt text-orange-400"></i> {{ $achievementList[2]->date ? $achievementList[2]->date->format('d M Y') : '' }}</span>
                                    <span class="text-orange-400 font-bold">Detail →</span>
                                </div>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
                @else
                <div class="text-center py-20 bg-slate-50 border border-slate-100 rounded-3xl shadow-sm">
                    <p class="text-slate-400 font-medium">Belum ada prestasi yang dipublikasikan.</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</section>
