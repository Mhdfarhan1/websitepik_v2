<x-layouts.dashboard title="Edit Laporan | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.reports.index') }}" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Edit Laporan</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Ubah data Laporan</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <form action="{{ route('dashboard.reports.update', $report) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-8">
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Judul Program <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $report->title) }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>
                                @error('title')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="desc" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Deskripsi Paragraf 1 <span class="text-rose-500">*</span></label>
                                <textarea name="desc" id="desc" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>{{ old('desc', $report->desc) }}</textarea>
                                @error('desc')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="desc2" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Deskripsi Paragraf 2 (Opsional)</label>
                                <textarea name="desc2" id="desc2" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all">{{ old('desc2', $report->desc2) }}</textarea>
                                @error('desc2')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="order_index" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Urutan Tampil</label>
                                <input type="number" name="order_index" id="order_index" value="{{ old('order_index', $report->order_index) }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all">
                                @error('order_index')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Foto / Gambar (Opsional)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-2xl hover:border-[#1e3a8a] hover:bg-slate-50 transition-all group relative overflow-hidden">
                                    <div class="space-y-2 text-center relative z-10">
                                        <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                                            <i class="fas fa-image text-2xl text-slate-400"></i>
                                        </div>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="image" class="relative cursor-pointer rounded-md font-bold text-[#1e3a8a] hover:text-[#1a337a] focus-within:outline-none bg-white/80 px-2 py-1 backdrop-blur-sm shadow-sm rounded-lg">
                                                <span>Ganti Gambar</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                            </label>
                                        </div>
                                        <p class="text-[10px] font-bold text-slate-500 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-lg inline-block shadow-sm">Biarkan kosong jika tidak ingin mengubah</p>
                                    </div>
                                    @if($report->image)
                                        <img id="preview" src="{{ asset('storage/' . $report->image) }}" class="absolute inset-0 w-full h-full object-cover rounded-2xl opacity-40 group-hover:opacity-20 transition-opacity">
                                    @else
                                        <img id="preview" class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl opacity-40 group-hover:opacity-20 transition-opacity">
                                    @endif
                                </div>
                                @error('image')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="document" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Dokumen PDF/Word (Opsional)</label>
                                @if($report->document)
                                    <div class="mb-3 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <span class="text-xs font-bold text-slate-700 truncate">Dokumen tersimpan</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $report->document) }}" target="_blank" class="text-xs font-bold text-[#1e3a8a] hover:underline whitespace-nowrap">Lihat File</a>
                                    </div>
                                @endif
                                <input type="file" name="document" id="document" accept=".pdf,.doc,.docx" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Pilih file baru untuk mengganti dokumen yang ada. Maks. 10MB</p>
                                @error('document')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#1e3a8a] hover:bg-[#1a337a] text-white rounded-xl font-bold text-sm shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                Perbarui Laporan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-layouts.dashboard>
