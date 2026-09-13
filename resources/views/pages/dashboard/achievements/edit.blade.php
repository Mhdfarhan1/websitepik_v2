<x-layouts.dashboard title="Edit Prestasi & Galeri Foto | Admin PIK-R">
    <div class="min-h-screen bg-slate-50/50 pb-20">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.achievements.index') }}" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-center text-slate-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all cursor-pointer">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Edit Prestasi & Dokumentasi Foto</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Perbarui Keterangan, Cover, Serta Tambah / Hapus Foto Dokumentasi</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('prestasi.show', $achievement->id) }}" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    <span>Lihat Halaman Publik</span>
                </a>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-600 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                <form action="{{ route('dashboard.achievements.update', $achievement) }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10 space-y-8">
                    @csrf
                    @method('PUT')

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
                            <input type="text" name="title" required value="{{ old('title', $achievement->title) }}" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            @error('title')
                                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Deskripsi & Cerita Lengkap Prestasi</label>
                            <textarea name="description" rows="5" 
                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-semibold text-slate-700 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all leading-relaxed">{{ old('description', $achievement->description) }}</textarea>
                            @error('description')
                                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Date -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Tanggal Penerimaan</label>
                                <input type="date" name="date" value="{{ old('date', $achievement->date ? $achievement->date->format('Y-m-d') : '') }}"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-semibold text-slate-700 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer">
                            </div>

                            <!-- Author -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Penyelenggara / Pemberi Apresiasi</label>
                                <input type="text" name="author" value="{{ old('author', $achievement->author) }}" 
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
                                <p class="text-[11px] font-medium text-slate-400">Foto sampul yang tampil di halaman utama dan daftar prestasi</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-28 h-20 rounded-2xl bg-slate-50 border border-slate-200 overflow-hidden shrink-0 shadow-sm">
                                @if($achievement->image && str_starts_with($achievement->image, 'http'))
                                    <img src="{{ $achievement->image }}" class="w-full h-full object-cover" alt="Current Cover">
                                @else
                                    <img src="{{ asset($achievement->image ?? 'assets/img/bg_utama.JPG') }}" class="w-full h-full object-cover" alt="Current Cover">
                                @endif
                            </div>
                            <div class="flex-1 space-y-2">
                                <input type="file" name="image" accept="image/*"
                                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl p-2">
                                <p class="text-[10px] font-bold text-slate-400 ml-1">Biarkan kosong jika tidak ingin mengubah cover. Otomatis dikompresi ke WebP.</p>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: GALERI FOTO DOKUMENTASI TERDAFTAR -->
                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between pb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm font-black border border-teal-100">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Dokumentasi Foto Prestasi</h3>
                                    <p class="text-[11px] font-medium text-slate-400">Banyak foto dokumentasi dalam prestasi ini ({{ $achievement->images->count() }} foto tersimpan)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Photos Grid -->
                        @if($achievement->images->count() > 0)
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80">
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-3">Foto Dokumentasi Saat Ini:</p>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    @foreach($achievement->images as $photo)
                                        <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-white aspect-video shadow-xs" id="photo-card-{{ $photo->id }}">
                                            <img src="{{ asset($photo->image_path) }}" class="w-full h-full object-cover" alt="Foto">
                                            
                                            <!-- Delete Overlay Button -->
                                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <button type="button" 
                                                        onclick="deletePhotoItem({{ $achievement->id }}, {{ $photo->id }})"
                                                        class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-[10px] font-bold shadow flex items-center gap-1 cursor-pointer">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add More Photos -->
                        <div class="space-y-2 pt-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Tambah Foto Dokumentasi Baru</label>
                            <input type="file" name="photos[]" multiple accept="image/*"
                                   id="multiPhotosEditInput"
                                   onchange="previewMultiPhotosEdit(this)"
                                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl p-2">
                            <p class="text-[10px] font-bold text-slate-400 ml-1">
                                Pilih beberapa foto sekaligus (Ctrl/Shift + klik). Semua foto otomatis dioptimasi dan dikompresi ke WebP.
                            </p>
                            <div id="multiPhotosEditPreviewContainer" class="hidden grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3"></div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="pt-6 flex items-center justify-between border-t border-slate-100">
                        <a href="{{ route('dashboard.achievements.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider transition-all">
                            Batal
                        </a>
                        <button type="submit" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center gap-2 cursor-pointer">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewMultiPhotosEdit(input) {
            const container = document.getElementById('multiPhotosEditPreviewContainer');
            container.innerHTML = '';
            if (input.files && input.files.length > 0) {
                container.classList.remove('hidden');
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative rounded-xl overflow-hidden border border-teal-200 bg-slate-50 aspect-video shadow-xs';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute bottom-1 right-1 bg-teal-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">
                                Baru #${index + 1}
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

        function deletePhotoItem(achievementId, photoId) {
            Swal.fire({
                title: 'Hapus foto ini?',
                text: "Foto dokumentasi ini akan langsung dihapus dari server!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest',
                    cancelButton: 'px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest text-slate-400'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/dashboard/achievements/${achievementId}/photos/${photoId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const el = document.getElementById(`photo-card-${photoId}`);
                            if (el) el.remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Foto berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal menghapus foto.');
                    });
                }
            });
        }
    </script>
    @endpush
</x-layouts.dashboard>
