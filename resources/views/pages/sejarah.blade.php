<x-layouts.app>
    <div class="relative min-h-screen pt-20 bg-slate-50">
        
        <!-- Section 1: Header (Building Background) -->
        <div class="relative overflow-hidden border-b border-slate-200">
            <!-- Local Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('assets/img/bg_utama.JPG') }}" alt="Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-white/85 backdrop-blur-[1px]"></div>
                <!-- Gradient to smooth transition -->
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-slate-50/50"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 py-12 sm:py-20 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-[11px] font-bold uppercase tracking-widest mb-4 animate-fade-in-up">
                    Profil Organisasi
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1e3a5f] tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                    {!! str_replace('PIK-R', '<span class="text-orange-500">PIK-R</span>', e($settings->sejarah_title)) !!}
                </h1>
                <div class="w-16 h-1 bg-orange-500 mx-auto mt-6 rounded-full animate-fade-in-up" style="animation-delay: 0.2s"></div>
            </div>
        </div>

        <!-- Section 1.5: Sambutan Pembina (Dynamic) -->
        <div class="max-w-6xl mx-auto px-4 py-16 sm:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Photo -->
                <div class="lg:col-span-5 animate-fade-in-up">
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-orange-500/10 rounded-[2.5rem] scale-95 group-hover:scale-100 transition-transform duration-500"></div>
                        <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border-8 border-white">
                            <img src="{{ $settings->pembina_photo ? asset($settings->pembina_photo) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800' }}" alt="Pembina" class="w-full h-auto object-cover min-h-[300px]">
                        </div>
                    </div>
                </div>

                <!-- Speech Content -->
                <div class="lg:col-span-7 space-y-6 animate-fade-in-up" style="animation-delay: 0.2s">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Sambutan <span class="text-orange-500">Pembina</span> {{ $settings->pembina_period }}
                    </h2>
                    
                    <div class="space-y-4 text-slate-600 text-sm sm:text-base leading-relaxed font-medium">
                        <p>Assalamu’alaikum warahmatullahi wabarakatuh,</p>
                        <p>Salam sejahtera bagi kita semua,</p>
                        
                        @if($settings->pembina_pantun)
                            <div class="pl-4 border-l-4 border-orange-500 py-2 italic text-slate-500 space-y-1">
                                @foreach(explode("\n", $settings->pembina_pantun) as $line)
                                    <p>{{ $line }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if($settings->pembina_speech)
                            @foreach(explode("\n\n", $settings->pembina_speech) as $para)
                                <p>{{ $para }}</p>
                            @endforeach
                        @endif

                        <div class="pt-4">
                            <p class="font-bold text-slate-900 text-base sm:text-lg">— {{ $settings->pembina_name }}</p>
                            <p class="text-[11px] font-bold text-orange-500 uppercase tracking-widest mt-1 italic">Pembina PIK-R REQUEST</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 pt-6">
                        <a href="#tentang" class="px-8 py-3.5 bg-[#1e3a5f] text-white rounded-2xl font-bold text-[15px] hover:bg-[#152a45] transition-all shadow-lg flex items-center gap-3">
                            Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('profil-lengkap') }}" class="px-8 py-3.5 border border-[#e2e8f0] text-[#334155] rounded-2xl font-bold text-[15px] hover:bg-slate-50 transition-all flex items-center gap-3 shadow-sm bg-white">
                            Profil Lengkap <i class="fas fa-user-circle text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Tentang PIK-R (Slanted Background) -->
        <div id="tentang" class="relative w-full overflow-hidden my-16 group">
            <!-- Background Slant -->
            <div class="absolute inset-0 bg-[#1e3a5f] z-0"></div>
            <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-blue-200/50 z-0 skew-x-[-15deg] origin-top translate-x-12 hidden lg:block"></div>
            <div class="absolute right-0 top-0 bottom-0 w-1/4 bg-blue-300/30 z-0 skew-x-[-15deg] origin-top translate-x-24 hidden lg:block"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 py-16 sm:py-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Text Content -->
                    <div class="space-y-8 animate-fade-in-up">
                        <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                            {!! str_replace('PIK-R REQUEST', '<span class="text-orange-500">PIK-R REQUEST</span>', e($settings->about_title)) !!}
                        </h2>
                        
                        <div class="space-y-6 text-slate-300 text-sm sm:text-base leading-relaxed">
                            @if($settings->about_content)
                                @foreach(explode("\n\n", $settings->about_content) as $para)
                                    <p>{{ $para }}</p>
                                @endforeach
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="#timeline" class="px-8 py-3 bg-orange-500 text-white rounded-full font-bold text-sm hover:bg-orange-600 transition-all shadow-lg">
                                Sejarah PIK-R
                            </a>
                        </div>
                    </div>

                    <!-- Video / Thumbnail -->
                    <div class="relative animate-fade-in-up" style="animation-delay: 0.2s">
                        <a href="{{ $settings->about_video_url }}" target="_blank" class="relative aspect-video rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 group/video block">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1200" alt="Video Thumbnail" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center group-hover/video:bg-slate-900/20 transition-all duration-500">
                                <div class="w-20 h-20 bg-red-600 text-white rounded-full flex items-center justify-center text-3xl shadow-2xl transform group-hover/video:scale-110 transition-all">
                                    <i class="fas fa-play ml-1"></i>
                                </div>
                            </div>
                            <!-- Bottom Badge -->
                            <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center text-white/90 text-[10px] font-bold uppercase tracking-widest">
                                <span>Company Profile - PIK-R REQUEST</span>
                                <div class="flex items-center gap-2">
                                    <i class="fab fa-youtube text-lg text-red-500"></i>
                                    <span>Tonton di YouTube</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Timeline -->
        <div id="timeline" class="max-w-4xl mx-auto px-4 py-16 sm:py-24">
            <div class="text-center mb-20 animate-fade-in-up" style="animation-delay: 0.4s">
                <h2 class="text-xl sm:text-2xl font-bold text-[#1e3a5f] uppercase tracking-wider">MILESTONE & PENCAPAIAN</h2>
                <div class="w-12 h-1 bg-orange-500 mx-auto mt-3 rounded-full"></div>
            </div>

            <!-- Timeline Container -->
            <div class="relative">
                <!-- Vertical Line (Centered) -->
                <div class="absolute left-4 sm:left-1/2 top-0 bottom-0 w-0.5 bg-slate-200 -translate-x-1/2"></div>
                
                <div class="space-y-16">
                    @forelse($milestones as $index => $m)
                        @if($index % 2 === 0)
                            <!-- Left aligned (even index) -->
                            <div class="relative flex items-center group animate-fade-in-up" style="animation-delay: 0.4s">
                                <!-- Dot -->
                                <div class="absolute left-4 sm:left-1/2 w-4 h-4 rounded-full bg-white border-4 border-orange-500 z-20 -translate-x-1/2 shadow-sm"></div>
                                
                                <!-- Content -->
                                <div class="ml-12 sm:ml-0 sm:w-1/2 sm:pr-12 sm:text-right">
                                    <span class="inline-block px-3 py-1 bg-orange-500 text-white text-[10px] font-bold rounded-lg mb-2">{{ $m->year }}</span>
                                    <h3 class="text-base sm:text-lg font-bold text-[#1e3a5f]">{{ $m->title }}</h3>
                                    <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed max-w-sm sm:ml-auto">{{ $m->description }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Right aligned (odd index) -->
                            <div class="relative flex items-center justify-end group animate-fade-in-up" style="animation-delay: 0.4s">
                                <!-- Dot -->
                                <div class="absolute left-4 sm:left-1/2 w-4 h-4 rounded-full bg-white border-4 border-[#1e3a5f] z-20 -translate-x-1/2 shadow-sm"></div>
                                
                                <!-- Content -->
                                <div class="ml-12 sm:ml-0 sm:w-1/2 sm:pl-12 text-left">
                                    <span class="inline-block px-3 py-1 bg-[#1e3a5f] text-white text-[10px] font-bold rounded-lg mb-2">{{ $m->year }}</span>
                                    <h3 class="text-base sm:text-lg font-bold text-[#1e3a5f]">{{ $m->title }}</h3>
                                    <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed max-w-sm">{{ $m->description }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest py-6">Belum ada data timeline sejarah.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Section 3: Prestasi Gallery (Optional/Small) -->
        <div class="w-full bg-[#1e3a5f] py-16 sm:py-20 animate-fade-in-up shadow-inner relative overflow-hidden" style="animation-delay: 0.5s">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
                <h2 class="text-xl sm:text-2xl font-bold text-white mb-6">Membangun Masa Depan Bersama</h2>
                <p class="text-slate-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                    Kami percaya bahwa setiap langkah kecil dalam mengedukasi remaja akan berdampak besar bagi kemajuan bangsa. Perjalanan kami baru saja dimulai, dan kami mengundang Anda untuk menjadi bagian dari sejarah kami selanjutnya.
                </p>
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-10 py-3.5 bg-orange-500 text-white rounded-full font-bold text-sm hover:bg-orange-600 transition-all shadow-xl hover:shadow-orange-500/20 group">
                        <span>Bergabung Bersama Kami</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
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
    </style>
</x-layouts.app>
