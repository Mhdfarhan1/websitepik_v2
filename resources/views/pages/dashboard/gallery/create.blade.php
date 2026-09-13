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
            <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm">
                <form action="{{ route('dashboard.gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10 space-y-6">
                    @csrf

                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Keterangan / Judul Foto (Opsional)</label>
                        <input type="text" name="title" placeholder="Contoh: Diskusi Peer Counselor SMAN 1..." 
                               class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">File Gambar / Foto</label>
                        <input type="file" name="image" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[10px] font-bold text-slate-400 mt-2 ml-1">Format JPG/PNG (MAX 2MB). Disarankan berasio landscape atau portrait.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Type -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Tipe Media</label>
                            <select name="type" class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-xs font-bold text-slate-650 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                <option value="image" selected>Gambar / Foto</option>
                                <option value="video">Video Link (Placeholder)</option>
                            </select>
                        </div>

                        <!-- Order Index -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Nomor Urutan Tampil</label>
                            <input type="number" name="order_index" value="0" min="0" placeholder="Urutan angka" 
                                   class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-xs font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 flex gap-4 border-t border-slate-50">
                        <a href="{{ route('dashboard.gallery.index') }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-500 py-4 rounded-xl font-bold text-xs uppercase tracking-wider text-center transition-all">
                            Kembali
                        </a>
                        <button type="submit" class="flex-[2] bg-[#1e3a8a] hover:bg-[#1a337a] text-white py-4 rounded-xl font-bold text-xs uppercase tracking-wider text-center shadow-lg shadow-[#1e3a8a]/20 transition-all">
                            Simpan Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
