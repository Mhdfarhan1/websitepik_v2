<div class="relative inline-block" 
     x-data="pikrNavbarBell()" 
     @click.away="open = false" 
     @keydown.escape.window="open = false">
    
    <!-- Bell Button -->
    <button type="button"
            @click="open = !open; if(open) fetchRecent();" 
            class="relative w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 flex items-center justify-center transition-all cursor-pointer border border-slate-100 shadow-xs active:scale-95 focus:outline-none"
            title="Pusat Notifikasi">
        <i class="fas fa-bell text-base sm:text-lg"></i>
        
        <!-- Unread Badge -->
        <span x-show="unreadCount > 0" 
              x-text="unreadCount > 99 ? '99+' : unreadCount"
              x-cloak
              class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-rose-500 text-white font-black text-[9px] flex items-center justify-center shadow-md animate-pulse border-2 border-white">
        </span>
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute right-0 mt-2.5 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200/90 overflow-hidden z-[120] flex flex-col">
        
        <!-- Dropdown Header -->
        <div class="p-3.5 sm:p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-bell text-amber-500 text-xs"></i>
                <h4 class="font-extrabold text-xs sm:text-sm text-slate-800">Notifikasi</h4>
                <span x-show="unreadCount > 0" class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 font-extrabold text-[10px]" x-text="unreadCount + ' Baru'" x-cloak></span>
            </div>

            <template x-if="unreadCount > 0">
                <button type="button" @click="markAllRead()" class="text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors cursor-pointer">
                    Tandai dibaca
                </button>
            </template>
        </div>

        <!-- Notification List -->
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 text-slate-700">
            <template x-if="loading">
                <div class="p-6 text-center text-slate-400 space-y-2">
                    <i class="fas fa-circle-notch fa-spin text-base text-blue-600"></i>
                    <p class="text-xs">Memuat notifikasi...</p>
                </div>
            </template>

            <template x-if="!loading && notifications.length === 0">
                <div class="p-6 text-center text-slate-400 space-y-2">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 text-sm">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-600">Belum ada notifikasi</p>
                    <p class="text-[11px] text-slate-400">Pembaruan prestasi dan kegiatan akan muncul di sini.</p>
                </div>
            </template>

            <template x-for="item in notifications" :key="item.id">
                <a :href="item.read_url" 
                   class="block p-3 sm:p-3.5 hover:bg-slate-50 transition-colors relative group"
                   :class="!item.is_read ? 'bg-blue-50/40' : ''">
                    <div class="flex items-start gap-3">
                        <!-- Icon -->
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 shadow-2xs mt-0.5"
                             :class="!item.is_read ? 'bg-[#17385c] text-amber-400' : 'bg-slate-100 text-slate-500'">
                            <i :class="item.type_icon" class="text-xs"></i>
                        </div>

                        <!-- Content -->
                        <div class="min-w-0 flex-1 space-y-0.5">
                            <div class="flex items-center justify-between gap-1">
                                <span class="text-[9px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded border"
                                      :class="item.type_badge"
                                      x-text="item.type_label"></span>
                                <span class="text-[10px] text-slate-400" x-text="item.time_ago"></span>
                            </div>
                            <h5 class="text-xs font-bold text-slate-800 leading-snug line-clamp-1 group-hover:text-blue-700 transition-colors"
                                x-text="item.title"></h5>
                            <p class="text-[11px] text-slate-500 leading-tight line-clamp-2"
                               x-text="item.message"></p>
                        </div>

                        <!-- Unread Dot -->
                        <template x-if="!item.is_read">
                            <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0 mt-1"></span>
                        </template>
                    </div>
                </a>
            </template>
        </div>

        <!-- Dropdown Footer -->
        <div class="p-2.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between px-4">
            <button type="button" 
                    onclick="if(window.PikrWebPush){ PikrWebPush.subscribe(); }" 
                    class="text-[11px] font-bold text-amber-600 hover:text-amber-700 flex items-center gap-1.5 transition-colors cursor-pointer">
                <i class="fas fa-mobile-alt"></i>
                <span>Push di HP</span>
            </button>

            <a href="{{ route('notifications.index') }}" 
               class="inline-flex items-center justify-center gap-1 text-xs font-bold text-slate-700 hover:text-brand py-1 transition-colors">
                <span>Lihat Semua</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>
