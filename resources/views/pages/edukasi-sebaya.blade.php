@php
    $heroSettings = app(\App\Services\PeerEducationService::class)->getSettings();
@endphp
<x-layouts.app>
    <div class="relative min-h-screen">
        
        <!-- Section 1: Hero Edukasi Sebaya (Full Screen) -->
        <div class="relative w-full h-screen flex items-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                @php
                    $bgUrl = $heroSettings['hero_bg'] ?? '';
                    if($bgUrl && !str_starts_with($bgUrl, 'http')) {
                        $bgUrl = asset($bgUrl);
                    }
                @endphp
                <img src="{{ $bgUrl ?: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=1600' }}" alt="Edukasi Sebaya Background" class="w-full h-full object-cover object-center">
                <!-- Precise Teal-Blue Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#1e3a5f]/95 via-[#1e3a5f]/80 to-teal-500/40"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20">
                <div class="max-w-2xl space-y-6 animate-fade-in-up">
                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-white tracking-tight leading-tight">
                        {{ $heroSettings['hero_title_1'] ?? 'Edukasi' }} <span class="text-orange-500">{{ $heroSettings['hero_title_2'] ?? 'Sebaya' }}</span>
                    </h1>
                    
                    <p class="text-slate-200 text-[13px] sm:text-sm leading-relaxed max-w-xl font-medium">
                        {{ $heroSettings['hero_desc'] ?? 'Pendidik Sebaya (Peer Educator) adalah remaja yang memiliki komitmen dan kepedulian untuk memberikan edukasi serta informasi yang benar kepada teman sebaya. Kami hadir sebagai jembatan komunikasi yang relevan, akrab, dan tanpa sekat di lingkungan SMAN 1 Tasik Putri Puyu.' }}
                    </p>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="#detail-edukasi" class="px-6 py-2.5 bg-teal-400/90 text-white rounded-xl font-bold text-[12px] hover:bg-teal-500 transition-all shadow-lg flex items-center gap-2">
                            Mengenal Pendidik Sebaya <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                        <a href="#" class="px-6 py-2.5 border-2 border-white text-white rounded-xl font-bold text-[12px] hover:bg-white hover:text-[#1e3a5f] transition-all flex items-center gap-2">
                            Lihat Modul GenRe <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Detail Edukasi (Alternating Layout) -->
        <div id="detail-edukasi" class="max-w-7xl mx-auto px-4 py-20 sm:py-32 space-y-24 sm:space-y-40">
            <div class="text-center mb-20 sm:mb-32">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Pilar <span class="text-orange-500">Edukasi</span> Kami
                </h2>
                <div class="w-16 h-1 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            @forelse ($edukasi as $index => $item)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 sm:gap-20 items-center {{ $index % 2 != 0 ? 'lg:flex-row-reverse' : '' }}">
                <!-- Text Area -->
                <div class="space-y-6 sm:space-y-8 {{ $index % 2 != 0 ? 'lg:order-2' : 'lg:order-1' }}">
                    <h3 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $item->title }}
                    </h3>
                    <div class="space-y-4 sm:space-y-6 text-slate-600 text-sm sm:text-base leading-relaxed font-medium">
                        <p>{{ $item->desc }}</p>
                        @if($item->desc2)
                        <p>{{ $item->desc2 }}</p>
                        @endif
                    </div>
                </div>

                <!-- Image Area -->
                <div class="relative {{ $index % 2 != 0 ? 'lg:order-1' : 'lg:order-2' }}">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        @php
                            $imgUrl = $item->image ?? '';
                            if($imgUrl && !str_starts_with($imgUrl, 'http')) {
                                $imgUrl = asset('storage/' . $imgUrl);
                            }
                        @endphp
                        <img src="{{ $imgUrl ?: 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200' }}" alt="{{ $item->title }}" class="w-full h-auto object-cover aspect-[4/3] hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent"></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-slate-500">
                Belum ada data pilar edukasi.
            </div>
            @endforelse
        </div>

        <!-- Section 3: Horizontal CTA Banner (Precise Match) -->
        <div class="relative w-full overflow-hidden border-b-4 border-orange-500">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=1600" alt="CTA Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#3a9d91]/90"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-6 py-10 sm:py-14">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-8">
                    <div class="text-white text-center sm:text-left space-y-1">
                        <h4 class="text-xl sm:text-2xl font-bold tracking-tight">
                            Ingin berkonsultasi atau bergabung dengan PIK-R REQUEST?
                        </h4>
                        <p class="text-white/90 text-sm sm:text-base font-medium">
                            Kami selalu terbuka untuk mendengarkan dan tumbuh bersama setiap remaja.
                        </p>
                    </div>
                    
                    <div class="flex-shrink-0">
                        <a href="#" class="px-8 py-2.5 border border-white text-white rounded-xl font-bold text-[13px] hover:bg-white hover:text-[#3a9d91] transition-all flex items-center gap-3">
                            Hubungi Konselor <i class="fas fa-chevron-right text-[10px]"></i>
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
