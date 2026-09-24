<header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
    <div class="flex items-center gap-4">
        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenu = true" class="lg:hidden w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Quick Search Bar -->
        <div class="relative w-64 md:w-96 hidden sm:block">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" placeholder="Cari menu atau fitur..." 
                   class="w-full bg-slate-50 border-none rounded-2xl py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-blue-500/20 transition-all">
        </div>
    </div>

    <!-- Right Actions -->
    <div class="flex items-center gap-4 lg:gap-6">
        <!-- Live Notifications Dropdown -->
        <x-notifications.navbar-bell />

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ openProfile: false }">
            <div @click="openProfile = !openProfile" @click.outside="openProfile = false" class="flex items-center gap-4 pl-4 lg:pl-6 border-l border-slate-100 cursor-pointer select-none">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ str_replace('_', ' ', auth()->user()->role ?? 'User') }}</p>
                </div>
                <div class="flex items-center gap-2 group">
                    <div class="w-11 h-11 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm border-2 border-white shadow-md group-hover:scale-105 transition-transform">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <i class="fas fa-chevron-down text-[10px] text-slate-300 group-hover:text-slate-500 transition-colors" :class="openProfile ? 'rotate-180' : ''"></i>
                </div>
            </div>

            <!-- Profile Menu -->
            <div x-show="openProfile" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50 text-slate-700 font-medium text-xs overflow-hidden">
                
                <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                    <p class="font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('dashboard.profile-settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                    <i class="fas fa-user-cog text-blue-500 w-4"></i>
                    <span>Pengaturan Profil</span>
                </a>
                <a href="{{ route('dashboard.password.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                    <i class="fas fa-key text-amber-500 w-4"></i>
                    <span>Ganti Password</span>
                </a>
                <div class="border-t border-slate-100 my-1"></div>
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-2.5 text-rose-600 hover:bg-rose-50 transition-colors">
                    <i class="fas fa-sign-out-alt text-rose-500 w-4"></i>
                    <span>Keluar Akun</span>
                </a>
            </div>
        </div>
    </div>
</header>
