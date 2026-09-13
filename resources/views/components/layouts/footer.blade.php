<footer id="kontak"
    class="bg-[#0b132b] text-slate-400 pt-20 pb-10 relative overflow-hidden font-sans border-t border-slate-800/80">

    <div
        class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-transparent via-[#f59e0b] to-transparent opacity-80">
    </div>
    <div
        class="absolute top-[-20%] left-[-10%] w-[400px] h-[400px] bg-blue-600/10 rounded-full blur-[120px] pointer-events-none">
    </div>
    <div
        class="absolute bottom-[-20%] right-[-10%] w-[400px] h-[400px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 mb-16">

            <!-- Column 1: Organization Info -->
            <div class="lg:col-span-4 space-y-6" data-aos="fade-up">
                <div class="flex items-center gap-3.5">
                    <div class="p-2.5 bg-white/10 rounded-2xl border border-white/15 shadow-lg backdrop-blur-md">
                        <img src="{{ asset('assets/img/logo_utama.png') }}" alt="Logo PIK-R REQUEST"
                            class="w-9 h-9 object-contain">
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight leading-tight">PIK-R REQUEST</h3>
                        <p class="text-[11px] text-[#f59e0b] font-extrabold tracking-widest uppercase mt-0.5">SMAN 1
                            Tasik Putri Puyu</p>
                    </div>
                </div>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-sm font-medium">
                    Pusat Informasi dan Konseling Remaja (PIK-R) yang berfokus pada transformasi karakter, edukasi
                    kesehatan reproduksi, dan pendampingan positif generasi muda.
                </p>

                <!-- Social Media Icons -->
                <div class="flex items-center gap-2.5 pt-2">
                    <a href="https://instagram.com/mhd_frhannn" target="_blank" title="Instagram Developer @mhd_frhannn"
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-gradient-to-tr hover:from-amber-500 hover:to-rose-500 hover:text-white transition-all duration-300 group shadow-sm">
                        <i class="fab fa-instagram text-base transition-transform group-hover:scale-110"></i>
                    </a>
                    <a href="#" title="YouTube"
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-red-600 hover:text-white transition-all duration-300 group shadow-sm">
                        <i class="fab fa-youtube text-base transition-transform group-hover:scale-110"></i>
                    </a>
                    <a href="#" title="TikTok"
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-slate-900 hover:text-white transition-all duration-300 group shadow-sm">
                        <i class="fab fa-tiktok text-base transition-transform group-hover:scale-110"></i>
                    </a>
                    <a href="#" title="Facebook"
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white transition-all duration-300 group shadow-sm">
                        <i class="fab fa-facebook-f text-base transition-transform group-hover:scale-110"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Navigasi Cepat -->
            <div class="lg:col-span-3 space-y-4" data-aos="fade-up" data-aos-delay="100">
                <h4 class="text-white font-extrabold text-sm uppercase tracking-wider relative inline-block pb-2">
                    Navigasi Utama
                    <span class="absolute bottom-0 left-0 w-10 h-[2.5px] bg-[#f59e0b] rounded-full"></span>
                </h4>
                <ul class="space-y-2.5 pt-2 text-xs font-semibold">
                    <li><a href="{{ url('/#beranda') }}"
                            class="hover:text-white hover:pl-1.5 transition-all duration-200 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[9px] text-[#f59e0b]"></i> Beranda</a></li>
                    <li><a href="{{ route('visi-misi') }}"
                            class="hover:text-white hover:pl-1.5 transition-all duration-200 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[9px] text-[#f59e0b]"></i> Visi & Misi</a></li>
                    <li><a href="{{ route('proker') }}"
                            class="hover:text-white hover:pl-1.5 transition-all duration-200 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[9px] text-[#f59e0b]"></i> Program Kerja</a></li>
                    <li><a href="{{ route('edukasi') }}"
                            class="hover:text-white hover:pl-1.5 transition-all duration-200 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[9px] text-[#f59e0b]"></i> Edukasi Sebaya</a></li>
                    <li><a href="{{ route('konseling') }}"
                            class="hover:text-white hover:pl-1.5 transition-all duration-200 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[9px] text-[#f59e0b]"></i> Layanan Konseling</a></li>
                    <li><a href="{{ route('kegiatan') }}"
                            class="hover:text-white hover:pl-1.5 transition-all duration-200 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[9px] text-[#f59e0b]"></i> Agenda Kegiatan</a></li>
                    <li><a href="{{ route('laporan') }}"
                            class="hover:text-white hover:pl-1.5 transition-all duration-200 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[9px] text-[#f59e0b]"></i> Laporan Transparansi</a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Hubungi Kami -->
            <div class="lg:col-span-5 space-y-6" data-aos="fade-up" data-aos-delay="200">
                <h4 class="text-white font-extrabold text-sm uppercase tracking-wider relative inline-block pb-2">
                    Hubungi Sekretariat
                    <span class="absolute bottom-0 left-0 w-10 h-[2.5px] bg-[#f59e0b] rounded-full"></span>
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 space-y-1.5">
                        <div
                            class="w-8 h-8 rounded-xl bg-amber-500/20 text-[#f59e0b] flex items-center justify-center text-xs font-bold">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5 class="text-xs font-bold text-white">Alamat Sekolah</h5>
                        <p class="text-[11px] text-slate-300 leading-relaxed font-medium">Jl. SMAN 1 Tasik Putri Puyu,
                            Kabupaten Kepulauan Meranti, Riau.</p>
                    </div>

                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 space-y-1.5">
                        <div
                            class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs font-bold">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="text-xs font-bold text-white">Kontak Layanan</h5>
                        <p class="text-[11px] text-slate-300 leading-relaxed font-medium">pikr.request@gmail.com</p>
                        <p class="text-[11px] text-slate-400 font-medium">+62 812-3456-7890</p>
                    </div>
                </div>

                <!-- Newsletter Input -->
                <div class="space-y-2 pt-2">
                    <label class="block text-xs font-bold text-white">Langganan Informasi PIK-R</label>
                    <div
                        class="flex items-center bg-white/5 border border-white/10 rounded-2xl p-1.5 focus-within:border-[#f59e0b] transition-all">
                        <input type="email" placeholder="Masukkan alamat email anda..."
                            class="bg-transparent border-none text-white text-xs w-full px-4 focus:ring-0 placeholder:text-slate-500">
                        <button type="button"
                            class="px-5 py-2.5 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-xl font-bold text-xs shadow-md transition-all shrink-0 flex items-center gap-1.5">
                            <span>Kirim</span>
                            <i class="fas fa-paper-plane text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright & Developer Bar -->
        <div
            class="pt-8 border-t border-white/10 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-medium">
            <p class="text-slate-400 text-center sm:text-left">
                &copy; {{ date('Y') }} <span class="text-white font-bold">PIK-R REQUEST SMAN 1 Tasik Putri Puyu</span>.
                All rights reserved.
            </p>

            <!-- Developer Credit -->
            <div
                class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-slate-300 shadow-sm hover:border-amber-400/50 transition-colors">
                <span class="text-slate-400">Developed by</span>
                <a href="https://www.instagram.com/mhd.frhnxz_?igsh=ZmRqN2N2Z3ZpaXVj" target="_blank"
                    class="text-[#f59e0b] hover:text-amber-300 font-extrabold flex items-center gap-1.5 transition-colors">
                    <i class="fab fa-instagram text-xs"></i>
                    <span>mhd_frhannn</span>
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="back-to-top"
    class="fixed bottom-12 sm:bottom-14 right-6 sm:right-8 w-12 h-12 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-2xl shadow-xl shadow-amber-500/20 flex items-center justify-center opacity-0 translate-y-10 pointer-events-none transition-all duration-300 z-[60] hover:scale-110 active:scale-95 border border-white/20">
    <i class="fas fa-arrow-up text-sm"></i>
</button>