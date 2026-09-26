<x-layouts.dashboard title="Manajemen Jejak Nakhoda (Ketua) | Admin PIK-R">
    <div class="space-y-8" x-data="{ 
        activeTab: 'leaders',
        addLeaderModalOpen: false,
        editLeaderModalOpen: false,
        editLeaderData: {
            id: null,
            name: '',
            period: '',
            generation: '',
            title_badge: 'Ketua Demisioner',
            status: 'demisioner',
            quote: '',
            story: '',
            experience: '',
            hope: '',
            instagram: '',
            order_index: 0,
            is_active: 1,
            photo_url: null
        },

        addPhotoPreview: null,
        editPhotoPreview: null,

        openAddModal() {
            this.clearAddPhoto();
            this.addLeaderModalOpen = true;
        },

        openEditModal(leader) {
            this.editLeaderData = {
                id: leader.id,
                name: leader.name || '',
                period: leader.period || '',
                generation: leader.generation || '',
                title_badge: leader.title_badge || 'Ketua Demisioner',
                status: leader.status || 'demisioner',
                quote: leader.quote || '',
                story: leader.story || '',
                experience: leader.experience || '',
                hope: leader.hope || '',
                instagram: leader.instagram || '',
                order_index: leader.order_index || 0,
                is_active: leader.is_active ? 1 : 0,
                photo_url: leader.photo ? ('/' + leader.photo) : null
            };
            this.clearEditPhoto();
            this.editLeaderModalOpen = true;
        },

        previewAddPhoto(event) {
            const file = event.target.files?.[0];
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Silakan pilih file gambar yang valid (JPG, PNG, atau WEBP).');
                    this.clearAddPhoto();
                    return;
                }
                this.addPhotoPreview = URL.createObjectURL(file);
            }
        },

        clearAddPhoto() {
            this.addPhotoPreview = null;
            const input = document.getElementById('addPhotoFileInput');
            if (input) input.value = '';
        },

        previewEditPhoto(event) {
            const file = event.target.files?.[0];
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Silakan pilih file gambar yang valid (JPG, PNG, atau WEBP).');
                    this.clearEditPhoto();
                    return;
                }
                this.editPhotoPreview = URL.createObjectURL(file);
            }
        },

        clearEditPhoto() {
            this.editPhotoPreview = null;
            const input = document.getElementById('editPhotoFileInput');
            if (input) input.value = '';
        }
    }">
        
        <!-- Header Banner -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-gradient-to-r from-[#17385c] via-[#1e3a5f] to-[#2563eb] p-7 sm:p-8 rounded-[28px] text-white shadow-xl shadow-blue-900/10 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-300/30 text-amber-300 text-[11px] font-bold uppercase tracking-wider">
                    <i class="fas fa-crown text-[10px]"></i>
                    <span>Hall of Fame & Estafet Kepemimpinan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Jejak Nakhoda (Ketua PIK-R)</h1>
                <p class="text-white/80 text-xs sm:text-sm font-medium max-w-2xl leading-relaxed">
                    Dokumentasikan sejarah para Ketua yang telah menakhodai PIK-R REQUEST. Atur musik latar kenangan, foto resmi, kisah perjalanan, pengalaman berharga, serta harapan masa depan.
                </p>
            </div>

            <!-- Action Ribbon -->
            <div class="relative z-10 flex items-center gap-3 shrink-0 flex-wrap">
                <a href="{{ route('jejak-ketua') }}" target="_blank" class="bg-white/15 hover:bg-white/25 border border-white/20 text-white font-extrabold px-4 py-3 rounded-2xl text-xs uppercase tracking-wider transition-all flex items-center gap-2 shadow-sm">
                    <i class="fas fa-external-link-alt text-[10px] text-amber-300"></i>
                    <span>Lihat Halaman Publik</span>
                </a>
                <button @click="openAddModal()" class="bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold px-5 py-3 rounded-2xl text-xs uppercase tracking-wider shadow-lg transition-all flex items-center gap-2">
                    <i class="fas fa-plus text-[10px]"></i>
                    <span>Tambah Ketua Baru</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 shadow-sm text-emerald-800">
                <i class="fas fa-check-circle text-emerald-500 text-base"></i>
                <p class="text-xs font-bold">{{ session('success') }}</p>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-3 shadow-sm text-rose-800">
                <i class="fas fa-exclamation-triangle text-rose-500 text-base mt-0.5"></i>
                <div class="text-xs font-semibold space-y-1">
                    @foreach($errors->all() as $err)
                        <p>• {{ $err }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tab Bar -->
        <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
            <button @click="activeTab = 'leaders'" 
                    :class="activeTab === 'leaders' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all">
                <i class="fas fa-user-tie"></i>
                <span>Daftar Nakhoda ({{ count($leaders) }})</span>
            </button>
            <button @click="activeTab = 'settings'" 
                    :class="activeTab === 'settings' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all">
                <i class="fas fa-music text-amber-400"></i>
                <span>Pengaturan Musik & Halaman</span>
            </button>
        </div>

        <!-- TAB 1: DAFTAR KETUA -->
        <div x-show="activeTab === 'leaders'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($leaders as $leader)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all p-5 flex flex-col justify-between group relative overflow-hidden">
                        
                        <!-- Top status tag -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                {{ $leader->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                {{ $leader->title_badge }}
                            </span>

                            <div class="flex items-center gap-1.5">
                                @if($leader->is_active)
                                    <span class="w-2 h-2 rounded-full bg-emerald-500" title="Aktif di publik"></span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-slate-300" title="Diarsipkan / Tersembunyi"></span>
                                @endif
                                <span class="text-xs font-bold text-slate-400">{{ $leader->period }}</span>
                            </div>
                        </div>

                        <!-- Leader Info Card -->
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-gradient-to-tr from-[#17385c] to-blue-600 flex items-center justify-center font-black text-white text-lg shrink-0 shadow-sm border-2 border-slate-100">
                                @if($leader->photo)
                                    <img src="{{ asset($leader->photo) }}" alt="{{ $leader->name }}" class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr($leader->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-extrabold text-slate-900 text-base leading-snug group-hover:text-blue-600 transition-colors truncate">
                                    {{ $leader->name }}
                                </h3>
                                <p class="text-xs font-bold text-slate-400 mt-0.5">{{ $leader->generation ?: 'Generasi Terdata' }}</p>
                                @if($leader->instagram)
                                    <a href="https://instagram.com/{{ ltrim($leader->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-pink-600 font-bold hover:underline mt-1">
                                        <i class="fab fa-instagram"></i>
                                        <span>{{ '@' . ltrim($leader->instagram, '@') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Quote Snippet -->
                        @if($leader->quote)
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-slate-600 text-xs italic mb-4 line-clamp-2">
                                “{{ $leader->quote }}”
                            </div>
                        @endif

                        <!-- Story/Experience/Hope Checklist Indicators -->
                        <div class="grid grid-cols-3 gap-2 py-3 border-t border-slate-100 text-center mb-4">
                            <div class="p-2 rounded-xl {{ $leader->story ? 'bg-blue-50 text-blue-800' : 'bg-slate-50 text-slate-400' }}">
                                <span class="block text-[10px] font-black uppercase tracking-wider">Cerita</span>
                                <i class="fas {{ $leader->story ? 'fa-check-circle text-blue-600' : 'fa-times-circle text-slate-300' }} text-xs mt-1"></i>
                            </div>
                            <div class="p-2 rounded-xl {{ $leader->experience ? 'bg-amber-50 text-amber-800' : 'bg-slate-50 text-slate-400' }}">
                                <span class="block text-[10px] font-black uppercase tracking-wider">Pengalaman</span>
                                <i class="fas {{ $leader->experience ? 'fa-check-circle text-amber-600' : 'fa-times-circle text-slate-300' }} text-xs mt-1"></i>
                            </div>
                            <div class="p-2 rounded-xl {{ $leader->hope ? 'bg-purple-50 text-purple-800' : 'bg-slate-50 text-slate-400' }}">
                                <span class="block text-[10px] font-black uppercase tracking-wider">Harapan</span>
                                <i class="fas {{ $leader->hope ? 'fa-check-circle text-purple-600' : 'fa-times-circle text-slate-300' }} text-xs mt-1"></i>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <button @click="openEditModal({{ json_encode($leader) }})" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-edit text-xs"></i>
                                <span>Edit Profil</span>
                            </button>

                            <form action="{{ route('dashboard.leaders.destroy', $leader->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Ketua {{ $leader->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 rounded-xl text-rose-500 hover:bg-rose-50 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-slate-200">
                        <i class="fas fa-user-tie text-4xl text-slate-300 mb-3"></i>
                        <h4 class="font-extrabold text-slate-700 text-base">Belum Ada Data Ketua</h4>
                        <p class="text-xs text-slate-400 mt-1">Klik tombol 'Tambah Ketua Baru' di atas untuk memulai mengabadikan sejarah para pemimpin.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- TAB 2: PENGATURAN MUSIK & HALAMAN -->
        <div x-show="activeTab === 'settings'" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-8" style="display: none;">
            
            <form action="{{ route('dashboard.leaders.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section: Informasi Halaman -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-heading"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Judul & Teks Header Halaman</h3>
                            <p class="text-xs text-slate-400">Sesuaikan tulisan yang tampil di bagian atas halaman publik Jejak Nakhoda</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700">Badge Atas Header</label>
                            <input type="text" name="badge_title" value="{{ old('badge_title', $setting->badge_title) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700">Judul Utama Halaman</label>
                            <input type="text" name="page_title" value="{{ old('page_title', $setting->page_title) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-slate-700">Deskripsi / Subtitle Pengantar</label>
                            <textarea name="subtitle" rows="3"
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">{{ old('subtitle', $setting->subtitle) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section: Musik Latar Otomatis -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">
                                <i class="fas fa-music"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Pemutar Musik Kenangan (Lagu Otomatis)</h3>
                                <p class="text-xs text-slate-400">Lagu yang berputar otomatis di latar belakang halaman publik untuk membangun suasana nostalgia & apresiasi</p>
                            </div>
                        </div>

                        <!-- Toggle switch -->
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_audio_active" value="1" {{ $setting->is_audio_active ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500 relative"></div>
                            <span class="text-xs font-bold text-slate-700">Aktifkan Musik</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700">Judul Lagu</label>
                            <input type="text" name="audio_title" value="{{ old('audio_title', $setting->audio_title) }}" placeholder="Contoh: Kenangan Pemimpin / Monokrom"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700">Nama Artis / Penyanyi</label>
                            <input type="text" name="audio_artist" value="{{ old('audio_artist', $setting->audio_artist) }}" placeholder="Contoh: Tulus / Hymne GenRe"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-slate-700">Unggah File Audio Baru (.mp3, .wav, .m4a)</label>
                            <input type="file" name="audio_file" accept="audio/*"
                                   class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-extrabold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            <p class="text-[11px] text-slate-400">Ukuran maksimal audio: 25 MB.</p>
                        </div>
                    </div>

                    <!-- Audio Player Preview if file exists -->
                    @if($setting->audio_file)
                        <div class="p-4 bg-amber-50/70 border border-amber-200/80 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shadow-xs">
                                    <i class="fas fa-play"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-extrabold text-slate-800 block">{{ $setting->audio_title ?: 'Musik Kenangan Aktif' }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium">{{ $setting->audio_artist ?: 'Artis Tidak Diketahui' }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                                <audio controls class="h-8 max-w-xs">
                                    <source src="{{ asset($setting->audio_file) }}">
                                    Browser Anda tidak mendukung tag audio.
                                </audio>
                                <label class="inline-flex items-center gap-1.5 text-xs text-rose-600 font-bold hover:underline cursor-pointer">
                                    <input type="checkbox" name="remove_audio" value="1" class="rounded text-rose-600">
                                    <span>Hapus Lagu</span>
                                </label>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#17385c] hover:bg-[#102742] text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>

            </form>

        </div>

        <!-- MODAL TAMBAH KETUA BARU -->
        <div x-show="addLeaderModalOpen" 
             x-transition.opacity
             @keydown.escape.window="addLeaderModalOpen = false"
             class="fixed inset-0 z-[120] bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 overflow-y-auto"
             style="display: none;">
            
            <div @click.away="addLeaderModalOpen = false" 
                 class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                
                <!-- Modal Header -->
                <div class="px-6 py-4 bg-[#17385c] text-white flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-amber-400 text-slate-950 flex items-center justify-center text-xs font-black">
                            <i class="fas fa-crown"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-black uppercase tracking-wider">Tambah Rekam Jejak Ketua</h3>
                            <p class="text-[11px] text-white/70">Masukkan data profil dan 3 lembar narasi kepemimpinan</p>
                        </div>
                    </div>
                    <button @click="addLeaderModalOpen = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('dashboard.leaders.store') }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto space-y-5 text-slate-700">
                    @csrf

                    <!-- Foto & Identitas Dasar -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Nama Lengkap Ketua & Gelar <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" placeholder="Contoh: Ahmad Rinaldi, S.Kom." required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Periode Jabatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="period" placeholder="Contoh: 2023 — 2024" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Generasi / Angkatan</label>
                            <input type="text" name="generation" placeholder="Contoh: Generasi II"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Label Badge Kehormatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="title_badge" placeholder="Contoh: Ketua Demisioner / Ketua Perintis" value="Ketua Demisioner" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Status Jabatan <span class="text-rose-500">*</span></label>
                            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                                <option value="demisioner">Demisioner / Purna Bakti (Alumni)</option>
                                <option value="aktif">Petahana / Sedang Menjabat (Aktif)</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2 space-y-2">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-camera text-blue-600"></i>
                                <span>Foto Resmi Ketua (Jas / Seragam PDH)</span>
                            </label>

                            <!-- Live preview if selected -->
                            <div x-show="addPhotoPreview" class="p-3 bg-blue-50/70 border border-blue-200 rounded-2xl flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-16 h-20 rounded-xl overflow-hidden shadow-sm border-2 border-blue-400 bg-slate-900 shrink-0">
                                        <img :src="addPhotoPreview" alt="Preview Foto" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-black text-blue-700 bg-blue-100 px-2 py-0.5 rounded-md mb-1">
                                            <i class="fas fa-check-circle text-[10px]"></i> Foto Terpilih
                                        </span>
                                        <p class="text-[11px] text-slate-600 font-medium">Foto siap disimpan dan akan dioptimalkan otomatis oleh sistem.</p>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" @click="clearAddPhoto()" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Ganti / Hapus</span>
                                    </button>
                                </div>
                            </div>

                            <!-- File selector -->
                            <div x-show="!addPhotoPreview">
                                <input type="file" id="addPhotoFileInput" name="photo" accept="image/*" @change="previewAddPhoto($event)"
                                       class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-extrabold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, atau WEBP. Maksimal 10MB.</p>
                            </div>
                        </div>

                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Kutipan Singkat / Motto Kepemimpinan</label>
                            <input type="text" name="quote" placeholder="Contoh: Memimpin adalah melayani dengan ketulusan hati..."
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Username Instagram (Opsional)</label>
                            <input type="text" name="instagram" placeholder="Contoh: rinaldi_ahmad"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Urutan Tampil (Angka)</label>
                            <input type="number" name="order_index" value="0"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>
                    </div>

                    <!-- 3 Lembar Narasi: Cerita, Pengalaman, Harapan -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs font-black">
                                <i class="fas fa-feather-alt"></i>
                            </span>
                            <div>
                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">3 Lembar Narasi Mendalam</h4>
                                <p class="text-[11px] text-slate-400">Lembar kenangan yang akan dibaca publik pada Modal Reader</p>
                            </div>
                        </div>

                        <!-- 1. Cerita -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-book-open text-blue-600"></i>
                                <span>1. Cerita & Perjalanan Kepemimpinan</span>
                            </label>
                            <textarea name="story" rows="4" placeholder="Tuliskan kisah awal mula terpilih, dinamika organisasi, visi utama yang dibawa, dan perjalanan selama masa jabatan..."
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]"></textarea>
                        </div>

                        <!-- 2. Pengalaman -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-lightbulb text-amber-500"></i>
                                <span>2. Pengalaman & Tantangan yang Dilalui</span>
                            </label>
                            <textarea name="experience" rows="4" placeholder="Tuliskan momen berkesan, suka dan duka saat memimpin, serta rintangan yang berhasil dilewati bersama pengurus..."
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]"></textarea>
                        </div>

                        <!-- 3. Harapan -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-star text-purple-600"></i>
                                <span>3. Harapan & Pesan Estafet untuk Masa Depan PIK-R</span>
                            </label>
                            <textarea name="hope" rows="4" placeholder="Tuliskan harapan untuk kemajuan organisasi serta nasihat tulus untuk adik-adik kelas generasi penerus..."
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]"></textarea>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="addLeaderModalOpen = false" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#17385c] hover:bg-[#102742] text-white text-xs font-extrabold uppercase tracking-wider transition-all shadow-md">
                            Simpan Data Ketua
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- MODAL EDIT KETUA -->
        <div x-show="editLeaderModalOpen" 
             x-transition.opacity
             @keydown.escape.window="editLeaderModalOpen = false"
             class="fixed inset-0 z-[120] bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 overflow-y-auto"
             style="display: none;">
            
            <div @click.away="editLeaderModalOpen = false" 
                 class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                
                <!-- Modal Header -->
                <div class="px-6 py-4 bg-[#17385c] text-white flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-amber-400 text-slate-950 flex items-center justify-center text-xs font-black">
                            <i class="fas fa-edit"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-black uppercase tracking-wider">Edit Rekam Jejak Ketua</h3>
                            <p class="text-[11px] text-white/70">Perbarui profil dan 3 lembar narasi kepemimpinan</p>
                        </div>
                    </div>
                    <button @click="editLeaderModalOpen = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <form :action="'{{ url('/dashboard/leaders') }}/' + editLeaderData.id" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto space-y-5 text-slate-700">
                    @csrf
                    @method('PUT')

                    <!-- Foto & Identitas Dasar -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Nama Lengkap Ketua & Gelar <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" x-model="editLeaderData.name" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Periode Jabatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="period" x-model="editLeaderData.period" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Generasi / Angkatan</label>
                            <input type="text" name="generation" x-model="editLeaderData.generation"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Label Badge Kehormatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="title_badge" x-model="editLeaderData.title_badge" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Status Jabatan <span class="text-rose-500">*</span></label>
                            <select name="status" x-model="editLeaderData.status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                                <option value="demisioner">Demisioner / Purna Bakti (Alumni)</option>
                                <option value="aktif">Petahana / Sedang Menjabat (Aktif)</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2 space-y-2">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-camera text-blue-600"></i>
                                <span>Foto Resmi Ketua</span>
                            </label>

                            <!-- Live preview if new photo is selected -->
                            <div x-show="editPhotoPreview" class="p-3 bg-blue-50/70 border border-blue-200 rounded-2xl flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-16 h-20 rounded-xl overflow-hidden shadow-sm border-2 border-blue-400 bg-slate-900 shrink-0">
                                        <img :src="editPhotoPreview" alt="Preview Baru" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-black text-blue-700 bg-blue-100 px-2 py-0.5 rounded-md mb-1">
                                            <i class="fas fa-check-circle text-[10px]"></i> Foto Baru Dipilih
                                        </span>
                                        <p class="text-[11px] text-slate-600 font-medium">Foto ini akan menggantikan foto lama saat Anda menyimpan.</p>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" @click="clearEditPhoto()" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                        <i class="fas fa-undo"></i>
                                        <span>Batal Ganti</span>
                                    </button>
                                </div>
                            </div>

                            <!-- If no new photo selected yet, show current photo (if exists) and file picker -->
                            <div x-show="!editPhotoPreview" class="space-y-2">
                                <template x-if="editLeaderData.photo_url">
                                    <div class="flex items-center justify-between p-2.5 bg-slate-50 border border-slate-200 rounded-2xl">
                                        <div class="flex items-center gap-3">
                                            <img :src="editLeaderData.photo_url" alt="Foto Saat Ini" class="w-12 h-14 rounded-xl object-cover bg-slate-900 border border-slate-200 shadow-xs">
                                            <div>
                                                <span class="text-xs font-bold text-slate-800 block">Foto Saat Ini</span>
                                                <label class="inline-flex items-center gap-1 text-[11px] text-rose-600 font-bold hover:underline cursor-pointer">
                                                    <input type="checkbox" name="remove_photo" value="1" class="rounded text-rose-600">
                                                    <span>Hapus Foto Ini</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <input type="file" id="editPhotoFileInput" name="photo" accept="image/*" @change="previewEditPhoto($event)"
                                       class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-extrabold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                <p class="text-[11px] text-slate-400">Pilih file foto baru jika ingin mengganti foto ketua.</p>
                            </div>
                        </div>

                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Kutipan Singkat / Motto Kepemimpinan</label>
                            <input type="text" name="quote" x-model="editLeaderData.quote"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Username Instagram</label>
                            <input type="text" name="instagram" x-model="editLeaderData.instagram"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800">Urutan Tampil</label>
                            <input type="number" name="order_index" x-model="editLeaderData.order_index"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]">
                        </div>
                    </div>

                    <!-- 3 Lembar Narasi: Cerita, Pengalaman, Harapan -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs font-black">
                                <i class="fas fa-feather-alt"></i>
                            </span>
                            <div>
                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">3 Lembar Narasi Mendalam</h4>
                                <p class="text-[11px] text-slate-400">Lembar kenangan yang akan dibaca publik pada Modal Reader</p>
                            </div>
                        </div>

                        <!-- 1. Cerita -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-book-open text-blue-600"></i>
                                <span>1. Cerita & Perjalanan Kepemimpinan</span>
                            </label>
                            <textarea name="story" x-model="editLeaderData.story" rows="4"
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]"></textarea>
                        </div>

                        <!-- 2. Pengalaman -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-lightbulb text-amber-500"></i>
                                <span>2. Pengalaman & Tantangan yang Dilalui</span>
                            </label>
                            <textarea name="experience" x-model="editLeaderData.experience" rows="4"
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]"></textarea>
                        </div>

                        <!-- 3. Harapan -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <i class="fas fa-star text-purple-600"></i>
                                <span>3. Harapan & Pesan Estafet untuk Masa Depan PIK-R</span>
                            </label>
                            <textarea name="hope" x-model="editLeaderData.hope" rows="4"
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-[#17385c]"></textarea>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="editLeaderModalOpen = false" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#17385c] hover:bg-[#102742] text-white text-xs font-extrabold uppercase tracking-wider transition-all shadow-md">
                            Perbarui Data Ketua
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</x-layouts.dashboard>
