<!-- Mitra & Logo Section -->
<section class="bg-slate-50/70 py-14 sm:py-16 border-y border-slate-100 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.25em] mb-10">
            Didukung & Berkolaborasi Bersama Mitra Strategis
        </p>
        
        <!-- Center Container -->
        <div class="flex flex-wrap items-center justify-center gap-10 sm:gap-16 md:gap-20">
            @forelse($partners ?? [] as $partner)
                <div class="flex-shrink-0 flex items-center justify-center p-3 rounded-2xl bg-white border border-slate-100 shadow-xs hover:shadow-md hover:border-slate-200 transition-all duration-300 group cursor-pointer">
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-10 sm:h-14 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-70 group-hover:opacity-100 group-hover:scale-105">
                </div>
            @empty
                <!-- Fallback Icons -->
                <div class="flex items-center opacity-30 gap-10 text-slate-400">
                    <i class="fas fa-shield-alt text-3xl"></i>
                    <i class="fas fa-hand-holding-heart text-3xl"></i>
                    <i class="fas fa-users text-3xl"></i>
                </div>
            @endforelse
        </div>
    </div>
</section>
