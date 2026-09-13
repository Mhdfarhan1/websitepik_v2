<x-layouts.dashboard title="Manajemen Profil & Sejarah | Admin PIK-R">
    <div x-data="{ 
        activeTab: 'pembina',
        showMilestoneModal: false,
        editMilestoneId: null,
        milestoneYear: '',
        milestoneTitle: '',
        milestoneDesc: ''
    }">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Manajemen Profil & Sejarah</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola Sambutan Pembina, Deskripsi Organisasi & Timeline Sejarah</p>
            </div>
            
            <!-- Tab Buttons -->
            <div class="bg-slate-100 p-1 rounded-xl flex gap-1 border border-slate-200 shadow-inner">
                <button @click="activeTab = 'pembina'" 
                        :class="activeTab === 'pembina' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer">
                    Sambutan & Profil
                </button>
                <button @click="activeTab = 'visimisi'" 
                        :class="activeTab === 'visimisi' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer">
                    Visi, Misi & Pilar
                </button>
                <button @click="activeTab = 'milestones'" 
                        :class="activeTab === 'milestones' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer">
                    Timeline Sejarah
                </button>
            </div>
        </header>

        <div class="p-6 lg:p-8 max-w-5xl mx-auto w-full">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <!-- TAB 1: SAMBUTAN & PROFIL -->
            <div x-show="activeTab === 'pembina'" x-transition class="space-y-6">
                <form action="{{ route('dashboard.profile-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <x-dashboard.card title="Sambutan Pembina PIK-R">
                        <div class="p-6 lg:p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama Pembina -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Pembina</label>
                                    <input type="text" name="pembina_name" value="{{ $settings->pembina_name }}" required
                                           class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>
                                
                                <!-- Periode Jabatan -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Periode Jabatan (cth: Periode 2024-2029)</label>
                                    <input type="text" name="pembina_period" value="{{ $settings->pembina_period }}" required
                                           class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>
                            </div>

                            <!-- Foto Pembina -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Foto Pembina</label>
                                <div class="flex items-center gap-6">
                                    <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-200 overflow-hidden shrink-0 shadow-sm">
                                        @if($settings->pembina_photo)
                                            <img src="{{ asset($settings->pembina_photo) }}" alt="Foto Pembina" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="fas fa-user-tie text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" name="pembina_photo" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        <p class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-wide">Format: JPG, JPEG, PNG (Max 2MB)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pantun Sambutan -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Pantun Sambutan (Gunakan Enter untuk Baris Baru)</label>
                                <textarea name="pembina_pantun" rows="4" required
                                          class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->pembina_pantun }}</textarea>
                            </div>

                            <!-- Pidato Sambutan -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Isi Pidato Sambutan</label>
                                <textarea name="pembina_speech" rows="8" required
                                          class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->pembina_speech }}</textarea>
                            </div>
                        </div>
                    </x-dashboard.card>

                    <x-dashboard.card title="Deskripsi & Video Tentang PIK-R">
                        <div class="p-6 lg:p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Judul Halaman Sejarah -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Halaman Sejarah (cth: Sejarah PIK-R)</label>
                                    <input type="text" name="sejarah_title" value="{{ $settings->sejarah_title }}" required
                                           class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>

                                <!-- Judul Section Tentang -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Section Tentang (cth: Tentang PIK-R REQUEST)</label>
                                    <input type="text" name="about_title" value="{{ $settings->about_title }}" required
                                           class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>
                            </div>

                            <!-- Link Video YouTube -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Tautan Video YouTube Organisasi (Link URL)</label>
                                <input type="url" name="about_video_url" value="{{ $settings->about_video_url }}" required
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>

                            <!-- Konten Tentang Organisasi -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Konten Deskripsi Tentang Organisasi</label>
                                <textarea name="about_content" rows="6" required
                                          class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->about_content }}</textarea>
                            </div>
                        </div>
                    </x-dashboard.card>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-blue-500/10 transition-all cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- TAB: VISI, MISI & PILAR -->
            <div x-show="activeTab === 'visimisi'" x-transition style="display: none;" class="space-y-6">
                <form action="{{ route('dashboard.profile-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <x-dashboard.card title="Visi & Misi Organisasi">
                        <div class="p-6 lg:p-8 space-y-6">
                            <!-- Background Image -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Gambar Latar Belakang (Hero)</label>
                                <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center bg-slate-50 border border-slate-200 rounded-xl p-4">
                                    <div class="flex-1 w-full">
                                        <input type="file" name="visi_misi_bg" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        <p class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-wide">Biarkan kosong jika tidak ingin mengubah.</p>
                                    </div>
                                    @if($settings->visi_misi_bg)
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . $settings->visi_misi_bg) }}" alt="Current BG" class="h-16 w-24 object-cover rounded-lg border border-slate-200 shadow-sm">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Visi -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Teks Visi</label>
                                <textarea name="visi_text" rows="3" required
                                          class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->visi_text }}</textarea>
                            </div>

                            <!-- Misi -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Teks Misi</label>
                                <textarea name="misi_text" rows="4" required
                                          class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->misi_text }}</textarea>
                            </div>
                        </div>
                    </x-dashboard.card>
                    
                    <x-dashboard.card title="Pilar Utama PIK-R">
                        <div class="p-6 lg:p-8 space-y-6">
                            @for($i = 1; $i <= 4; $i++)
                            <div class="space-y-3 bg-slate-50 border border-slate-200 p-4 rounded-xl">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Judul Pilar {{ $i }}</label>
                                    <input type="text" name="pilar_{{ $i }}_title" value="{{ $settings->{'pilar_'.$i.'_title'} }}" required
                                           class="w-full bg-white border-slate-200 border rounded-xl py-2 px-3 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Deskripsi Pilar {{ $i }}</label>
                                    <textarea name="pilar_{{ $i }}_desc" rows="2" required
                                              class="w-full bg-white border-slate-200 border rounded-xl py-2 px-3 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->{'pilar_'.$i.'_desc'} }}</textarea>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </x-dashboard.card>
                    
                    <x-dashboard.card title="Rencana Strategis, Tujuan & Sasaran">
                        <div class="p-6 lg:p-8 space-y-6">
                            <!-- Rencana Strategis Button Text -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Teks Tombol Rencana Strategis</label>
                                <input type="text" name="renstra_text" value="{{ $settings->renstra_text }}" required
                                       class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                            </div>

                            <!-- Rencana Strategis PDF -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">File Dokumen Rencana Strategis (PDF)</label>
                                <input type="file" name="renstra_file" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                @if($settings->renstra_file)
                                    <p class="text-[10px] font-bold text-emerald-600 mt-2"><i class="fas fa-check-circle"></i> File Renstra saat ini sudah terunggah.</p>
                                @endif
                            </div>

                            <!-- Tujuan -->
                            <div class="space-y-2 pt-4">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Tujuan (Gunakan Enter untuk setiap poin)</label>
                                <textarea name="tujuan_text" rows="5" required
                                          class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->tujuan_text }}</textarea>
                            </div>

                            <!-- Sasaran -->
                            <div class="space-y-2 pt-4">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Sasaran Strategi (Gunakan Enter untuk setiap poin)</label>
                                <textarea name="sasaran_text" rows="5" required
                                          class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">{{ $settings->sasaran_text }}</textarea>
                            </div>
                        </div>
                    </x-dashboard.card>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-blue-500/10 transition-all cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: MILESTONES -->
            <div x-show="activeTab === 'milestones'" x-transition style="display: none;" class="space-y-6">
                <x-dashboard.card title="Timeline Sejarah / Milestones">
                    <div class="p-8 space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Milestones Organisasi</p>
                                <p class="text-xs font-bold text-slate-500 mt-1">Atur titik timeline perkembangan sejarah PIK-R berdasarkan tahun.</p>
                            </div>
                            <button @click="showMilestoneModal = true; editMilestoneId = null; milestoneYear = ''; milestoneTitle = ''; milestoneDesc = ''" 
                                    class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-[#1e3a8a]/10 transition-all flex items-center gap-2 cursor-pointer">
                                <i class="fas fa-plus"></i> Tambah Milestone
                            </button>
                        </div>

                        <!-- Table Container -->
                        <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm bg-white">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left custom-table">
                                    <thead class="bg-slate-50/70 border-b border-slate-100">
                                        <tr>
                                            <th class="text-center w-24">Tahun</th>
                                            <th>Judul Pencapaian</th>
                                            <th>Keterangan / Deskripsi</th>
                                            <th class="text-center w-36">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse($milestones as $m)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="text-center font-black text-[#1e3a8a] text-sm">{{ $m->year }}</td>
                                            <td>
                                                <span class="font-bold text-slate-700">{{ $m->title }}</span>
                                            </td>
                                            <td class="max-w-xs truncate font-medium text-slate-500 text-xs" title="{{ $m->description }}">
                                                {{ $m->description }}
                                            </td>
                                            <td class="text-center">
                                                <div class="flex justify-center gap-2">
                                                    <!-- Edit -->
                                                    <button @click="
                                                        showMilestoneModal = true;
                                                        editMilestoneId = {{ $m->id }};
                                                        milestoneYear = '{{ $m->year }}';
                                                        milestoneTitle = '{{ addslashes($m->title) }}';
                                                        milestoneDesc = '{{ addslashes($m->description) }}';
                                                    " class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-blue-600 transition-all flex items-center justify-center border border-slate-100 shadow-sm cursor-pointer">
                                                        <i class="fas fa-edit text-[10px]"></i>
                                                    </button>
                                                    
                                                    <!-- Delete -->
                                                    <form action="{{ route('dashboard.profile-settings.milestones.destroy', $m->id) }}" method="POST" class="inline" id="delete-milestone-{{ $m->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                onclick="confirmDelete('delete-milestone-{{ $m->id }}', 'Hapus milestone sejarah tahun {{ $m->year }} ini?')"
                                                                class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center border border-rose-100 shadow-sm cursor-pointer">
                                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest py-12 bg-slate-50/10">Belum ada milestones sejarah terdaftar.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </x-dashboard.card>
            </div>

        </div>

        <!-- Milestone Add/Edit Modal -->
        <div x-show="showMilestoneModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
             
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showMilestoneModal = false"></div>
            
            <!-- Modal Body -->
            <div class="flex items-center justify-center min-h-screen p-4 relative z-10">
                <div class="bg-white rounded-3xl max-w-md w-full border border-slate-100 shadow-2xl p-6 lg:p-8 transform transition-all space-y-6">
                    
                    <div class="flex justify-between items-center border-b border-slate-150 pb-3">
                        <h3 class="text-sm font-black text-slate-800" x-text="editMilestoneId ? 'Edit Milestone Sejarah' : 'Tambah Milestone Sejarah'"></h3>
                        <button @click="showMilestoneModal = false" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-all cursor-pointer">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Form -->
                    <form :action="editMilestoneId ? '{{ url('dashboard/profile-settings/milestones') }}/' + editMilestoneId : '{{ route('dashboard.profile-settings.milestones.store') }}'" 
                          method="POST" class="space-y-4">
                        @csrf
                        <template x-if="editMilestoneId">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <!-- Tahun -->
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Tahun</label>
                            <input type="number" name="year" x-model="milestoneYear" required placeholder="Cth: 2024"
                                   class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                        </div>

                        <!-- Judul -->
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Judul Milestone / Pencapaian</label>
                            <input type="text" name="title" x-model="milestoneTitle" required placeholder="Cth: Pembentukan Resmi"
                                   class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all">
                        </div>

                        <!-- Deskripsi -->
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-0.5">Deskripsi / Keterangan Singkat</label>
                            <textarea name="description" x-model="milestoneDesc" rows="4" required placeholder="Jelaskan detail titik pencapaian sejarah di tahun tersebut..."
                                      class="w-full bg-slate-50 border-slate-200 border rounded-xl py-3 px-4 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 transition-all"></textarea>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 pt-3 justify-end">
                            <button type="button" @click="showMilestoneModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-650 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all cursor-pointer">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layouts.dashboard>

<style>
    /* Force exact styles to match table.blade.php */
    .custom-table th {
        padding: 1.25rem 1.5rem !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .custom-table td {
        padding: 1.25rem 1.5rem !important;
        font-size: 13px !important;
        color: #334155 !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f8fafc !important;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none !important;
    }
    .custom-table tbody tr:hover {
        background-color: rgba(248, 250, 252, 0.5) !important;
    }
</style>
