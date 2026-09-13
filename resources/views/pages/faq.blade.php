<x-layouts.app>
    <div class="relative min-h-screen bg-slate-50">
        
        <!-- Section 1: Hero FAQ (Building Background Style) -->
        <div class="relative overflow-hidden border-b border-slate-200">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('assets/img/bg_utama.JPG') }}" alt="Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-white/85 backdrop-blur-[1px]"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-slate-50/50"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 pt-32 pb-12 sm:pt-48 sm:pb-20">
                <!-- Header Section -->
                <div class="text-center mb-10 space-y-4 animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-widest mx-auto">
                        Pusat Bantuan
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1e3a5f] tracking-tight">
                        Pertanyaan <span class="text-orange-500">Sering Diajukan</span>
                    </h1>
                    <div class="w-16 h-1 bg-orange-500 mx-auto rounded-full"></div>
                    <p class="mt-4 text-slate-500 text-sm sm:text-base font-medium max-w-2xl mx-auto leading-relaxed">
                        Temukan jawaban cepat untuk pertanyaan umum mengenai PIK-R REQUEST, layanan kami, dan cara bergabung.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 2: FAQ Accordion (Updated UI Style) -->
        <div class="max-w-3xl mx-auto px-4 py-20">
            <div class="space-y-5" x-data="{ active: null }">
                @php
                    $faqs = [
                        [
                            'q' => 'Apa itu PIK-R REQUEST?',
                            'a' => 'PIK-R REQUEST adalah Pusat Informasi dan Konseling Remaja di SMAN 1 Tasik Putri Puyu yang berfokus pada pemberian informasi dan layanan konseling sebaya mengenai penyiapan kehidupan berkeluarga bagi remaja (GenRe).'
                        ],
                        [
                            'q' => 'Bagaimana cara bergabung menjadi anggota?',
                            'a' => 'Siswa SMAN 1 Tasik Putri Puyu dapat mendaftar melalui laman pendaftaran di website ini atau langsung mendatangi sekretariat PIK-R REQUEST saat periode open recruitment dibuka.'
                        ],
                        [
                            'q' => 'Apakah layanan konseling di PIK-R REQUEST bersifat rahasia?',
                            'a' => 'Tentu saja. Kami menjunjung tinggi asas kerahasiaan. Setiap sesi konseling sebaya dilakukan secara privat dan informasi Anda akan dijaga dengan sangat aman oleh para konselor sebaya kami.'
                        ],
                        [
                            'q' => 'Siapa saja yang bisa mendapatkan layanan di sini?',
                            'a' => 'Layanan informasi dan edukasi kami terbuka untuk seluruh siswa SMAN 1 Tasik Putri Puyu dan remaja di lingkungan sekitar yang membutuhkan informasi seputar kesehatan reproduksi dan perencanaan masa depan.'
                        ],
                        [
                            'q' => 'Apa saja program unggulan PIK-R REQUEST?',
                            'a' => 'Program unggulan kami meliputi Edukasi Sebaya, Konseling Privat, Sosialisasi GenRe ke kelas-selas, hingga kampanye kreatif melalui media sosial mengenai pencegahan pernikahan dini dan NAPZA.'
                        ],
                        [
                            'q' => 'Apakah ada biaya untuk mendapatkan layanan?',
                            'a' => 'Seluruh layanan yang disediakan oleh PIK-R REQUEST bersifat GRATIS dan tidak dipungut biaya apapun bagi seluruh siswa.'
                        ]
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s">
                    <button 
                        @click="active = (active === {{ $index }} ? null : {{ $index }})"
                        class="w-full px-8 py-6 text-left flex items-center justify-between gap-6 focus:outline-none group"
                    >
                        <span class="font-bold text-[#1e3a5f] text-[15px] sm:text-[17px] leading-tight italic">{{ $faq['q'] }}</span>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-500 transition-all shrink-0">
                            <i class="fas fa-plus text-[10px] transition-transform duration-500" :class="active === {{ $index }} ? 'rotate-45 text-blue-600' : ''"></i>
                        </div>
                    </button>
                    
                    <div 
                        x-show="active === {{ $index }}"
                        x-collapse
                        x-cloak
                        class="px-8 pb-8 text-slate-500 text-sm sm:text-[15px] leading-relaxed"
                    >
                        <div class="pt-2 border-t border-slate-50">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Section 3: Final CTA (Banner Style) - Compact Version -->
        <div class="max-w-7xl mx-auto px-4 pb-24">
            <div class="relative rounded-[2rem] overflow-hidden shadow-xl animate-fade-in-up">
                <!-- Background Image with Blue Overlay -->
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&q=80&w=1600" alt="Collaboration Background" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-blue-900/85 backdrop-blur-[1px]"></div>
                </div>

                <div class="relative z-10 p-6 sm:p-10 lg:p-12 text-white max-w-3xl">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold leading-tight tracking-tight mb-4">
                        “Bangkitkan Potensi <span class="text-orange-400 italic">Intelektualmu</span> <br class="hidden sm:block"> Berkolaborasi Bersama Kami!”
                    </h2>
                    <p class="text-slate-200 text-xs sm:text-sm mb-8 max-w-2xl font-medium leading-relaxed opacity-90">
                        Mari bersama membangun ruang kolaborasi yang menginspirasi, berdampak, dan berfokus pada pengembangan wawasan akademik serta kemampuan digital.
                    </p>
                    <a href="#" class="inline-flex items-center justify-center px-8 py-3 bg-orange-500 text-white rounded-full font-black text-xs uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg hover:scale-105 active:scale-95">
                        Kontak Kami
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
