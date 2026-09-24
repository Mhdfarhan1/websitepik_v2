<aside 
    :class="[
        isMobile ? (mobileMenu ? 'translate-x-0 w-[280px]' : '-translate-x-full w-[280px]') : (sidebarOpen ? 'w-[280px]' : 'w-[84px]'),
        'fixed lg:sticky top-0 h-screen bg-white flex flex-col z-[70] border-r border-slate-200/80 shadow-[1px_0_10px_rgba(0,0,0,0.02)] transition-all duration-300 ease-in-out'
    ]"
    class="overflow-hidden select-none">
    
    <!-- Brand / Header -->
    <div class="h-20 flex items-center px-5 justify-between shrink-0 border-b border-slate-100">
        <div class="flex items-center gap-3 min-w-0" :class="!sidebarOpen && !isMobile ? 'mx-auto' : ''">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center p-2 shadow-md shadow-blue-500/20 shrink-0">
                <img src="{{ asset('assets/img/logo_utama.png') }}" class="w-full h-full object-contain brightness-0 invert" alt="Logo">
            </div>
            <div class="flex flex-col min-w-0" x-show="isMobile || sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95">
                <span class="text-[15px] font-black text-slate-800 leading-tight tracking-tight">PIK-R <span class="text-blue-600">REQUEST</span></span>
                <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase mt-0.5">Admin Control Panel</span>
            </div>
        </div>

        <!-- Toggle Desktop Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
                x-show="sidebarOpen && !isMobile"
                class="hidden lg:flex w-8 h-8 rounded-xl border border-slate-200/80 items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all cursor-pointer">
            <i class="fas fa-chevron-left text-[11px]"></i>
        </button>

        <!-- Close Mobile Button -->
        <button @click="mobileMenu = false" class="lg:hidden w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 cursor-pointer">
            <i class="fas fa-times text-xs"></i>
        </button>
    </div>

    <!-- Collapsed Expand Button -->
    <div x-show="!sidebarOpen && !isMobile" class="flex justify-center py-3 border-b border-slate-100">
        <button @click="sidebarOpen = true" title="Buka Sidebar" class="w-9 h-9 rounded-xl border border-slate-200 flex items-center justify-center text-blue-600 bg-blue-50/70 hover:bg-blue-100 transition-all shadow-sm cursor-pointer">
            <i class="fas fa-chevron-right text-xs"></i>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <div id="sidebarNavScroll" class="flex-1 overflow-y-auto no-scrollbar px-3 py-4 space-y-4">
        @php 
            $menuSettings = \App\Models\MenuSetting::all()->keyBy('menu_key'); 
            $role = auth()->user()->role;
            $canSee = function($key) use ($menuSettings, $role) {
                if($role === 'super_admin') return true;
                $setting = $menuSettings[$key] ?? null;
                return $setting ? $setting->{$role . '_visible'} : false;
            };
        @endphp

        <!-- 1. Menu Utama -->
        @if($canSee('dashboard'))
        <div class="space-y-1">
            <div x-show="isMobile || sidebarOpen" class="px-3 pt-1 pb-1 flex items-center gap-2">
                <span class="text-[10px] font-extrabold tracking-wider uppercase text-slate-400">Utama</span>
                <div class="h-[1px] flex-1 bg-slate-100"></div>
            </div>
            <x-dashboard.sidebar-item href="{{ route('dashboard') }}" icon="fas fa-th-large" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-dashboard.sidebar-item>
        </div>
        @endif

        <!-- 2. Konten Publikasi -->
        @if($canSee('berita') || $canSee('kegiatan') || $canSee('galeri') || $canSee('prestasi'))
        <div class="space-y-1">
            <div x-show="isMobile || sidebarOpen" class="px-3 pt-3 pb-1 flex items-center gap-2">
                <span class="text-[10px] font-extrabold tracking-wider uppercase text-slate-400">Konten Publikasi</span>
                <div class="h-[1px] flex-1 bg-slate-100"></div>
            </div>

            @if($canSee('berita'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.news.index') }}" icon="fas fa-newspaper" :active="request()->routeIs('dashboard.news.*')">
                    Berita & Artikel
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('kegiatan'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.activities.index') }}" icon="fas fa-calendar-alt" :active="request()->routeIs('dashboard.activities.*')">
                    Agenda Kegiatan
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('galeri'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.gallery.index') }}" icon="fas fa-images" :active="request()->routeIs('dashboard.gallery.*')">
                    Galeri & Foto
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('prestasi'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.achievements.index') }}" icon="fas fa-trophy" :active="request()->routeIs('dashboard.achievements.*')">
                    Prestasi
                </x-dashboard.sidebar-item>
            @endif

            <x-dashboard.sidebar-item href="{{ route('dashboard.notifications.index') }}" icon="fas fa-bell" :active="request()->routeIs('dashboard.notifications.*')">
                Pusat Notifikasi
            </x-dashboard.sidebar-item>
        </div>
        @endif

        <!-- 3. Layanan & Edukasi -->
        @if($canSee('proker') || $canSee('edukasi_sebaya') || $role !== 'super_admin')
        <div class="space-y-1">
            <div x-show="isMobile || sidebarOpen" class="px-3 pt-3 pb-1 flex items-center gap-2">
                <span class="text-[10px] font-extrabold tracking-wider uppercase text-slate-400">Layanan & Edukasi</span>
                <div class="h-[1px] flex-1 bg-slate-100"></div>
            </div>

            @if($canSee('proker'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.work-programs.index') }}" icon="fas fa-briefcase" :active="request()->routeIs('dashboard.work-programs.*')">
                    Program Kerja
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('edukasi_sebaya'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.peer-educations.index') }}" icon="fas fa-graduation-cap" :active="request()->routeIs('dashboard.peer-educations.*')">
                    Edukasi Sebaya
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('kegiatan'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.counselings.index') }}" icon="fas fa-comments" :active="request()->routeIs('dashboard.counselings.*')">
                    Layanan Konseling
                </x-dashboard.sidebar-item>
                <x-dashboard.sidebar-item href="{{ route('dashboard.counselors.index') }}" icon="fas fa-user-friends" :active="request()->routeIs('dashboard.counselors.*')">
                    Tim Konselor Sebaya
                </x-dashboard.sidebar-item>
            @endif

            @if($role !== 'super_admin')
                <x-dashboard.sidebar-item href="{{ route('dashboard.peer-evaluation.index') }}" icon="fas fa-user-check" :active="request()->routeIs('dashboard.peer-evaluation.index') || request()->routeIs('dashboard.peer-evaluation.evaluate')">
                    Penilaian Anggota
                </x-dashboard.sidebar-item>
            @endif
        </div>
        @endif

        <!-- 4. Profil & Laporan -->
        @if($canSee('sejarah') || $canSee('profil_lengkap') || $canSee('struktur') || $canSee('laporan'))
        <div class="space-y-1">
            <div x-show="isMobile || sidebarOpen" class="px-3 pt-3 pb-1 flex items-center gap-2">
                <span class="text-[10px] font-extrabold tracking-wider uppercase text-slate-400">Profil & Laporan</span>
                <div class="h-[1px] flex-1 bg-slate-100"></div>
            </div>

            @if($canSee('sejarah'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.profile-settings.index') }}" icon="fas fa-id-card" :active="request()->routeIs('dashboard.profile-settings.*')">
                    Profil & Sejarah
                </x-dashboard.sidebar-item>
            @endif

            <x-dashboard.sidebar-item href="{{ route('dashboard.tributes.index') }}" icon="fas fa-award" :active="request()->routeIs('dashboard.tributes.*')">
                Jejak Bakti & Duta
            </x-dashboard.sidebar-item>

            @if($canSee('profil_lengkap'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.complete-profile.index') }}" icon="fas fa-address-card" :active="request()->routeIs('dashboard.complete-profile.*')">
                    Profil Lengkap
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('struktur'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.organization-structures.index') }}" icon="fas fa-sitemap" :active="request()->routeIs('dashboard.organization-structures.*')">
                    Struktur Organisasi
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('laporan'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.reports.index') }}" icon="fas fa-file-alt" :active="request()->routeIs('dashboard.reports.*')">
                    Laporan Berkala
                </x-dashboard.sidebar-item>
                <x-dashboard.sidebar-item href="{{ route('dashboard.statistics.settings') }}" icon="fas fa-chart-line" :active="request()->routeIs('dashboard.statistics.*')">
                    Statistik Layanan
                </x-dashboard.sidebar-item>
            @endif
        </div>
        @endif

        <!-- 5. Sistem & Pengaturan -->
        <div class="space-y-1">
            <div x-show="isMobile || sidebarOpen" class="px-3 pt-3 pb-1 flex items-center gap-2">
                <span class="text-[10px] font-extrabold tracking-wider uppercase text-slate-400">Sistem & Pengaturan</span>
                <div class="h-[1px] flex-1 bg-slate-100"></div>
            </div>

            @if($canSee('user_management'))
                <x-dashboard.sidebar-item icon="fas fa-users-cog" :active="request()->routeIs('dashboard.users.*')" :isDropdown="true">
                    Manajemen Akun
                    <x-slot:children>
                        @if($canSee('akun_pembina')) 
                            <a href="{{ route('dashboard.users.pembina') }}" class="flex items-center gap-2 py-1.5 px-2 rounded-lg text-xs font-semibold {{ request()->routeIs('dashboard.users.pembina') ? 'text-blue-600 bg-blue-50/70 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.users.pembina') ? 'bg-blue-600 ring-2 ring-blue-100' : 'bg-slate-300' }}"></span>
                                <span>Akun Pembina</span>
                            </a>
                        @endif
                        @if($canSee('akun_ketua')) 
                            <a href="{{ route('dashboard.users.ketua') }}" class="flex items-center gap-2 py-1.5 px-2 rounded-lg text-xs font-semibold {{ request()->routeIs('dashboard.users.ketua') ? 'text-blue-600 bg-blue-50/70 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.users.ketua') ? 'bg-blue-600 ring-2 ring-blue-100' : 'bg-slate-300' }}"></span>
                                <span>Akun Ketua</span>
                            </a>
                        @endif
                        @if($canSee('akun_anggota')) 
                            <a href="{{ route('dashboard.users.anggota') }}" class="flex items-center gap-2 py-1.5 px-2 rounded-lg text-xs font-semibold {{ request()->routeIs('dashboard.users.anggota') ? 'text-blue-600 bg-blue-50/70 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.users.anggota') ? 'bg-blue-600 ring-2 ring-blue-100' : 'bg-slate-300' }}"></span>
                                <span>Akun Anggota</span>
                            </a>
                        @endif
                    </x-slot:children>
                </x-dashboard.sidebar-item>

                @if($role === 'super_admin')
                    <x-dashboard.sidebar-item href="{{ route('dashboard.registrations.index') }}" icon="fas fa-user-clock" :active="request()->routeIs('dashboard.registrations.*')">
                        Pendaftaran Anggota
                    </x-dashboard.sidebar-item>
                @endif
            @endif

            @if($canSee('mitra'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.partners.index') }}" icon="fas fa-handshake" :active="request()->routeIs('dashboard.partners.*')">
                    Jejaring Mitra
                </x-dashboard.sidebar-item>
            @endif

            @if($canSee('tampilan'))
                <x-dashboard.sidebar-item href="{{ route('dashboard.appearance.index') }}" icon="fas fa-palette" :active="request()->routeIs('dashboard.appearance.index')">
                    Tampilan & Tema
                </x-dashboard.sidebar-item>
            @endif

            @if($role === 'super_admin')
                <x-dashboard.sidebar-item href="{{ route('dashboard.media-optimizer.index') }}" icon="fas fa-compress-arrows-alt" :active="request()->routeIs('dashboard.media-optimizer.*')">
                    Optimasi Media & Storage
                </x-dashboard.sidebar-item>

                <x-dashboard.sidebar-item href="{{ route('dashboard.peer-evaluation.config') }}" icon="fas fa-clipboard-list" :active="request()->routeIs('dashboard.peer-evaluation.config') || request()->routeIs('dashboard.peer-evaluation.results*')">
                    Kuesioner Penilaian
                </x-dashboard.sidebar-item>

                <x-dashboard.sidebar-item href="{{ route('dashboard.activity-logs.index') }}" icon="fas fa-history" :active="request()->routeIs('dashboard.activity-logs.*')">
                    Log Aktivitas
                </x-dashboard.sidebar-item>

                <x-dashboard.sidebar-item href="{{ route('dashboard.menu-settings.index') }}" icon="fas fa-user-shield" :active="request()->routeIs('dashboard.menu-settings.index')">
                    Hak Akses Menu
                </x-dashboard.sidebar-item>
            @endif
        </div>
    </div>

    <!-- User Profile & Logout Bottom Bar -->
    <div class="p-3 border-t border-slate-100 bg-slate-50/50">
        <div class="flex items-center justify-between p-2 rounded-xl bg-white border border-slate-200/80 shadow-sm" :class="!sidebarOpen && !isMobile ? 'justify-center p-1.5' : ''">
            <div class="flex items-center gap-2.5 min-w-0" x-show="isMobile || sidebarOpen">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xs shrink-0 shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-bold text-slate-800 truncate">{{ explode(' ', auth()->user()->name ?? 'User')[0] }}</span>
                    <span class="text-[9px] font-semibold text-blue-600 uppercase tracking-wider">{{ str_replace('_', ' ', auth()->user()->role ?? 'Admin') }}</span>
                </div>
            </div>

            <a href="{{ route('logout') }}" 
               title="Keluar dari Sistem"
               class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors shrink-0">
                <i class="fas fa-sign-out-alt text-xs"></i>
            </a>
        </div>
    </div>
</aside>
