<x-layouts.app>
    <div class="relative min-h-screen pt-20 bg-slate-50">
        
        <!-- Section 1: Header & Visi/Misi (Building Background) -->
        <div class="relative overflow-hidden border-b border-slate-200">
            <!-- Local Background Image -->
            <div class="absolute inset-0 z-0">
                @php
                    $bgUrl = $settings->visi_misi_bg ?? '';
                    if($bgUrl && !str_starts_with($bgUrl, 'http')) {
                        $bgUrl = asset('storage/' . $bgUrl);
                    }
                @endphp
                <img src="{{ $bgUrl ?: asset('assets/img/bg_utama.JPG') }}" alt="Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-white/85 backdrop-blur-[1px]"></div>
                <!-- Gradient to smooth transition -->
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-slate-50/50"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 py-12 sm:py-20">
                <!-- Header Section -->
                <div class="text-center mb-10 space-y-3 animate-fade-in-up">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f] tracking-tight">
                        Visi & <span class="text-orange-500">Misi</span>
                    </h1>
                    <div class="w-16 h-1 bg-orange-500 mx-auto rounded-full"></div>
                </div>

                <!-- Visi & Misi Content -->
                <div class="space-y-8 text-center max-w-3xl mx-auto">
                    <!-- Visi -->
                    <div class="animate-fade-in-up" style="animation-delay: 0.1s">
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                            <span class="font-bold text-[#1e3a5f]">Visi</span> {{ $settings->visi_text }}
                        </p>
                    </div>

                    <!-- Misi -->
                    <div class="animate-fade-in-up" style="animation-delay: 0.2s">
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                            <span class="font-bold text-[#1e3a5f]">Misi</span> {{ $settings->misi_text }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Pillars & Strategic Button (Clean Background) -->
        <div class="relative z-10 max-w-4xl mx-auto px-4 py-16 sm:py-20">
            <!-- Budaya Section -->
            <div class="text-center animate-fade-in-up" style="animation-delay: 0.3s">
                <h2 class="text-xl sm:text-2xl font-bold text-[#1e3a5f] mb-6 tracking-wide uppercase">PILAR UTAMA PIK-R</h2>
                
                <!-- Logo Placeholder / Graphic -->
                <div class="relative h-20 flex items-center justify-center mb-8">
                    <div class="text-4xl sm:text-6xl font-black italic tracking-tighter text-[#1e3a5f]/10 absolute uppercase">GENRE</div>
                    <div class="flex items-center gap-1 text-3xl sm:text-5xl font-black italic tracking-tighter uppercase">
                        <span class="text-[#1e3a5f]">G</span>
                        <span class="text-orange-500">E</span>
                        <span class="text-[#1e3a5f]">N</span>
                        <span class="text-orange-500">R</span>
                        <span class="text-[#1e3a5f]">E</span>
                    </div>
                </div>

                <!-- Values Accordion -->
                <div class="max-w-2xl mx-auto space-y-2.5 text-left">
                    @php
                        $values = [
                            ['title' => $settings->pilar_1_title, 'content' => $settings->pilar_1_desc],
                            ['title' => $settings->pilar_2_title, 'content' => $settings->pilar_2_desc],
                            ['title' => $settings->pilar_3_title, 'content' => $settings->pilar_3_desc],
                            ['title' => $settings->pilar_4_title, 'content' => $settings->pilar_4_desc],
                        ];
                    @endphp

                    @foreach ($values as $index => $value)
                    <div class="bg-white border border-slate-200/60 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                        <button class="w-full px-4 py-2.5 flex items-center justify-between text-left group focus:outline-none" onclick="toggleAccordion({{ $index }})">
                            <span class="text-sm font-bold text-[#1e3a5f] group-hover:text-orange-500 transition-colors italic">
                                {{ $value['title'] }}
                            </span>
                            <div class="w-6 h-6 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-orange-500/10 transition-colors">
                                <i id="icon-{{ $index }}" class="fas fa-plus text-slate-400 group-hover:text-orange-500 text-[10px] transition-transform duration-300"></i>
                            </div>
                        </button>
                        <div id="content-{{ $index }}" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                            <div class="px-4 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                                {{ $value['content'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Rencana Strategis Button -->
            <div class="mt-20 flex justify-center animate-fade-in-up" style="animation-delay: 0.35s">
                <a href="{{ $settings->renstra_file ? asset('storage/' . $settings->renstra_file) : '#' }}" target="_blank" class="inline-flex items-center gap-3 px-8 py-3 bg-orange-500 text-white rounded-full font-bold text-xs sm:text-sm hover:bg-orange-600 transition-all shadow-lg hover:shadow-orange-500/20 group">
                    <span>{{ $settings->renstra_text }}</span>
                    <i class="fas fa-file-pdf text-lg group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Section 3: Tujuan & Sasaran (Full Width Blue) -->
        <div class="w-full bg-[#1e3a5f] py-16 sm:py-24 animate-fade-in-up shadow-inner relative overflow-hidden" style="animation-delay: 0.4s">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-48 -mt-48 blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full -ml-48 -mb-48 blur-[100px]"></div>

            <div class="max-w-6xl mx-auto px-4 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 lg:gap-24">
                    <!-- Tujuan -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/20">
                                <i class="fas fa-bullseye text-xl"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Tujuan</h3>
                        </div>
                        <ul class="space-y-5">
                            @php
                                $tujuan = array_filter(array_map('trim', explode("\n", $settings->tujuan_text)));
                            @endphp
                            @foreach ($tujuan as $item)
                            <li class="flex items-start gap-4 group">
                                <div class="mt-1.5 w-2 h-2 rounded-full bg-orange-500 shrink-0 group-hover:scale-125 transition-transform shadow-[0_0_10px_rgba(249,115,22,0.5)]"></div>
                                <p class="text-sm sm:text-[15px] text-slate-300 leading-relaxed group-hover:text-white transition-colors">{{ $item }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Sasaran Strategi -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/20">
                                <i class="fas fa-chess-knight text-xl"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Sasaran Strategi</h3>
                        </div>
                        <ul class="space-y-5">
                            @php
                                $sasaran = array_filter(array_map('trim', explode("\n", $settings->sasaran_text)));
                            @endphp
                            @foreach ($sasaran as $item)
                            <li class="flex items-start gap-4 group">
                                <div class="mt-1.5 w-2 h-2 rounded-full bg-orange-500 shrink-0 group-hover:scale-125 transition-transform shadow-[0_0_10px_rgba(249,115,22,0.5)]"></div>
                                <p class="text-sm sm:text-[15px] text-slate-300 leading-relaxed group-hover:text-white transition-colors">{{ $item }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Struktur Organisasi (Constrained) -->
        <div class="max-w-6xl mx-auto px-4 py-16 sm:py-24 animate-fade-in-up" style="animation-delay: 0.5s">
            <div class="text-center mb-16">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Struktur <span class="text-orange-500">Organisasi</span>
                </h2>
                <div class="w-16 h-1 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-4">
                @php
                    $pengurus = [
                        [
                            'role' => 'Pembina',
                            'name' => 'Bambang Hendrawan, ST., MSM.',
                            'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800'
                        ],
                        [
                            'role' => 'Ketua Umum',
                            'name' => 'Ahmad Riyad Firdaus, S.SI.',
                            'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=800'
                        ],
                        [
                            'role' => 'Sekretaris Umum',
                            'name' => 'Arniati, S.E., M.SI.',
                            'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=800'
                        ],
                        [
                            'role' => 'Bendahara Umum',
                            'name' => 'Dr. Muhammad Zaenuddin, S.SI.',
                            'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=800'
                        ]
                    ];
                @endphp

                @foreach ($pengurus as $person)
                <div class="group relative aspect-[3/4] rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500">
                    <img src="{{ $person['image'] }}" alt="{{ $person['name'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f] via-transparent to-transparent opacity-90 group-hover:from-orange-600 transition-colors duration-500"></div>
                    <div class="absolute bottom-0 inset-x-0 p-5 text-center">
                        <p class="text-[10px] font-black text-white/80 uppercase tracking-widest mb-1">{{ $person['role'] }}</p>
                        <h4 class="text-xs sm:text-sm font-bold text-white leading-tight uppercase">{{ $person['name'] }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(index) {
            const content = document.getElementById(`content-${index}`);
            const icon = document.getElementById(`icon-${index}`);
            
            for (let i = 0; i < 4; i++) {
                if (i !== index) {
                    const otherContent = document.getElementById(`content-${i}`);
                    const otherIcon = document.getElementById(`icon-${i}`);
                    if (otherContent) otherContent.style.maxHeight = null;
                    if (otherIcon) {
                        otherIcon.classList.remove('rotate-45');
                        otherIcon.classList.add('fa-plus');
                        otherIcon.classList.remove('fa-minus');
                    }
                }
            }

            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                icon.classList.remove('rotate-45');
                icon.classList.add('fa-plus');
                icon.classList.remove('fa-minus');
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
                icon.classList.add('rotate-45');
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        }
    </script>

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
