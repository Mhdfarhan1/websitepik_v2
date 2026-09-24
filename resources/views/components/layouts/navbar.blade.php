<!-- Header Container -->
<header class="w-full z-50 fixed top-0 transition-all duration-300" id="header">
    <!-- Top Bar -->
    <div id="topbar" class="bg-[#1e3a5f] text-white h-10 relative overflow-hidden hidden lg:block transition-all duration-300">
        <!-- Slanted Decorations -->
        <div class="absolute left-0 top-0 bottom-0 flex h-full z-0">
            <div class="bg-brand w-20 skew-x-[-30deg] origin-bottom -ml-6 shadow-lg"></div>
            <div class="bg-teal-400 w-40 skew-x-[-30deg] origin-bottom -ml-8 shadow-lg"></div>
        </div>
        
        <!-- Top Menu -->
        <div class="max-w-7xl mx-auto px-4 h-full flex justify-end items-center relative z-10">
            <div class="flex space-x-5 text-[11px] xl:text-xs font-medium items-center">
                <a href="#" class="hover:text-brand-light transition">Artikel Edukasi</a>
                <a href="#" class="hover:text-brand-light transition">Modul Materi</a>
                <a href="#" class="hover:text-brand-light transition">Pendidik Sebaya</a>
                <a href="#" class="hover:text-brand-light transition">Konselor Sebaya</a>
                <a href="#" class="hover:text-brand-light transition">Jejaring Mitra</a>
                <a href="#" class="hover:text-brand-light transition">Kontak</a>
                <a href="{{ route('faq') }}" class="hover:text-brand-light transition">FAQ</a>
                <a href="#" class="hover:text-brand-light transition border-r border-white/20 pr-5">Bantuan Layanan</a>
            
                <!-- Social Icons -->
                <div class="flex space-x-4 pl-1 items-center">
                    <a href="#" class="hover:text-brand-light transition text-sm"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-brand-light transition text-sm"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-brand-light transition text-sm"><i class="fab fa-youtube"></i></a>
                    <button class="hover:text-brand-light transition text-sm ml-2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav id="main-nav" class="bg-white border-b border-slate-100 shadow-sm transition-all duration-500 w-full relative z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20 transition-all duration-500" id="nav-container">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-2 sm:gap-3 group cursor-pointer">
                    <img src="{{ asset('assets/img/logo_utama.png') }}" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10 object-contain group-hover:scale-105 transition-transform duration-300">
                    <div class="flex flex-col whitespace-nowrap">
                        <span class="font-extrabold text-[14px] sm:text-lg lg:text-xl tracking-tight text-[#1e3a5f] leading-none">PIK-R REQUEST</span>
                        <span class="text-[9px] font-bold text-slate-500 mt-1 uppercase tracking-wider hidden md:block">Pusat Informasi & Konseling Remaja</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex space-x-6 items-center">
                    <a href="{{ url('/#beranda') }}" class="text-[13px] font-bold {{ request()->is('/') ? 'text-brand' : 'text-slate-800' }} hover:text-brand transition-all uppercase tracking-wide">BERANDA</a>
                    
                    <div class="relative dropdown">
                        <button class="text-[13px] font-bold {{ request()->routeIs('visi-misi', 'struktur', 'sejarah', 'profil-lengkap') ? 'text-brand' : 'text-slate-800' }} hover:text-brand flex items-center gap-1 transition-all uppercase tracking-wide">
                            TENTANG PIK-R <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('visi-misi') }}" class="{{ request()->routeIs('visi-misi') ? 'text-brand' : '' }}">Visi & Misi</a>
                            <a href="{{ route('struktur') }}" class="{{ request()->routeIs('struktur') ? 'text-brand' : '' }}">Struktur Organisasi</a>
                            <a href="{{ route('sejarah') }}" class="{{ request()->routeIs('sejarah') ? 'text-brand' : '' }}">Sejarah</a>
                            <a href="{{ route('profil-lengkap') }}" class="{{ request()->routeIs('profil-lengkap') ? 'text-brand' : '' }}">Profil Lengkap</a>
                            <a href="{{ route('jejak-bakti') }}" class="{{ request()->routeIs('jejak-bakti') ? 'text-brand' : '' }} flex items-center justify-between">
                                <span>Jejak Bakti & Duta</span>
                                <span class="px-1.5 py-0.5 rounded text-[9px] bg-amber-100 text-amber-800 font-black uppercase tracking-wider">Juara</span>
                            </a>
                        </div>
                    </div>

                    <div class="relative dropdown">
                        <button class="text-[13px] font-bold {{ request()->routeIs('proker', 'edukasi', 'konseling') ? 'text-brand' : 'text-slate-800' }} hover:text-brand flex items-center gap-1 transition-all uppercase tracking-wide">
                            PENDIDIKAN <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('proker') }}" class="{{ request()->routeIs('proker') ? 'text-brand' : '' }}">Program Kerja</a>
                            <a href="{{ route('edukasi') }}" class="{{ request()->routeIs('edukasi') ? 'text-brand' : '' }}">Edukasi Sebaya</a>
                            <a href="{{ route('konseling') }}" class="{{ request()->routeIs('konseling') ? 'text-brand' : '' }}">Layanan Konseling</a>
                        </div>
                    </div>

                    <a href="{{ route('laporan') }}" class="text-[13px] font-bold {{ request()->routeIs('laporan') ? 'text-brand' : 'text-slate-800' }} hover:text-brand transition-all uppercase tracking-wide">LAPORAN</a>
                    
                    <a href="{{ route('kegiatan') }}" class="text-[13px] font-bold {{ request()->routeIs('kegiatan') ? 'text-brand' : 'text-slate-800' }} hover:text-brand transition-all uppercase tracking-wide">KEGIATAN</a>

                    <a href="{{ route('prestasi') }}" class="text-[13px] font-bold {{ request()->routeIs('prestasi') ? 'text-brand' : 'text-slate-800' }} hover:text-brand transition-all uppercase tracking-wide">PRESTASI</a>

                    <!-- Language selector icon (Indo flag style) -->
                    <div class="relative dropdown ml-2 flex items-center">
                        <button class="flex items-center gap-1 focus:outline-none">
                            <div class="w-5 h-3.5 border border-slate-200 overflow-hidden flex flex-col rounded-sm shadow-sm">
                                <div class="bg-red-600 h-1/2"></div>
                                <div class="bg-white h-1/2"></div>
                            </div>
                            <i class="fas fa-chevron-down text-[9px] text-slate-400"></i>
                        </button>
                        <div class="dropdown-menu !min-w-[80px]" style="right: 0; left: auto;">
                            <a href="#" class="flex items-center gap-2 text-xs text-slate-700 hover:text-brand"><span class="w-4 h-3 bg-slate-200 inline-block overflow-hidden border border-slate-300"><div class="bg-red-600 h-1/2"></div><div class="bg-white h-1/2"></div></span> ID</a>
                            <a href="#" class="flex items-center gap-2 text-xs text-slate-700 hover:text-brand"><span class="w-4 h-3 bg-blue-800 inline-block border border-slate-300 relative overflow-hidden"></span> EN</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div class="lg:hidden flex items-center gap-2">
                    <button id="mobile-menu-btn" class="text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 focus:outline-none transition-colors rounded-xl hover:text-brand">
                        <i class="fas fa-bars text-xl" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[90] hidden opacity-0 transition-opacity duration-300 lg:hidden"></div>

        <!-- Mobile Sidebar -->
        <div id="mobile-sidebar" class="fixed top-0 right-0 h-screen w-[280px] sm:w-[320px] bg-[#1e293b] text-white z-[100] transform translate-x-full transition-transform duration-500 ease-out overflow-y-auto flex flex-col shadow-2xl lg:hidden border-l border-white/5">
            <!-- Header Sidebar (Close Button Only) -->
            <div class="flex justify-end p-3">
                <button id="close-mobile-menu" class="text-white/60 hover:text-white transition-all duration-300 hover:rotate-90 p-3 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 font-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu Links -->
            <div class="flex-col flex flex-grow pb-10">
                <div class="border-t border-white/5">
                    <a href="{{ url('/#beranda') }}" class="px-5 py-4 block text-[15px] font-medium {{ request()->is('/') ? 'text-white bg-white/10' : 'text-white/90' }} hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Beranda</a>
                </div>
                
                <!-- Tentang PIK-R Dropdown -->
                <div class="border-t border-white/5 flex flex-col">
                    <div class="flex items-center w-full group cursor-pointer">
                        <a href="#" class="px-5 py-4 block text-[15px] font-medium {{ request()->routeIs('visi-misi', 'struktur', 'sejarah', 'profil-lengkap') ? 'text-white' : 'text-white/90' }} group-hover:text-white group-hover:pl-7 transition-all duration-300 flex-grow">Tentang PIK-R</a>
                        <button class="mobile-sidebar-dropdown-btn p-4 border-l border-white/5 group-hover:bg-white/5 transition-all duration-300 w-14 flex justify-center items-center focus:outline-none shrink-0 text-white/60 group-hover:text-white">
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300 {{ request()->routeIs('visi-misi', 'struktur', 'sejarah', 'profil-lengkap') ? 'rotate-180' : '' }}"></i>
                        </button>
                    </div>
                    <div class="mobile-sidebar-dropdown-content {{ request()->routeIs('visi-misi', 'struktur', 'sejarah', 'profil-lengkap') ? 'max-h-[500px]' : 'max-h-0' }} overflow-hidden transition-all duration-500 ease-in-out flex flex-col bg-[#141e2e]">
                        <a href="{{ route('visi-misi') }}" class="px-8 py-3.5 block text-[14px] {{ request()->routeIs('visi-misi') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">Visi & Misi</a>
                        <a href="{{ route('struktur') }}" class="px-8 py-3.5 block text-[14px] {{ request()->routeIs('struktur') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">Struktur Organisasi</a>
                        <a href="{{ route('sejarah') }}" class="px-8 py-3.5 block text-[14px] {{ request()->routeIs('sejarah') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">Sejarah</a>
                        <a href="{{ route('profil-lengkap') }}" class="px-8 py-3.5 block text-[14px] {{ request()->routeIs('profil-lengkap') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">Profil Lengkap</a>
                        <a href="{{ route('jejak-bakti') }}" class="px-8 py-3.5 flex items-center justify-between text-[14px] {{ request()->routeIs('jejak-bakti') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">
                            <span>Jejak Bakti & Duta</span>
                            <span class="px-1.5 py-0.5 rounded text-[9px] bg-amber-400 text-slate-900 font-black uppercase">Juara</span>
                        </a>
                    </div>
                </div>

                <!-- Pendidikan Dropdown -->
                <div class="border-t border-white/5 flex flex-col">
                    <div class="flex items-center w-full group cursor-pointer">
                        <a href="#" class="px-5 py-4 block text-[15px] font-medium {{ request()->routeIs('proker', 'edukasi') ? 'text-white' : 'text-white/90' }} group-hover:text-white group-hover:pl-7 transition-all duration-300 flex-grow">Pendidikan</a>
                        <button class="mobile-sidebar-dropdown-btn p-4 border-l border-white/5 group-hover:bg-white/5 transition-all duration-300 w-14 flex justify-center items-center focus:outline-none shrink-0 text-white/60 group-hover:text-white">
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300 {{ request()->routeIs('proker', 'edukasi') ? 'rotate-180' : '' }}"></i>
                        </button>
                    </div>
                    <div class="mobile-sidebar-dropdown-content {{ request()->routeIs('proker', 'edukasi', 'konseling') ? 'max-h-[500px]' : 'max-h-0' }} overflow-hidden transition-all duration-500 ease-in-out flex flex-col bg-[#141e2e]">
                        <a href="{{ route('proker') }}" class="px-8 py-3.5 block text-[14px] {{ request()->routeIs('proker') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">Program Kerja</a>
                        <a href="{{ route('edukasi') }}" class="px-8 py-3.5 block text-[14px] {{ request()->routeIs('edukasi') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">Edukasi Sebaya</a>
                        <a href="{{ route('konseling') }}" class="px-8 py-3.5 block text-[14px] {{ request()->routeIs('konseling') ? 'text-brand font-bold' : 'text-white/70' }} hover:text-white hover:pl-10 transition-all duration-300 border-t border-white/5">Layanan Konseling</a>
                    </div>
                </div>

                <div class="border-t border-white/5">
                    <a href="{{ route('laporan') }}" class="px-5 py-4 block text-[15px] font-medium {{ request()->routeIs('laporan') ? 'text-white bg-white/10' : 'text-white/90' }} hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">LAPORAN</a>
                </div>
                <div class="border-t border-white/5">
                    <a href="{{ route('prestasi') }}" class="px-5 py-4 block text-[15px] font-medium {{ request()->routeIs('prestasi') ? 'text-white bg-white/10' : 'text-white/90' }} hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">PRESTASI</a>
                </div>
                <div class="border-t border-white/5">
                    <a href="{{ route('faq') }}" class="px-5 py-4 block text-[15px] font-medium {{ request()->routeIs('faq') ? 'text-white bg-white/10' : 'text-white/90' }} hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">FAQ</a>
                </div>

                <div class="border-t border-white/5">
                    <a href="#" class="px-5 py-4 block text-[15px] font-medium text-white/90 hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Artikel Edukasi</a>
                </div>
                <div class="border-t border-white/5">
                    <a href="#" class="px-5 py-4 block text-[15px] font-medium text-white/90 hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Modul Materi</a>
                </div>
                <div class="border-t border-white/5">
                    <a href="#" class="px-5 py-4 block text-[15px] font-medium text-white/90 hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Pendidik Sebaya</a>
                </div>
                <div class="border-t border-white/5">
                    <a href="#" class="px-5 py-4 block text-[15px] font-medium text-white/90 hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Konselor Sebaya</a>
                </div>
                <div class="border-t border-white/5">
                    <a href="#" class="px-5 py-4 block text-[15px] font-medium text-white/90 hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Jejaring Mitra</a>
                </div>
                <div class="border-t border-white/5">
                    <a href="#kontak" class="px-5 py-4 block text-[15px] font-medium text-white/90 hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Kontak</a>
                </div>

                <div class="border-t border-white/5">
                    <a href="#" class="px-5 py-4 block text-[15px] font-medium text-white/90 hover:text-white hover:bg-white/5 transition-all duration-300 hover:pl-7">Bantuan Layanan</a>
                </div>

                <!-- Language Selector Mobile -->
                <div class="border-y border-white/5 flex flex-col">
                    <div class="flex items-center w-full group cursor-pointer">
                        <div class="px-5 py-4 flex items-center gap-3 flex-grow text-white/90 group-hover:text-white group-hover:pl-7 transition-all duration-300">
                            <div class="w-5 h-3.5 flex flex-col rounded-[2px] overflow-hidden shadow-sm">
                                <div class="bg-red-600 h-1/2 w-full"></div>
                                <div class="bg-white h-1/2 w-full"></div>
                            </div>
                            <span class="text-[15px] font-medium">Indonesia</span>
                        </div>
                        <button class="mobile-sidebar-dropdown-btn p-4 border-l border-white/5 group-hover:bg-white/5 transition-all duration-300 w-14 flex justify-center items-center focus:outline-none shrink-0 text-white/60 group-hover:text-white">
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                        </button>
                    </div>
                    <div class="mobile-sidebar-dropdown-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out flex flex-col bg-[#141e2e]">
                        <a href="#" class="px-5 py-4 text-[15px] text-white/70 hover:text-white hover:pl-8 flex items-center gap-3 transition-all duration-300 border-t border-white/5">
                            <div class="w-5 h-3.5 bg-blue-800 flex items-center justify-center text-[7px] font-bold text-white rounded-[2px] shadow-sm">EN</div> English
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
