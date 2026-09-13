<x-layouts.app>
    <div class="relative min-h-screen">
        
        @php
            $heroBgColor = $settings->hero_bg_color ?: '#1e3a5f';
            $heroBgImage = $settings->hero_bg ? asset($settings->hero_bg) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1600';
            $heroTag = $settings->hero_tag ?: 'Complete Identity';
        @endphp

        <!-- Section 1: Hero Profil Lengkap -->
        <div class="relative w-full pt-32 pb-20 sm:pt-52 sm:pb-32 overflow-hidden" style="background-color: {{ $heroBgColor }};">
            <div class="absolute inset-0 z-0">
                <img src="{{ $heroBgImage }}" alt="Background" class="w-full h-full object-cover opacity-25">
                <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/60"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-teal-300 text-[11px] font-extrabold uppercase tracking-widest mb-6 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                    {{ $heroTag }}
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight" style="animation-delay: 0.1s">
                    {!! str_replace('PIK-R REQUEST', '<span class="text-orange-500">PIK-R REQUEST</span>', e($settings->hero_title)) !!}
                </h1>
                <p class="mt-6 text-slate-200 text-sm sm:text-base max-w-2xl mx-auto font-medium leading-relaxed opacity-95">
                    {{ $settings->hero_desc }}
                </p>
                
                @if($settings->pdf_path)
                    <div class="mt-10 flex flex-wrap justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s">
                        <a href="{{ asset($settings->pdf_path) }}" target="_blank" class="px-8 py-3 bg-orange-500 text-white rounded-xl font-bold text-sm hover:bg-orange-600 transition-all shadow-xl flex items-center gap-3 group">
                            <i class="fas fa-file-pdf"></i> Unduh Profil PDF
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section 1.5: Biography of Pembina (Precise Match) -->
        <div class="bg-white border-b border-slate-100 relative">
            <!-- Decorative Spacer to push content down and create better transition -->
            <div class="h-12 sm:h-20"></div>

            <div class="max-w-7xl mx-auto px-4 pb-20 sm:pb-32">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 items-start">
                    <!-- Photo Side -->
                    <div class="lg:col-span-5 pt-4">
                        <div class="relative group">
                            <!-- Background Decoration -->
                            <div class="absolute -inset-6 bg-slate-50 rounded-[3rem] scale-95 group-hover:scale-100 transition-transform duration-500"></div>
                            
                            <!-- Image Container -->
                            <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl bg-white p-2">
                                <img src="{{ $settings->bio_photo ? asset($settings->bio_photo) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800' }}" alt="{{ $settings->bio_name }}" class="w-full h-auto object-cover grayscale-[20%] group-hover:grayscale-0 transition-all duration-700 min-h-[300px]">
                            </div>

                            <!-- Accent Element -->
                            <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-orange-500/10 rounded-full blur-2xl -z-10"></div>
                        </div>
                    </div>

                    <!-- Text Side -->
                    <div class="lg:col-span-7 space-y-10">
                        <div class="space-y-6">
                            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Sekilas Biografi</h2>
                            <div class="space-y-4 text-slate-600 text-sm sm:text-[15px] leading-relaxed">
                                <p>
                                    <strong class="text-slate-900">{{ $settings->bio_name }}</strong>
                                    @if($settings->bio_content)
                                        @foreach(explode("\n\n", $settings->bio_content) as $para)
                                            {{ $para }}
                                        @endforeach
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($settings->bio_expertise)
                            <div class="space-y-4">
                                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Bidang Keahlian</h3>
                                <div class="text-slate-600 text-sm sm:text-[15px] leading-relaxed space-y-4">
                                    @foreach(explode("\n\n", $settings->bio_expertise) as $para)
                                        <p>{{ $para }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($settings->bio_hopes)
                            <div class="space-y-4">
                                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Harapan tentang PIK-R REQUEST</h3>
                                <div class="text-slate-600 text-sm sm:text-[15px] leading-relaxed space-y-4">
                                    @foreach(explode("\n\n", $settings->bio_hopes) as $para)
                                        <p>{{ $para }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Identitas Organisasi -->
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="space-y-2">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Identitas <span class="text-orange-500">Organisasi</span>
                        </h2>
                        <div class="w-12 h-1 bg-orange-500 rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-1">
                            <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Nama Organisasi</p>
                            <p class="text-slate-800 font-bold">{{ $settings->org_name }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-1">
                            <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Singkatan / Akronim Motto</p>
                            <p class="text-slate-800 font-bold">{{ $settings->org_abbreviation }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-1">
                            <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Tahun Berdiri</p>
                            <p class="text-slate-800 font-bold">{{ $settings->org_year }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-1">
                            <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Basis Organisasi</p>
                            <p class="text-slate-800 font-bold">{{ $settings->org_base }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -inset-4 bg-orange-500/5 rounded-3xl -rotate-2"></div>
                    <div class="relative bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-slate-100">
                        <h3 class="text-xl font-bold text-[#1e3a5f] mb-6">Filosofi Nama</h3>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed italic">
                            {{ $settings->org_philosophy }}
                        </p>
                        <div class="mt-8 pt-8 border-t border-slate-100 flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Motto Organisasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Landasan Hukum -->
        <div class="bg-slate-50 py-20 border-y border-slate-100">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Landasan <span class="text-orange-500">Operasional</span>
                    </h2>
                    <p class="text-slate-500 text-sm max-w-xl mx-auto">PIK-R REQUEST beroperasi berdasarkan regulasi nasional dan kebijakan institusional yang jelas.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @if($settings->reg_1_title)
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-4 hover:shadow-md transition-shadow animate-fade-in-up">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                                <i class="fas fa-gavel"></i>
                            </div>
                            <h4 class="font-bold text-slate-900">{{ $settings->reg_1_title }}</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $settings->reg_1_desc }}</p>
                        </div>
                    @endif

                    @if($settings->reg_2_title)
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-4 hover:shadow-md transition-shadow animate-fade-in-up" style="animation-delay: 0.1s">
                            <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center text-xl">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <h4 class="font-bold text-slate-900">{{ $settings->reg_2_title }}</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $settings->reg_2_desc }}</p>
                        </div>
                    @endif

                    @if($settings->reg_3_title)
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-4 hover:shadow-md transition-shadow animate-fade-in-up" style="animation-delay: 0.2s">
                            <div class="w-12 h-12 bg-orange-550/10 text-orange-600 rounded-xl flex items-center justify-center text-xl">
                                <i class="fas fa-university"></i>
                            </div>
                            <h4 class="font-bold text-slate-900">{{ $settings->reg_3_title }}</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $settings->reg_3_desc }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Section 4: Nilai Utama (Alternating Style) -->
        <div class="max-w-7xl mx-auto px-4 py-20 space-y-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200" alt="Team" class="w-full h-auto">
                </div>
                <div class="space-y-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Fokus Utama <span class="text-orange-500">Pengembangan</span>
                    </h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="shrink-0 w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-[10px] font-bold">01</div>
                            <div>
                                <h5 class="font-bold text-slate-900">Literasi Kesehatan Reproduksi</h5>
                                <p class="text-sm text-slate-500 mt-1">Mengedukasi remaja mengenai pentingnya menjaga kesehatan alat reproduksi secara bertanggung jawab.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="shrink-0 w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-bold">02</div>
                            <div>
                                <h5 class="font-bold text-slate-900">Perencanaan Masa Depan</h5>
                                <p class="text-sm text-slate-500 mt-1">Membantu remaja merancang jenjang karir dan kehidupan berkeluarga yang berencana.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="shrink-0 w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center text-[10px] font-bold">03</div>
                            <div>
                                <h5 class="font-bold text-slate-900">Pencegahan Perilaku Berisiko</h5>
                                <p class="text-sm text-slate-500 mt-1">Sosialisasi intensif untuk menghindari pernikahan dini, seks bebas, dan NAPZA.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Final CTA -->
        <div class="w-full bg-[#1e3a5f] py-16 sm:py-20 shadow-inner relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-orange-500 to-transparent"></div>
            <div class="max-w-4xl mx-auto px-4 relative z-10 text-center space-y-8">
                <h2 class="text-xl sm:text-3xl font-bold text-white tracking-tight">Butuh Informasi Lebih Detail?</h2>
                <p class="text-slate-300 text-sm max-w-xl mx-auto leading-relaxed">
                    Tim humas kami siap memberikan penjelasan lebih lanjut mengenai kemitraan, program kerja, atau layanan konseling PIK-R REQUEST.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="mailto:info@pikr-request.org" class="px-8 py-3 border-2 border-white/20 text-white rounded-xl font-bold text-sm hover:bg-white/10 transition-all flex items-center gap-3">
                        <i class="far fa-envelope"></i> Email Kami
                    </a>
                    <a href="#" class="px-8 py-3 bg-teal-500 text-white rounded-xl font-bold text-sm hover:bg-teal-600 transition-all shadow-lg flex items-center gap-3">
                        <i class="fab fa-whatsapp text-lg"></i> Hubungi WhatsApp
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
