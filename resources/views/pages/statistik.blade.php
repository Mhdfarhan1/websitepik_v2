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
            
            <!-- Section Title & Badge -->
            <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200/60 text-blue-700 text-xs font-black uppercase tracking-widest mb-3 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>Transparansi & Akuntabilitas Publik</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    Statistik & Capaian <span class="text-[#f59e0b]">Layanan Remaja</span>
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-3 font-medium leading-relaxed max-w-2xl mx-auto">
                    Data terkini mengenai jangkauan penerima manfaat, sesi konseling sebaya, dan kegiatan edukasi kesehatan reproduksi di lingkungan SMAN 1 Tasik Putri Puyu.
                </p>
                <div class="w-20 h-1 bg-gradient-to-r from-blue-600 via-amber-500 to-emerald-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Top 3 KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mb-12">
                
                <!-- KPI Card 1: Total Remaja Teredukasi -->
                <div class="bg-white p-7 sm:p-8 rounded-3xl border border-slate-200/80 hover:border-blue-400/50 shadow-sm hover:shadow-2xl transition-all duration-300 group hover:-translate-y-1.5 relative overflow-hidden" data-aos="fade-up" data-aos-delay="0">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl pointer-events-none group-hover:bg-blue-500/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-6 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 flex items-center justify-center text-2xl font-bold border border-blue-200/60 group-hover:scale-110 shadow-sm transition-transform">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200/60 shadow-sm">
                            <i class="fas fa-arrow-up text-[10px]"></i>
                            <span>{{ $settings['total_remaja_trend'] ?? '+12% dari bulan lalu' }}</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">{{ number_format($settings['total_remaja'] ?? 428) }}</h3>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-1.5">
                            <span>Total Remaja Teredukasi</span>
                            <i class="fas fa-check-circle text-blue-500 text-[11px]"></i>
                        </p>
                    </div>
                </div>

                <!-- KPI Card 2: Sesi Konseling Sebaya -->
                <div class="bg-white p-7 sm:p-8 rounded-3xl border border-slate-200/80 hover:border-amber-400/50 shadow-sm hover:shadow-2xl transition-all duration-300 group hover:-translate-y-1.5 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full blur-2xl pointer-events-none group-hover:bg-amber-500/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-6 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 text-[#f59e0b] flex items-center justify-center text-2xl font-bold border border-amber-200/60 group-hover:scale-110 shadow-sm transition-transform">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200/60 shadow-sm">
                            <i class="fas fa-check-circle text-[10px]"></i>
                            <span>{{ $settings['sesi_konseling_trend'] ?? '100% Ditangani Profesional' }}</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">{{ number_format($settings['sesi_konseling'] ?? 56) }}</h3>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-1.5">
                            <span>Sesi Konseling Sebaya</span>
                            <i class="fas fa-check-circle text-amber-500 text-[11px]"></i>
                        </p>
                    </div>
                </div>

                <!-- KPI Card 3: Kegiatan Edukasi -->
                <div class="bg-white p-7 sm:p-8 rounded-3xl border border-slate-200/80 hover:border-purple-400/50 shadow-sm hover:shadow-2xl transition-all duration-300 group hover:-translate-y-1.5 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-2xl pointer-events-none group-hover:bg-purple-500/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-6 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 flex items-center justify-center text-2xl font-bold border border-purple-200/60 group-hover:scale-110 shadow-sm transition-transform">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200/60 shadow-sm">
                            <i class="fas fa-arrow-up text-[10px]"></i>
                            <span>{{ $settings['kegiatan_edukasi_trend'] ?? '+5 kegiatan baru' }}</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">{{ number_format($settings['kegiatan_edukasi'] ?? 12) }}</h3>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-1.5">
                            <span>Kegiatan Edukasi Terlaksana</span>
                            <i class="fas fa-check-circle text-purple-500 text-[11px]"></i>
                        </p>
                    </div>
                </div>

            </div>

            <!-- 3 Modern Charts Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                
                <!-- Chart 1: Demografi Klien (Donut Chart) -->
                <div class="bg-white p-7 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Berdasarkan Tingkat Kelas</span>
                            <h3 class="text-lg font-black text-slate-900 mt-0.5">Demografi Klien</h3>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shadow-sm">
                            <i class="fas fa-chart-pie text-base"></i>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center justify-center py-2">
                        <div id="demografiChart" class="w-full"></div>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-500">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#2563eb]"></span> Kelas X</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b]"></span> Kelas XI</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#10b981]"></span> Kelas XII</span>
                    </div>
                </div>

                <!-- Chart 2: Topik Konseling Utama (Bar Chart) -->
                <div class="bg-white p-7 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-[10px] font-black text-[#f59e0b] uppercase tracking-widest">Isu Paling Sering Dibahas</span>
                            <h3 class="text-lg font-black text-slate-900 mt-0.5">Topik Konseling</h3>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-amber-50 text-[#f59e0b] flex items-center justify-center border border-amber-100 shadow-sm">
                            <i class="fas fa-chart-bar text-base"></i>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center justify-center py-2">
                        <div id="topikChart" class="w-full"></div>
                    </div>
                    <div class="pt-4 border-t border-slate-100 text-[11px] font-semibold text-slate-400 flex items-center justify-between">
                        <span>Layanan Konseling Rahasia & Nyaman</span>
                        <i class="fas fa-lock text-emerald-500"></i>
                    </div>
                </div>

                <!-- Chart 3: Pencapaian Target (RadialBar Gauge Chart) -->
                <div class="bg-white p-7 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Target Edukasi Tahunan</span>
                            <h3 class="text-lg font-black text-slate-900 mt-0.5">Pencapaian Target</h3>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-sm">
                            <i class="fas fa-bullseye text-base"></i>
                        </div>
                    </div>

                    @php
                        $totalRemaja = $settings['total_remaja'] ?? 428;
                        $target = max(1, $settings['target_edukasi_tahunan'] ?? 1000);
                        $calcPct = round(($totalRemaja / $target) * 100);
                        $displayPct = min(max(0, $calcPct), 100);
                    @endphp

                    <div class="flex-1 flex items-center justify-center relative py-2">
                        <div id="targetChart" class="w-full"></div>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none flex-col mt-3">
                            <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $displayPct }}%</span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-full mt-1">Tercapai</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-600 mb-2">
                            <span>Realisasi Capaian</span>
                            <span class="text-slate-900 font-extrabold">{{ number_format($totalRemaja) }} / {{ number_format($target) }} Remaja</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-amber-500 to-emerald-500 transition-all duration-1000" style="width: {{ $displayPct }}%;"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Transparency Statement Card -->
            <div class="mt-12 p-8 sm:p-10 bg-gradient-to-r from-[#17385c] via-[#1e40af] to-blue-600 rounded-3xl text-white shadow-xl shadow-blue-900/10 flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden" data-aos="fade-up">
                <div class="space-y-2 text-center sm:text-left relative z-10">
                    <span class="text-[11px] font-black text-amber-300 uppercase tracking-widest">Keterbukaan Informasi Publik</span>
                    <h4 class="text-xl sm:text-2xl font-black text-white">Komitmen Akuntabilitas PIK-R REQUEST</h4>
                    <p class="text-xs sm:text-sm text-blue-100 max-w-xl leading-relaxed font-medium">
                        Data statistik disajikan secara aktual untuk memastikan keberlanjutan program edukasi remaja, peningkatan mutu layanan konseling sebaya, dan transparansi publik SMAN 1 Tasik Putri Puyu.
                    </p>
                </div>
                <a href="{{ route('laporan') }}" class="relative z-10 px-7 py-3.5 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-amber-500/20 transition-all hover:scale-105 shrink-0 flex items-center gap-2.5">
                    <i class="fas fa-file-download text-sm"></i>
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
            var demoX = {{ $settings['demo_kelas_x'] ?? 45 }};
            var demoXI = {{ $settings['demo_kelas_xi'] ?? 35 }};
            var demoXII = {{ $settings['demo_kelas_xii'] ?? 20 }};

            var demografiOptions = {
                series: [demoX, demoXI, demoXII],
                chart: {
                    type: 'donut',
                    height: 270,
                    fontFamily: 'Plus Jakarta Sans, Inter, sans-serif',
                },
                labels: ['Kelas X', 'Kelas XI', 'Kelas XII'],
                colors: ['#2563eb', '#f59e0b', '#10b981'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: { fontSize: '11px', fontWeight: 700, color: '#64748b' },
                                value: { fontSize: '24px', fontWeight: 900, color: '#0f172a' },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    label: 'Total Klien',
                                    fontSize: '10px',
                                    fontWeight: 800,
                                    color: '#94a3b8',
                                    formatter: function () {
                                        return '{{ number_format($settings['sesi_konseling'] ?? 56) }}';
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                legend: { show: false }
            };
            new ApexCharts(document.querySelector("#demografiChart"), demografiOptions).render();

            // Chart 2: Topik Bar (Fixed HTML Entity &amp; Bug via JSON encoding)
            var topicCategories = {!! json_encode([
                html_entity_decode($settings['topik_1_nama'] ?? 'Kesehatan Mental', ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                html_entity_decode($settings['topik_2_nama'] ?? 'Akademik & Belajar', ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                html_entity_decode($settings['topik_3_nama'] ?? 'Hubungan Sosial', ENT_QUOTES | ENT_HTML5, 'UTF-8')
            ]) !!};

            var topikOptions = {
                series: [{
                    name: 'Persentase',
                    data: [{{ $settings['topik_1_pct'] ?? 45 }}, {{ $settings['topik_2_pct'] ?? 35 }}, {{ $settings['topik_3_pct'] ?? 20 }}]
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
                        barHeight: '52%'
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
                    categories: topicCategories,
                    labels: { show: false },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { fontSize: '11px', fontWeight: 800, colors: '#334155' } }
                },
                grid: { show: false },
                legend: { show: false }
            };
            new ApexCharts(document.querySelector("#topikChart"), topikOptions).render();

            // Chart 3: Target Radial Bar (Vibrant Multi-tone)
            var targetPercentValue = {{ $displayPct }};
            var targetOptions = {
                series: [targetPercentValue],
                chart: {
                    height: 270,
                    type: 'radialBar',
                    fontFamily: 'Plus Jakarta Sans, Inter, sans-serif',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '68%',
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
                        gradientToColors: ['#10b981'],
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
