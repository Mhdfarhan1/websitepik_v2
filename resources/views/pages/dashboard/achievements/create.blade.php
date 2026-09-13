<x-layouts.dashboard title="Tambah Prestasi Baru | Admin PIK-R">
    <div class="min-h-screen bg-slate-50/50 pb-20">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.achievements.index') }}" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-center text-slate-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all cursor-pointer">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Tambah Prestasi Baru</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Unggah Potret Cover, Keterangan, dan Banyak Foto Dokumentasi</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                <i class="fas fa-magic text-xs"></i> Kompresi Otomatis WebP Aktif
            </span>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                <form action="{{ route('dashboard.achievements.store') }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10 space-y-8">
                    @csrf

                    <!-- SECTION 1: INFORMASI PRESTASI -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-black border border-amber-100">
                                <i class="fas fa-award"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Informasi Capaian Prestasi</h3>
                        </div>

                        <!-- Title -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1 flex items-center gap-1">
                                <span>Nama / Judul Prestasi</span>
                                <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Juara 1 PIK-R Percontohan Tingkat Kabupaten Kepulauan Meranti" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            @error('title')
                                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Deskripsi & Cerita Lengkap Prestasi</label>
                            <textarea name="description" rows="5" placeholder="Tuliskan detail latar belakang penghargaan, proses seleksi, atau apresiasi yang diraih..." 
                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-semibold text-slate-700 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all leading-relaxed">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Date -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Tanggal Penerimaan</label>
                                <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-semibold text-slate-700 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer">
                            </div>

                            <!-- Author -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Penyelenggara / Pemberi Apresiasi</label>
                                <input type="text" name="author" value="{{ old('author', 'BKKBN & Forum GenRe') }}" placeholder="Contoh: BKKBN Riau / Dinas Pendidikan" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-semibold text-slate-700 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: FOTO COVER UTAMA -->
                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-3 pb-2">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-black border border-blue-100">
                                <i class="fas fa-image"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Foto Sampul Utama (Cover)</h3>
                                <p class="text-[11px] font-medium text-slate-400">Foto utama yang ditampilkan pada kartu daftar prestasi</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <input type="file" name="image" required accept="image/*"
                                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl p-2">
                            <p class="text-[10px] font-bold text-slate-400 ml-1">JPG, PNG, WEBP (Maks 15MB). Otomatis dikompresi menjadi WebP ringan.</p>
                            @error('image')
                                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 3: BANYAK FOTO DOKUMENTASI (GALERI PRESTASI) -->
                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm font-black border border-teal-100">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Banyak Foto Dokumentasi (Galeri Foto)</h3>
                                    <p class="text-[11px] font-medium text-slate-400">Letakkan banyak foto dokumentasi dalam satu prestasi ini (Bisa pilih multiple)</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-teal-50 text-teal-700 text-[10px] font-bold border border-teal-100">
                                Multi-Upload
                            </span>
                        </div>

                        <div class="space-y-2">
                            <input type="file" name="photos[]" multiple accept="image/*"
                                   id="multiPhotosInput"
                                   onchange="previewMultiPhotos(this)"
                                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl p-2">
                            <p class="text-[10px] font-bold text-slate-400 ml-1">
                                Tekan dan tahan <kbd class="px-1.5 py-0.5 bg-slate-200 text-slate-700 rounded text-[9px] font-mono">Ctrl</kbd> atau <kbd class="px-1.5 py-0.5 bg-slate-200 text-slate-700 rounded text-[9px] font-mono">Shift</kbd> untuk memilih banyak foto sekaligus. Semua foto otomatis dikompresi ke WebP.
                            </p>
                            
                            <!-- Container Preview Multiple Images -->
                            <div id="multiPhotosPreviewContainer" class="hidden grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3"></div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="pt-6 flex items-center justify-between border-t border-slate-100">
                        <a href="{{ route('dashboard.achievements.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider transition-all">
                            Batal
                        </a>
                        <button type="submit" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center gap-2 cursor-pointer">
                            <i class="fas fa-check"></i>
                            Simpan Prestasi & Semua Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewMultiPhotos(input) {
            const container = document.getElementById('multiPhotosPreviewContainer');
            container.innerHTML = '';
            if (input.files && input.files.length > 0) {
                container.classList.remove('hidden');
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50 aspect-video shadow-xs';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute bottom-1 right-1 bg-black/60 backdrop-blur-xs text-white text-[9px] font-bold px-1.5 py-0.5 rounded">
                                Foto #${index + 1}
                            </div>
                        `;
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-layouts.dashboard>
