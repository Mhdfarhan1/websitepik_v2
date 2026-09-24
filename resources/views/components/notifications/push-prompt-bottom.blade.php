<!-- Floating Bottom Push Notification Permission Prompt -->
<div x-data="pikrPushPromptBottom()" 
     x-init="initPrompt()" 
     x-show="show" 
     x-cloak
     x-transition:enter="transition ease-out duration-500 transform"
     x-transition:enter-start="opacity-0 translate-y-12 scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-300 transform"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-12 scale-95"
     class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:bottom-6 z-[999] max-w-sm sm:max-w-md w-auto">
    
    <div class="relative bg-white/95 backdrop-blur-xl border border-slate-200/90 rounded-3xl p-5 sm:p-6 shadow-2xl shadow-slate-900/15 overflow-hidden">
        
        <!-- Decorative Accent Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 via-amber-500 to-indigo-600"></div>

        <!-- Close Button (Nanti) -->
        <button type="button" 
                @click="dismissPrompt()" 
                class="absolute top-3.5 right-3.5 w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors text-xs cursor-pointer"
                title="Tutup">
            <i class="fas fa-times"></i>
        </button>

        <!-- STATE 1: Default Question Prompt -->
        <template x-if="state === 'prompt'">
            <div class="space-y-4">
                <div class="flex items-start gap-3.5 pr-6">
                    <!-- Icon / Logo PIK-R -->
                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200/60 p-2 flex items-center justify-center shadow-xs">
                            <img src="{{ asset('assets/img/Logo_pikr.png') }}" 
                                 alt="Logo PIK-R REQUEST" 
                                 class="w-full h-full object-contain"
                                 onerror="this.src='/assets/img/logo_utama.png'">
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-amber-500 text-slate-950 text-[10px] font-black flex items-center justify-center shadow-xs animate-bounce">
                            <i class="fas fa-bell"></i>
                        </span>
                    </div>

                    <!-- Texts -->
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200/70 text-[9px] font-black uppercase tracking-wider">
                                NOTIFIKASI WEBSITE
                            </span>
                        </div>
                        <h4 class="text-sm sm:text-base font-extrabold text-slate-800 leading-snug mt-1">
                            Aktifkan Notifikasi PIK-R?
                        </h4>
                    </div>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed">
                    Dapatkan kabar langsung saat ada <strong>Prestasi baru 🏆</strong>, <strong>Rekam Jejak Duta GenRe 👑</strong>, dan <strong>Agenda Kegiatan 📅</strong> di HP atau browsermu.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col-reverse sm:flex-row items-center gap-2 pt-1">
                    <button type="button" 
                            @click="dismissPrompt()" 
                            class="w-full sm:w-auto flex-1 px-4 py-2.5 rounded-2xl border border-slate-200 hover:bg-slate-100 text-slate-600 font-bold text-xs transition-all text-center cursor-pointer">
                        Nanti Saja
                    </button>

                    <button type="button" 
                            @click="enablePush()" 
                            class="w-full sm:w-auto flex-1 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-extrabold text-xs shadow-lg shadow-blue-600/25 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fas fa-bell"></i>
                        <span>Izinkan Notifikasi</span>
                    </button>
                </div>
            </div>
        </template>

        <!-- STATE 2: Loading Processing -->
        <template x-if="state === 'loading'">
            <div class="py-4 text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto text-xl animate-spin">
                    <i class="fas fa-circle-notch"></i>
                </div>
                <h5 class="text-sm font-extrabold text-slate-800">Menghubungkan Perangkat...</h5>
                <p class="text-xs text-slate-400">Silakan klik "Allow" atau "Izinkan" jika browser meminta konfirmasi.</p>
            </div>
        </template>

        <!-- STATE 3: Success -->
        <template x-if="state === 'success'">
            <div class="py-3 text-center space-y-2">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto text-xl shadow-xs">
                    <i class="fas fa-check"></i>
                </div>
                <h5 class="text-sm font-extrabold text-emerald-700">Notifikasi Berhasil Diaktifkan! 🔔</h5>
                <p class="text-xs text-slate-500">Terima kasih! Kamu akan menerima info update resmi dari PIK-R REQUEST.</p>
            </div>
        </template>

        <!-- STATE 4: Denied / Blocked -->
        <template x-if="state === 'denied'">
            <div class="py-2 space-y-3 text-center">
                <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto text-sm">
                    <i class="fas fa-bell-slash"></i>
                </div>
                <h5 class="text-xs font-bold text-slate-800">Izin Notifikasi Belum Diaktifkan</h5>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Browser memblokir notifikasi. Kamu bisa mengaktifkannya kapan saja melalui ikon gembok di sebelah alamat web (address bar).
                </p>
                <button type="button" @click="show = false" class="px-4 py-1.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors">
                    Mengerti
                </button>
            </div>
        </template>

    </div>
</div>
