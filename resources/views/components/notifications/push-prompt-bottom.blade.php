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
     class="fixed bottom-4 left-3 right-3 sm:left-auto sm:right-6 sm:bottom-6 z-[9999] max-w-sm sm:max-w-md w-auto mx-auto sm:mx-0">
    
    <div class="relative bg-white/95 backdrop-blur-xl border border-slate-200/90 rounded-3xl p-5 sm:p-6 shadow-2xl shadow-slate-900/20 overflow-hidden ring-1 ring-black/5">
        
        <!-- Decorative Accent Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 via-amber-500 to-indigo-600"></div>

        <!-- Close Button (Nanti) -->
        <button type="button" 
                @click="dismissPrompt()" 
                class="absolute top-3.5 right-3.5 w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors text-xs cursor-pointer z-10"
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
                            <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200/70 text-[9px] font-black uppercase tracking-wider">
                                NOTIFIKASI PIK-R
                            </span>
                        </div>
                        <h4 class="text-sm sm:text-base font-extrabold text-slate-800 leading-snug mt-1">
                            Aktifkan Notifikasi di HP Anda?
                        </h4>
                    </div>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed">
                    Dapatkan kabar langsung di status bar HP seperti notifikasi pesan saat ada <strong>Prestasi 🏆</strong>, <strong>Jejak Duta GenRe 👑</strong>, dan <strong>Agenda Baru 📅</strong>.
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
                            class="w-full sm:w-auto flex-1 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold text-xs shadow-lg shadow-blue-600/25 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fas fa-bell"></i>
                        <span>Izinkan Sekarang</span>
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
                <p class="text-xs text-slate-500">Silakan klik "Allow" atau "Izinkan" jika muncul dialog konfirmasi di browser HP.</p>
            </div>
        </template>

        <!-- STATE 3: Success -->
        <template x-if="state === 'success'">
            <div class="py-3 text-center space-y-2">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto text-xl shadow-xs">
                    <i class="fas fa-check"></i>
                </div>
                <h5 class="text-sm font-extrabold text-emerald-700">Notifikasi Berhasil Diaktifkan! 🔔</h5>
                <p class="text-xs text-slate-500">Perangkat Anda telah terhubung. Cek status bar HP Anda untuk melihat notifikasi selamat datang.</p>
            </div>
        </template>

        <!-- STATE 4: Denied / Blocked by Browser -->
        <template x-if="state === 'denied'">
            <div class="py-2 space-y-3 text-center">
                <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto text-sm">
                    <i class="fas fa-bell-slash"></i>
                </div>
                <h5 class="text-xs font-bold text-slate-800">Izin Notifikasi Diblokir di Browser HP</h5>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Browser Anda saat ini memblokir notifikasi. Untuk mengaktifkan:
                    <br>
                    <span class="font-semibold text-slate-700">Ketuk ikon gembok 🔒 di samping alamat web &gt; Izin Situs &gt; Izinkan Notifikasi</span>.
                </p>
                <div class="flex items-center justify-center gap-2 pt-1">
                    <button type="button" @click="dismissPrompt()" class="px-4 py-1.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors">
                        Tutup
                    </button>
                    <button type="button" @click="enablePush()" class="px-4 py-1.5 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition-colors">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </template>

        <!-- STATE 5: Unsupported OEM Browser (Vivo / Oppo / Webview) -->
        <template x-if="state === 'unsupported'">
            <div class="py-2 space-y-3 text-center">
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto text-sm">
                    <i class="fab fa-chrome"></i>
                </div>
                <h5 class="text-xs font-bold text-slate-800">Buka Melalui Google Chrome di HP</h5>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Browser bawaan HP ini belum mendukung Web Push Notifikasi langsung. Untuk menerima notifikasi seperti WhatsApp di HP, silakan buka website ini melalui aplikasi <strong>Google Chrome di HP</strong>.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-2 pt-1">
                    <button type="button" 
                            @click="openInChrome()" 
                            class="w-full sm:w-auto flex-1 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-extrabold text-xs shadow-md shadow-blue-600/20 hover:from-blue-700 hover:to-indigo-700 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fab fa-chrome"></i>
                        <span>Buka di Google Chrome</span>
                    </button>
                    <button type="button" 
                            @click="copyUrl()" 
                            class="w-full sm:w-auto px-3.5 py-2 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 font-bold text-xs transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                        <i :class="copied ? 'fas fa-check text-emerald-500' : 'fas fa-copy'"></i>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                    </button>
                </div>
            </div>
        </template>

        <!-- STATE 6: Insecure Context (Requires HTTPS) -->
        <template x-if="state === 'need_https'">
            <div class="py-2 space-y-3 text-center">
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto text-sm">
                    <i class="fas fa-lock"></i>
                </div>
                <h5 class="text-xs font-bold text-slate-800">Koneksi HTTPS Diperlukan</h5>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Fitur notifikasi di HP mewajibkan koneksi aman (HTTPS). Silakan beralih ke https:// untuk mengaktifkan notifikasi.
                </p>
                <button type="button" 
                        @click="redirectToHttps()" 
                        class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/20 transition-all">
                    Beralih ke HTTPS Sekarang 🔒
                </button>
            </div>
        </template>

    </div>
</div>

<script>
    if (typeof window.pikrPushPromptBottom === 'undefined') {
        window.pikrPushPromptBottom = function() {
            return {
                show: false,
                state: 'prompt',
                copied: false,
                initPrompt() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const forceShow = urlParams.has('notif') || urlParams.has('prompt') || urlParams.has('reset_push');

                    if (forceShow) {
                        try {
                            sessionStorage.removeItem('pikr_push_prompt_dismissed');
                            localStorage.removeItem('pikr_push_prompt_dismissed');
                        } catch (e) {}
                    } else {
                        try {
                            if (sessionStorage.getItem('pikr_push_prompt_dismissed')) {
                                return;
                            }
                        } catch (e) {}
                    }

                    // Safe check notification permission
                    let permission = 'default';
                    try {
                        if (typeof window.Notification !== 'undefined') {
                            permission = window.Notification.permission;
                        }
                    } catch (e) {}

                    // If already granted in browser or already subscribed, NEVER show popup on reload/relog!
                    if ((permission === 'granted' || localStorage.getItem('pikr_push_subscribed') === 'true') && !forceShow) {
                        return;
                    }

                    // If explicitly denied, don't nag user unless forced with ?notif=1
                    if (permission === 'denied' && !forceShow) {
                        return;
                    }

                    // Display prompt after a brief 700ms entrance delay only for undecided users
                    setTimeout(() => {
                        this.show = true;
                    }, 700);
                },
                dismissPrompt() {
                    this.show = false;
                    try {
                        sessionStorage.setItem('pikr_push_prompt_dismissed', 'true');
                    } catch (e) {}
                },
                redirectToHttps() {
                    window.location.href = window.location.href.replace('http:', 'https:');
                },
                copyUrl() {
                    try {
                        navigator.clipboard.writeText(window.location.href);
                        this.copied = true;
                        setTimeout(() => { this.copied = false; }, 2500);
                    } catch (e) {
                        alert('Link website: ' + window.location.href);
                    }
                },
                openInChrome() {
                    const currentUrl = window.location.href.replace(/^https?:\/\//, '');
                    const scheme = window.location.protocol.replace(':', '');
                    // Android Intent to open directly in Google Chrome
                    window.location.href = 'intent://' + currentUrl + '#Intent;scheme=' + scheme + ';package=com.android.chrome;end';
                },
                async enablePush() {
                    // Check if on insecure HTTP on live host
                    if (window.location.protocol === 'http:' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
                        this.state = 'need_https';
                        return;
                    }

                    // Check push support
                    const hasSW = 'serviceWorker' in navigator;
                    const hasPush = 'PushManager' in window;
                    const hasNotif = typeof window.Notification !== 'undefined';

                    if (!hasSW || !hasPush || !hasNotif) {
                        this.state = 'unsupported';
                        return;
                    }

                    this.state = 'loading';
                    try {
                        if (window.PikrWebPush) {
                            const success = await window.PikrWebPush.subscribe(true);
                            if (success) {
                                this.state = 'success';
                                try { sessionStorage.removeItem('pikr_push_prompt_dismissed'); } catch (e) {}
                                setTimeout(() => { this.show = false; }, 2600);
                            } else {
                                const perm = typeof window.Notification !== 'undefined' ? window.Notification.permission : '';
                                if (perm === 'denied') {
                                    this.state = 'denied';
                                } else if (!window.PikrWebPush.isSupported) {
                                    this.state = 'unsupported';
                                } else {
                                    this.state = 'prompt';
                                }
                            }
                        } else {
                            const permission = await Notification.requestPermission();
                            if (permission === 'granted') {
                                this.state = 'success';
                                setTimeout(() => { this.show = false; }, 2200);
                            } else if (permission === 'denied') {
                                this.state = 'denied';
                            } else {
                                this.state = 'prompt';
                            }
                        }
                    } catch (e) {
                        console.error('Error enabling push:', e);
                        this.state = 'prompt';
                    }
                }
            };
        };
    }
</script>
