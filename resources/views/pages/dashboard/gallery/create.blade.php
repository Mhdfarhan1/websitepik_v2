<x-layouts.dashboard title="Tambah Foto Galeri Baru | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.gallery.index') }}" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Tambah Foto Galeri</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Unggah Potret Kegiatan Organisasi Baru</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-2xl mx-auto w-full">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs font-medium">
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

            <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                <form id="gallery-form" action="{{ route('dashboard.gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10 space-y-6">
                    @csrf

                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Keterangan / Judul Foto (Opsional)</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Diskusi Peer Counselor SMAN 1..." 
                               class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>

                    <!-- Image Upload with Auto Client-Side Compression & Live Preview -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">File Gambar / Foto <span class="text-rose-500">*</span></label>
                        
                        <div class="relative border-2 border-dashed border-slate-200 hover:border-blue-400 bg-slate-50/70 hover:bg-blue-50/20 rounded-2xl p-4 transition-all">
                            <input type="file" id="image-input" name="image" required accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#1e3a8a] file:text-white hover:file:bg-[#1a337a] file:cursor-pointer cursor-pointer transition-all">
                            
                            <div class="flex items-center gap-2 mt-2 text-[11px] text-slate-400">
                                <i class="fas fa-magic text-blue-500"></i>
                                <span>Foto berukuran besar otomatis dikompres sebelum diunggah agar proses simpan cepat & tidak terblokir limit server.</span>
                            </div>

                            <!-- Live Preview & Compression Info Container -->
                            <div id="preview-container" class="hidden mt-4 pt-4 border-t border-slate-200/70">
                                <div class="flex flex-col sm:flex-row items-center gap-4 bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                        <img id="preview-img" src="" alt="Gallery Preview" class="w-full h-full object-cover">
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

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Type -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Tipe Media</label>
                            <select name="type" class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                <option value="image" {{ old('type', 'image') === 'image' ? 'selected' : '' }}>Gambar / Foto</option>
                                <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video Link (Placeholder)</option>
                            </select>
                        </div>

                        <!-- Order Index -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Nomor Urutan Tampil</label>
                            <input type="number" name="order_index" value="{{ old('order_index', 0) }}" min="0" placeholder="Urutan angka" 
                                   class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-xs font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 flex gap-4 border-t border-slate-50">
                        <a href="{{ route('dashboard.gallery.index') }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-500 py-4 rounded-xl font-bold text-xs uppercase tracking-wider text-center transition-all">
                            Kembali
                        </a>
                        <button type="submit" id="submit-btn" class="flex-[2] bg-[#1e3a8a] hover:bg-[#1a337a] text-white py-4 rounded-xl font-bold text-xs uppercase tracking-wider text-center shadow-lg shadow-[#1e3a8a]/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-save" id="submit-icon"></i>
                            <span id="submit-text">Simpan Foto</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Client-Side Auto Compression Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('gallery-form');
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

                compressionStatus.innerHTML = '<i class="fas fa-spinner fa-spin text-blue-500"></i> Mengoptimalkan & mengompres foto...';
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
                submitText.textContent = 'Menyimpan Foto...';
            });
        });
    </script>
</x-layouts.dashboard>
