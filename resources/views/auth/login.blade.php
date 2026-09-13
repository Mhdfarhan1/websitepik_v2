<x-layouts.app title="Login | PIK-R REQUEST">
    <div class="min-h-screen relative flex items-center justify-center bg-[#f8fafc] text-slate-800 font-sans overflow-hidden py-12 px-4 sm:px-6 lg:px-8" x-data="{ showPassword: false }">
        
        <!-- Subtle Soft Blue Glow Blobs -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-200/50 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-sky-200/50 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-blue-100/30 rounded-full blur-[160px] pointer-events-none"></div>

        <!-- Floating Back Button (Top Left) -->
        <div class="absolute top-6 left-6 z-20">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-white hover:bg-slate-50 border border-slate-200/80 text-[#1b3c66] text-xs font-bold shadow-sm hover:shadow-md transition-all duration-200 group">
                <i class="fas fa-arrow-left text-xs transition-transform group-hover:-translate-x-1 text-blue-600"></i>
                <span>Beranda</span>
            </a>
        </div>

        <!-- Main Login Card Container -->
        <div class="relative z-10 w-full max-w-4xl mx-auto bg-white rounded-[2.5rem] border border-slate-200/80 shadow-[0_20px_50px_rgba(30,64,175,0.08)] overflow-hidden grid grid-cols-1 lg:grid-cols-12" data-aos="fade-up" data-aos-duration="800">
            
            <!-- Left Side: White & Blue Branding Panel (Visible on LG) -->
            <div class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-[#1b3c66] via-[#1e40af] to-[#2563eb] text-white p-10 flex-col justify-between relative overflow-hidden">
                <!-- Background Decorative Waves / Blobs -->
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10">
                    <!-- Brand Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 border border-white/20 text-white text-xs font-semibold backdrop-blur-md mb-8">
                        <i class="fas fa-sparkles text-amber-300"></i>
                        <span>Generasi Berencana</span>
                    </div>

                    <!-- Heading -->
                    <h1 class="text-3xl font-extrabold text-white leading-tight mb-4" style="font-family: 'Montserrat', sans-serif;">
                        PIK-R REQUEST
                    </h1>
                    <p class="text-blue-100 text-xs leading-relaxed mb-8">
                        Pusat Informasi dan Konseling Remaja SMAN 1 Tasik Putri Puyu. Wadah aspirasi, edukasi sebaya, dan konseling remaja.
                    </p>

                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white text-xs shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs font-medium text-blue-50">Layanan Konseling Sebaya</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white text-xs shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs font-medium text-blue-50">Edukasi Kesehatan Remaja</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white text-xs shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs font-medium text-blue-50">Program Kerja & Kegiatan</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Quote -->
                <div class="relative z-10 pt-8 border-t border-white/15">
                    <p class="text-xs text-blue-100 italic" style="font-family: 'Dancing Script', cursive; font-size: 1.15rem;">
                        "Berencana itu Keren! Siapkan masa depanmu."
                    </p>
                </div>
            </div>

            <!-- Right Side: Clean White Form -->
            <div class="col-span-1 lg:col-span-7 p-8 sm:p-12 flex flex-col justify-center bg-white">
                
                <!-- Logo & Title -->
                <div class="flex flex-col items-center text-center mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 p-2.5 border border-blue-100 mb-4 flex items-center justify-center shadow-sm">
                        <img src="{{ asset('assets/img/logo_utama.png') }}" alt="Logo PIK-R" class="w-full h-full object-contain">
                    </div>
                    <h2 class="text-2xl font-bold text-[#1b3c66] tracking-tight">Selamat Datang 👋</h2>
                    <p class="text-slate-400 text-xs font-medium mt-1">Silakan masuk ke akun Anda</p>
                </div>

                <!-- Validation Error -->
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-700 p-3.5 rounded-2xl text-xs font-medium mb-6 flex items-center gap-2.5">
                        <i class="fas fa-exclamation-circle text-rose-500 text-sm shrink-0"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5" onsubmit="handleLoginSubmit(event)">
                    @csrf
                    
                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 ml-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 placeholder:text-slate-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all font-medium"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between px-1">
                            <label class="block text-xs font-bold text-slate-700">Password</label>
                            <button type="button" onclick="showForgotInfo()" class="text-[11px] font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                Lupa password?
                            </button>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-lock text-sm"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                class="block w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 placeholder:text-slate-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all font-medium"
                                placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" id="rem" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500/20">
                            <span class="text-xs text-slate-600 font-medium">Ingat saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="btnLoginSubmit" class="w-full bg-[#1e40af] hover:bg-blue-800 text-white font-bold text-sm py-3.5 rounded-2xl shadow-lg shadow-blue-900/10 hover:shadow-blue-900/20 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 group mt-2">
                        <span>Masuk</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-3 text-slate-400 font-medium">Belum punya akun?</span>
                    </div>
                </div>

                <!-- Register Action -->
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full py-3 px-4 rounded-2xl border border-blue-100 bg-blue-50/60 hover:bg-blue-50 text-blue-700 font-bold text-xs transition-all duration-200 gap-2">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Akun Baru</span>
                </a>

                <!-- Footer copyright -->
                <div class="mt-8 text-center pt-4 border-t border-slate-100">
                    <p class="text-[11px] text-slate-400 font-medium">
                        &copy; {{ date('Y') }} PIK-R REQUEST
                    </p>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function handleLoginSubmit(e) {
            const btn = document.getElementById('btnLoginSubmit');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i> <span>Memproses...</span>';
                btn.classList.add('opacity-80', 'cursor-not-allowed');
            }
            
            Swal.fire({
                title: 'Memproses Masuk...',
                text: 'Sedang memverifikasi akun Anda, mohon tunggu.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: 'rounded-3xl p-6',
                    title: 'text-lg font-bold text-[#1b3c66]'
                }
            });
        }

        function showForgotInfo() {
            Swal.fire({
                title: 'Lupa Password?',
                text: 'Silakan hubungi Pembina atau Admin PIK-R REQUEST SMAN 1 Tasik Putri Puyu untuk mereset password akun Anda.',
                icon: 'info',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#1e40af',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-2xl px-6 py-2.5 text-sm font-bold'
                }
            });
        }
    </script>
    @endpush

    @push('styles')
    <style>
        nav, footer, #main-nav, #topbar { display: none !important; }
        body { background-color: #f8fafc; }
    </style>
    @endpush
</x-layouts.app>
