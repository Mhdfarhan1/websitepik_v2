<x-layouts.dashboard title="Pusat Notifikasi | Admin PIK-R">
    <div x-data="{
        selectedItems: [],
        filterType: 'all',
        filterStatus: 'all',
        fillForm(item) {
            document.getElementById('input-type').value = item.source_type || 'informasi';
            document.getElementById('input-title').value = item.default_title || item.title;
            document.getElementById('input-message').value = item.default_message || '';
            document.getElementById('input-url').value = item.url || '';
            document.getElementById('manual-broadcast-section').scrollIntoView({ behavior: 'smooth' });
        }
    }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-sm">
                        <i class="fas fa-bell"></i>
                    </span>
                    Pusat Notifikasi & Web Push
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Kelola Siaran Notifikasi Konten Website & Web Push</p>
            </div>
            <a href="{{ route('notifications.index') }}" target="_blank" class="px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs transition-all flex items-center gap-2">
                <i class="fas fa-external-link-alt text-[10px]"></i>
                Halaman Publik
            </a>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8">
            <!-- 1. Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-800">{{ number_format($stats['active_subscribers'] ?? 0) }}</div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Device Subscriber Aktif</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-800">{{ number_format($stats['total_sent_push'] ?? 0) }}</div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Push Terkirim</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-800">{{ number_format($stats['pending_contents'] ?? 0) }}</div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Konten Belum Disiarkan</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 text-sm font-black text-emerald-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            VAPID Siap
                        </div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Web Push Engine</div>
                    </div>
                </div>
            </div>

            <!-- 2. ANTREAN KONTEN MASUK (KONTEN TERBARU WEBSITE SIAP DISIARKAN) -->
            <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fas fa-layer-group"></i>
                            </span>
                            Pilih Konten Website untuk Disiarkan
                        </h2>
                        <p class="text-xs text-slate-400 mt-1">
                            Setiap konten baru di <strong>Prestasi, Kegiatan, Artikel, atau Jejak Bakti</strong> otomatis muncul di sini. Admin tinggal klik tombol <strong>"⚡ Kirim Notifikasi Ini"</strong> atau centang beberapa untuk digabungkan.
                        </p>
                    </div>

                    <!-- Category Filters -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="button" 
                                @click="filterType = 'all'" 
                                :class="filterType === 'all' ? 'bg-[#1e40af] text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                                class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all cursor-pointer">
                            Semua
                        </button>
                        <button type="button" 
                                @click="filterType = 'prestasi'" 
                                :class="filterType === 'prestasi' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                                class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all cursor-pointer flex items-center gap-1">
                            🏆 Prestasi
                        </button>
                        <button type="button" 
                                @click="filterType = 'kegiatan'" 
                                :class="filterType === 'kegiatan' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                                class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all cursor-pointer flex items-center gap-1">
                            📅 Kegiatan
                        </button>
                        <button type="button" 
                                @click="filterType = 'artikel'" 
                                :class="filterType === 'artikel' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                                class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all cursor-pointer flex items-center gap-1">
                            📰 Artikel
                        </button>
                        <button type="button" 
                                @click="filterType = 'jejak_bakti'" 
                                :class="filterType === 'jejak_bakti' ? 'bg-purple-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                                class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all cursor-pointer flex items-center gap-1">
                            👑 Jejak Bakti
                        </button>
                    </div>
                </div>

                <!-- Form Batch Send (Fitur Gabungkan Notifikasi / Anti-Spam) -->
                <form action="{{ route('dashboard.notifications.batch-send') }}" method="POST" id="batch-send-form">
                    @csrf
                    
                    <!-- Batch Action Bar if items selected -->
                    <div x-show="selectedItems.length > 0" 
                         x-cloak 
                         x-transition
                         class="mb-6 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 font-black text-xs flex items-center justify-center" x-text="selectedItems.length"></span>
                            <div>
                                <h4 class="text-xs font-black text-slate-800">Konten Terpilih untuk Disiarkan</h4>
                                <p class="text-[11px] text-slate-500">Kirim sekaligus ke seluruh subscriber dalam 1 notifikasi siaran (Anti-Spam).</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="selectedItems = []" class="px-3 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition-colors">
                                Batalkan Pilihan
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md shadow-amber-500/20 active:scale-95 transition-all flex items-center gap-2 cursor-pointer">
                                <i class="fas fa-paper-plane"></i>
                                <span>Siarkan <span x-text="selectedItems.length"></span> Konten Sekaligus</span>
                            </button>
                        </div>
                    </div>

                    <!-- Content Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($availableContents as $item)
                            <div x-show="filterType === 'all' || filterType === '{{ $item['source_type'] }}'"
                                 class="p-4 sm:p-5 rounded-2xl border transition-all relative flex flex-col justify-between group {{ $item['is_notified'] ? 'bg-slate-50/60 border-slate-200/60' : 'bg-white border-amber-200/80 shadow-xs hover:border-amber-400' }}">
                                
                                <div>
                                    <!-- Card Header: Type Badge & Status -->
                                    <div class="flex items-center justify-between gap-2 mb-3">
                                        <div class="flex items-center gap-2">
                                            <!-- Checkbox for Batch Sending -->
                                            <input type="checkbox" 
                                                   name="selected_items[]" 
                                                   value="{{ json_encode($item) }}" 
                                                   x-model="selectedItems"
                                                   class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">

                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border {{ $item['badge_color'] }}">
                                                <span>{{ $item['badge_icon'] }}</span>
                                                <span>{{ $item['badge_label'] }}</span>
                                            </span>
                                        </div>

                                        <!-- Status Indicator -->
                                        @if($item['is_notified'])
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                                                <i class="fas fa-check-circle text-[9px]"></i> Sudah Disiarkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 animate-pulse">
                                                <i class="fas fa-circle text-[7px] text-amber-500"></i> Belum Disiarkan
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Content Title & Meta -->
                                    <h3 class="text-sm font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug mb-1">
                                        {{ $item['title'] }}
                                    </h3>
                                    
                                    <p class="text-[11px] text-slate-400 mb-2">
                                        {{ $item['subtitle'] }}
                                    </p>

                                    <!-- Link Target Preview -->
                                    <div class="text-[11px] text-slate-500 flex items-center gap-1.5 font-mono mb-4 truncate">
                                        <i class="fas fa-link text-[10px] text-slate-400"></i>
                                        <a href="{{ $item['url'] }}" target="_blank" class="hover:text-blue-600 hover:underline truncate">
                                            {{ $item['url'] }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                    <button type="button" 
                                            @click="fillForm({{ json_encode($item) }})" 
                                            class="px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-[11px] transition-all flex items-center gap-1.5 cursor-pointer">
                                        <i class="fas fa-pen-to-square text-[10px]"></i>
                                        <span>Edit di Form</span>
                                    </button>

                                    <!-- 1-Click Quick Send Form -->
                                    <form action="{{ route('dashboard.notifications.quick-send') }}" method="POST" class="inline" onsubmit="return confirm('Kirim notifikasi untuk konten ini sekarang?')">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $item['source_type'] }}">
                                        <input type="hidden" name="title" value="{{ $item['default_title'] }}">
                                        <input type="hidden" name="message" value="{{ $item['default_message'] }}">
                                        <input type="hidden" name="url" value="{{ $item['url'] }}">
                                        
                                        <button type="submit" 
                                                class="px-4 py-1.5 rounded-xl font-extrabold text-[11px] transition-all flex items-center gap-1.5 cursor-pointer shadow-xs active:scale-95 {{ $item['is_notified'] ? 'bg-slate-100 hover:bg-slate-200 text-slate-700' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-600/20' }}">
                                            <i class="fas fa-bolt text-[10px]"></i>
                                            <span>{{ $item['is_notified'] ? 'Kirim Ulang' : '⚡ Kirim Notifikasi Ini' }}</span>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @empty
                            <div class="col-span-2 py-12 text-center text-slate-400">
                                <i class="fas fa-inbox text-3xl text-slate-300 mb-2"></i>
                                <p class="text-xs font-semibold">Belum ada konten yang diupload di website.</p>
                            </div>
                        @endforelse
                    </div>
                </form>
            </div>

            <!-- 3. FORM SIARAN KUSTOM / EDIT BROADCAST -->
            <div id="manual-broadcast-section" class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                            <i class="fas fa-bullhorn text-amber-500"></i>
                            Kirim Notifikasi Kustom / Manual
                        </h2>
                        <p class="text-xs text-slate-400 mt-1">Kustomisasi judul, pesan, dan URL sebelum disiarkan ke subscriber dan Notification Center.</p>
                    </div>

                    <!-- Quick Auto-Fill Dropdown -->
                    <div class="hidden sm:block">
                        <select onchange="if(this.value){ const item = JSON.parse(this.value); document.getElementById('input-type').value = item.source_type; document.getElementById('input-title').value = item.default_title; document.getElementById('input-message').value = item.default_message; document.getElementById('input-url').value = item.url; }" 
                                class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none cursor-pointer">
                            <option value="">⚡ Pilih Konten Masuk (Auto-Fill Form)...</option>
                            @foreach($availableContents as $contentItem)
                                <option value="{{ json_encode($contentItem) }}">
                                    {{ $contentItem['badge_icon'] }} [{{ $contentItem['badge_label'] }}] {{ Str::limit($contentItem['title'], 45) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <form action="{{ route('dashboard.notifications.send') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-700 mb-2">Kategori Notifikasi</label>
                            <select id="input-type" name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                                <option value="prestasi">🏆 Prestasi Baru</option>
                                <option value="kegiatan">📅 Agenda & Kegiatan</option>
                                <option value="artikel">📰 Artikel & Edukasi</option>
                                <option value="jejak_bakti">👑 Jejak Bakti Duta GenRe</option>
                                <option value="pengumuman">📢 Pengumuman Resmi</option>
                                <option value="informasi">ℹ️ Informasi Umum</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-700 mb-2">Judul Notifikasi</label>
                            <input type="text" id="input-title" name="title" required maxlength="120" placeholder="Contoh: Prestasi Baru 🏆: Juara 1 GenRe Award 2026" value="{{ old('title') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 mb-2">Isi Pesan Notifikasi</label>
                        <textarea id="input-message" name="message" required rows="3" maxlength="255" placeholder="Tuliskan ringkasan pesan yang informatif bagi pembaca..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-semibold text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">{{ old('message') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Maksimal 255 karakter agar pas di layar push notification HP pengguna.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-700 mb-2">Target URL (Ketika notifikasi diklik)</label>
                            <input type="text" id="input-url" name="url" placeholder="Contoh: /profil/prestasi/1 atau /kegiatan/..." value="{{ old('url', '/') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 mb-2">Icon Notifikasi (Opsional)</label>
                            <input type="text" name="icon" value="{{ old('icon', '/assets/img/Logo_pikr.png') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="broadcast_push" value="1" checked class="w-5 h-5 rounded-lg border-amber-300 text-amber-500 focus:ring-amber-400">
                            <div>
                                <span class="text-xs font-bold text-amber-950">Kirim Web Push ke Browser & HP Subscriber</span>
                                <p class="text-[11px] text-amber-800">Perangkat subscriber yang mengizinkan notifikasi akan menerima popup notifikasi secara langsung.</p>
                            </div>
                        </label>

                        <button type="submit" class="px-6 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-extrabold text-xs shadow-lg shadow-amber-500/20 active:scale-95 transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Notifikasi Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <!-- 4. RIWAYAT NOTIFIKASI YANG SUDAH TERKIRIM -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-black text-slate-800">Riwayat Notifikasi Website</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar notifikasi yang sudah tersimpan di sistem dan Notification Center</p>
                    </div>

                    <!-- Filter Type -->
                    <form method="GET" action="{{ route('dashboard.notifications.index') }}" class="flex items-center gap-2">
                        <select name="type" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none">
                            <option value="">Semua Kategori</option>
                            <option value="prestasi" {{ request('type') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="jejak_bakti" {{ request('type') == 'jejak_bakti' ? 'selected' : '' }}>Jejak Bakti</option>
                            <option value="kegiatan" {{ request('type') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            <option value="artikel" {{ request('type') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                            <option value="pengumuman" {{ request('type') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="informasi" {{ request('type') == 'informasi' ? 'selected' : '' }}>Informasi</option>
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Kategori & Judul</th>
                                <th class="px-6 py-4">Pesan</th>
                                <th class="px-6 py-4">URL Tujuan</th>
                                <th class="px-6 py-4">Status Push</th>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($notifications as $notif)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-sm shrink-0">
                                                {!! $notif->type_icon !!}
                                            </span>
                                            <div>
                                                <div class="font-extrabold text-slate-800 text-xs">{{ $notif->title }}</div>
                                                <span class="inline-block mt-0.5 px-2 py-0.5 text-[9px] font-extrabold rounded-md {{ $notif->type_badge_color }}">
                                                    {{ strtoupper(str_replace('_', ' ', $notif->type)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs max-w-xs truncate text-slate-600">
                                        {{ $notif->message }}
                                    </td>
                                    <td class="px-6 py-4 text-xs font-mono text-blue-600">
                                        @if($notif->url)
                                            <a href="{{ $notif->url }}" target="_blank" class="hover:underline flex items-center gap-1">
                                                {{ Str::limit($notif->url, 25) }}
                                                <i class="fas fa-external-link-alt text-[9px]"></i>
                                            </a>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs">
                                        @if($notif->is_sent)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                                                <i class="fas fa-check-circle text-[9px]"></i> Terkirim
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">
                                                Web Only
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-400 whitespace-nowrap">
                                        {{ $notif->created_at->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('dashboard.notifications.destroy', $notif) }}" method="POST" class="inline" onsubmit="return confirm('Hapus riwayat notifikasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center inline-flex shadow-sm cursor-pointer">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-3">
                                                <i class="fas fa-bell-slash text-xl"></i>
                                            </div>
                                            <p class="text-xs font-bold text-slate-400">Belum ada riwayat notifikasi</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($notifications->hasPages())
                    <div class="p-6 border-t border-slate-100">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.dashboard>
