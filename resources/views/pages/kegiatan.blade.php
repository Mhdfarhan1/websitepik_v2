<x-layouts.app>
    <div class="relative min-h-screen bg-slate-50">
        
        <!-- Section 1: Hero Banner Kegiatan (Full Screen 100vh - Matching Gambar 2 Exactly) -->
        <div class="relative w-full h-screen flex items-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                @php
                    $bgUrl = $heroSettings['hero_bg'] ?? '';
                    if($bgUrl && !str_starts_with($bgUrl, 'http')) {
                        $bgUrl = asset($bgUrl);
                    }
                @endphp
                <img src="{{ $bgUrl ?: 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=1600' }}" alt="Banner Kegiatan" class="w-full h-full object-cover object-center">
                
                <!-- Precise Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#17385c]/95 via-[#17385c]/85 to-blue-600/40"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20">
                <div class="max-w-2xl space-y-6 animate-fade-in-up">
                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white tracking-tight leading-tight">
                        {{ $heroSettings['hero_title_1'] ?? 'Agenda &' }} <span class="text-[#f59e0b]">{{ $heroSettings['hero_title_2'] ?? 'Kegiatan Terjadwal' }}</span>
                    </h1>
                    
                    <p class="text-slate-200 text-xs sm:text-sm leading-relaxed max-w-xl font-medium">
                        {{ $heroSettings['hero_desc'] ?? 'Jelajahi agenda sosialisasi kesehatan reproduksi remaja, pelatihan konselor sebaya, workshop edukasi GenRe, dan aksi nyata seputar remaja SMAN 1 Tasik Putri Puyu.' }}
                    </p>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="#daftar-kegiatan" class="px-6 py-3 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-xl font-bold text-xs transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2 active:scale-95">
                            <span>Lihat Agenda Terbaru</span>
                            <i class="fas fa-arrow-down text-[10px]"></i>
                        </a>
                        <a href="{{ route('edukasi') }}" class="px-6 py-3 border-2 border-white text-white rounded-xl font-bold text-xs hover:bg-white hover:text-[#17385c] transition-all flex items-center gap-2 active:scale-95">
                            <span>Layanan Konseling</span>
                            <i class="fas fa-comments text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Activities List Section -->
        <div id="daftar-kegiatan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <x-sections.activities :activities="$activities" :show-view-all="false" :show-pagination="true" />
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
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</x-layouts.app>
