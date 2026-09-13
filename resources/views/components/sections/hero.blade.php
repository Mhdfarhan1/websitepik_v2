<!-- Hero Section (Full Cover Style) -->
<section id="beranda" class="relative min-h-[90vh] lg:min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay & Animations -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <!-- Campus/School Background Image with Ken Burns Effect -->
        <img src="{{ asset($appearance['hero_bg'] ?? 'assets/img/bg_utama.JPG') }}"
            alt="bg utama" class="w-full h-full object-cover object-top animate-ken-burns" />
        
        <!-- Animated Decorative Blobs -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-brand/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-teal-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>

        <!-- Dark Blue Moody Overlays -->
        <div class="absolute inset-0 bg-[#0f172a]/70 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0f172a]/40 via-transparent to-[#0f172a]"></div>
        
        <!-- Grid Pattern Overlay for Tech Feel -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>

    <style>
        @keyframes ken-burns {
            0% { transform: scale(1); }
            100% { transform: scale(1.15); }
        }
        .animate-ken-burns {
            animation: ken-burns 30s ease-out infinite alternate;
        }
    </style>

    <div class="relative z-10 text-center px-4 sm:px-6 w-full max-w-5xl mx-auto py-24 sm:py-28 lg:py-32 flex flex-col items-center justify-center" data-aos="zoom-out"
        data-aos-duration="1500">
        <!-- Main Title (Bold Sans) -->
        <h1 class="text-white drop-shadow-2xl text-center leading-none" style="font-family: 'Montserrat', sans-serif;">
            <span class="inline-block px-3.5 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[11px] sm:text-xs md:text-sm font-bold uppercase tracking-[0.2em] text-white mb-3 sm:mb-4"
                data-aos="fade-down" data-aos-delay="200">Selamat Datang di</span>
            <span class="block text-3xl sm:text-4xl md:text-5xl lg:text-[3.75rem] font-black uppercase tracking-tight text-white leading-tight mt-1">{{ $appearance['hero_title'] ?? 'PIK-R REQUEST' }}</span>
        </h1>

        <!-- Subtitle (Cursive/Script) -->
        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-[2.75rem] text-amber-300 drop-shadow-lg font-normal mt-2 sm:mt-3"
            style="font-family: 'Dancing Script', cursive;" data-aos="fade-up" data-aos-delay="600">
            {{ $appearance['hero_subtitle'] ?? 'SMA Negeri 1 Tasik Putri Puyu' }}
        </h2>

        <!-- Mobile-friendly CTA button group -->
        <div class="mt-6 sm:mt-8 flex flex-wrap items-center justify-center gap-3 w-full max-w-xs sm:max-w-none" data-aos="fade-up" data-aos-delay="800">
            <a href="#tentang" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-[#f59e0b] hover:bg-[#d97706] text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-amber-500/25 transition-all text-center">
                Jelajahi Profil
            </a>
            <a href="{{ route('konseling') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-md border border-white/30 text-white font-bold text-xs uppercase tracking-wider transition-all text-center">
                Layanan Konseling
            </a>
        </div>
    </div>
</section>