<x-layouts.dashboard title="Manajemen Kotak Waktu PIK-R | Admin PIK-R">
    <div class="space-y-8" x-data="timeCapsuleDashboardApp()">

        <!-- Header Section -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#17385c] via-[#1a4473] to-[#1e3a8a] p-6 sm:p-8 text-white shadow-xl">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 text-xs font-black tracking-wider uppercase">
                        <i class="fas fa-box-archive"></i>
                        <span>RUANG ARSIP DIGITAL MASA DEPAN</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Kotak Waktu PIK-R (Time Capsule)</h1>
                    <p class="text-xs sm:text-sm text-slate-200/90 max-w-2xl leading-relaxed">
                        Simpan pesan, cerita rahasia, foto kenangan, dan video dari generasi saat ini. Sistem secara otomatis mengunci seluruh dokumen sampai tanggal pembukaan yang ditentukan tiba.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('kotak-waktu', ['kapsul' => $selectedCapsule ? $selectedCapsule->slug : '']) }}" target="_blank"
                       class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold flex items-center gap-2 transition-all shadow-sm">
                        <i class="fas fa-external-link-alt text-amber-400"></i>
                        <span>Lihat Publik</span>
                    </a>
                    <button @click="openAddCapsuleModal()"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black flex items-center gap-2 transition-all shadow-lg shadow-amber-500/20 active:scale-95">
                        <i class="fas fa-plus"></i>
                        <span>Buat Kotak Waktu</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
            <button @click="activeTab = 'capsules'"
                    :class="activeTab === 'capsules' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
                <i class="fas fa-boxes-stacked"></i>
                <span>Daftar Kotak Waktu ({{ $capsules->count() }})</span>
            </button>

            <button @click="activeTab = 'items'"
                    :class="activeTab === 'items' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
                <i class="fas fa-folder-open"></i>
                <span>Kelola Konten Kapsul @if($selectedCapsule) ({{ $selectedCapsule->title }}) @endif</span>
            </button>

            <button @click="activeTab = 'settings'"
                    :class="activeTab === 'settings' ? 'bg-[#17385c] text-white shadow-sm font-extrabold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
                <i class="fas fa-sliders"></i>
                <span>Pengaturan Halaman & Musik</span>
            </button>
        </div>

        <!-- ==================== TAB 1: DAFTAR KAPSUL WAKTU ==================== -->
        <div x-show="activeTab === 'capsules'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($capsules as $capsule)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all relative overflow-hidden group">
                        @if($capsule->is_featured)
                            <div class="absolute top-4 right-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                                    ⭐ Edisi Utama
                                </span>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <!-- Status Lock Badge -->
                            <div>
                                @if($capsule->is_locked)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="fas fa-lock text-[10px]"></i> 🔒 TERKUNCI
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fas fa-lock-open text-[10px]"></i> 🔓 TELAH DIBUKA
                                    </span>
                                @endif
                            </div>

                            <!-- Title & Generation -->
                            <div>
                                <h3 class="text-xl font-black text-slate-900 leading-snug">
                                    {{ $capsule->title }}
                                </h3>
                                <p class="text-xs text-slate-500 font-bold mt-1">
                                    {{ $capsule->creator_generation }}
                                </p>
                            </div>

                            <!-- Dates Box -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Tanggal Dibuat:</span>
                                    <span class="font-bold text-slate-800">{{ $capsule->formatted_created_date }}</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Akan Dibuka:</span>
                                    <span class="font-extrabold text-amber-700">{{ $capsule->formatted_unlock_date }}</span>
                                </div>
                            </div>

                            <!-- Contents Count Summary -->
                            <div class="grid grid-cols-4 gap-2 pt-1 text-center">
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="text-xs font-black text-slate-800">{{ $capsule->letters_count }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase">Surat</div>
                                </div>
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="text-xs font-black text-slate-800">{{ $capsule->stories_count }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase">Kisah</div>
                                </div>
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="text-xs font-black text-slate-800">{{ $capsule->photos_count }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase">Foto</div>
                                </div>
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="text-xs font-black text-slate-800">{{ $capsule->videos_count }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase">Video</div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between gap-2">
                            <a href="{{ route('dashboard.time-capsules.index', ['capsule_id' => $capsule->id]) }}"
                               @click="activeTab = 'items'"
                               class="px-3.5 py-2 rounded-xl bg-[#17385c] hover:bg-[#1a4473] text-white text-xs font-bold flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-folder-open text-[11px]"></i>
                                <span>Kelola Konten</span>
                            </a>

                            <div class="flex items-center gap-1">
                                @if(!$capsule->is_featured)
                                    <form action="{{ route('dashboard.time-capsules.feature', $capsule->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" title="Jadikan Kapsul Utama"
                                                class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-amber-100 hover:text-amber-800 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                            <i class="far fa-star"></i>
                                        </button>
                                    </form>
                                @endif

                                <button @click="openEditCapsuleModal(@js($capsule))" title="Edit Kapsul"
                                        class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                <form action="{{ route('dashboard.time-capsules.destroy', $capsule->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus Kotak Waktu \'{{ $capsule->title }}\' beserta seluruh isi pesannya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Kapsul"
                                            class="w-8 h-8 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center text-xs transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center bg-white rounded-3xl border border-slate-200">
                        <i class="fas fa-box-open text-4xl text-slate-300 mb-3 block"></i>
                        <h4 class="text-sm font-bold text-slate-700">Belum Ada Kotak Waktu</h4>
                        <p class="text-xs text-slate-400 mt-1">Buat kotak waktu pertama untuk mengawali arsip masa depan.</p>
                        <button @click="openAddCapsuleModal()" class="mt-4 px-4 py-2 rounded-xl bg-[#17385c] text-white text-xs font-bold">
                            + Buat Sekarang
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ==================== TAB 2: KELOLA KONTEN KAPSUL ==================== -->
        <div x-show="activeTab === 'items'" class="space-y-8">
            @if($selectedCapsule)
                <!-- Capsule Selector Banner -->
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Sedang Mengelola Kapsul:</div>
                        <h2 class="text-xl font-black text-slate-900 mt-0.5">{{ $selectedCapsule->title }}</h2>
                        <div class="text-xs text-slate-500 font-semibold mt-1 flex flex-wrap items-center gap-3">
                            <span><i class="fas fa-users mr-1 text-slate-400"></i> {{ $selectedCapsule->creator_generation }}</span>
                            <span>•</span>
                            <span><i class="fas fa-calendar mr-1 text-slate-400"></i> Dibuka: <strong>{{ $selectedCapsule->formatted_unlock_date }}</strong></span>
                            <span>•</span>
                            @if($selectedCapsule->is_locked)
                                <span class="text-amber-600 font-extrabold">🔒 Terkunci</span>
                            @else
                                <span class="text-emerald-600 font-extrabold">🔓 Telah Dibuka</span>
                            @endif
                        </div>
                    </div>

                    <!-- Switch Capsule Dropdown -->
                    <div class="flex items-center gap-3">
                        <label class="text-xs font-bold text-slate-500 hidden sm:inline">Ganti Kapsul:</label>
                        <select onchange="window.location.href = '{{ route('dashboard.time-capsules.index') }}?capsule_id=' + this.value"
                                class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:ring-2 focus:ring-sky-500">
                            @foreach($capsules as $c)
                                <option value="{{ $c->id }}" {{ $selectedCapsule->id === $c->id ? 'selected' : '' }}>
                                    {{ $c->title }} ({{ $c->creator_generation }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 4 Categories Grid: Letters, Stories, Photos, Videos -->
                <div class="space-y-8">

                    <!-- Section 1: Surat & Pesan -->
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900">Surat & Pesan untuk Masa Depan</h3>
                                    <p class="text-xs text-slate-500">Pesan dan surat resmi yang dititipkan kepada generasi penerus</p>
                                </div>
                            </div>
                            <button @click="openAddItemModal('letter')"
                                    class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Surat</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                            @forelse($selectedCapsule->letters as $item)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between space-y-3">
                                    <div class="space-y-1.5">
                                        <div class="text-[10px] font-black uppercase text-amber-700">Surat #{{ $item->order_index }}</div>
                                        <h4 class="text-sm font-black text-slate-900 leading-snug">{{ $item->title }}</h4>
                                        <div class="text-[11px] font-bold text-slate-600">
                                            {{ $item->author_name }} @if($item->author_role) <span class="text-slate-400 font-normal">({{ $item->author_role }})</span> @endif
                                        </div>
                                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed pt-1">
                                            {{ $item->content }}
                                        </p>
                                    </div>
                                    <div class="pt-2 border-t border-slate-200/60 flex items-center justify-end gap-1.5">
                                        <button @click="openEditItemModal(@js($item))" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-200 text-xs">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('dashboard.time-capsules.items.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 text-xs">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-6 text-center text-xs text-slate-400">
                                    Belum ada surat yang ditambahkan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Section 2: Cerita & Kenangan -->
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm">
                                    <i class="fas fa-book-bookmark"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900">Cerita & Kisah Perjalanan</h3>
                                    <p class="text-xs text-slate-500">Narasi di balik layar, suka duka, dan memori tak terlupakan</p>
                                </div>
                            </div>
                            <button @click="openAddItemModal('story')"
                                    class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Cerita</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            @forelse($selectedCapsule->stories as $item)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between space-y-3">
                                    <div class="space-y-1.5">
                                        <div class="text-[10px] font-black uppercase text-blue-700">Cerita #{{ $item->order_index }}</div>
                                        <h4 class="text-sm font-black text-slate-900 leading-snug">{{ $item->title }}</h4>
                                        <div class="text-[11px] font-bold text-slate-600">
                                            Penulis: {{ $item->author_name ?: 'Pengurus' }}
                                        </div>
                                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed pt-1 whitespace-pre-line">
                                            {{ $item->content }}
                                        </p>
                                    </div>
                                    <div class="pt-2 border-t border-slate-200/60 flex items-center justify-end gap-1.5">
                                        <button @click="openEditItemModal(@js($item))" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-200 text-xs">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('dashboard.time-capsules.items.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus cerita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 text-xs">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-6 text-center text-xs text-slate-400">
                                    Belum ada cerita yang ditambahkan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Section 3: Galeri Foto Arsip -->
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900">Foto Arsip Kenangan</h3>
                                    <p class="text-xs text-slate-500">Foto bersejarah kepengurusan yang disimpan dalam kapsul</p>
                                </div>
                            </div>
                            <button @click="openAddItemModal('photo')"
                                    class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Foto</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 pt-2">
                            @forelse($selectedCapsule->photos as $item)
                                <div class="rounded-2xl border border-slate-200 overflow-hidden bg-slate-50 flex flex-col justify-between">
                                    <div class="aspect-video relative bg-slate-900">
                                        @if($item->media_path)
                                            <img src="{{ asset($item->media_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Tidak ada foto</div>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <div class="text-xs font-black text-slate-800 line-clamp-1">{{ $item->title }}</div>
                                        <div class="text-[10px] text-slate-500 line-clamp-1 mt-0.5">{{ $item->content }}</div>
                                        <div class="pt-2 mt-2 border-t border-slate-200 flex items-center justify-end gap-1">
                                            <button @click="openEditItemModal(@js($item))" class="p-1 rounded text-slate-500 hover:bg-slate-200 text-xs">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <form action="{{ route('dashboard.time-capsules.items.destroy', $item->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus foto ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 rounded text-red-500 hover:bg-red-50 text-xs">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-6 text-center text-xs text-slate-400">
                                    Belum ada foto arsip yang ditambahkan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Section 4: Video Kenangan -->
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-sm">
                                    <i class="fas fa-video"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900">Video Kenangan & Rekaman Suara</h3>
                                    <p class="text-xs text-slate-500">Video dokumenter atau rekaman suara pesan masa depan</p>
                                </div>
                            </div>
                            <button @click="openAddItemModal('video')"
                                    class="px-3.5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-black text-xs flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Video</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            @forelse($selectedCapsule->videos as $item)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between space-y-3">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-black uppercase text-purple-700">Video #{{ $item->order_index }}</span>
                                            @if($item->external_url)
                                                <span class="text-[10px] font-bold text-slate-400">YouTube / Tautan Eksternal</span>
                                            @endif
                                        </div>
                                        <h4 class="text-sm font-black text-slate-900">{{ $item->title }}</h4>
                                        @if($item->content)
                                            <p class="text-xs text-slate-500 line-clamp-2">{{ $item->content }}</p>
                                        @endif
                                    </div>
                                    <div class="pt-2 border-t border-slate-200/60 flex items-center justify-end gap-1.5">
                                        <button @click="openEditItemModal(@js($item))" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-200 text-xs">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('dashboard.time-capsules.items.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus video ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 text-xs">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-6 text-center text-xs text-slate-400">
                                    Belum ada video dokumenter yang ditambahkan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            @else
                <div class="p-12 text-center bg-white rounded-3xl border border-slate-200">
                    <p class="text-xs text-slate-400">Silakan buat atau pilih Kotak Waktu terlebih dahulu.</p>
                </div>
            @endif
        </div>

        <!-- ==================== TAB 3: PENGATURAN HALAMAN & MUSIK ==================== -->
        <div x-show="activeTab === 'settings'" class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
            <form action="{{ route('dashboard.time-capsules.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
                @csrf

                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-base font-black text-slate-900">Pengaturan Tampilan & Musik Kotak Waktu</h3>
                    <p class="text-xs text-slate-500">Sesuaikan teks header, banner visual, dan melodi instrumen pengiring di halaman publik.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Badge Atas (Pill Tag)</label>
                        <input type="text" name="badge_title" value="{{ old('badge_title', $setting->badge_title) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Halaman</label>
                        <input type="text" name="page_title" value="{{ old('page_title', $setting->page_title) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Subjudul / Filosofi</label>
                        <textarea name="subtitle" rows="3"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed focus:ring-2 focus:ring-sky-500">{{ old('subtitle', $setting->subtitle) }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Default: “Tidak semua cerita harus dibaca hari ini. Beberapa cerita sengaja kita tinggalkan untuk masa depan.”</p>
                    </div>

                    <!-- Musik Kenangan -->
                    <div class="sm:col-span-2 pt-4 border-t border-slate-100 space-y-4">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">Musik Latar Kenangan (Audio)</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Musik</label>
                                <input type="text" name="audio_title" value="{{ old('audio_title', $setting->audio_title) }}"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Penyanyi / Komposer</label>
                                <input type="text" name="audio_artist" value="{{ old('audio_artist', $setting->audio_artist) }}"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Unggah File Audio Baru (.mp3, .wav, .m4a)</label>
                                <input type="file" name="audio_file" accept="audio/*"
                                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#17385c] file:text-white">
                                @if($setting->audio_file)
                                    <div class="mt-2 flex items-center gap-3 text-xs text-slate-600">
                                        <i class="fas fa-check-circle text-emerald-500"></i>
                                        <span>File audio aktif: <strong>{{ basename($setting->audio_file) }}</strong></span>
                                        <label class="inline-flex items-center gap-1.5 text-red-600 font-bold ml-3 cursor-pointer">
                                            <input type="checkbox" name="remove_audio" value="1" class="rounded border-slate-300">
                                            Hapus Musik
                                        </label>
                                    </div>
                                @endif
                            </div>

                            <div class="sm:col-span-2">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_audio_active" value="1" {{ $setting->is_audio_active ? 'checked' : '' }} class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                    <span class="text-xs font-bold text-slate-700">Aktifkan Tombol Pemutar Musik di Halaman Publik</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#17385c] hover:bg-[#1a4473] text-white font-black text-xs shadow-md transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- ==================== MODAL TAMBAH KAPSUL ==================== -->
        <div x-show="addCapsuleModalOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
             @keydown.escape.window="addCapsuleModalOpen = false">
            <div class="relative w-full max-w-xl bg-white rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto"
                 @click.outside="addCapsuleModalOpen = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Buat Kotak Waktu (Time Capsule) Baru</h3>
                    <button @click="addCapsuleModalOpen = false" class="text-slate-400 hover:text-slate-600 text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('dashboard.time-capsules.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Kapsul (Contoh: TIME CAPSULE 2026)</label>
                        <input type="text" name="title" required placeholder="TIME CAPSULE 2026"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Dibuat Oleh (Generasi / Periode)</label>
                        <input type="text" name="creator_generation" required placeholder="Generasi PIK-R REQUEST 2025–2026"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Dibuat</label>
                            <input type="date" name="created_date" required value="{{ date('Y-m-d') }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Akan Dibuka (Tanggal & Jam)</label>
                            <input type="datetime-local" name="unlock_date" required value="{{ date('Y-m-d', strtotime('+4 years')) }}T00:00"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pesan Segel Pengantar (Opsional)</label>
                        <textarea name="seal_message" rows="3" placeholder="Pesan pengantar segel waktu dari angkatan pembuat..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed focus:ring-2 focus:ring-sky-500"></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                            <span class="text-xs font-bold text-slate-700">Jadikan Edisi Utama</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="addCapsuleModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#17385c] hover:bg-[#1a4473] text-white font-black text-xs shadow-md">
                            Simpan & Kunci Kapsul
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== MODAL EDIT KAPSUL ==================== -->
        <div x-show="editCapsuleModalOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
             @keydown.escape.window="editCapsuleModalOpen = false">
            <div class="relative w-full max-w-xl bg-white rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto"
                 @click.outside="editCapsuleModalOpen = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Edit Kotak Waktu</h3>
                    <button @click="editCapsuleModalOpen = false" class="text-slate-400 hover:text-slate-600 text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form :action="'{{ url('/dashboard/time-capsules') }}/' + editCapsuleData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Kapsul</label>
                        <input type="text" name="title" x-model="editCapsuleData.title" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Dibuat Oleh</label>
                        <input type="text" name="creator_generation" x-model="editCapsuleData.creator_generation" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Dibuat</label>
                            <input type="date" name="created_date" x-model="editCapsuleData.created_date" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Akan Dibuka (Tanggal & Jam)</label>
                            <input type="datetime-local" name="unlock_date" x-model="editCapsuleData.unlock_date" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pesan Segel Pengantar</label>
                        <textarea name="seal_message" x-model="editCapsuleData.seal_message" rows="3"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed focus:ring-2 focus:ring-sky-500"></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" :checked="editCapsuleData.is_featured" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                            <span class="text-xs font-bold text-slate-700">Jadikan Edisi Utama</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="editCapsuleModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#17385c] hover:bg-[#1a4473] text-white font-black text-xs shadow-md">
                            Perbarui Kapsul
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== MODAL TAMBAH KONTEN (Surat/Cerita/Foto/Video) ==================== -->
        <div x-show="addItemModalOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
             @keydown.escape.window="addItemModalOpen = false">
            <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto"
                 @click.outside="addItemModalOpen = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900" x-text="'Tambah ' + getItemTypeLabel(itemFormData.type)"></h3>
                    <button @click="addItemModalOpen = false" class="text-slate-400 hover:text-slate-600 text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @if($selectedCapsule)
                    <form action="{{ route('dashboard.time-capsules.items.store', $selectedCapsule->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="type" x-model="itemFormData.type">

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Dokumen / Konten</label>
                            <input type="text" name="title" required placeholder="Contoh: Pesan untuk Generasi 2030"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pengirim / Penulis</label>
                                <input type="text" name="author_name" placeholder="Farhan & BPH"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan / Peran</label>
                                <input type="text" name="author_role" placeholder="Ketua Umum 2025/2026"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                            </div>
                        </div>

                        <!-- Content Text (Surat / Cerita / Caption) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1" x-text="itemFormData.type === 'photo' ? 'Keterangan Foto' : (itemFormData.type === 'video' ? 'Deskripsi Video' : 'Isi Teks / Narasi')"></label>
                            <textarea name="content" rows="4" placeholder="Tuliskan isi pesan secara lengkap..."
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed focus:ring-2 focus:ring-sky-500"></textarea>
                        </div>

                        <!-- Media File for Photo or Video -->
                        <template x-if="itemFormData.type === 'photo' || itemFormData.type === 'video'">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1" x-text="'File ' + (itemFormData.type === 'photo' ? 'Foto (JPG, PNG, WEBP)' : 'Video (MP4)')"></label>
                                <input type="file" name="media_file" :accept="itemFormData.type === 'photo' ? 'image/*' : 'video/*'"
                                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#17385c] file:text-white">
                            </div>
                        </template>

                        <!-- External URL for Video -->
                        <template x-if="itemFormData.type === 'video'">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tautan YouTube / Google Drive Video (Opsional)</label>
                                <input type="url" name="external_url" placeholder="https://www.youtube.com/watch?v=..."
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                            </div>
                        </template>

                        <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                            <button type="button" @click="addItemModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-[#17385c] hover:bg-[#1a4473] text-white font-black text-xs shadow-md">
                                Tambahkan ke Kapsul
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- ==================== MODAL EDIT KONTEN ==================== -->
        <div x-show="editItemModalOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
             @keydown.escape.window="editItemModalOpen = false">
            <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto"
                 @click.outside="editItemModalOpen = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Edit Konten Kapsul</h3>
                    <button @click="editItemModalOpen = false" class="text-slate-400 hover:text-slate-600 text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form :action="'{{ url('/dashboard/time-capsules/items') }}/' + editItemData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" x-model="editItemData.type">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Dokumen / Konten</label>
                        <input type="text" name="title" x-model="editItemData.title" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pengirim / Penulis</label>
                            <input type="text" name="author_name" x-model="editItemData.author_name"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan / Peran</label>
                            <input type="text" name="author_role" x-model="editItemData.author_role"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Isi Teks / Narasi</label>
                        <textarea name="content" x-model="editItemData.content" rows="4"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs leading-relaxed focus:ring-2 focus:ring-sky-500"></textarea>
                    </div>

                    <template x-if="editItemData.type === 'photo' || editItemData.type === 'video'">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1" x-text="'Ganti File ' + (editItemData.type === 'photo' ? 'Foto' : 'Video') + ' (Biarkan kosong jika tidak diganti)'"></label>
                            <input type="file" name="media_file" :accept="editItemData.type === 'photo' ? 'image/*' : 'video/*'"
                                   class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#17385c] file:text-white">
                        </div>
                    </template>

                    <template x-if="editItemData.type === 'video'">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tautan YouTube / Drive</label>
                            <input type="url" name="external_url" x-model="editItemData.external_url"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-sky-500">
                        </div>
                    </template>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="editItemModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#17385c] hover:bg-[#1a4473] text-white font-black text-xs shadow-md">
                            Perbarui Konten
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function timeCapsuleDashboardApp() {
            return {
                activeTab: '{{ request()->query('capsule_id') ? 'items' : 'capsules' }}',

                addCapsuleModalOpen: false,
                editCapsuleModalOpen: false,
                editCapsuleData: {
                    id: null,
                    title: '',
                    creator_generation: '',
                    created_date: '',
                    unlock_date: '',
                    seal_message: '',
                    is_featured: false
                },

                addItemModalOpen: false,
                itemFormData: {
                    type: 'letter'
                },

                editItemModalOpen: false,
                editItemData: {
                    id: null,
                    type: 'letter',
                    title: '',
                    author_name: '',
                    author_role: '',
                    content: '',
                    external_url: ''
                },

                openAddCapsuleModal() {
                    this.addCapsuleModalOpen = true;
                },

                openEditCapsuleModal(capsule) {
                    this.editCapsuleData = {
                        id: capsule.id,
                        title: capsule.title || '',
                        creator_generation: capsule.creator_generation || '',
                        created_date: capsule.created_date ? capsule.created_date.split('T')[0] : '',
                        unlock_date: capsule.unlock_date ? capsule.unlock_date.substring(0, 16) : '',
                        seal_message: capsule.seal_message || '',
                        is_featured: !!capsule.is_featured
                    };
                    this.editCapsuleModalOpen = true;
                },

                openAddItemModal(type) {
                    this.itemFormData = { type: type };
                    this.addItemModalOpen = true;
                },

                openEditItemModal(item) {
                    this.editItemData = {
                        id: item.id,
                        type: item.type || 'letter',
                        title: item.title || '',
                        author_name: item.author_name || '',
                        author_role: item.author_role || '',
                        content: item.content || '',
                        external_url: item.external_url || ''
                    };
                    this.editItemModalOpen = true;
                },

                getItemTypeLabel(type) {
                    switch (type) {
                        case 'letter': return 'Surat / Pesan Rahasia';
                        case 'story': return 'Cerita Kenangan';
                        case 'photo': return 'Foto Arsip';
                        case 'video': return 'Video Dokumenter';
                        default: return 'Konten';
                    }
                }
            };
        }
    </script>
</x-layouts.dashboard>
