<x-layouts.app title="Pendaftaran Berhasil | PIK-R REQUEST">
    <div class="min-h-screen flex items-center justify-center bg-[#fdfdfd] relative overflow-hidden font-sans">
        <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-emerald-50 rounded-full blur-[120px] opacity-40"></div>
        
        <div class="relative z-10 max-w-lg w-full px-6 text-center" data-aos="zoom-in">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-12 lg:p-16">
                <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-10 shadow-inner">
                    <i class="fas fa-check text-3xl text-emerald-500"></i>
                </div>

                <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-4">Pendaftaran Berhasil!</h1>
                <p class="text-slate-500 text-sm leading-relaxed mb-10">
                    Terima kasih telah mendaftar. Data kamu sudah kami terima dan sedang dalam tahap peninjauan oleh <span class="text-slate-800 font-bold text-emerald-600">Pembina PIK-R</span>.
                </p>

                <div class="bg-slate-50 rounded-2xl p-6 mb-10 text-left">
                    <div class="flex items-start gap-4">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                            Kami akan membuatkan akun untukmu setelah verifikasi selesai. Informasi akun akan dikirimkan melalui Email atau WhatsApp yang kamu daftarkan.
                        </p>
                    </div>
                </div>

                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 px-10 py-4 bg-[#1e40af] hover:bg-blue-800 text-white font-black text-[11px] uppercase tracking-[0.15em] rounded-2xl shadow-xl shadow-blue-900/10 transition-all active:scale-95">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
