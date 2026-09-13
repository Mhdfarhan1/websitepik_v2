<x-layouts.dashboard title="Tulis Berita Baru | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.news.index') }}" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Tulis Berita Baru</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Publikasikan Informasi Dan Kegiatan Terbaru Anda</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm">
                <form action="{{ route('dashboard.news.store') }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10 space-y-6">
                    @csrf

                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Judul Berita / Artikel</label>
                        <input type="text" name="title" required placeholder="Tulis judul berita yang menarik..." 
                               class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>

                    <!-- Content -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Isi Berita</label>
                        <textarea name="content" rows="12" required placeholder="Tulis isi berita lengkap di sini..." 
                                  class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Image Upload -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Gambar Cover / Thumbnail</label>
                            <input type="file" name="image" class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            <p class="text-[10px] font-bold text-slate-400 mt-2 ml-1">Format JPG/PNG (MAX 2MB).</p>
                        </div>

                        <!-- Published At -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Tanggal Diterbitkan</label>
                            <input type="datetime-local" name="published_at" value="{{ now()->format('Y-m-d\TH:i') }}"
                                   class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-xs font-semibold text-slate-650 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                            <p class="text-[10px] font-bold text-slate-400 mt-2 ml-1">Biarkan default untuk langsung menerbitkannya sekarang.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 flex gap-4 border-t border-slate-50">
                        <a href="{{ route('dashboard.news.index') }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-500 py-4 rounded-xl font-bold text-xs uppercase tracking-wider text-center transition-all">
                            Kembali
                        </a>
                        <button type="submit" class="flex-[2] bg-[#1e3a8a] hover:bg-[#1a337a] text-white py-4 rounded-xl font-bold text-xs uppercase tracking-wider text-center shadow-lg shadow-[#1e3a8a]/20 transition-all">
                            Terbitkan Berita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
