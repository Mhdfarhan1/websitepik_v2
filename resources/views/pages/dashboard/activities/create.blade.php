<x-layouts.dashboard title="Tambah Agenda Kegiatan | Admin PIK-R">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-xl font-black text-slate-800">Tambah Agenda Kegiatan Baru</h1>
                <p class="text-xs font-bold text-slate-400 mt-1">Isi formulir kegiatan untuk dipublikasikan pada landing page & agenda admin</p>
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
            <form action="{{ route('dashboard.activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Title & Category -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-8 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Nama / Judul Kegiatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Sosialisasi Kesehatan Reproduksi Remaja" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>

                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kategori Kegiatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="category" value="{{ old('category', 'Edukasi & Konseling') }}" required placeholder="Edukasi, Workshop, Sosialisasi..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>
                </div>

                <!-- Date, Time, Location -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                        <input type="date" name="event_date" value="{{ old('event_date', date('Y-m-d')) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>

                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Jam Mulai & Selesai <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="time_start" value="{{ old('time_start', '08:30') }}" placeholder="08:30" required class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-center focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                            <input type="text" name="time_end" value="{{ old('time_end', '12:00') }}" placeholder="12:00" class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-center focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                        </div>
                    </div>

                    <div class="md:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Status Agenda <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option value="upcoming" {{ old('status') === 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                            <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>Berlangsung (Ongoing)</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        </select>
                    </div>
                </div>

                <!-- Location -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Lokasi Tempat Pelaksanaan <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-rose-500 text-xs"></i>
                        <input type="text" name="location" value="{{ old('location') }}" required placeholder="Contoh: Aula Utama SMAN 1 Tasik Putri Puyu" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Deskripsi & Rincian Kegiatan <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="5" required placeholder="Tuliskan deskripsi lengkap agenda kegiatan..." class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">{{ old('description') }}</textarea>
                </div>

                <!-- Poster Image Upload -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Gambar Poster Kegiatan (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP. Maksimal 10MB.</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard.activities.index') }}" class="px-6 py-3 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-xs transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-[#1e40af] hover:bg-blue-800 text-white font-bold text-xs rounded-2xl shadow-lg shadow-blue-900/10 transition-all active:scale-95 flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Agenda Kegiatan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
