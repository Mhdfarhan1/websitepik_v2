<x-layouts.dashboard title="Dashboard Admin PIK-R">
    <div class="space-y-8">
        <!-- Welcome Banner (Refined Navy & Indigo Accent) -->
        <div class="relative overflow-hidden bg-gradient-to-r from-[#172e4d] via-[#1e3a5f] to-[#15273f] rounded-3xl p-8 lg:p-10 text-white shadow-xl shadow-slate-900/10 border border-slate-700/30">
            <!-- Subtle Radial Gradient Background Highlights -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-br from-blue-500/15 to-transparent rounded-full blur-3xl pointer-events-none -mr-40 -mt-40"></div>
            <div class="absolute bottom-0 left-1/3 w-[300px] h-[300px] bg-amber-500/10 rounded-full blur-2xl pointer-events-none -mb-32"></div>

            <div class="relative z-10 max-w-2xl">
                <div class="flex items-center gap-3 mb-3.5">
                    <span class="px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md text-[10px] font-extrabold uppercase tracking-widest border border-white/15 text-slate-200">
                        {{ strtoupper(auth()->user()->role) }} PANEL
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[11px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Sistem Aktif
                    </span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-extrabold mb-3 leading-tight tracking-tight text-white">
                    Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }} 👋
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm font-normal leading-relaxed max-w-xl">
                    Kelola seluruh konten landing page, program kerja, laporan, dan data organisasi PIK-R REQUEST SMAN 1 Tasik Putri Puyu dalam satu kendali terpusat.
                </p>

                <!-- Quick Actions Dropdown -->
                <div class="mt-7 flex flex-wrap items-center gap-3" x-data="{ openQuickAction: false }">
                    <div class="relative">
                        <button @click="openQuickAction = !openQuickAction" @click.outside="openQuickAction = false" 
                            class="bg-[#f59e0b] hover:bg-[#d97706] text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-amber-500/20 transition-all duration-200 flex items-center gap-2 cursor-pointer active:scale-95">
                            <i class="fas fa-plus text-xs"></i>
                            <span>Tambah Data Utama</span>
                            <i class="fas fa-chevron-down text-[9px] transition-transform" :class="openQuickAction ? 'rotate-180' : ''"></i>
                        </button>

                        <!-- Quick Action Menu -->
                        <div x-show="openQuickAction" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute left-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50 text-slate-700 font-medium text-xs overflow-hidden">
                            
                            <a href="{{ route('dashboard.news.create') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-newspaper text-blue-500 w-4"></i>
                                <span>Tambah Berita Baru</span>
                            </a>
                            <a href="{{ route('dashboard.work-programs.create') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-briefcase text-emerald-500 w-4"></i>
                                <span>Tambah Program Kerja</span>
                            </a>
                            <a href="{{ route('dashboard.gallery.create') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-images text-amber-500 w-4"></i>
                                <span>Tambah Media Visual</span>
                            </a>
                            <a href="{{ route('dashboard.reports.create') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-file-alt text-purple-500 w-4"></i>
                                <span>Tambah Laporan</span>
                            </a>
                            @if(auth()->user()->role === 'super_admin')
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('dashboard.users.anggota') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-user-plus text-rose-500 w-4"></i>
                                <span>Tambah Akun Anggota</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    @if(isset($pendingRegistrationsCount) && $pendingRegistrationsCount > 0)
                    <a href="{{ route('dashboard.registrations.index') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 backdrop-blur-md">
                        <i class="fas fa-bell text-amber-400"></i>
                        <span>{{ $pendingRegistrationsCount }} Pendaftaran Menunggu</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5" data-aos="fade-up" data-aos-delay="100">
            <x-dashboard.stats-card title="Total Anggota" value="{{ $totalAnggota ?? 0 }}" icon="fas fa-user-friends" color="blue" />
            <x-dashboard.stats-card title="Program Kerja" value="{{ $totalProker ?? 0 }}" icon="fas fa-briefcase" color="green" />
            <x-dashboard.stats-card title="Data Galeri" value="{{ $totalGaleri ?? 0 }}" icon="fas fa-image" color="orange" />
            <x-dashboard.stats-card title="Kegiatan & Edukasi" value="{{ $totalKegiatan ?? 0 }}" icon="fas fa-calendar-alt" color="purple" />
        </div>

        <!-- Charts & Lists Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Distribution Chart -->
            <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs" data-aos="fade-up" data-aos-delay="200">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Distribusi Anggota</h3>
                        <p class="text-[11px] text-slate-400 font-medium">Perbandingan Pengurus Inti vs Anggota</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 text-xs">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
                <div class="h-56 relative">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>

            <!-- Content Stats -->
            <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs" data-aos="fade-up" data-aos-delay="300">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Statistik Konten</h3>
                        <p class="text-[11px] text-slate-400 font-medium">Jumlah Konten Aktif di Sistem</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 text-xs">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
                <div class="h-56 relative">
                    <canvas id="contentChart"></canvas>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between" data-aos="fade-up" data-aos-delay="400">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Anggota Terbaru</h3>
                            <p class="text-[11px] text-slate-400 font-medium">Pengguna terdaftar terbaru</p>
                        </div>
                        <a href="{{ route('dashboard.users.anggota') }}" class="text-[11px] font-bold text-blue-600 hover:text-blue-700 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentUsers as $u)
                        <div class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 transition-colors group cursor-pointer border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200/80 flex items-center justify-center text-slate-700 font-bold text-xs shrink-0 group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-200 transition-colors">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition-colors leading-tight truncate">{{ $u->name }}</p>
                                    <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $u->email }}</p>
                                </div>
                            </div>
                            <span @class([
                                'px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider shrink-0 ml-2 border',
                                'bg-amber-50 text-amber-700 border-amber-200' => in_array($u->role, ['super_admin', 'pembina', 'ketua']),
                                'bg-blue-50 text-blue-700 border-blue-200' => $u->role === 'anggota',
                            ])>
                                {{ str_replace('_', ' ', $u->role) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 italic text-center py-6">Belum ada data anggota.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Distribution Chart (Professional Navy & Slate Palette)
            const distCtx = document.getElementById('distributionChart')?.getContext('2d');
            if (distCtx) {
                new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Anggota', 'Pengurus Inti'],
                        datasets: [{
                            data: [{{ $memberUsersCount ?? 0 }}, {{ $coreUsersCount ?? 0 }}],
                            backgroundColor: ['#2563eb', '#f59e0b'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 16,
                                    font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 },
                                    color: '#64748b'
                                }
                            }
                        }
                    }
                });
            }

            // Content Chart (Harmonious Modern Bar Style)
            const contentCtx = document.getElementById('contentChart')?.getContext('2d');
            if (contentCtx) {
                new Chart(contentCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Proker', 'Galeri', 'Berita', 'Laporan'],
                        datasets: [{
                            label: 'Jumlah',
                            data: [{{ $totalProker ?? 0 }}, {{ $totalGaleri ?? 0 }}, {{ $newsCount ?? 0 }}, {{ $reportCount ?? 0 }}],
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#6366f1'],
                            borderRadius: 6,
                            barThickness: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9', drawBorder: false },
                                ticks: { 
                                    font: { family: 'Plus Jakarta Sans', weight: '600', size: 10 },
                                    color: '#94a3b8',
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { 
                                    font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 },
                                    color: '#64748b'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-layouts.dashboard>
