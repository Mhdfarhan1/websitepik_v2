<x-layouts.dashboard title="Dashboard Ketua | Admin PIK-R">
    @php 
        $menuSettings = \App\Models\MenuSetting::all()->keyBy('menu_key'); 
        $role = auth()->user()->role;
        $canSee = function($key) use ($menuSettings, $role) {
            if ($role === 'super_admin' || $role === 'ketua') return true;
            $setting = $menuSettings[$key] ?? null;
            return $setting ? $setting->{$role . '_visible'} : false;
        };
    @endphp

    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 rounded-[32px] p-8 lg:p-10 text-white shadow-xl shadow-blue-600/15">
            <div class="relative z-10 max-w-2xl">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-md text-[10px] font-black uppercase tracking-widest border border-white/20">
                        KETUA PIK-R PANEL
                    </span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[11px] font-bold text-blue-100">Sesi Operasional Aktif</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold mb-3 leading-tight" style="font-family: 'Montserrat', sans-serif;">
                    Semangat Beraksi, {{ explode(' ', auth()->user()->name)[0] }}! 🚀
                </h2>
                <p class="text-blue-100 text-sm font-medium leading-relaxed opacity-95">
                    Panel kendali operasional Ketua. Kelola program kerja, koordinasi anggota, dan pastikan seluruh konten publikasi up-to-date.
                </p>

                <!-- Quick Action Buttons -->
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a href="{{ route('dashboard.work-programs.create') }}" class="bg-white text-blue-700 hover:bg-blue-50 px-5 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-black/10 transition-all flex items-center gap-2 active:scale-95">
                        <i class="fas fa-plus-circle text-blue-600"></i>
                        <span>Buat Program Kerja</span>
                    </a>
                    <a href="{{ route('dashboard.news.create') }}" class="bg-white/15 hover:bg-white/25 border border-white/20 text-white px-5 py-3 rounded-2xl font-bold text-xs backdrop-blur-md transition-all flex items-center gap-2">
                        <i class="fas fa-newspaper text-amber-300"></i>
                        <span>Tambah Berita Baru</span>
                    </a>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400/20 rounded-full -ml-32 -mb-32 blur-3xl pointer-events-none"></div>
        </div>

        <!-- Operational Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="100">
            @if($canSee('berita'))
                <a href="{{ route('dashboard.news.index') }}" class="block transition-transform hover:-translate-y-1">
                    <x-dashboard.stats-card title="Publikasi Berita" value="{{ $newsCount ?? 0 }}" icon="fas fa-bullhorn" color="blue" />
                </a>
            @endif
            @if($canSee('proker'))
                <a href="{{ route('dashboard.work-programs.index') }}" class="block transition-transform hover:-translate-y-1">
                    <x-dashboard.stats-card title="Program Kerja" value="{{ $totalProker ?? 0 }}" icon="fas fa-tasks" color="green" />
                </a>
            @endif
            @if($canSee('prestasi'))
                <a href="{{ route('dashboard.achievements.index') }}" class="block transition-transform hover:-translate-y-1">
                    <x-dashboard.stats-card title="Total Prestasi" value="{{ $totalPrestasi ?? 0 }}" icon="fas fa-trophy" color="orange" />
                </a>
            @endif
            <a href="{{ route('dashboard.users.anggota') }}" class="block transition-transform hover:-translate-y-1">
                <x-dashboard.stats-card title="Total Anggota" value="{{ $totalAnggota ?? 0 }}" icon="fas fa-users" color="purple" />
            </a>
        </div>

        <!-- Operational Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Program Monitor -->
            <div class="lg:col-span-7 bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-800">Monitor Program Kerja</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Daftar Program Kerja Terbaru</p>
                    </div>
                    <a href="{{ route('dashboard.work-programs.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($latestProkers as $proker)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:bg-blue-50/50 hover:border-blue-100 transition-all">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $proker->title }}</h4>
                                <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $proker->desc ?? 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.work-programs.edit', $proker) }}" class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-all shrink-0">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                    </div>
                    @empty
                    <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <i class="fas fa-folder-open text-slate-300 text-3xl mb-2"></i>
                        <p class="text-xs text-slate-500 font-medium">Belum ada program kerja yang ditambahkan.</p>
                        <a href="{{ route('dashboard.work-programs.create') }}" class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-all">
                            + Tambah Program Kerja
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Access Control Quick Links -->
            <div class="lg:col-span-5 bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md" data-aos="fade-up" data-aos-delay="300">
                <div class="mb-6">
                    <h3 class="text-lg font-black text-slate-800">Aksi Cepat Ketua</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Pintasan Tugas Utama Hari Ini</p>
                </div>
                
                <div class="space-y-3">
                    @if($canSee('berita'))
                    <a href="{{ route('dashboard.news.create') }}" class="flex items-center justify-between p-4 rounded-2xl bg-blue-50/60 border border-blue-100 hover:bg-blue-100/80 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs shrink-0">
                                <i class="fas fa-[#pen] fa-newspaper"></i>
                            </div>
                            <span class="text-xs font-bold text-blue-900">Buat Berita Baru</span>
                        </div>
                        <i class="fas fa-chevron-right text-blue-400 group-hover:translate-x-1 transition-transform text-xs"></i>
                    </a>
                    @endif

                    @if($canSee('prestasi'))
                    <a href="{{ route('dashboard.achievements.create') }}" class="flex items-center justify-between p-4 rounded-2xl bg-amber-50/60 border border-amber-100 hover:bg-amber-100/80 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs shrink-0">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <span class="text-xs font-bold text-amber-900">Input Prestasi</span>
                        </div>
                        <i class="fas fa-chevron-right text-amber-400 group-hover:translate-x-1 transition-transform text-xs"></i>
                    </a>
                    @endif

                    <a href="{{ route('dashboard.peer-evaluation.index') }}" class="flex items-center justify-between p-4 rounded-2xl bg-purple-50/60 border border-purple-100 hover:bg-purple-100/80 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center text-xs shrink-0">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <span class="text-xs font-bold text-purple-900">Penilaian Anggota</span>
                        </div>
                        <i class="fas fa-chevron-right text-purple-400 group-hover:translate-x-1 transition-transform text-xs"></i>
                    </a>

                    <a href="{{ route('dashboard.users.anggota') }}" class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 hover:bg-emerald-100/80 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xs shrink-0">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="text-xs font-bold text-emerald-900">Data Anggota</span>
                        </div>
                        <i class="fas fa-chevron-right text-emerald-400 group-hover:translate-x-1 transition-transform text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
