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

                <!-- Poster Image Upload with Auto Client-Side Compression & Live Preview -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700">Gambar Poster Kegiatan</label>
                    
                    @if($activity->image)
                        <div id="current-poster-box" class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200 w-fit">
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
                        <input type="file" id="image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer transition-all">
                        
                        <div class="flex items-center gap-2 mt-2 text-[11px] text-slate-400">
                            <i class="fas fa-magic text-blue-500"></i>
                            <span>Pilih gambar baru jika ingin mengganti poster lama. Otomatis dikompres aman sebelum diunggah.</span>
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

    <!-- Client-Side Auto Compression Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('activity-form');
            const input = document.getElementById('image-input');
            const previewContainer = document.getElementById('preview-container');
            const previewImg = document.getElementById('preview-img');
            const previewFilename = document.getElementById('preview-filename');
            const previewOrigSize = document.getElementById('preview-orig-size');
            const previewCompSize = document.getElementById('preview-comp-size');
            const compressionStatus = document.getElementById('compression-status');
            const removeBtn = document.getElementById('remove-image-btn');
            const submitBtn = document.getElementById('submit-btn');
            const submitIcon = document.getElementById('submit-icon');
            const submitText = document.getElementById('submit-text');

            let isCompressing = false;

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
                    console.error('Client compression error:', err);
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
