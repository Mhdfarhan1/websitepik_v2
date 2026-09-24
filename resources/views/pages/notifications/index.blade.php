<x-layouts.app title="Pusat Notifikasi & Pemberitahuan | PIK-R REQUEST">
    <div class="min-h-screen bg-slate-50 pt-20 pb-16">
        
        <!-- Header Banner -->
        <div class="relative bg-gradient-to-r from-[#17385c] via-[#1e40af] to-[#17385c] text-white py-12 sm:py-16 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-amber-300 text-xs font-black uppercase tracking-wider border border-white/15">
                            <i class="fas fa-bell"></i>
                            <span>Pusat Notifikasi Terpusat</span>
                        </div>
                        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Notifikasi & Kabar Terbaru</h1>
                        <p class="text-xs sm:text-sm text-slate-200 font-medium max-w-xl">
                            Pantau setiap pembaruan prestasi, rekam jejak duta, agenda kegiatan, serta artikel edukasi terbaru dari PIK-R REQUEST SMAN 1 Tasik Putri Puyu.
                        </p>
                    </div>

                    <!-- Push Notification Status Toggle Card -->
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl sm:max-w-xs shrink-0 flex flex-col justify-between gap-3 shadow-lg">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center text-xs font-bold shrink-0">
                                <i class="fas fa-satellite-dish"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Push Notifikasi Browser</h4>
                                <p class="text-[10px] text-slate-300">Pemberitahuan instan di HP & Laptop</p>
                            </div>
                        </div>

                        <button onclick="window.PikrWebPush ? (PikrWebPush.isSubscribed ? PikrWebPush.unsubscribe() : PikrWebPush.subscribe()) : null"
                                class="btn-pikr-push-toggle w-full px-3.5 py-2 rounded-xl bg-white hover:bg-amber-400 text-slate-900 font-black text-xs transition-all flex items-center justify-center gap-2 shadow-sm cursor-pointer active:scale-95">
                            <i class="push-toggle-icon fas fa-bell text-amber-500"></i>
                            <span class="push-toggle-label">Aktifkan Notifikasi</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
            
            <!-- Controls Bar: Category Filter & Mark All Read -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-md p-4 sm:p-5 mb-6 space-y-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black uppercase tracking-wider text-slate-400">Filter Kategori</span>
                        @if($unreadCount > 0)
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-500 text-white text-[11px] font-black animate-pulse">
                                {{ $unreadCount }} Belum Dibaca
                            </span>
                        @endif
                    </div>

                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-check-double"></i>
                                <span>Tandai Semua Sudah Dibaca</span>
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Category Pills (Horizontal Scroll on Mobile) -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-thin">
                    <a href="{{ route('notifications.index', ['kategori' => 'semua']) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === 'semua' ? 'bg-[#17385c] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua ({{ $categoryCounts['semua'] ?? 0 }})
                    </a>

                    <a href="{{ route('notifications.index', ['kategori' => 'unread']) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === 'unread' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        ● Belum Dibaca ({{ $categoryCounts['unread'] ?? 0 }})
                    </a>

                    <a href="{{ route('notifications.index', ['kategori' => 'prestasi']) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === 'prestasi' ? 'bg-amber-500 text-slate-950 shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        🏆 Prestasi ({{ $categoryCounts['prestasi'] ?? 0 }})
                    </a>

                    <a href="{{ route('notifications.index', ['kategori' => 'jejak_bakti']) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === 'jejak_bakti' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        👑 Jejak Bakti ({{ $categoryCounts['jejak_bakti'] ?? 0 }})
                    </a>

                    <a href="{{ route('notifications.index', ['kategori' => 'kegiatan']) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === 'kegiatan' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        📅 Kegiatan ({{ $categoryCounts['kegiatan'] ?? 0 }})
                    </a>

                    <a href="{{ route('notifications.index', ['kategori' => 'artikel']) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === 'artikel' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        📰 Artikel / Berita ({{ $categoryCounts['artikel'] ?? 0 }})
                    </a>

                    <a href="{{ route('notifications.index', ['kategori' => 'pengumuman']) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === 'pengumuman' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        📢 Pengumuman ({{ $categoryCounts['pengumuman'] ?? 0 }})
                    </a>
                </div>

            </div>

            <!-- Notifications List -->
            <div class="space-y-3">
                @forelse($notifications as $notif)
                    <div class="bg-white rounded-2xl border transition-all duration-200 p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs hover:shadow-md {{ $notif->is_read ? 'border-slate-200/70 opacity-90' : 'border-blue-300/80 bg-blue-50/20' }}">
                        
                        <div class="flex items-start gap-3.5 sm:gap-4 min-w-0 flex-1">
                            <!-- Icon -->
                            <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-2xs mt-0.5 sm:mt-0 {{ $notif->is_read ? 'bg-slate-100 text-slate-500' : 'bg-[#17385c] text-amber-400' }}">
                                <i class="{{ $notif->type_icon }} text-base"></i>
                            </div>

                            <!-- Content -->
                            <div class="min-w-0 flex-1 space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    @if(!$notif->is_read)
                                        <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0" title="Belum Dibaca"></span>
                                    @endif

                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider border {{ $notif->type_badge_class }}">
                                        {{ $notif->type_label }}
                                    </span>

                                    <span class="text-[11px] text-slate-400 font-medium">
                                        {{ $notif->created_at ? $notif->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>

                                <h3 class="text-sm sm:text-base font-black text-slate-900 leading-snug">
                                    {{ $notif->title }}
                                </h3>

                                <p class="text-xs text-slate-600 leading-relaxed font-normal">
                                    {{ $notif->message }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex items-center gap-2 w-full sm:w-auto justify-end pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                            @if($notif->url)
                                <a href="{{ route('notifications.read', $notif->id) }}"
                                   class="px-4 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 w-full sm:w-auto shadow-xs {{ $notif->is_read ? 'bg-slate-100 hover:bg-slate-200 text-slate-700' : 'bg-[#17385c] hover:bg-[#102742] text-white' }}">
                                    <span>Lihat Konten</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            @else
                                <span class="text-xs text-slate-400 italic">Informasi</span>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl border border-dashed border-slate-200 p-12 text-center text-slate-400 space-y-3">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center text-2xl mx-auto shadow-inner">
                            <i class="fas fa-bell-slash"></i>
                        </div>
                        <h4 class="font-extrabold text-slate-700 text-base">Tidak Ada Notifikasi</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">
                            Belum ada pemberitahuan baru pada kategori ini. Notifikasi akan otomatis muncul setiap ada konten baru yang dipublikasikan.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $notifications->links() }}
                </div>
            @endif

        </div>

    </div>
</x-layouts.app>
