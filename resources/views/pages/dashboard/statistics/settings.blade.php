<x-layouts.dashboard title="Pengaturan Statistik | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Statistik Layanan</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Sesuaikan angka laporan</p>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <form action="{{ route('dashboard.statistics.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    <div class="space-y-12">
                        <!-- Top 3 Stats -->
                        <div>
                            <h2 class="text-lg font-black text-slate-800 mb-6 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-sort-numeric-up text-blue-500"></i> Angka Utama & Tampilan
                                </div>
                            </h2>
                            
                            <!-- Hero Image -->
                            <div class="mb-6 bg-slate-50 p-5 rounded-2xl border border-slate-100 flex flex-col md:flex-row gap-6 items-start md:items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800">Gambar Latar Belakang (Hero)</h3>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar latar belakang saat ini.</p>
                                </div>
                                <div class="flex-shrink-0 w-full md:w-64">
                                    <input type="file" name="statistik_bg" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                                </div>
                                @if(!empty($settings['statistik_bg']))
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $settings['statistik_bg']) }}" alt="Current BG" class="h-12 w-20 object-cover rounded-lg border border-slate-200">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-6 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800">Target Edukasi Tahunan</h3>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5">Digunakan pada grafik Pencapaian Target.</p>
                                </div>
                                <div class="w-48">
                                    <input type="number" name="target_edukasi_tahunan" value="{{ old('target_edukasi_tahunan', $settings['target_edukasi_tahunan'] ?? 1000) }}" class="w-full px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required min="1">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-4 relative">
                                    <span class="absolute top-4 right-4 text-[9px] font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded-md">OTOMATIS</span>
                                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Remaja Teredukasi</h3>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Total (Dari Peserta Edukasi)</label>
                                        <input type="number" value="{{ $settings['total_remaja'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-100 border-transparent text-sm font-bold text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="total_remaja" value="{{ $settings['total_remaja'] }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Tren (Teks)</label>
                                        <input type="text" name="total_remaja_trend" value="{{ old('total_remaja_trend', $settings['total_remaja_trend']) }}" class="w-full px-4 py-3 rounded-xl bg-white border-transparent focus:border-[#1e3a8a] focus:ring-0 text-xs font-medium transition-all" required>
                                    </div>
                                </div>

                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-4 relative">
                                    <span class="absolute top-4 right-4 text-[9px] font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded-md">OTOMATIS</span>
                                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Konseling Sebaya</h3>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Total (Dari Data Konseling)</label>
                                        <input type="number" value="{{ $settings['sesi_konseling'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-100 border-transparent text-sm font-bold text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="sesi_konseling" value="{{ $settings['sesi_konseling'] }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Tren (Teks)</label>
                                        <input type="text" name="sesi_konseling_trend" value="{{ old('sesi_konseling_trend', $settings['sesi_konseling_trend']) }}" class="w-full px-4 py-3 rounded-xl bg-white border-transparent focus:border-[#1e3a8a] focus:ring-0 text-xs font-medium transition-all" required>
                                    </div>
                                </div>

                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-4 relative">
                                    <span class="absolute top-4 right-4 text-[9px] font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded-md">OTOMATIS</span>
                                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Kegiatan Edukasi</h3>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Total (Dari Data Edukasi)</label>
                                        <input type="number" value="{{ $settings['kegiatan_edukasi'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-100 border-transparent text-sm font-bold text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="kegiatan_edukasi" value="{{ $settings['kegiatan_edukasi'] }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Tren (Teks)</label>
                                        <input type="text" name="kegiatan_edukasi_trend" value="{{ old('kegiatan_edukasi_trend', $settings['kegiatan_edukasi_trend']) }}" class="w-full px-4 py-3 rounded-xl bg-white border-transparent focus:border-[#1e3a8a] focus:ring-0 text-xs font-medium transition-all" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Demographics -->
                        <div class="pt-8 border-t border-slate-100">
                            <h2 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                                <i class="fas fa-chart-bar text-teal-500"></i> Demografi Kelas (Persentase)
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="relative p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="absolute top-2 right-2 text-[9px] font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded-md">OTOMATIS</span>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Kelas X (%)</label>
                                    <input type="number" value="{{ $settings['demo_kelas_x'] }}" min="0" max="100" class="w-full px-4 py-3 rounded-xl bg-slate-100 border-transparent text-sm font-bold text-slate-500 cursor-not-allowed" disabled>
                                    <input type="hidden" name="demo_kelas_x" value="{{ $settings['demo_kelas_x'] }}">
                                </div>
                                <div class="relative p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="absolute top-2 right-2 text-[9px] font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded-md">OTOMATIS</span>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Kelas XI (%)</label>
                                    <input type="number" value="{{ $settings['demo_kelas_xi'] }}" min="0" max="100" class="w-full px-4 py-3 rounded-xl bg-slate-100 border-transparent text-sm font-bold text-slate-500 cursor-not-allowed" disabled>
                                    <input type="hidden" name="demo_kelas_xi" value="{{ $settings['demo_kelas_xi'] }}">
                                </div>
                                <div class="relative p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="absolute top-2 right-2 text-[9px] font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded-md">OTOMATIS</span>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Kelas XII (%)</label>
                                    <input type="number" value="{{ $settings['demo_kelas_xii'] }}" min="0" max="100" class="w-full px-4 py-3 rounded-xl bg-slate-100 border-transparent text-sm font-bold text-slate-500 cursor-not-allowed" disabled>
                                    <input type="hidden" name="demo_kelas_xii" value="{{ $settings['demo_kelas_xii'] }}">
                                </div>
                            </div>
                        </div>

                        <!-- Topics -->
                        <div class="pt-8 border-t border-slate-100">
                            <h2 class="text-lg font-black text-slate-800 mb-2 flex items-center gap-2">
                                <i class="fas fa-bullseye text-orange-500"></i> Topik Konseling Utama
                            </h2>
                            <p class="text-xs font-bold text-slate-400 mb-6">Diurutkan dan dihitung otomatis berdasarkan data fitur Layanan Konseling terbaru.</p>
                            
                            <div class="space-y-6">
                                <!-- Topic 1 -->
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-slate-100 p-4 rounded-2xl border border-slate-200">
                                    <div class="md:col-span-4">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Judul Topik 1</label>
                                        <input type="text" value="{{ $settings['topik_1_nama'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_1_nama" value="{{ $settings['topik_1_nama'] }}">
                                    </div>
                                    <div class="md:col-span-6">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                                        <input type="text" value="{{ $settings['topik_1_desc'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_1_desc" value="{{ $settings['topik_1_desc'] }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Persen (%)</label>
                                        <input type="number" value="{{ $settings['topik_1_pct'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_1_pct" value="{{ $settings['topik_1_pct'] }}">
                                    </div>
                                </div>

                                <!-- Topic 2 -->
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-slate-100 p-4 rounded-2xl border border-slate-200">
                                    <div class="md:col-span-4">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Judul Topik 2</label>
                                        <input type="text" value="{{ $settings['topik_2_nama'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_2_nama" value="{{ $settings['topik_2_nama'] }}">
                                    </div>
                                    <div class="md:col-span-6">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                                        <input type="text" value="{{ $settings['topik_2_desc'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_2_desc" value="{{ $settings['topik_2_desc'] }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Persen (%)</label>
                                        <input type="number" value="{{ $settings['topik_2_pct'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_2_pct" value="{{ $settings['topik_2_pct'] }}">
                                    </div>
                                </div>

                                <!-- Topic 3 -->
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-slate-100 p-4 rounded-2xl border border-slate-200">
                                    <div class="md:col-span-4">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Judul Topik 3</label>
                                        <input type="text" value="{{ $settings['topik_3_nama'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_3_nama" value="{{ $settings['topik_3_nama'] }}">
                                    </div>
                                    <div class="md:col-span-6">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                                        <input type="text" value="{{ $settings['topik_3_desc'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_3_desc" value="{{ $settings['topik_3_desc'] }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Persen (%)</label>
                                        <input type="number" value="{{ $settings['topik_3_pct'] }}" class="w-full px-4 py-3 rounded-xl bg-slate-200 border-transparent text-sm font-medium text-slate-500 cursor-not-allowed" disabled>
                                        <input type="hidden" name="topik_3_pct" value="{{ $settings['topik_3_pct'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-slate-100">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#1e3a8a] hover:bg-[#1a337a] text-white rounded-xl font-bold text-sm shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                Simpan Pengaturan Statistik
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
