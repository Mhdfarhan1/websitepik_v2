<x-layouts.dashboard title="Dashboard Anggota | PIK-R">
    <div class="mb-10">
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Dashboard Anggota</h1>
        <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-widest text-emerald-600">Pusat Informasi Anggota Aktif</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Welcome Card -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[32px] border border-slate-100 shadow-xl shadow-slate-500/5 p-8 lg:p-12 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full -mr-32 -mt-32 transition-transform group-hover:scale-110 duration-700"></div>
                
                <div class="relative z-10">
                    <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-100">Akun Terverifikasi</span>
                    <h2 class="text-3xl font-black text-slate-800 mt-6 leading-tight">Selamat Datang Kembali,<br><span class="text-emerald-600">{{ auth()->user()->name }}</span></h2>
                    <p class="text-slate-500 mt-4 leading-relaxed font-medium">Terima kasih telah bergabung dengan PIK-R REQUEST. Saat ini akun Anda telah aktif sebagai anggota resmi. Anda dapat memantau informasi terbaru melalui website utama atau berkonsultasi melalui layanan yang tersedia.</p>
                    
                    <div class="mt-10 flex flex-wrap gap-4">
                        <a href="{{ url('/') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20 active:scale-95">Lihat Website Utama</a>
                        <a href="{{ route('dashboard.password.index') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95">Pengaturan Keamanan</a>
                    </div>
                </div>
            </div>

            <!-- Basic Info Card -->
            <div class="bg-white rounded-[32px] border border-slate-100 shadow-xl shadow-slate-500/5 p-8">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Informasi Keanggotaan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Email Terdaftar</p>
                        <p class="text-sm font-bold text-slate-700">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Bergabung</p>
                        <p class="text-sm font-bold text-slate-700">{{ auth()->user()->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Info -->
        <div class="space-y-8">
            <div class="bg-emerald-600 rounded-[32px] p-8 text-white shadow-xl shadow-emerald-500/20 relative overflow-hidden">
                <i class="fas fa-quote-left absolute top-4 right-6 text-emerald-500/30 text-6xl"></i>
                <h4 class="text-sm font-black uppercase tracking-widest mb-4 relative z-10">Pesan Hari Ini</h4>
                <p class="text-emerald-50 font-medium italic leading-relaxed relative z-10">"Remaja yang sehat adalah remaja yang berani mengambil keputusan tepat untuk masa depannya."</p>
                <div class="mt-8 pt-8 border-t border-emerald-500/30">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Salam Genre!</p>
                </div>
            </div>

            <div class="bg-white rounded-[32px] border border-slate-100 shadow-xl shadow-slate-500/5 p-8 text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mx-auto mb-6">
                    <i class="fas fa-headset text-2xl"></i>
                </div>
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-2">Butuh Bantuan?</h4>
                <p class="text-xs text-slate-400 font-medium leading-relaxed mb-6">Jika Anda memiliki pertanyaan mengenai sistem atau kegiatan, silakan hubungi pengurus.</p>
                <a href="#" class="block w-full py-4 bg-blue-50 text-blue-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-100 transition-all">Hubungi Admin</a>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
