@props([
    'structures' => collect(),
    'settings' => [],
])

@php
    // Find key leaders: Ketua, Sekretaris, Bendahara, or take top 3 ordered
    $ketua = $structures->first(function($s) {
        return str_contains(strtolower($s->position), 'ketua');
    });
    $sekretaris = $structures->first(function($s) {
        return str_contains(strtolower($s->position), 'sekretaris');
    });
    $bendahara = $structures->first(function($s) {
        return str_contains(strtolower($s->position), 'bendahara');
    });

    // If specific positions exist, build main trio
    if ($ketua || $sekretaris || $bendahara) {
        $displayStructures = collect([$ketua, $sekretaris, $bendahara])->filter()->values();
    } else {
        // Otherwise take top 3
        $displayStructures = $structures->take(3);
    }

    // Default badge color mapping based on position
    $getBadgeStyle = function($position) {
        $pos = strtolower($position);
        if (str_contains($pos, 'ketua') || str_contains($pos, 'pimpinan')) {
            return 'bg-orange-100 text-[#d97706] border-orange-200';
        } elseif (str_contains($pos, 'sekretaris')) {
            return 'bg-blue-100 text-[#2563eb] border-blue-200';
        } elseif (str_contains($pos, 'bendahara')) {
            return 'bg-emerald-100 text-[#059669] border-emerald-200';
        } else {
            return 'bg-purple-100 text-[#7c3aed] border-purple-200';
        }
    };

    $periode = $settings['periode'] ?? 'Periode 2025/2026';
    $subtitle = $settings['subtitle'] ?? 'Dedikasi dan Inovasi untuk Generasi Berencana ' . $periode;
@endphp

<!-- Pengurus Struktural Section (Dynamically Connected) -->
<section id="pengurus" class="py-14 sm:py-20 bg-white relative overflow-hidden">
    <!-- Background Decorative Blobs -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-50 rounded-full blur-[80px] -z-10 opacity-60 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-orange-50 rounded-full blur-[100px] -z-10 opacity-60 translate-x-1/3 translate-y-1/3"></div>
    
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-12" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100 text-orange-600 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest mb-2.5 sm:mb-3">
                The Dream Team
            </div>
            <h2 class="text-2xl sm:text-[2rem] md:text-[2.75rem] font-extrabold text-slate-900 mb-3 sm:mb-4 tracking-tight leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-600">Pengurus</span> 
                <span class="text-[#f59e0b]">Struktural</span>
            </h2>
            <div class="w-14 sm:w-16 h-1 bg-gradient-to-r from-[#f59e0b] to-orange-300 mx-auto rounded-full mb-3 sm:mb-4"></div>
            <p class="text-slate-500 text-xs sm:text-base font-medium max-w-xl mx-auto px-2">{{ $subtitle }}</p>
        </div>

        @if($displayStructures->isNotEmpty())
            <!-- Dynamic Grid from DB -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 sm:gap-8 lg:gap-12 max-w-xs sm:max-w-none mx-auto">
                @foreach($displayStructures as $idx => $officer)
                    <div class="officer-card group" data-aos="fade-up" data-aos-delay="{{ ($idx + 1) * 100 }}">
                        <div class="relative aspect-[3/4] rounded-[2rem] sm:rounded-[2.5rem] overflow-hidden shadow-xl sm:shadow-2xl shadow-slate-200/50 bg-slate-100">
                            @if($officer->image)
                                <img src="{{ str_starts_with($officer->image, 'http') ? $officer->image : asset($officer->image) }}" 
                                     alt="{{ $officer->name }}" 
                                     class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-white shadow-inner flex items-center justify-center mb-3">
                                        <i class="fas fa-user-tie text-2xl sm:text-3xl text-slate-300"></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400">Foto Pengurus</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Info Card -->
                        <div class="glass-info -mt-8 sm:-mt-10 mx-4 sm:mx-6 p-4 sm:p-5 rounded-2xl sm:rounded-3xl relative z-30 text-center transition-all duration-500 group-hover:-mt-12 sm:group-hover:-mt-14 group-hover:shadow-xl group-hover:bg-white bg-white/95 backdrop-blur-md border border-white/60 shadow-lg">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1 tracking-tight line-clamp-1" title="{{ $officer->name }}">{{ $officer->name }}</h3>
                            <span class="inline-block px-3 py-0.5 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-bold uppercase tracking-wider border {{ $badgeStyle = $getBadgeStyle($officer->position) }}">
                                {{ $officer->position }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Fallback Static Trio -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 max-w-5xl mx-auto">
                <div class="officer-card group" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative aspect-[3/4] rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/50">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=800" alt="Insyirah Dwi Azhari" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="glass-info -mt-10 mx-6 p-5 rounded-3xl relative z-30 text-center transition-all duration-500 group-hover:-mt-14 group-hover:shadow-xl group-hover:bg-white bg-white/90 backdrop-blur-md border border-white/60 shadow-lg">
                        <h3 class="text-lg font-bold text-slate-900 mb-0.5 tracking-tight">Insyirah Dwi Azhari</h3>
                        <span class="inline-block px-3 py-0.5 rounded-full bg-orange-100 text-[#d97706] text-[10px] font-bold uppercase tracking-wider border border-orange-200">Ketua Umum</span>
                    </div>
                </div>

                <div class="officer-card group" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative aspect-[3/4] rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/50">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=800" alt="Kirana Ramadhani Al Irham" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="glass-info -mt-10 mx-6 p-5 rounded-3xl relative z-30 text-center transition-all duration-500 group-hover:-mt-14 group-hover:shadow-xl group-hover:bg-white bg-white/90 backdrop-blur-md border border-white/60 shadow-lg">
                        <h3 class="text-lg font-bold text-slate-900 mb-0.5 tracking-tight">Kirana Ramadhani Al Irham</h3>
                        <span class="inline-block px-3 py-0.5 rounded-full bg-blue-100 text-[#2563eb] text-[10px] font-bold uppercase tracking-wider border border-blue-200">Sekretaris Umum</span>
                    </div>
                </div>

                <div class="officer-card group" data-aos="fade-up" data-aos-delay="300">
                    <div class="relative aspect-[3/4] rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/50">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=800" alt="Putri Amelia" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="glass-info -mt-10 mx-6 p-5 rounded-3xl relative z-30 text-center transition-all duration-500 group-hover:-mt-14 group-hover:shadow-xl group-hover:bg-white bg-white/90 backdrop-blur-md border border-white/60 shadow-lg">
                        <h3 class="text-lg font-bold text-slate-900 mb-0.5 tracking-tight">Putri Amelia</h3>
                        <span class="inline-block px-3 py-0.5 rounded-full bg-emerald-100 text-[#059669] text-[10px] font-bold uppercase tracking-wider border border-emerald-200">Bendahara Umum</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action to View Full Structure -->
        <div class="mt-14 text-center" data-aos="fade-up">
            <a href="{{ route('struktur') }}" class="inline-flex items-center gap-3 px-8 py-3.5 bg-gradient-to-r from-[#1e3a5f] to-[#0f243a] hover:from-orange-500 hover:to-amber-500 text-white font-bold text-xs uppercase tracking-widest rounded-full shadow-xl shadow-slate-200 hover:shadow-orange-500/25 transition-all duration-300 group">
                <span>Lihat Bagan & Seluruh Struktur</span>
                <i class="fas fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>

