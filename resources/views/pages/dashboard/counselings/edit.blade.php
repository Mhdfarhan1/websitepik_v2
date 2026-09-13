<x-layouts.dashboard title="Edit Layanan Konseling | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.counselings.index') }}" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:text-[#1e3a8a] hover:bg-blue-50 transition-all flex items-center justify-center border border-slate-100">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Edit Konseling</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Edit data konseling</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <form action="{{ route('dashboard.counselings.update', $counseling) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column: Primary Info -->
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Judul Konseling <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $counseling->title) }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>
                                @error('title')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="topic" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Topik Konseling <span class="text-rose-500">*</span></label>
                                <select name="topic" id="topic" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>
                                    <option value="" disabled>Pilih Topik...</option>
                                    <option value="Kesehatan Mental" @if(old('topic', $counseling->topic) == 'Kesehatan Mental') selected @endif>Kesehatan Mental</option>
                                    <option value="Akademik & Belajar" @if(old('topic', $counseling->topic) == 'Akademik & Belajar') selected @endif>Akademik & Belajar</option>
                                    <option value="Hubungan Sosial" @if(old('topic', $counseling->topic) == 'Hubungan Sosial') selected @endif>Hubungan Sosial</option>
                                    <option value="Keluarga" @if(old('topic', $counseling->topic) == 'Keluarga') selected @endif>Keluarga</option>
                                    <option value="Karir & Masa Depan" @if(old('topic', $counseling->topic) == 'Karir & Masa Depan') selected @endif>Karir & Masa Depan</option>
                                    <option value="Lainnya" @if(old('topic', $counseling->topic) == 'Lainnya') selected @endif>Lainnya</option>
                                </select>
                                <p class="text-[10px] text-slate-400 font-bold mt-2">Pilihan topik ini akan digunakan untuk grafik statistik otomatis.</p>
                                @error('topic')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="student_class" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Kelas Klien (Opsional)</label>
                                <select name="student_class" id="student_class" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all">
                                    <option value="" @if(empty(old('student_class', $counseling->student_class))) selected @endif>Tidak Disebutkan</option>
                                    <option value="Kelas X" @if(old('student_class', $counseling->student_class) == 'Kelas X') selected @endif>Kelas X</option>
                                    <option value="Kelas XI" @if(old('student_class', $counseling->student_class) == 'Kelas XI') selected @endif>Kelas XI</option>
                                    <option value="Kelas XII" @if(old('student_class', $counseling->student_class) == 'Kelas XII') selected @endif>Kelas XII</option>
                                </select>
                                <p class="text-[10px] text-slate-400 font-bold mt-2">Digunakan untuk grafik Demografi Klien.</p>
                                @error('student_class')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="counselor_name" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Nama Konselor</label>
                                <input type="text" name="counselor_name" id="counselor_name" value="{{ old('counselor_name', $counseling->counselor_name) }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all">
                                @error('counselor_name')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column: Details -->
                        <div class="space-y-6">
                            <div>
                                <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Tanggal Konseling</label>
                                <input type="date" name="date" id="date" value="{{ old('date', $counseling->date) }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all">
                                @error('date')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Status <span class="text-rose-500">*</span></label>
                                <select name="status" id="status" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>
                                    <option value="Selesai" @if(old('status', $counseling->status) == 'Selesai') selected @endif>Selesai</option>
                                    <option value="Sedang Berjalan" @if(old('status', $counseling->status) == 'Sedang Berjalan') selected @endif>Sedang Berjalan</option>
                                    <option value="Menunggu" @if(old('status', $counseling->status) == 'Menunggu') selected @endif>Menunggu</option>
                                    <option value="Dibatalkan" @if(old('status', $counseling->status) == 'Dibatalkan') selected @endif>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Deskripsi / Catatan Singkat</label>
                                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all">{{ old('description', $counseling->description) }}</textarea>
                                @error('description')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                        <a href="{{ route('dashboard.counselings.index') }}" class="px-6 py-3 rounded-xl font-bold text-sm text-slate-500 hover:bg-slate-50 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-[#1e3a8a] hover:bg-[#1a337a] text-white rounded-xl font-bold text-sm shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
