<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Sedang Dalam Pemeliharaan | PIK-R REQUEST</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_utama.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.08); }
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .glow-orb {
            animation: pulse-glow 8s ease-in-out infinite;
        }

        .spin-slow {
            animation: spin-slow 25s linear infinite;
        }

        /* Glassmorphism */
        .glass-panel {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .glass-pill {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#081325] via-[#11294a] to-[#17385c] text-white flex items-center justify-center p-4 sm:p-6 lg:p-8 relative overflow-x-hidden selection:bg-amber-500 selection:text-white">

    <!-- Decorative Background Orbs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="glow-orb absolute -top-32 -left-32 w-96 h-96 bg-blue-600/25 rounded-full blur-3xl"></div>
        <div class="glow-orb absolute -bottom-40 -right-40 w-[30rem] h-[30rem] bg-amber-500/20 rounded-full blur-3xl" style="animation-delay: -3s;"></div>
        <div class="glow-orb absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-cyan-500/15 rounded-full blur-3xl" style="animation-delay: -5s;"></div>
        
        <!-- Subtle Pattern Grid Overlay -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-3xl my-auto">
        <div class="glass-panel rounded-[2.5rem] p-8 sm:p-12 lg:p-14 shadow-2xl shadow-black/40 text-center relative overflow-hidden">
            
            <!-- Corner Accent Light -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-gradient-to-br from-amber-400/30 to-transparent rounded-full blur-2xl pointer-events-none"></div>

            <!-- Top Logo with Glowing Rings -->
            <div class="flex justify-center mb-8 relative">
                <div class="relative">
                    <!-- Spinning decorative border ring -->
                    <div class="absolute -inset-2.5 rounded-full border border-dashed border-amber-400/40 spin-slow"></div>
                    <div class="absolute -inset-5 rounded-full border border-blue-400/20"></div>
                    
                    <!-- Glowing Backing -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-amber-500 to-blue-600 rounded-full blur-xl opacity-60"></div>
                    
                    <!-- Logo Container -->
                    <div class="floating relative w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-white p-3.5 shadow-2xl flex items-center justify-center border-2 border-white/80">
                        <img src="{{ asset('assets/img/logo_utama.png') }}" 
                             alt="Logo PIK-R REQUEST" 
                             class="w-full h-full object-contain drop-shadow"
                             onerror="this.onerror=null; this.src='/assets/img/logo_utama.png';">
                    </div>
                </div>
            </div>

            <!-- Organization Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-pill text-xs font-black uppercase tracking-widest text-amber-300 mb-6 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                <span>PIK-R REQUEST • SMAN 1 TASIK PUTRI PUYU</span>
            </div>

            <!-- Title & Status -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight text-white mb-4">
                Sistem Sedang Dalam <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-400 to-orange-400">
                    Peningkatan & Pemeliharaan
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-blue-100/90 text-sm sm:text-base leading-relaxed max-w-xl mx-auto font-medium mb-8">
                Kami sedang melakukan optimalisasi performa hosting, sinkronisasi storage media, dan pembaruan sistem keamanan agar website PIK-R REQUEST semakin cepat, responsif, dan nyaman digunakan.
            </p>

            <!-- 3 Highlights Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 text-left">
                <div class="glass-pill p-4 rounded-2xl border border-white/10 hover:border-white/20 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-base mb-2.5">
                        <i class="fas fa-server"></i>
                    </div>
                    <h4 class="text-xs font-extrabold text-white">Optimalisasi Server</h4>
                    <p class="text-[11px] text-blue-200/70 mt-0.5 leading-snug">Migrasi dan sinkronisasi kapasitas storage cPanel.</p>
                </div>

                <div class="glass-pill p-4 rounded-2xl border border-white/10 hover:border-white/20 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-base mb-2.5">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="text-xs font-extrabold text-white">Peningkatan Akses</h4>
                    <p class="text-[11px] text-blue-200/70 mt-0.5 leading-snug">Akselerasi loading foto modern format WebP.</p>
                </div>

                <div class="glass-pill p-4 rounded-2xl border border-white/10 hover:border-white/20 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-base mb-2.5">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="text-xs font-extrabold text-white">Privasi Terjaga</h4>
                    <p class="text-[11px] text-blue-200/70 mt-0.5 leading-snug">Pembaruan enkripsi data konseling siswa.</p>
                </div>
            </div>

            <!-- Emergency Counseling Callout & Action Buttons -->
            <div class="p-5 rounded-2xl bg-white/5 border border-white/10 mb-8 text-xs text-blue-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-left">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg shrink-0">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-white">Butuh Konseling Sebaya Mendesak?</p>
                        <p class="text-[11px] text-slate-300">Konselor kami tetap siap mendengar ceritamu secara rahasia.</p>
                    </div>
                </div>
                <a href="https://wa.me/6281234567890?text=Halo%20Kak%20Konselor%20PIK-R%2C%20saya%20ingin%20bercerita" 
                   target="_blank" 
                   class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/20 transition-all hover:scale-105 shrink-0 flex items-center gap-2">
                    <i class="fab fa-whatsapp text-sm"></i>
                    <span>Hubungi Konselor</span>
                </a>
            </div>

            <!-- Interactive Refresh Button with Countdown -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <button onclick="window.location.reload();" 
                        class="w-full sm:w-auto px-7 py-3.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider shadow-xl shadow-amber-500/25 transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2.5 cursor-pointer">
                    <i class="fas fa-rotate-right" id="refresh-icon"></i>
                    <span>Coba Muat Ulang Halaman</span>
                </button>

                <a href="{{ route('login') }}" 
                   class="w-full sm:w-auto px-5 py-3.5 glass-pill hover:bg-white/20 text-white/80 hover:text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-user-shield text-xs"></i>
                    <span>Akses Pengurus / Admin</span>
                </a>
            </div>

            <!-- Footer Meta -->
            <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] font-semibold text-slate-400">
                <span id="auto-refresh-timer">Pengecekan otomatis dalam <strong class="text-amber-300" id="timer-count">30</strong> detik...</span>
                <span>&copy; {{ date('Y') }} PIK-R REQUEST • Generasi Berencana</span>
            </div>

        </div>
    </div>

    <!-- Auto Refresh Countdown Script -->
    <script>
        let countdown = 30;
        const timerElement = document.getElementById('timer-count');
        const refreshIcon = document.getElementById('refresh-icon');

        const interval = setInterval(() => {
            countdown--;
            if (timerElement) {
                timerElement.innerText = countdown;
            }
            if (countdown <= 0) {
                clearInterval(interval);
                if (refreshIcon) refreshIcon.classList.add('animate-spin');
                window.location.reload();
            }
        }, 1000);
    </script>
</body>
</html>
