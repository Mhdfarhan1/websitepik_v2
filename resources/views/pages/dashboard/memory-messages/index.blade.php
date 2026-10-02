<x-layouts.dashboard title="Manajemen Jejak Rasa | Admin PIK-R">
    <div class="space-y-8" x-data="memoryDashboardApp('{{ request()->query('tab', 'messages') }}')">

        <!-- Header Section -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#17223b] via-[#261e38] to-[#3a1c28] p-6 sm:p-8 text-white shadow-xl">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 text-xs font-black tracking-wider uppercase">
                        <i class="fas fa-feather-pointed"></i>
                        <span>BILIK NOSTALGIA & JEJAK RASA</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Manajemen Jejak Rasa</h1>
                    <p class="text-xs sm:text-sm text-slate-200/90 max-w-2xl leading-relaxed">
                        Kelola surat kata tak terucap dari anggota/alumni, dokumentasi naratif "Ruang yang Kini Sunyi", arsip Surat Pamit Demisioner, serta musik instrumen pengiring kenangan.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('jejak-rasa') }}" target="_blank"
                       class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold flex items-center gap-2 transition-all shadow-sm">
                        <i class="fas fa-external-link-alt text-rose-400"></i>
                        <span>Lihat Publik</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center gap-2 border-b border-slate-200 pb-2 overflow-x-auto no-scrollbar">
            <button @click="activeTab = 'messages'"
                    :class="activeTab === 'messages' ? 'bg-[#17223b] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2 shrink-0 cursor-pointer">
                <i class="fas fa-envelope-open-text"></i>
                <span>Surat Tak Terucap ({{ $messages->total() }})</span>
            </button>

            <button @click="activeTab = 'moments'"
                    :class="activeTab === 'moments' ? 'bg-[#17223b] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2 shrink-0 cursor-pointer">
                <i class="fas fa-camera-retro"></i>
                <span>Ruang yang Kini Sunyi ({{ $silentMoments->count() }})</span>
            </button>

            <button @click="activeTab = 'farewells'"
                    :class="activeTab === 'farewells' ? 'bg-[#17223b] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2 shrink-0 cursor-pointer">
                <i class="fas fa-scroll"></i>
                <span>Surat Pamit Angkatan ({{ $farewellLetters->count() }})</span>
            </button>

            <button @click="activeTab = 'settings'"
                    :class="activeTab === 'settings' ? 'bg-[#17223b] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2 shrink-0 cursor-pointer">
                <i class="fas fa-sliders"></i>
                <span>Pengaturan Halaman & Musik</span>
            </button>
        </div>

        <!-- ==================== TAB 1: SURAT TAK TERUCAP & MODERASI ==================== -->
        <div x-show="activeTab === 'messages'" class="space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-500">Filter Status:</span>
                    <a href="{{ route('dashboard.memory-messages.index', ['tab' => 'messages']) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold {{ !$status ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('dashboard.memory-messages.index', ['tab' => 'messages', 'status' => 'approved']) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $status === 'approved' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Ditayangkan
                    </a>
                    <a href="{{ route('dashboard.memory-messages.index', ['tab' => 'messages', 'status' => 'pending']) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $status === 'pending' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Disembunyikan
                    </a>
                </div>
            </div>

            <!-- Table of Letters -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                                <th class="p-4 pl-6">Kepada / Ditujukan</th>
                                <th class="p-4">Pengirim & Angkatan</th>
                                <th class="p-4">Kategori Rasa</th>
                                <th class="p-4">Cuplikan Pesan</th>
                                <th class="p-4 text-center">Pelukan</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 pr-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($messages as $msg)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-4 pl-6 font-bold text-slate-900">
                                        <div class="flex items-center gap-1.5">
                                            @if($msg->is_pinned)
                                                <span class="text-amber-500" title="Disematkan"><i class="fas fa-thumbtack text-xs"></i></span>
                                            @endif
                                            <span>{{ $msg->recipient_name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-slate-800">{{ $msg->sender_name }}</div>
                                        @if($msg->sender_role)
                                            <div class="text-[11px] text-slate-400">{{ $msg->sender_role }}</div>
                                        @endif
                                        @if($msg->generation)
                                            <div class="text-[10px] text-blue-600 font-semibold">{{ $msg->generation }}</div>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase
                                            @if($msg->category === 'terima_kasih') bg-amber-50 text-amber-700 border border-amber-200
                                            @elseif($msg->category === 'maaf') bg-rose-50 text-rose-700 border border-rose-200
                                            @elseif($msg->category === 'rindu') bg-sky-50 text-sky-700 border border-sky-200
                                            @elseif($msg->category === 'pesan_adik') bg-emerald-50 text-emerald-700 border border-emerald-200
                                            @else bg-purple-50 text-purple-700 border border-purple-200 @endif">
                                            {{ $msg->category_label }}
                                        </span>
                                    </td>
                                    <td class="p-4 max-w-xs">
                                        <p class="line-clamp-2 text-slate-600">{{ $msg->message }}</p>
                                    </td>
                                    <td class="p-4 text-center font-bold text-rose-500">
                                        {{ $msg->hug_count }} 🤍
                                    </td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('dashboard.memory-messages.toggle-approve', $msg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer transition-all
                                                           {{ $msg->is_approved ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}">
                                                {{ $msg->is_approved ? '✓ Ditayangkan' : '⏸ Disembunyikan' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-4 pr-6 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- Toggle Pin -->
                                            <form action="{{ route('dashboard.memory-messages.toggle-pin', $msg->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-2 rounded-lg {{ $msg->is_pinned ? 'text-amber-500 bg-amber-50 hover:bg-amber-100' : 'text-slate-400 bg-slate-100 hover:bg-slate-200' }} transition-all"
                                                        title="{{ $msg->is_pinned ? 'Lepas Sematan' : 'Sematkan di Atas' }}">
                                                    <i class="fas fa-thumbtack text-xs"></i>
                                                </button>
                                            </form>

                                            <!-- Delete -->
                                            <form action="{{ route('dashboard.memory-messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat kenangan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-rose-500 bg-rose-50 hover:bg-rose-100 transition-all" title="Hapus Surat">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-400">
                                        Belum ada surat tak terucap yang masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($messages->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- ==================== TAB 2: RUANG YANG KINI SUNYI ==================== -->
        <div x-show="activeTab === 'moments'" class="space-y-6" style="display: none;">
            
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Daftar Momen & Sudut Ruangan</h3>
                    <p class="text-xs text-slate-500">Kilas balik naratif kenangan sudut ruang sekretariat</p>
                </div>
                <button @click="openAddMomentModal()"
                        class="px-4 py-2.5 rounded-xl bg-[#17223b] hover:bg-[#25365d] text-white text-xs font-bold flex items-center gap-2 cursor-pointer shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Momen</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($silentMoments as $moment)
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="aspect-[16/9] bg-slate-900 overflow-hidden relative">
                                @if($moment->photo)
                                    <img src="{{ asset($moment->photo) }}" alt="{{ $moment->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 bg-slate-100">
                                        <i class="fas fa-camera text-2xl mb-1"></i>
                                        <span class="text-[10px] font-bold">Tanpa Foto</span>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 px-2 py-0.5 rounded bg-black/60 text-white text-[10px] font-bold">
                                    {{ $moment->period ?: 'Momen Abadi' }}
                                </div>
                            </div>

                            <div class="p-5 space-y-2">
                                <h4 class="text-sm font-black text-slate-800">{{ $moment->title }}</h4>
                                @if($moment->subtitle)
                                    <p class="text-[11px] font-semibold text-slate-400">{{ $moment->subtitle }}</p>
                                @endif
                                <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed mt-2 italic">{{ $moment->narrative }}</p>
                            </div>
                        </div>

                        <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <span class="text-[10px] font-bold {{ $moment->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                {{ $moment->is_active ? '✓ Aktif' : 'Nonaktif' }}
                            </span>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('dashboard.memory-messages.moments.destroy', $moment->id) }}" method="POST" onsubmit="return confirm('Hapus momen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-3xl border border-slate-200">
                        Belum ada momen naratif yang ditambahkan.
                    </div>
                @endforelse
            </div>

        </div>

        <!-- ==================== TAB 3: SURAT PAMIT ANGKATAN ==================== -->
        <div x-show="activeTab === 'farewells'" class="space-y-6" style="display: none;">
            
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Daftar Surat Pamit Demisioner</h3>
                    <p class="text-xs text-slate-500">Pesan dan surat perpisahan resmi per angkatan/generasi</p>
                </div>
                <button @click="openAddFarewellModal()"
                        class="px-4 py-2.5 rounded-xl bg-[#17223b] hover:bg-[#25365d] text-white text-xs font-bold flex items-center gap-2 cursor-pointer shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Surat Pamit</span>
                </button>
            </div>

            <div class="space-y-4">
                @forelse($farewellLetters as $farewell)
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
                        <div class="space-y-1">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-black uppercase bg-purple-100 text-purple-800">
                                {{ $farewell->period }}
                            </span>
                            <h4 class="text-base font-black text-slate-800">{{ $farewell->generation_title }}</h4>
                            <p class="text-xs text-slate-500">Oleh: {{ $farewell->author_representative ?: 'Pengurus Demisioner' }}</p>
                            <p class="text-xs text-slate-600 line-clamp-2 max-w-2xl mt-2 italic">{{ $farewell->letter_content }}</p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <form action="{{ route('dashboard.memory-messages.farewells.destroy', $farewell->id) }}" method="POST" onsubmit="return confirm('Hapus surat pamit ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 bg-white rounded-3xl border border-slate-200">
                        Belum ada surat pamit demisioner yang ditambahkan.
                    </div>
                @endforelse
            </div>

        </div>

        <!-- ==================== TAB 4: PENGATURAN HALAMAN & MUSIK ==================== -->
        <div x-show="activeTab === 'settings'" class="max-w-3xl space-y-6" style="display: none;">
            
            <form action="{{ route('dashboard.memory-messages.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 space-y-6 shadow-sm">
                @csrf

                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-base font-black text-slate-800">Pengaturan Teks & Banner</h3>
                    <p class="text-xs text-slate-500">Sesuaikan judul dan suasana pengantar halaman Jejak Rasa</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Badge Tagline</label>
                        <input type="text" name="badge_title" value="{{ $setting->badge_title }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Halaman</label>
                        <input type="text" name="page_title" value="{{ $setting->page_title }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Subjudul / Narasi Pengantar</label>
                        <textarea name="subtitle" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 leading-relaxed">{{ $setting->subtitle }}</textarea>
                    </div>
                </div>

                <div class="border-b border-slate-100 pb-4 pt-2">
                    <h3 class="text-base font-black text-slate-800">Alunan Musik Latar Kenangan</h3>
                    <p class="text-xs text-slate-500">Musik instrumen piano nostalgia yang diputar lembut di halaman publik</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="is_audio_active" name="is_audio_active" value="1" {{ $setting->is_audio_active ? 'checked' : '' }} class="w-4 h-4 rounded text-rose-600">
                        <label for="is_audio_active" class="text-xs font-bold text-slate-700 cursor-pointer">Aktifkan Pemutar Musik Latar</label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Musik</label>
                            <input type="text" name="audio_title" value="{{ $setting->audio_title }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Penyanyi / Artis</label>
                            <input type="text" name="audio_artist" value="{{ $setting->audio_artist }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Berkas Audio Baru (MP3 / WAV)</label>
                        <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        @if($setting->audio_file)
                            <p class="text-[11px] text-emerald-600 font-semibold mt-1">✓ Berkas audio saat ini terpasang.</p>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#17223b] hover:bg-[#25365d] text-white text-xs font-bold uppercase tracking-wider transition-all shadow-md">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>

        </div>

        <!-- ==================== MODAL TAMBAH MOMEN ==================== -->
        <div x-show="addMomentModalOpen" 
             class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto"
             style="display: none;">
            <div @click.away="addMomentModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-xl w-full shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b pb-3">
                    <h3 class="text-base font-black text-slate-800">Tambah Momen "Ruang yang Kini Sunyi"</h3>
                    <button @click="addMomentModalOpen = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                </div>
                <form action="{{ route('dashboard.memory-messages.moments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Momen *</label>
                        <input type="text" name="title" required placeholder="Misal: Sudut Meja Jam 5 Sore" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Subjudul</label>
                        <input type="text" name="subtitle" placeholder="Keterangan singkat momen" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Periode / Waktu</label>
                        <input type="text" name="period" placeholder="Misal: Periode 2023/2024" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Foto Momen</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-600">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Narasi Kisah Puitis *</label>
                        <textarea name="narrative" required rows="4" placeholder="Ceritakan bagaimana momen ini begitu berkesan dan membuat rindu..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs leading-relaxed"></textarea>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="is_active_moment" name="is_active" value="1" checked class="w-4 h-4 rounded text-rose-600">
                        <label for="is_active_moment" class="text-xs font-bold text-slate-700 cursor-pointer">Aktifkan Momen Ini</label>
                    </div>
                    <div class="pt-3 border-t flex justify-end gap-2">
                        <button type="button" @click="addMomentModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-bold text-slate-600">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#17223b] text-white text-xs font-bold">Simpan Momen</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== MODAL TAMBAH SURAT PAMIT ==================== -->
        <div x-show="addFarewellModalOpen" 
             class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto"
             style="display: none;">
            <div @click.away="addFarewellModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-xl w-full shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b pb-3">
                    <h3 class="text-base font-black text-slate-800">Tambah Surat Pamit Demisioner</h3>
                    <button @click="addFarewellModalOpen = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                </div>
                <form action="{{ route('dashboard.memory-messages.farewells.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Generasi *</label>
                        <input type="text" name="generation_title" required placeholder="Misal: Surat Pamit Generasi 3 — Lentera Harapan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Periode *</label>
                        <input type="text" name="period" required placeholder="Misal: Periode 2023/2024" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Perwakilan Penulis</label>
                        <input type="text" name="author_representative" placeholder="Misal: Seluruh Pengurus Demisioner" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Isi Surat Pamit *</label>
                        <textarea name="letter_content" required rows="6" placeholder="Tuliskan pesan wasiat, terima kasih, dan harapan untuk adik-adik kelas..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs leading-relaxed font-serif"></textarea>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="is_active_farewell" name="is_active" value="1" checked class="w-4 h-4 rounded text-rose-600">
                        <label for="is_active_farewell" class="text-xs font-bold text-slate-700 cursor-pointer">Aktifkan Surat Pamit Ini</label>
                    </div>
                    <div class="pt-3 border-t flex justify-end gap-2">
                        <button type="button" @click="addFarewellModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-bold text-slate-600">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#17223b] text-white text-xs font-bold">Simpan Surat Pamit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function memoryDashboardApp(defaultTab) {
            return {
                activeTab: defaultTab || 'messages',
                addMomentModalOpen: false,
                addFarewellModalOpen: false,

                openAddMomentModal() {
                    this.addMomentModalOpen = true;
                },

                openAddFarewellModal() {
                    this.addFarewellModalOpen = true;
                }
            };
        }
    </script>
</x-layouts.dashboard>
