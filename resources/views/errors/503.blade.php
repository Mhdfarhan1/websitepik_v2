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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Subtle grid background */
        .bg-grid {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }

        /* Ambient Glow animation */
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.65; transform: scale(1.1); }
        }

        .ambient-glow {
            animation: pulseGlow 10s ease-in-out infinite;
        }

        /* Subtle Shimmer for progress line */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }

        .shimmer-bar {
            position: relative;
            overflow: hidden;
        }

        .shimmer-bar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2.2s infinite;
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden bg-[#0a0f1d] text-slate-200 antialiased flex flex-col justify-between p-6 sm:p-10 relative selection:bg-blue-600 selection:text-white">

    <!-- Ambient Lighting (Ultra-refined soft backlights) -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="ambient-glow absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-blue-600/15 rounded-full blur-[120px]"></div>
        <div class="ambient-glow absolute bottom-1/4 left-1/3 w-[500px] h-[350px] bg-indigo-500/10 rounded-full blur-[140px]" style="animation-delay: -5s;"></div>
        <div class="absolute inset-0 bg-grid pointer-events-none"></div>
    </div>

    <!-- Top Navigation / Branding -->
    <header class="relative z-10 w-full max-w-5xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 p-2 flex items-center justify-center backdrop-blur-md shadow-sm">
                <img src="{{ asset('assets/img/logo_utama.png') }}" 
                     alt="Logo" 
                     class="w-full h-full object-contain"
                     onerror="this.onerror=null; this.src='/assets/img/logo_utama.png';">
            </div>
            <div>
                <span class="text-xs font-black tracking-wider uppercase text-white block">PIK-R REQUEST</span>
                <span class="text-[10px] font-semibold text-slate-400 block tracking-tight">SMAN 1 Tasik Putri Puyu</span>
            </div>
        </div>

        <a href="{{ route('login') }}" 
           class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <i class="fas fa-lock text-[10px] text-slate-400"></i>
            <span>Akses Admin</span>
        </a>
    </header>

    <!-- Centerpiece Content -->
    <main class="relative z-10 w-full max-w-2xl mx-auto text-center my-auto px-4 py-8">
        
        <!-- Status Pill -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-blue-300 text-xs font-bold mb-8 backdrop-blur-md">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            <span>Pemeliharaan Sistem Terjadwal</span>
        </div>

        <!-- Sleek Headline -->
        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-[1.15] mb-5">
            Website Sedang Dalam <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-white to-indigo-200">
                Peningkatan Layanan
            </span>
        </h1>

        <!-- Elegant Description -->
        <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-lg mx-auto font-normal mb-8">
            Kami sedang memperbarui sistem, mengoptimalkan kecepatan server, dan memperkuat keamanan data untuk kenyamanan sahabat PIK-R REQUEST.
        </p>

        <!-- Subtle Shimmer Progress Indicator -->
        <div class="max-w-md mx-auto mb-10">
            <div class="flex items-center justify-between text-[11px] font-semibold text-slate-400 mb-2 px-1">
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-circle-notch fa-spin text-blue-400 text-[10px]"></i>
                    <span>Optimalisasi performa & database</span>
                </span>
                <span class="text-blue-300 font-mono">Status: Aktif</span>
            </div>
            <div class="w-full h-1.5 rounded-full bg-white/5 border border-white/10 overflow-hidden shimmer-bar">
                <div class="h-full bg-gradient-to-r from-blue-500 via-indigo-400 to-cyan-400 w-3/4 rounded-full"></div>
            </div>
        </div>

        <!-- Sleek Actions (Subtle & Refined) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="window.location.reload();" 
                    class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white text-slate-950 hover:bg-slate-100 font-bold text-xs uppercase tracking-wider transition-all hover:scale-[1.02] active:scale-95 shadow-lg shadow-white/5 flex items-center justify-center gap-2 cursor-pointer">
                <i class="fas fa-rotate-right text-xs text-slate-900" id="refresh-icon"></i>
                <span>Cek Kembali Sekarang</span>
            </button>

            <a href="https://wa.me/6281234567890?text=Halo%20Kak%20Konselor%20PIK-R%2C%20saya%20ingin%20bercerita" 
               target="_blank"
               class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                <i class="fab fa-whatsapp text-emerald-400 text-sm"></i>
                <span>Konseling Darurat</span>
            </a>
        </div>

    </main>

    <!-- Bottom Footer -->
    <footer class="relative z-10 w-full max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-500 font-medium">
        <div class="flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            <span>Pengecekan otomatis dalam <span class="font-mono text-slate-300" id="timer-count">30</span> detik</span>
        </div>
        <div>
            <span>&copy; {{ date('Y') }} PIK-R REQUEST • Generasi Berencana</span>
        </div>
    </footer>

    <!-- Auto Refresh Timer Script -->
    <script>
        let countdown = 30;
        const timerElement = document.getElementById('timer-count');
        const refreshIcon = document.getElementById('refresh-icon');

        const interval = setInterval(() => {
            countdown--;
            if (timerElement) timerElement.innerText = countdown;
            if (countdown <= 0) {
                clearInterval(interval);
                if (refreshIcon) refreshIcon.classList.add('fa-spin');
                window.location.reload();
            }
        }, 1000);
    </script>
</body>
</html>
