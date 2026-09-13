<x-layouts.app title="Form Pendaftaran Anggota | PIK-R REQUEST">
    <div class="min-h-screen py-20 bg-[#fdfdfd] relative overflow-hidden font-sans">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-blue-50 rounded-full blur-[120px] opacity-40"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/4 bg-slate-100 rounded-full blur-[100px] opacity-60"></div>

        <div class="relative z-10 max-w-2xl mx-auto px-6">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-12 lg:p-16">
                <!-- Header -->
                <div class="text-center mb-12">
                    <img src="{{ asset('assets/img/logo_utama.png') }}" alt="Logo" class="w-16 h-16 mx-auto mb-8 object-contain">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-3">Formulir Pendaftaran</h1>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed max-w-md mx-auto">
                        Silahkan lengkapi data diri kamu di bawah ini untuk menjadi bagian dari pengurus PIK-R.
                    </p>
                </div>

                <!-- Form -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <!-- Honeypot field (hidden from humans) -->
                    <div class="hidden" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    
                    @if ($errors->any())
                        <div class="bg-rose-50 border border-rose-100 p-4 rounded-2xl mb-6">
                            <p class="text-xs font-bold text-rose-600 mb-2">Harap periksa kesalahan berikut:</p>
                            <ul class="list-disc list-inside text-[11px] text-rose-500 font-medium space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-700 ml-1 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="block w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[20px] text-sm text-slate-800 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500/30 transition-all"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-700 ml-1 uppercase tracking-widest">Email Aktif</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="block w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[20px] text-sm text-slate-800 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500/30 transition-all"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-700 ml-1 uppercase tracking-widest">Nomor WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="block w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[20px] text-sm text-slate-800 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500/30 transition-all"
                            placeholder="0812xxxx">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-700 ml-1 uppercase tracking-widest">Alasan Bergabung</label>
                        <textarea name="reason" rows="4" required
                            class="block w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[20px] text-sm text-slate-800 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500/30 transition-all"
                            placeholder="Apa motivasi kamu bergabung dengan PIK-R?">{{ old('reason') }}</textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#1e40af] hover:bg-blue-800 text-white font-black text-[13px] uppercase tracking-widest py-5 rounded-[20px] shadow-xl shadow-blue-900/10 transition-all active:scale-[0.98]">
                            Kirim Pendaftaran
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center pt-8 border-t border-slate-50">
                    <p class="text-[11px] text-slate-400 font-medium">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 font-bold hover:underline">Masuk Dashboard</a>
                    </p>
                </div>
            </div>

            <!-- Back link -->
            <div class="text-center mt-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-slate-600 transition-all">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
