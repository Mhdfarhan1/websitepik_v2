<x-layouts.app>
    <div class="relative min-h-screen bg-slate-50">
        
        <!-- Section 1: Hero Banner Statistik Layanan (100vh Full Screen Matching Gambar 2 Layout Exactly) -->
        <div class="relative w-full h-screen flex items-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                @php
                    $bgUrl = $settings['statistik_bg'] ?? '';
                    if($bgUrl && !str_starts_with($bgUrl, 'http')) {
                        $bgUrl = asset('storage/' . $bgUrl);
                    }
                @endphp
                <img src="{{ $bgUrl ?: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1600' }}" alt="Statistik Background" class="w-full h-full object-cover object-center">
                
                <!-- Precise Dark Navy Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#17385c]/95 via-[#17385c]/85 to-blue-600/40"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20">
                <div class="max-w-2xl space-y-6 animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-amber-300 text-xs font-extrabold uppercase tracking-widest">
                        <i class="fas fa-chart-pie text-amber-400"></i>
                        <span>Update Data: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white tracking-tight leading-tight">
                        Statistik <span class="text-[#f59e0b]">Layanan PIK-R</span>
                    </h1>
                    
                    <p class="text-slate-200 text-xs sm:text-sm leading-relaxed max-w-xl font-medium">
                        Keterbukaan informasi dan akuntabilitas publik mengenai capaian penerima manfaat layanan konseling, kegiatan edukasi, serta dampak sosial PIK-R REQUEST SMAN 1 Tasik Putri Puyu.
                    </p>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="#dashboard-statistik" class="px-6 py-3 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-xl font-bold text-xs transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2 active:scale-95">
                            <span>Eksplorasi Data & Grafik</span>
                            <i class="fas fa-arrow-down text-[10px]"></i>
                        </a>
                        <a href="{{ route('laporan') }}" class="px-6 py-3 border-2 border-white text-white rounded-xl font-bold text-xs hover:bg-white hover:text-[#17385c] transition-all flex items-center gap-2 active:scale-95">
                            <span>Laporan Berkala</span>
                            <i class="fas fa-file-alt text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Interactive Stats Dashboard -->
        <div id="dashboard-statistik" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            
            <!-- Top 3 KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mb-12">
                
                <!-- KPI Card 1: Total Remaja Teredukasi -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1" data-aos="fade-up" data-aos-delay="0">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold border border-blue-100 group-hover:scale-110 transition-transform">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100">
                            <i class="fas fa-arrow-up text-[10px]"></i>
                            <span>{{ $settings['total_remaja_trend'] ?? '+12% dari bulan lalu' }}</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">{{ number_format($settings['total_remaja'] ?? 0) }}</h3>
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mt-2">Total Remaja Teredukasi</p>
                    </div>
                </div>

                <!-- KPI Card 2: Sesi Konseling Sebaya -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-[#f59e0b] flex items-center justify-center text-2xl font-bold border border-amber-100 group-hover:scale-110 transition-transform">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100">
                            <i class="fas fa-check-circle text-[10px]"></i>
                            <span>{{ $settings['sesi_konseling_trend'] ?? '100% Ditangani Professional' }}</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">{{ number_format($settings['sesi_konseling'] ?? 0) }}</h3>
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mt-2">Sesi Konseling Sebaya</p>
                    </div>
                </div>

                <!-- KPI Card 3: Kegiatan Edukasi -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl font-bold border border-purple-100 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100">
                            <i class="fas fa-arrow-up text-[10px]"></i>
                            <span>{{ $settings['kegiatan_edukasi_trend'] ?? '+5 kegiatan baru' }}</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">{{ number_format($settings['kegiatan_edukasi'] ?? 0) }}</h3>
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mt-2">Kegiatan Edukasi Terlaksana</p>
                    </div>
                </div>

            </div>

            <!-- 3 Modern Charts Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                
                <!-- Chart 1: Demografi Klien (Donut Chart) -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-[10px] font-extrabold text-blue-600 uppercase tracking-widest">Berdasarkan Tingkat Kelas</span>
                            <h3 class="text-lg font-extrabold text-slate-900 mt-0.5">Demografi Klien</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center justify-center py-4">
                        <div id="demografiChart" class="w-full"></div>
                    </div>
                </div>

                <!-- Chart 2: Topik Konseling Utama (Bar Chart) -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-[10px] font-extrabold text-[#f59e0b] uppercase tracking-widest">Isu Paling Sering Dibahas</span>
                            <h3 class="text-lg font-extrabold text-slate-900 mt-0.5">Topik Konseling</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#f59e0b] flex items-center justify-center">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center justify-center py-4">
                        <div id="topikChart" class="w-full"></div>
                    </div>
                </div>

                <!-- Chart 3: Pencapaian Target (RadialBar Gauge Chart) -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between" data-aos="fade-up" data-aos-delay="500">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-widest">Target Edukasi Tahunan</span>
                            <h3 class="text-lg font-extrabold text-slate-900 mt-0.5">Pencapaian Target</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fas fa-bullseye"></i>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center justify-center relative py-4">
                        <div id="targetChart" class="w-full"></div>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none flex-col mt-4">
                            @php
                                $totalRemaja = $settings['total_remaja'] ?? 0;
                                $target = max(1, $settings['target_edukasi_tahunan'] ?? 1000);
                                $pct = min(round(($totalRemaja / $target) * 100), 100);
                            @endphp
                            <span class="text-3xl font-black text-slate-900">{{ $pct }}%</span>
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Tercapai</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Transparency Statement Card -->
            <div class="mt-12 p-8 sm:p-10 bg-gradient-to-r from-[#17385c] via-[#1e40af] to-blue-600 rounded-3xl text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6" data-aos="fade-up">
                <div class="space-y-2 text-center sm:text-left">
                    <span class="text-[11px] font-extrabold text-amber-300 uppercase tracking-widest">Keterbukaan Informasi Publik</span>
                    <h4 class="text-xl font-extrabold text-white">Komitmen Akuntabilitas PIK-R REQUEST</h4>
                    <p class="text-xs text-blue-100 max-w-xl leading-relaxed">
                        Data statistik disajikan secara aktual untuk memastikan keberlanjutan program edukasi remaja, peningkatan mutu layanan konseling, dan transparansi publik SMAN 1 Tasik Putri Puyu.
                    </p>
                </div>
                <a href="{{ route('laporan') }}" class="px-6 py-3.5 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-xl font-extrabold text-xs shadow-lg shadow-amber-500/20 transition-all hover:scale-105 shrink-0 flex items-center gap-2">
                    <i class="fas fa-file-download"></i>
                    <span>Unduh Laporan Berkala</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart 1: Demografi Donut
            var demografiOptions = {
                series: [{{ $settings['demo_kelas_x'] ?? 0 }}, {{ $settings['demo_kelas_xi'] ?? 0 }}, {{ $settings['demo_kelas_xii'] ?? 0 }}],
                chart: {
                    type: 'donut',
                    height: 280,
                    fontFamily: 'Plus Jakarta Sans, Inter, sans-serif',
                },
                labels: ['Kelas X', 'Kelas XI', 'Kelas XII'],
                colors: ['#2563eb', '#f59e0b', '#10b981'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: { fontSize: '12px', fontWeight: 700, color: '#64748b' },
                                value: { fontSize: '24px', fontWeight: 900, color: '#0f172a' },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    label: 'Total Klien',
                                    fontSize: '10px',
                                    fontWeight: 800,
                                    color: '#94a3b8'
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 700,
                    markers: { radius: 12 }
                }
            };
            new ApexCharts(document.querySelector("#demografiChart"), demografiOptions).render();

            // Chart 2: Topik Bar
            var topikOptions = {
                series: [{
                    name: 'Persentase',
                    data: [{{ $settings['topik_1_pct'] ?? 33 }}, {{ $settings['topik_2_pct'] ?? 33 }}, {{ $settings['topik_3_pct'] ?? 34 }}]
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'Plus Jakarta Sans, Inter, sans-serif',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        horizontal: true,
                        distributed: true,
                        barHeight: '55%'
                    }
                },
                colors: ['#2563eb', '#f59e0b', '#10b981'],
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val + "%";
                    },
                    style: { fontSize: '11px', fontWeight: 800, colors: ['#ffffff'] }
                },
                xaxis: {
                    categories: ['{{ $settings['topik_1_nama'] ?? 'Kesehatan Mental' }}', '{{ $settings['topik_2_nama'] ?? 'Akademik & Belajar' }}', '{{ $settings['topik_3_nama'] ?? 'Kesehatan Reproduksi' }}'],
                    labels: { show: false },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { fontSize: '11px', fontWeight: 700, colors: '#475569' } }
                },
                grid: { show: false },
                legend: { show: false }
            };
            new ApexCharts(document.querySelector("#topikChart"), topikOptions).render();

            // Chart 3: Target Radial Bar
            @php
                $totalRemaja = $settings['total_remaja'] ?? 0;
                $target = max(1, $settings['target_edukasi_tahunan'] ?? 1000);
                $pct = min(round(($totalRemaja / $target) * 100), 100);
            @endphp
            var targetPercentage = {{ $pct }};
            var targetOptions = {
                series: [targetPercentage],
                chart: {
                    height: 280,
                    type: 'radialBar',
                    fontFamily: 'Plus Jakarta Sans, Inter, sans-serif',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '65%',
                        },
                        track: {
                            background: '#f1f5f9',
                            strokeWidth: '100%',
                        },
                        dataLabels: {
                            show: false
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        gradientToColors: ['#2563eb'],
                        stops: [0, 100]
                    }
                },
                stroke: {
                    lineCap: 'round'
                },
                colors: ['#f59e0b'],
            };
            new ApexCharts(document.querySelector("#targetChart"), targetOptions).render();
        });
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
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</x-layouts.app>
