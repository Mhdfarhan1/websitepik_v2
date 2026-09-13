<x-layouts.dashboard title="Optimasi Media & Penyimpanan | Admin PIK-R">
    <div class="min-h-screen bg-slate-50/50 pb-20">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Optimasi Media & Storage</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">HEMAT PENYIMPANAN HOSTING & PERCEPAT LOADING WEBSITE SECARA OTOMATIS</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 text-[11px] font-bold border border-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Kompresi WebP Aktif
                </span>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4 text-emerald-700 shadow-sm animate-fade-in-down">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-wider">Optimasi Berhasil!</h4>
                        <p class="text-xs font-medium text-emerald-800 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-center gap-4 text-blue-700 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-info-circle text-blue-600 text-lg"></i>
                    </div>
                    <p class="text-xs font-bold text-blue-800">{{ session('info') }}</p>
                </div>
            @endif

            <!-- Storage Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Media -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 shrink-0">
                        <i class="fas fa-images text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Total File Gambar</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($stats['total_files']) }}</h3>
                        <p class="text-[11px] font-semibold text-slate-500 mt-0.5">{{ $stats['formats']['webp'] }} WebP, {{ $stats['formats']['jpeg_jpg'] }} JPG, {{ $stats['formats']['png'] }} PNG</p>
                    </div>
                </div>

                <!-- Total Storage -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100 shrink-0">
                        <i class="fas fa-hdd text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Kapasitas Terpakai</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_formatted'] }}</h3>
                        <p class="text-[11px] font-semibold text-slate-500 mt-0.5">di folder uploads & storage</p>
                    </div>
                </div>

                <!-- Average Size -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-violet-50 flex items-center justify-center text-violet-600 border border-violet-100 shrink-0">
                        <i class="fas fa-weight-hanging text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Rata-rata Ukuran</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['avg_size_formatted'] }}</h3>
                        <p class="text-[11px] font-semibold text-slate-500 mt-0.5">per file media</p>
                    </div>
                </div>

                <!-- Large Files Need Optimization -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100 shrink-0">
                        <i class="fas fa-bolt text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">File Besar (>800KB)</p>
                        <h3 class="text-2xl font-black {{ $stats['large_files_count'] > 0 ? 'text-amber-600' : 'text-emerald-600' }} mt-1">
                            {{ $stats['large_files_count'] }}
                        </h3>
                        <p class="text-[11px] font-semibold text-slate-500 mt-0.5">
                            {{ $stats['large_files_count'] > 0 ? 'Dapat dikompresi lagi' : 'Semua sudah ringkas' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- How Automatic Compression Works Banner -->
            <div class="bg-gradient-to-r from-[#17385c] via-[#1e3a8a] to-[#2563eb] rounded-3xl p-8 lg:p-10 text-white shadow-xl shadow-blue-900/10 relative overflow-hidden">
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-[10px] font-extrabold uppercase tracking-widest border border-white/20 mb-4">
                        <i class="fas fa-shield-alt text-[#f59e0b]"></i>
                        SISTEM PENYIMPANAN HEMAT AKTIF
                    </div>
                    <h2 class="text-2xl lg:text-3xl font-extrabold tracking-tight mb-3">
                        Upload Foto Kamera 8–10 MB? Otomatis Ringkas Menjadi 300–600 KB!
                    </h2>
                    <p class="text-blue-100 text-sm leading-relaxed mb-6 font-medium opacity-90">
                        Sistem backend PHP secara otomatis memproses setiap foto yang diunggah di Galeri, Berita, Prestasi, Profil, dan Agenda Kegiatan tanpa mengurangi ketajaman visual:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-semibold">
                        <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15">
                            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white mb-3">
                                <i class="fas fa-compress-arrows-alt"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">1. Smart Scale (Max 1920px)</h4>
                            <p class="text-blue-200 mt-1 leading-snug">Foto kamera HP (4000px) dikecilkan ke resolusi Full HD proporsional.</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15">
                            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white mb-3">
                                <i class="fas fa-file-image"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">2. Format Modern WebP</h4>
                            <p class="text-blue-200 mt-1 leading-snug">Dikonversi ke WebP kualitas 80% yang hemat bandwidth hingga 90%.</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15">
                            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white mb-3">
                                <i class="fas fa-redo-alt"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">3. EXIF Auto-Orient</h4>
                            <p class="text-blue-200 mt-1 leading-snug">Foto vertikal/portrait dari smartphone tidak akan miring/terbalik.</p>
                        </div>
                    </div>
                </div>

                <!-- Decorative Watermark Icon -->
                <i class="fas fa-images absolute -right-8 -bottom-10 text-white/5 text-[220px] pointer-events-none"></i>
            </div>

            <!-- Two Columns: Live Simulator & Batch Optimizer -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Simulator & Live Test Tool -->
                <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm flex flex-col justify-between" x-data="imageSimulator()">
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 shrink-0">
                                <i class="fas fa-vial text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">Uji Coba Kompresi Langsung</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Coba upload foto kamera asli untuk melihat hasilnya</p>
                            </div>
                        </div>

                        <!-- Dropzone Area -->
                        <div class="border-2 border-dashed border-slate-200 hover:border-blue-500 rounded-2xl p-6 text-center cursor-pointer transition-colors bg-slate-50/50 hover:bg-blue-50/20"
                             @click="$refs.testFileInput.click()"
                             @dragover.prevent="$el.classList.add('border-blue-500', 'bg-blue-50/30')"
                             @dragleave.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50/30')"
                             @drop.prevent="handleDrop($event)">
                            <input type="file" x-ref="testFileInput" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" @change="handleFile($event.target.files[0])">
                            
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-3 shadow-inner">
                                <i class="fas fa-cloud-upload-alt text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-700">Pilih foto kamera atau tarik file ke sini</p>
                            <p class="text-[10px] text-slate-400 font-semibold mt-1">Mendukung file JPG, PNG, WEBP hingga 20 MB</p>
                        </div>

                        <!-- Loading State -->
                        <div x-show="loading" class="py-8 text-center" style="display: none;">
                            <div class="inline-block animate-spin w-8 h-8 border-4 border-blue-600 border-t-transparent rounded-full mb-3"></div>
                            <p class="text-xs font-bold text-slate-600">Sedang mengompresi & mengonversi gambar ke WebP...</p>
                        </div>

                        <!-- Simulation Results Card -->
                        <div x-show="result && !loading" class="mt-6 space-y-4" style="display: none;">
                            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-black text-emerald-800 uppercase tracking-wider">Hasil Optimasi:</span>
                                    <span class="px-2.5 py-1 bg-emerald-600 text-white font-extrabold text-[11px] rounded-lg shadow-sm" x-text="'Hemat ' + result?.saved_percentage + '%'"></span>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mt-3 pt-3 border-t border-emerald-100/80">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ukuran Asli</p>
                                        <p class="text-base font-extrabold text-slate-700" x-text="result?.original_size_formatted"></p>
                                        <p class="text-[10px] font-semibold text-slate-400" x-text="result?.original_dimensions"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Ukuran WebP Baru</p>
                                        <p class="text-base font-extrabold text-emerald-700" x-text="result?.compressed_size_formatted"></p>
                                        <p class="text-[10px] font-semibold text-emerald-600" x-text="result?.compressed_dimensions"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview thumbnail -->
                            <div class="flex items-center gap-4 p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-200 shrink-0 border border-slate-200">
                                    <img :src="result?.preview_data" class="w-full h-full object-cover" alt="Preview">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-700 truncate" x-text="result?.original_name"></p>
                                    <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Format output: .webp (Kualitas 80)</p>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 mt-1">
                                        <i class="fas fa-check-circle"></i> Kualitas visual tetap tajam
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Batch Optimizer Card -->
                <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100 shrink-0">
                                <i class="fas fa-magic text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">Optimasi Semua Gambar Lama</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Kompresi foto-foto yang diunggah sebelumnya</p>
                            </div>
                        </div>

                        <div class="p-5 bg-amber-50/60 border border-amber-100 rounded-2xl mb-6">
                            <h4 class="text-xs font-bold text-amber-900 flex items-center gap-2">
                                <i class="fas fa-lightbulb text-amber-500"></i>
                                Mengapa Fitur Ini Penting?
                            </h4>
                            <p class="text-xs text-amber-800/90 font-medium leading-relaxed mt-1.5">
                                Sebelum fitur ini dibuat, beberapa foto mungkin tersimpan dalam ukuran asli (2–8 MB) dan menghabiskan kuota hosting Anda (misalnya di InfinityFree).
                                Fitur ini akan memindai folder <code class="bg-amber-100/80 px-1.5 py-0.5 rounded text-[11px] font-mono">uploads/</code> dan <code class="bg-amber-100/80 px-1.5 py-0.5 rounded text-[11px] font-mono">storage/</code>, lalu mengecilkan ukuran filenya secara aman tanpa mengubah nama file atau tautan database.
                            </p>
                        </div>

                        <ul class="space-y-2.5 text-xs font-medium text-slate-600 mb-8">
                            <li class="flex items-center gap-2.5">
                                <i class="fas fa-check text-emerald-500"></i>
                                <span>Aman: Nama file tetap sama sehingga tidak merusak link atau database.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fas fa-check text-emerald-500"></i>
                                <span>Mengecilkan file gambar yang ukurannya di atas 400 KB.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fas fa-check text-emerald-500"></i>
                                <span>Menghemat puluhan hingga ratusan megabyte storage hosting seketika.</span>
                            </li>
                        </ul>
                    </div>

                    <form action="{{ route('dashboard.media-optimizer.batch') }}" method="POST" onsubmit="return confirm('Mulai proses optimasi semua gambar lama di hosting sekarang?')">
                        @csrf
                        <input type="hidden" name="threshold" value="400">
                        <button type="submit" class="w-full bg-[#1e3a8a] hover:bg-[#1a337a] text-white py-4 rounded-2xl font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-3 shadow-lg shadow-blue-900/20 transition-all cursor-pointer active:scale-[0.99]">
                            <i class="fas fa-magic text-sm"></i>
                            <span>Mulai Optimasi Gambar Lama Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function imageSimulator() {
            return {
                loading: false,
                result: null,
                handleDrop(e) {
                    this.$el.classList.remove('border-blue-500', 'bg-blue-50/30');
                    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                        this.handleFile(e.dataTransfer.files[0]);
                    }
                },
                handleFile(file) {
                    if (!file) return;
                    if (!file.type.startsWith('image/')) {
                        alert('Silakan pilih file gambar (JPG, PNG, WEBP).');
                        return;
                    }

                    this.loading = true;
                    this.result = null;

                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('dashboard.media-optimizer.simulate') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.loading = false;
                        if (data.success) {
                            this.result = data;
                        } else {
                            alert(data.message || 'Gagal memproses simulasi gambar.');
                        }
                    })
                    .catch(err => {
                        this.loading = false;
                        alert('Terjadi kesalahan saat memproses gambar: ' + err.message);
                    });
                }
            };
        }
    </script>
    @endpush
</x-layouts.dashboard>
