<x-layouts.dashboard title="Pengaturan Banner Laporan | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.reports.index') }}" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Pengaturan Banner</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Sesuaikan tampilan awal Laporan</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-4xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <form action="{{ route('dashboard.reports.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    <div class="space-y-8">
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="hero_title_1" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Judul Bagian 1 <span class="text-rose-500">*</span></label>
                                    <input type="text" name="hero_title_1" id="hero_title_1" value="{{ old('hero_title_1', $settings['hero_title_1'] ?? 'Laporan') }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>
                                    <p class="text-[10px] font-bold text-slate-400 mt-2">Teks normal (putih). Contoh: "Laporan"</p>
                                    @error('hero_title_1')
                                        <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="hero_title_2" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Judul Bagian 2 <span class="text-rose-500">*</span></label>
                                    <input type="text" name="hero_title_2" id="hero_title_2" value="{{ old('hero_title_2', $settings['hero_title_2'] ?? 'Unggulan') }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>
                                    <p class="text-[10px] font-bold text-slate-400 mt-2">Teks disorot (oranye). Contoh: "Unggulan"</p>
                                    @error('hero_title_2')
                                        <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="hero_desc" class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Deskripsi Singkat <span class="text-rose-500">*</span></label>
                                <textarea name="hero_desc" id="hero_desc" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:border-[#1e3a8a] focus:bg-white focus:ring-0 text-sm font-medium transition-all" required>{{ old('hero_desc', $settings['hero_desc'] ?? '') }}</textarea>
                                @error('hero_desc')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-3">Gambar Background (Opsional)</label>
                                
                                <div class="relative w-full rounded-2xl overflow-hidden border-2 border-slate-200 border-dashed bg-slate-50 hover:border-[#1e3a8a] transition-all group" style="min-height: 280px;">
                                    @php
                                        $bgUrl = $settings['hero_bg'] ?? '';
                                        if($bgUrl && !str_starts_with($bgUrl, 'http')) {
                                            $bgUrl = asset($bgUrl);
                                        }
                                    @endphp
                                    
                                    <!-- Image Preview -->
                                    <img id="preview" src="{{ $bgUrl }}" class="{{ $bgUrl ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-0 transition-transform duration-700 group-hover:scale-105">
                                    
                                    <!-- Dark Overlay on Hover -->
                                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex flex-col items-center justify-center gap-4 backdrop-blur-[2px]">
                                        <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/40 text-white shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                            <i class="fas fa-camera text-xl"></i>
                                        </div>
                                        
                                        <label for="hero_bg" class="cursor-pointer bg-white text-[#1e3a8a] px-6 py-2.5 rounded-full font-bold text-sm shadow-xl hover:bg-slate-50 hover:scale-105 transition-all transform translate-y-4 group-hover:translate-y-0 duration-300 delay-75">
                                            Ubah Gambar Background
                                            <input id="hero_bg" name="hero_bg" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                        </label>
                                        
                                        <p class="text-white/90 text-[11px] font-medium tracking-wide transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 delay-100">Format: JPG, PNG, GIF (Maks. 10MB)</p>
                                    </div>

                                    <!-- Empty State (Shows when no image is present) -->
                                    <div id="empty-state" class="absolute inset-0 z-0 flex flex-col items-center justify-center gap-3 {{ $bgUrl ? 'hidden' : '' }}">
                                        <div class="w-16 h-16 rounded-full bg-slate-200/70 flex items-center justify-center text-slate-400 mb-2">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                        <span class="text-sm font-bold text-slate-600">Belum ada gambar terpilih</span>
                                        <span class="text-[11px] font-medium text-slate-400">Arahkan kursor ke sini untuk mengunggah gambar</span>
                                    </div>
                                </div>
                                @error('hero_bg')
                                    <p class="text-xs text-rose-500 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#1e3a8a] hover:bg-[#1a337a] text-white rounded-xl font-bold text-sm shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                Simpan Pengaturan
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
            const emptyState = document.getElementById('empty-state');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (emptyState) emptyState.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-layouts.dashboard>
