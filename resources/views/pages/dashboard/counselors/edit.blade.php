<x-layouts.dashboard title="Edit Konselor & Pendidik Sebaya | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.counselors.index') }}" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Edit Profil Konselor / Pendidik</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Perbarui data profil tim pendamping konseling</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-8">
                <form action="{{ route('dashboard.counselors.update', $counselor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $counselor->name) }}" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                            @error('name')
                                <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Peran -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Tipe Peran <span class="text-rose-500">*</span></label>
                            <select name="role_type" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                                <option value="konselor_sebaya" {{ old('role_type', $counselor->role_type) === 'konselor_sebaya' ? 'selected' : '' }}>Konselor Sebaya</option>
                                <option value="pendidik_sebaya" {{ old('role_type', $counselor->role_type) === 'pendidik_sebaya' ? 'selected' : '' }}>Pendidik Sebaya</option>
                                <option value="keduanya" {{ old('role_type', $counselor->role_type) === 'keduanya' ? 'selected' : '' }}>Konselor & Pendidik Sebaya</option>
                            </select>
                            @error('role_type')
                                <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kelas / Gelar / Jabatan -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Kelas / Sertifikasi / Jabatan</label>
                            <input type="text" name="class_or_title" value="{{ old('class_or_title', $counselor->class_or_title) }}" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                        </div>

                        <!-- Urutan Tampilan -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Urutan Tampilan (Angka)</label>
                            <input type="number" name="order_index" value="{{ old('order_index', $counselor->order_index) }}" min="0" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                        </div>
                    </div>

                    <!-- Motto / Pesan Singkat -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Motto / Pesan Singkat</label>
                        <textarea name="bio_motto" rows="3" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">{{ old('bio_motto', $counselor->bio_motto) }}</textarea>
                    </div>

                    <!-- Photo Upload -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Foto Profil Konselor</label>
                        @if($counselor->photo)
                            <div class="mb-2 w-20 h-20 rounded-full overflow-hidden border border-slate-200">
                                <img src="{{ asset('storage/' . $counselor->photo) }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="photo" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                        <p class="text-[10px] text-slate-400">Pilih file baru jika ingin mengganti foto profil lama (Format: JPG, PNG, WEBP. Maksimal 10MB).</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard.counselors.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-[#1e40af] hover:bg-blue-800 text-white rounded-xl font-bold text-xs shadow-lg shadow-blue-900/10 transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
