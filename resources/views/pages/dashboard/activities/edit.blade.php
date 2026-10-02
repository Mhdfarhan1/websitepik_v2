<x-layouts.dashboard title="Edit Agenda Kegiatan | Admin PIK-R">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-xl font-black text-slate-800">Edit Agenda Kegiatan</h1>
                <p class="text-xs font-bold text-slate-400 mt-1">Perbarui informasi agenda kegiatan #{{ $activity->id }}</p>
            </div>
            <a href="{{ route('dashboard.activities.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs transition-all flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs font-medium">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fas fa-exclamation-circle text-rose-500"></i>
                    <span>Harap perbaiki kesalahan berikut:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 mt-1 text-rose-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
            <form id="activity-form" action="{{ route('dashboard.activities.update', $activity) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title & Category -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-8 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Nama / Judul Kegiatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $activity->title) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>

                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kategori Kegiatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="category" value="{{ old('category', $activity->category) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>
                </div>

                <!-- Date, Time, Location -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                        <input type="date" name="event_date" value="{{ old('event_date', $activity->event_date ? $activity->event_date->format('Y-m-d') : '') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>

                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Jam Mulai & Selesai <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="time_start" value="{{ old('time_start', $activity->time_start) }}" required class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-center focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                            <input type="text" name="time_end" value="{{ old('time_end', $activity->time_end) }}" class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-center focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                        </div>
                    </div>

                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Status Agenda <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option value="upcoming" {{ old('status', $activity->status) === 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                            <option value="ongoing" {{ old('status', $activity->status) === 'ongoing' ? 'selected' : '' }}>Berlangsung (Ongoing)</option>
                            <option value="completed" {{ old('status', $activity->status) === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        </select>
                    </div>
                </div>

                <!-- Location -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Lokasi Tempat Pelaksanaan <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-rose-500 text-xs"></i>
                        <input type="text" name="location" value="{{ old('location', $activity->location) }}" required class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Deskripsi & Rincian Kegiatan <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="5" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">{{ old('description', $activity->description) }}</textarea>
                </div>

                <!-- 1. Foto Poster Utama / Sampul Kegiatan -->
                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fas fa-image text-blue-600"></i>
                            <span>Foto Poster Utama / Sampul Kegiatan</span>
                        </label>
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-100">Banner Depan</span>
                    </div>
                    
                    @if($activity->image)
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200 w-fit">
                            <div class="w-16 h-16 rounded-xl overflow-hidden border border-slate-200 shrink-0">
                                <img src="{{ asset('storage/' . $activity->image) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Poster Saat Ini</span>
                                <span class="text-xs font-bold text-slate-700">Sudah terpasang</span>
                            </div>
                        </div>
                    @endif

                    <div class="relative border-2 border-dashed border-slate-200 hover:border-blue-400 bg-slate-50/70 hover:bg-blue-50/20 rounded-2xl p-4 transition-all">
                        <input type="file" id="image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#1e40af] file:text-white hover:file:bg-blue-800 file:cursor-pointer cursor-pointer transition-all">
                        
                        <div class="flex items-center gap-2 mt-2 text-[11px] text-slate-400">
                            <i class="fas fa-magic text-blue-500"></i>
                            <span>Pilih gambar baru jika ingin mengganti poster utama. Otomatis dikompres aman sebelum diunggah.</span>
                        </div>

                        <!-- Live Preview & Compression Info Container -->
                        <div id="preview-container" class="hidden mt-4 pt-4 border-t border-slate-200/70">
                            <div class="flex flex-col sm:flex-row items-center gap-4 bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                                <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    <img id="preview-img" src="" alt="Poster Preview" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0 space-y-1 text-center sm:text-left">
                                    <p id="preview-filename" class="text-xs font-bold text-slate-800 truncate"></p>
                                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 text-[10px]">
                                        <span id="preview-orig-size" class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-semibold"></span>
                                        <i class="fas fa-arrow-right text-[9px] text-slate-400"></i>
                                        <span id="preview-comp-size" class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold border border-emerald-200"></span>
                                    </div>
                                    <p id="compression-status" class="text-[10px] text-emerald-600 font-bold flex items-center justify-center sm:justify-start gap-1">
                                        <i class="fas fa-check-circle"></i> File siap diunggah aman
                                    </p>
                                </div>
                                <button type="button" id="remove-image-btn" class="px-3 py-1.5 text-xs text-rose-600 hover:bg-rose-50 rounded-lg font-bold transition-all border border-rose-200 shrink-0">
                                    <i class="fas fa-trash-alt mr-1"></i> Batal Pilih
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Foto Dokumentasi / Foto Pendukung Kegiatan (Bisa 2 - 5 Foto) -->
                <div class="space-y-3 pt-2 border-t border-slate-100">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fas fa-images text-emerald-600"></i>
                            <span>Foto Pendukung / Dokumentasi Momen (Bisa 2 - 5 Foto)</span>
                        </label>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">Konten Rincian</span>
                    </div>

                    <!-- Existing Documentation Photos List -->
                    @if(!empty($activity->documentation_images) && is_array($activity->documentation_images) && count($activity->documentation_images) > 0)
                        <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">Foto Pendukung Yang Sudah Terunggah ({{ count($activity->documentation_images) }} foto):</span>
                                <span class="text-[10px] text-slate-400">Centang kotak untuk menghapus foto yang diinginkan</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($activity->documentation_images as $docImg)
                                    <div class="relative flex items-center gap-3 p-2 bg-white rounded-xl border border-slate-200 shadow-sm group">
                                        <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                            <img src="{{ asset('storage/' . $docImg) }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="text-[10px] font-bold text-slate-500 block truncate">{{ basename($docImg) }}</span>
                                            <label class="inline-flex items-center gap-1.5 mt-1 text-[11px] font-bold text-rose-600 cursor-pointer">
                                                <input type="checkbox" name="remove_doc_images[]" value="{{ $docImg }}" class="rounded text-rose-600 focus:ring-rose-500">
                                                <span>Hapus Foto</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upload New Documentation Photos -->
                    <div class="relative border-2 border-dashed border-slate-200 hover:border-emerald-400 bg-slate-50/70 hover:bg-emerald-50/20 rounded-2xl p-4 transition-all">
                        <input type="file" id="docs-input" name="documentation_images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 file:cursor-pointer cursor-pointer transition-all">
                        
                        <div class="flex items-center gap-2 mt-2 text-[11px] text-slate-400">
                            <i class="fas fa-magic text-emerald-500"></i>
                            <span>Tambahkan foto dokumentasi baru jika ada. Otomatis dikompres aman sebelum diunggah.</span>
                        </div>

                        <!-- Documentation Preview Grid Container -->
                        <div id="docs-preview-container" class="hidden mt-4 pt-4 border-t border-slate-200/70">
                            <div class="flex items-center justify-between mb-3">
                                <span id="docs-count-badge" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                    <span>Foto Pendukung Baru Terpilih</span>
                                </span>
                                <button type="button" id="clear-all-docs-btn" class="text-[11px] font-bold text-rose-500 hover:underline">
                                    Hapus Semua Foto Baru
                                </button>
                            </div>
                            
                            <div id="docs-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                <!-- Dynamic thumbnail cards will be rendered here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard.activities.index') }}" class="px-6 py-3 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-xs transition-all">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn" class="px-8 py-3 bg-[#1e40af] hover:bg-blue-800 text-white font-bold text-xs rounded-2xl shadow-lg shadow-blue-900/10 transition-all active:scale-95 flex items-center gap-2">
                        <i class="fas fa-save" id="submit-icon"></i>
                        <span id="submit-text">Update Data Kegiatan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Client-Side Auto Compression Script (Single Poster & Multi-Doc Photos) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('activity-form');
            
            // Poster elements
            const input = document.getElementById('image-input');
            const previewContainer = document.getElementById('preview-container');
            const previewImg = document.getElementById('preview-img');
            const previewFilename = document.getElementById('preview-filename');
            const previewOrigSize = document.getElementById('preview-orig-size');
            const previewCompSize = document.getElementById('preview-comp-size');
            const compressionStatus = document.getElementById('compression-status');
            const removeBtn = document.getElementById('remove-image-btn');

            // Documentation elements
            const docsInput = document.getElementById('docs-input');
            const docsPreviewContainer = document.getElementById('docs-preview-container');
            const docsGrid = document.getElementById('docs-grid');
            const docsCountBadge = document.getElementById('docs-count-badge');
            const clearAllDocsBtn = document.getElementById('clear-all-docs-btn');

            // Submit elements
            const submitBtn = document.getElementById('submit-btn');
            const submitIcon = document.getElementById('submit-icon');
            const submitText = document.getElementById('submit-text');

            let isCompressing = false;
            let compressedDocsList = [];

            function formatBytes(bytes) {
                if (!bytes || bytes === 0) return '0 B';
                const k = 1024;
                const sizes = ['B', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
            }

            async function compressImage(file, maxWidth = 1600, quality = 0.82) {
                return new Promise((resolve) => {
                    if (!file.type.match(/image\/(jpeg|png|webp|jpg)/i) || file.size < 300 * 1024) {
                        resolve(file);
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = new Image();
                        img.onload = function () {
                            let width = img.width;
                            let height = img.height;

                            if (width > maxWidth || height > maxWidth) {
                                if (width > height) {
                                    height = Math.round((height * maxWidth) / width);
                                    width = maxWidth;
                                } else {
                                    width = Math.round((width * maxWidth) / height);
                                    height = maxWidth;
                                }
                            }

                            const canvas = document.createElement('canvas');
                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);

                            canvas.toBlob(function (blob) {
                                if (!blob || blob.size >= file.size) {
                                    resolve(file);
                                    return;
                                }
                                const baseName = file.name.replace(/\.[^/.]+$/, "");
                                const compressedFile = new File([blob], `${baseName}.webp`, {
                                    type: 'image/webp',
                                    lastModified: Date.now()
                                });
                                resolve(compressedFile);
                            }, 'image/webp', quality);
                        };
                        img.onerror = () => resolve(file);
                        img.src = e.target.result;
                    };
                    reader.onerror = () => resolve(file);
                    reader.readAsDataURL(file);
                });
            }

            // 1. Single Poster Compression Handler
            input.addEventListener('change', async function () {
                if (!this.files || !this.files[0]) {
                    previewContainer.classList.add('hidden');
                    return;
                }

                const originalFile = this.files[0];
                const originalSize = originalFile.size;

                previewFilename.textContent = originalFile.name;
                previewOrigSize.textContent = `Ukuran asli: ${formatBytes(originalSize)}`;
                previewImg.src = URL.createObjectURL(originalFile);
                previewContainer.classList.remove('hidden');

                compressionStatus.innerHTML = '<i class="fas fa-spinner fa-spin text-blue-500"></i> Mengoptimalkan & mengompres poster...';
                compressionStatus.className = 'text-[10px] text-blue-600 font-bold flex items-center justify-center sm:justify-start gap-1';
                previewCompSize.textContent = 'Memproses...';

                isCompressing = true;
                submitBtn.disabled = true;

                try {
                    const compressedFile = await compressImage(originalFile);
                    
                    const dt = new DataTransfer();
                    dt.items.add(compressedFile);
                    input.files = dt.files;

                    const compSize = compressedFile.size;
                    const savingPct = Math.round(((originalSize - compSize) / originalSize) * 100);

                    previewCompSize.textContent = `Terkoreksi: ${formatBytes(compSize)}`;
                    
                    if (savingPct > 0) {
                        compressionStatus.innerHTML = `<i class="fas fa-check-circle"></i> Berhasil dikompres ${savingPct}% lebih hemat! Aman dari limit server.`;
                        compressionStatus.className = 'text-[10px] text-emerald-600 font-bold flex items-center justify-center sm:justify-start gap-1';
                    } else {
                        compressionStatus.innerHTML = `<i class="fas fa-check-circle"></i> Ukuran file sudah optimal. Siap diunggah.`;
                        compressionStatus.className = 'text-[10px] text-emerald-600 font-bold flex items-center justify-center sm:justify-start gap-1';
                    }
                } catch (err) {
                    console.error('Poster compression error:', err);
                    previewCompSize.textContent = formatBytes(originalSize);
                    compressionStatus.innerHTML = '<i class="fas fa-info-circle"></i> Menggunakan file asli.';
                } finally {
                    isCompressing = false;
                    submitBtn.disabled = false;
                }
            });

            removeBtn.addEventListener('click', function () {
                input.value = '';
                previewContainer.classList.add('hidden');
                previewImg.src = '';
            });

            // 2. Multi-Documentation Photos Compression Handler
            function updateDocsDataTransfer() {
                const dt = new DataTransfer();
                compressedDocsList.forEach(file => dt.items.add(file));
                docsInput.files = dt.files;

                renderDocsGrid();
            }

            function renderDocsGrid() {
                docsGrid.innerHTML = '';
                if (compressedDocsList.length === 0) {
                    docsPreviewContainer.classList.add('hidden');
                    return;
                }

                docsPreviewContainer.classList.remove('hidden');
                docsCountBadge.innerHTML = `<i class="fas fa-check-circle text-emerald-500"></i> <span>${compressedDocsList.length} Foto Pendukung Baru Terpilih (Terkompres Aman)</span>`;

                compressedDocsList.forEach((file, index) => {
                    const card = document.createElement('div');
                    card.className = 'relative flex items-center gap-3 p-2.5 bg-white rounded-xl border border-slate-200 shadow-sm';
                    card.innerHTML = `
                        <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                            <img src="${URL.createObjectURL(file)}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-bold text-slate-800 truncate" title="${file.name}">${file.name}</p>
                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                ${formatBytes(file.size)}
                            </span>
                        </div>
                        <button type="button" data-index="${index}" class="remove-doc-single-btn w-7 h-7 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-all border border-transparent hover:border-rose-200 shrink-0" title="Hapus foto ini">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    `;
                    docsGrid.appendChild(card);
                });

                // Attach remove handlers
                document.querySelectorAll('.remove-doc-single-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const idx = parseInt(this.getAttribute('data-index'));
                        compressedDocsList.splice(idx, 1);
                        updateDocsDataTransfer();
                    });
                });
            }

            docsInput.addEventListener('change', async function () {
                if (!this.files || this.files.length === 0) return;

                isCompressing = true;
                submitBtn.disabled = true;
                docsPreviewContainer.classList.remove('hidden');
                docsCountBadge.innerHTML = '<i class="fas fa-spinner fa-spin text-blue-500"></i> <span>Mengompres foto-foto pendukung...</span>';

                try {
                    const selectedFiles = Array.from(this.files);
                    for (const rawFile of selectedFiles) {
                        const compressed = await compressImage(rawFile);
                        compressedDocsList.push(compressed);
                    }
                    updateDocsDataTransfer();
                } catch (err) {
                    console.error('Documentation photos compression error:', err);
                } finally {
                    isCompressing = false;
                    submitBtn.disabled = false;
                }
            });

            clearAllDocsBtn.addEventListener('click', function () {
                compressedDocsList = [];
                docsInput.value = '';
                updateDocsDataTransfer();
            });

            // Form Submit Protection
            form.addEventListener('submit', function (e) {
                if (isCompressing) {
                    e.preventDefault();
                    alert('Mohon tunggu sebentar, foto sedang diproses kompresi...');
                    return;
                }

                submitBtn.disabled = true;
                submitIcon.className = 'fas fa-circle-notch fa-spin';
                submitText.textContent = 'Memperbarui Agenda...';
            });
        });
    </script>
</x-layouts.dashboard>
