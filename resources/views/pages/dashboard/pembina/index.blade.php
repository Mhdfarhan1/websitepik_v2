<x-layouts.dashboard title="Dashboard Pembina | Admin PIK-R">
    @php 
        $menuSettings = \App\Models\MenuSetting::all()->keyBy('menu_key'); 
        $role = auth()->user()->role;
        $canSee = function($key) use ($menuSettings, $role) {
            if ($role === 'super_admin' || $role === 'pembina') return true;
            $setting = $menuSettings[$key] ?? null;
            return $setting ? $setting->{$role . '_visible'} : false;
        };
    @endphp

    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 rounded-[32px] p-8 lg:p-10 text-white shadow-xl shadow-emerald-600/15">
            <div class="relative z-10 max-w-2xl">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-md text-[10px] font-black uppercase tracking-widest border border-white/20">
                        PEMBINA PIK-R
                    </span>
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span class="text-[11px] font-bold text-emerald-100">Sesi Aktif</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold mb-3 leading-tight" style="font-family: 'Montserrat', sans-serif;">
                    Halo, Bapak/Ibu {{ explode(' ', auth()->user()->name)[0] }} 👋
                </h2>
                <p class="text-emerald-50 text-sm font-medium leading-relaxed opacity-95">
                    Selamat datang di panel kendali Pembina. Anda dapat memantau aktivitas, mengelola konten publikasi, dan memantau perkembangan organisasi PIK-R.
                </p>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full -ml-32 -mb-32 blur-3xl pointer-events-none"></div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="100">
            @if($canSee('berita'))
                <a href="{{ route('dashboard.news.index') }}" class="block transition-transform hover:-translate-y-1">
                    <x-dashboard.stats-card title="Artikel Berita" value="{{ $newsCount ?? 0 }}" icon="fas fa-newspaper" color="blue" />
                </a>
            @endif
            @if($canSee('kegiatan'))
                <a href="{{ route('dashboard.work-programs.index') }}" class="block transition-transform hover:-translate-y-1">
                    <x-dashboard.stats-card title="Program Kerja" value="{{ $totalProker ?? 0 }}" icon="fas fa-calendar-check" color="emerald" />
                </a>
            @endif
            @if($canSee('galeri'))
                <a href="{{ route('dashboard.gallery.index') }}" class="block transition-transform hover:-translate-y-1">
                    <x-dashboard.stats-card title="Media Galeri" value="{{ $totalGaleri ?? 0 }}" icon="fas fa-images" color="orange" />
                </a>
            @endif
            <a href="{{ route('dashboard.users.anggota') }}" class="block transition-transform hover:-translate-y-1">
                <x-dashboard.stats-card title="Total Anggota" value="{{ $totalAnggota ?? 0 }}" icon="fas fa-user-friends" color="purple" />
            </a>
        </div>

        <!-- Authorized Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Users -->
            <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-800">Anggota Baru Terdaftar</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Daftar Anggota Terbaru</p>
                    </div>
                    <a href="{{ route('dashboard.users.anggota') }}" class="text-xs font-bold text-emerald-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentUsers as $u)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ strtoupper(substr($u->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800 leading-tight">{{ $u->name }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">{{ $u->email }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 text-slate-600 rounded-lg text-[9px] font-bold uppercase">
                            {{ str_replace('_', ' ', $u->role) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data anggota.</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Shortcuts -->
            <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md" data-aos="fade-up" data-aos-delay="300">
                <div class="mb-6">
                    <h3 class="text-lg font-black text-slate-800">Pintasan Cepat</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Akses Langsung Fitur Utama</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @if($canSee('berita'))
                    <a href="{{ route('dashboard.news.create') }}" class="p-5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 transition-all group text-center">
                        <i class="fas fa-plus-circle text-emerald-600 mb-2 block text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 block">Buat Berita</span>
                    </a>
                    @endif
                    @if($canSee('galeri'))
                    <a href="{{ route('dashboard.gallery.create') }}" class="p-5 rounded-2xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 transition-all group text-center">
                        <i class="fas fa-upload text-blue-600 mb-2 block text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 block">Upload Galeri</span>
                    </a>
                    @endif
                    <a href="{{ route('dashboard.reports.index') }}" class="p-5 rounded-2xl bg-slate-50 hover:bg-purple-50 border border-slate-100 hover:border-purple-200 transition-all group text-center">
                        <i class="fas fa-file-signature text-purple-600 mb-2 block text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 block">Laporan Berkala</span>
                    </a>
                    <a href="{{ route('dashboard.users.anggota') }}" class="p-5 rounded-2xl bg-slate-50 hover:bg-amber-50 border border-slate-100 hover:border-amber-200 transition-all group text-center">
                        <i class="fas fa-users-cog text-amber-600 mb-2 block text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 block">Data Anggota</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
