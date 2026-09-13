<x-layouts.dashboard title="Ganti Password">
    <div class="mb-10">
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Keamanan Akun</h1>
        <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-widest text-brand">Perbarui Password Anda</p>
    </div>

    @if(session('warning'))
        <div class="mb-8 p-6 bg-amber-50 border border-amber-100 rounded-[24px] flex items-start gap-4 animate-fade-in shadow-sm shadow-amber-500/5">
            <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center shrink-0 shadow-lg shadow-amber-500/20">
                <i class="fas fa-shield-alt text-white"></i>
            </div>
            <div>
                <h4 class="text-sm font-black text-amber-800 uppercase tracking-widest">Langkah Keamanan Wajib</h4>
                <p class="text-xs text-amber-600/80 mt-1 font-medium">{{ session('warning') }}</p>
            </div>
        </div>
    @endif

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[32px] border border-slate-100 shadow-xl shadow-slate-500/5 overflow-hidden relative">
            <!-- Blue Accent Top -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-blue-600"></div>

            <div class="p-8 lg:p-12">
                <form action="{{ route('dashboard.password.update') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Password Saat Ini (Default)</label>
                            <div class="relative group">
                                <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs group-focus-within:text-blue-600 transition-colors"></i>
                                <input type="password" name="current_password" required
                                    class="w-full bg-slate-50/50 border-slate-200 border rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500/20 transition-all outline-none"
                                    placeholder="••••••••">
                            </div>
                            @error('current_password')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Password Baru</label>
                            <div class="relative group">
                                <i class="fas fa-key absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs group-focus-within:text-blue-600 transition-colors"></i>
                                <input type="password" name="password" required
                                    class="w-full bg-slate-50/50 border-slate-200 border rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500/20 transition-all outline-none"
                                    placeholder="Min. 8 karakter">
                            </div>
                            @error('password')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Konfirmasi Password Baru</label>
                            <div class="relative group">
                                <i class="fas fa-check-double absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs group-focus-within:text-blue-600 transition-colors"></i>
                                <input type="password" name="password_confirmation" required
                                    class="w-full bg-slate-50/50 border-slate-200 border rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500/20 transition-all outline-none"
                                    placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-2xl py-5 text-xs font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        Simpan Password Baru
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <p class="text-center mt-10 text-[10px] font-black text-slate-300 uppercase tracking-widest leading-loose px-10">
            Pastikan password Anda kuat dengan kombinasi huruf, angka, dan simbol untuk melindungi data pribadi Anda di platform PIK-R REQUEST.
        </p>
    </div>
</x-layouts.dashboard>
