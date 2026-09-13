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
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100 text-orange-600 text-[11px] font-bold uppercase tracking-widest mb-4 animate-fade-in-up">
                    Kepengurusan
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1e3a5f] tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                    Struktur <span class="text-orange-500">Organisasi</span>
                </h1>
                <div class="w-16 h-1 bg-orange-500 mx-auto mt-6 rounded-full animate-fade-in-up" style="animation-delay: 0.2s"></div>
                <p class="mt-6 text-slate-500 text-sm sm:text-base font-medium max-w-xl mx-auto animate-fade-in-up" style="animation-delay: 0.3s">
                    {{ $settings['subtitle'] ?? 'Dedikasi dan Inovasi untuk Generasi Berencana Periode ' . ($settings['periode'] ?? '2025/2026') . ' PIK-R REQUEST SMAN 1 Tasik Putri Puyu' }}
                </p>
            </div>
        </div>

        <!-- Section 2: Inti Kepengurusan (Grid) -->
        <div class="max-w-6xl mx-auto px-4 py-16 sm:py-24 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="text-center mb-12">
                <h2 class="text-xl sm:text-2xl font-bold text-[#1e3a5f] uppercase tracking-wider">INTI KEPENGURUSAN</h2>
                <div class="w-12 h-1 bg-orange-500 mx-auto mt-3 rounded-full"></div>
            </div>

            @php
                $groupedPengurus = $pengurus->groupBy('order_index');
            @endphp

            @if($groupedPengurus->isEmpty())
                <div class="text-center py-10">
                    <p class="text-slate-400 font-bold text-sm">Belum ada data pengurus yang ditambahkan.</p>
                </div>
            @else
                <div class="w-full overflow-x-auto pb-12 pt-4">
                    <div class="min-w-max mx-auto flex flex-col items-center">
                        @foreach($groupedPengurus as $level => $members)
                            
                            <!-- Parent connector going down (only if not first level) -->
                            @if(!$loop->first)
                                <div class="w-[2px] h-6 sm:h-8 bg-orange-500 relative z-0"></div>
                            @endif

                            <!-- Level Container -->
                            <div class="flex justify-center gap-0 relative">
                                @foreach($members as $person)
                                    <!-- Node -->
                                    <div class="relative flex flex-col items-center px-2 sm:px-6">
                                        
                                        <!-- Connecting lines -->
                                        @if(!$loop->parent->first)
                                            @if(count($members) > 1)
                                                <!-- Horizontal Line Left -->
                                                @if(!$loop->first)
                                                <div class="absolute top-0 right-[50%] w-[50%] h-[2px] bg-orange-500"></div>
                                                @endif
                                                
                                                <!-- Horizontal Line Right -->
                                                @if(!$loop->last)
                                                <div class="absolute top-0 left-[50%] w-[50%] h-[2px] bg-orange-500"></div>
                                                @endif
                                            @endif
                                            
                                            <!-- Vertical Line Down to Card -->
                                            <div class="w-[2px] h-6 sm:h-8 bg-orange-500 mb-0"></div>
                                        @endif

                                        <!-- The Card itself -->
                                        <div class="group relative aspect-[3/4] w-44 sm:w-56 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border-4 border-white mt-0 ring-1 ring-slate-100 bg-slate-100">
                                            <img src="{{ $person->image ? (str_starts_with($person->image, 'http') ? $person->image : asset($person->image)) : asset('assets/img/bg_utama.JPG') }}" alt="{{ $person->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f] via-[#1e3a5f]/40 to-transparent opacity-90 group-hover:from-orange-600 transition-colors duration-500"></div>
                                            <div class="absolute bottom-0 inset-x-0 p-4 sm:p-5 text-center translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                                <p class="text-[9px] sm:text-[10px] font-black text-white/80 uppercase tracking-widest mb-1">{{ $person->position }}</p>
                                                <h4 class="text-xs sm:text-sm font-bold text-white leading-tight uppercase">{{ $person->name }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Section 3: Bagan Struktur (Diagram) -->
        <div class="w-full bg-[#1e3a5f] py-16 sm:py-24 animate-fade-in-up shadow-inner relative overflow-hidden" style="animation-delay: 0.5s">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-48 -mt-48 blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full -ml-48 -mb-48 blur-[100px]"></div>

            <div class="max-w-5xl mx-auto px-4 relative z-10 text-center">
                <div class="space-y-4 mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Bagan Struktur Organisasi</h2>
                    <p class="text-slate-300 text-sm max-w-lg mx-auto">Visualisasi hierarki dan koordinasi kepengurusan PIK-R REQUEST SMAN 1 Tasik Putri Puyu {{ $settings['periode'] ?? 'Periode 2025/2026' }}</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md p-4 sm:p-8 rounded-[2rem] border border-white/10 shadow-2xl">
                    <div class="bg-white rounded-xl overflow-hidden shadow-inner p-2 sm:p-4">
                        @if(!empty($settings['bagan_image']))
                            <img src="{{ asset($settings['bagan_image']) }}" alt="Bagan Struktur" class="w-full h-auto rounded-lg transition-all duration-700">
                        @else
                            <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&q=80&w=1200" alt="Bagan Struktur Placeholder" class="w-full h-auto rounded-lg filter grayscale opacity-90 hover:grayscale-0 hover:opacity-100 transition-all duration-700">
                        @endif
                    </div>
                </div>
                
                <div class="mt-12">
                    @if(!empty($settings['bagan_pdf']))
                        <a href="{{ asset($settings['bagan_pdf']) }}" target="_blank" download class="inline-flex items-center gap-3 px-8 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs sm:text-sm rounded-full shadow-lg shadow-orange-500/30 transition-all group backdrop-blur-sm">
                            <i class="fas fa-file-pdf group-hover:scale-110 transition-transform"></i>
                            <span>Unduh Bagan Struktur (PDF)</span>
                        </a>
                    @else
                        <button disabled class="inline-flex items-center gap-3 px-8 py-3 bg-white/10 text-white/60 border border-white/10 rounded-full font-bold text-xs sm:text-sm cursor-not-allowed">
                            <i class="fas fa-info-circle"></i>
                            <span>Bagan PDF Belum Diunggah</span>
                        </button>
                    @endif
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
