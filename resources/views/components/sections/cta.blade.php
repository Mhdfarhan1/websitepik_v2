<!-- CTA Banner Section -->
<section class="py-10 sm:py-16 lg:py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="zoom-in">
        <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden bg-[#1e3a5f] shadow-2xl flex items-center min-h-[260px]">
            
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=1200" alt="Kolaborasi Remaja" class="absolute inset-0 w-full h-full object-cover object-right lg:object-center opacity-30 mix-blend-luminosity">
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#0f172a] via-[#1e3a5f]/95 lg:via-[#1e3a5f]/85 to-[#1e3a5f]/40"></div>

            <!-- Content -->
            <div class="relative z-10 p-6 sm:p-12 lg:p-14 w-full lg:w-[75%] space-y-3 sm:space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-teal-300 text-[10px] font-extrabold uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                    Kolaborasi & Konsultasi
                </div>

                <h2 class="text-xl sm:text-3xl lg:text-4xl font-black text-white leading-tight tracking-tight">
                    &ldquo;Bangkitkan Potensi <span class="text-[#f59e0b]">Remaja Hebat</span>, Berkolaborasi Bersama Kami!&rdquo;
                </h2>

                <p class="text-slate-200 text-xs sm:text-sm leading-relaxed max-w-2xl font-normal opacity-95">
                    Mari bersama membangun ruang kolaborasi yang menginspirasi, berdampak, dan berfokus pada pengembangan wawasan konseling serta karakter remaja berencana. Buka peluang sinergi untuk menciptakan inovasi dan karya nyata bersama PIK-R REQUEST.
                </p>

                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <a href="{{ route('konseling') }}" class="inline-flex items-center justify-center gap-2 bg-[#f59e0b] hover:bg-[#d97706] text-white px-7 py-3 rounded-xl font-bold shadow-lg shadow-amber-500/20 transition-all hover:scale-105 text-xs uppercase tracking-wider active:scale-95 text-center">
                        <span>Layanan Konseling</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/25 border border-white/30 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all backdrop-blur-xs active:scale-95 text-center">
                        <span>Daftar Anggota</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
