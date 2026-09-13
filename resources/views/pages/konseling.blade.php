<x-layouts.app>
    <div class="relative min-h-screen bg-slate-50">
        
        <!-- Section 1: Hero Banner Layanan Konseling (100vh Full Screen Matching Gambar 2 Layout Exactly) -->
        <div class="relative w-full h-screen flex items-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                @php
                    $bgUrl = $heroSettings['hero_bg'] ?? '';
                    if($bgUrl && !str_starts_with($bgUrl, 'http')) {
                        $bgUrl = asset($bgUrl);
                    }
                @endphp
                <img src="{{ $bgUrl ?: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=1600' }}" alt="Layanan Konseling Background" class="w-full h-full object-cover object-center">
                
                <!-- Precise Dark Navy Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#17385c]/95 via-[#17385c]/85 to-blue-600/40"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20">
                <div class="max-w-2xl space-y-6 animate-fade-in-up">

                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white tracking-tight leading-tight">
                        {{ $heroSettings['hero_title_1'] ?? 'Layanan' }} <span class="text-[#f59e0b]">{{ $heroSettings['hero_title_2'] ?? 'Konseling Sebaya' }}</span>
                    </h1>
                    
                    <p class="text-slate-200 text-xs sm:text-sm leading-relaxed max-w-xl font-medium">
                        {{ $heroSettings['hero_desc'] ?? 'Tempat aman dan nyaman bagi seluruh siswa SMAN 1 Tasik Putri Puyu untuk berkonsultasi, curhat, serta mendapatkan bimbingan seputar kesehatan reproduksi, kesehatan mental, hingga perencanaan masa depan.' }}
                    </p>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="#form-konseling" class="px-6 py-3 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-xl font-bold text-xs transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2 active:scale-95">
                            <span>Form Pengajuan Konseling</span>
                            <i class="fas fa-paper-plane text-[10px]"></i>
                        </a>
                        <a href="#apa-itu-konseling" class="px-6 py-3 border-2 border-white text-white rounded-xl font-bold text-xs hover:bg-white hover:text-[#17385c] transition-all flex items-center gap-2 active:scale-95">
                            <span>Apa Itu Konseling?</span>
                            <i class="fas fa-info-circle text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Apa Itu Konseling Remaja? -->
        <div id="apa-itu-konseling" class="py-16 lg:py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 sm:gap-16 items-center">
                    
                    <!-- Text Area -->
                    <div class="space-y-6" data-aos="fade-right">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 border border-amber-100 text-[#f59e0b] rounded-full text-xs font-bold uppercase tracking-wider">
                            <i class="fas fa-user-shield"></i>
                            <span>Pilihan Curhat Teman Sebaya</span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            {{ $heroSettings['about_title'] ?? 'Apa Itu Konseling Remaja?' }}
                        </h2>

                        <div class="text-slate-600 text-xs sm:text-sm leading-relaxed space-y-4 font-medium">
                            <p>
                                {{ $heroSettings['about_desc'] ?? 'Konseling Remaja PIK-R REQUEST adalah bentuk pendampingan teman sebaya (Peer Counseling) yang dirancang untuk membantu remaja SMAN 1 Tasik Putri Puyu dalam menghadapi berbagai tantangan masa remaja.' }}
                            </p>
                            <p class="p-4 bg-slate-50 rounded-2xl border-l-4 border-[#f59e0b] text-slate-700 italic">
                                "Kamu tidak sendirian. Semua cerita, masalah, dan curhatan kamu dijamin 100% RAHASIA tanpa ada penilaian negatif dari siapapun."
                            </p>
                        </div>

                        <!-- Highlights Grid -->
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-800">100% Rahasia</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-800">Konselor Sebaya</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-800">Tanpa Judgement</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-[#f59e0b] flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fas fa-[#f59e0b] fa-hands-helping"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-800">Gratis untuk Siswa</span>
                            </div>
                        </div>
                    </div>

                    <!-- Image Illustration -->
                    <div class="relative" data-aos="fade-left">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-100 group">
                            @php
                                $aboutImgUrl = $heroSettings['about_image'] ?? '';
                                if($aboutImgUrl && !str_starts_with($aboutImgUrl, 'http')) {
                                    $aboutImgUrl = asset($aboutImgUrl);
                                }
                            @endphp
                            <img src="{{ $aboutImgUrl ?: 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200' }}" alt="Konseling Remaja PIK-R" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#17385c]/80 via-transparent to-transparent"></div>
                            
                            <div class="absolute bottom-6 left-6 right-6 p-4 bg-white/90 backdrop-blur-md rounded-2xl border border-white/40 shadow-lg text-slate-800">
                                <span class="text-[10px] font-bold text-[#f59e0b] uppercase tracking-wider block">Tim Konselor PIK-R</span>
                                <h4 class="text-xs sm:text-sm font-bold mt-0.5">Siap Mendengar & Mendampingi Teman Sebaya SMAN 1 Tasik Putri Puyu</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Section 3: Layanan Unggulan Konseling -->
        <div id="layanan-unggulan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <span class="text-xs font-extrabold text-[#f59e0b] uppercase tracking-widest block mb-2">Topik Bimbingan & Curhat</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Fokus Layanan <span class="text-[#f59e0b]">Konseling PIK-R</span>
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-3 leading-relaxed">
                    Setiap topik ditangani dengan penuh empati dan pemahaman mendalam tentang dunia remaja.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- Card 1 -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="0">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-[#f59e0b] flex items-center justify-center text-2xl font-bold border border-amber-100 group-hover:scale-110 transition-transform">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-[#f59e0b] transition-colors leading-snug">
                            Kesehatan Reproduksi Remaja
                        </h3>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Diskusi terbuka seputar organ reproduksi, pubertas, kebersihan diri, pencegahan anemia, dan kesehatan gizi remaja.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="#form-konseling" class="text-xs font-bold text-[#f59e0b] flex items-center gap-1.5 hover:gap-2.5 transition-all">
                            <span>Daftar Konseling</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold border border-blue-100 group-hover:scale-110 transition-transform">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors leading-snug">
                            Kesehatan Mental & Stress
                        </h3>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Bimbingan pengelolaan stres ujian, kecemasan, hubungan pertemanan, keluarga, serta kesehatan emosional remaja.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="#form-konseling" class="text-xs font-bold text-blue-600 flex items-center gap-1.5 hover:gap-2.5 transition-all">
                            <span>Daftar Konseling</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="200">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl font-bold border border-rose-100 group-hover:scale-110 transition-transform">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-rose-500 transition-colors leading-snug">
                            Pencegahan Triad KRR
                        </h3>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Edukasi pencegahan pernikahan dini, hubungan seks pra-nikah, dan bahaya penyalahgunaan Narkotika/Napza.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="#form-konseling" class="text-xs font-bold text-rose-500 flex items-center gap-1.5 hover:gap-2.5 transition-all">
                            <span>Daftar Konseling</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="300">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl font-bold border border-purple-100 group-hover:scale-110 transition-transform">
                            <i class="fas fa-compass"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-purple-600 transition-colors leading-snug">
                            Perencanaan Karir & Karakter
                        </h3>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Konsultasi minat bakat, persiapan perguruan tinggi, pembentukan karakter pimpinan, dan studi lanjut GenRe.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="#form-konseling" class="text-xs font-bold text-purple-600 flex items-center gap-1.5 hover:gap-2.5 transition-all">
                            <span>Daftar Konseling</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Tim Konselor & Pendidik Sebaya (Siapa Aja Konselornya) -->
        <div class="py-16 lg:py-24 bg-slate-100/60 border-y border-slate-200/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                    <span class="text-xs font-extrabold text-[#f59e0b] uppercase tracking-widest block mb-2">Tim Pendamping PIK-R</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Tim Konselor & <span class="text-[#f59e0b]">Pendidik Sebaya</span>
                    </h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-3 leading-relaxed">
                        Pengurus & Konselor Sebaya PIK-R REQUEST SMAN 1 Tasik Putri Puyu yang siap mendengarkan dan mendampingi kamu.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    @forelse($counselors ?? [] as $index => $counselor)
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 text-center flex flex-col items-center justify-between group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-[#17385c] to-blue-600 text-white flex items-center justify-center font-bold text-2xl shadow-md mb-4 group-hover:scale-105 transition-transform overflow-hidden">
                                @if($counselor->photo)
                                    <img src="{{ asset('storage/' . $counselor->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr($counselor->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <h4 class="text-base font-extrabold text-slate-900 group-hover:text-[#f59e0b] transition-colors leading-snug">{{ $counselor->name }}</h4>
                            
                            @if($counselor->role_type === 'konselor_sebaya')
                                <span class="px-3 py-1 bg-amber-50 text-[#f59e0b] border border-amber-200 rounded-full text-[10px] font-bold uppercase tracking-wider mt-2">
                                    Konselor Sebaya
                                </span>
                            @elseif($counselor->role_type === 'pendidik_sebaya')
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-full text-[10px] font-bold uppercase tracking-wider mt-2">
                                    Pendidik Sebaya
                                </span>
                            @else
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-full text-[10px] font-bold uppercase tracking-wider mt-2">
                                    Konselor & Pendidik Sebaya
                                </span>
                            @endif

                            <p class="text-slate-500 text-xs mt-3 font-semibold">{{ $counselor->class_or_title ?: 'Siswa SMAN 1 Tasik Putri Puyu' }}</p>
                            
                            @if($counselor->bio_motto)
                                <p class="text-slate-400 text-[11px] italic mt-2 leading-relaxed">"{{ $counselor->bio_motto }}"</p>
                            @endif
                        </div>

                        <div class="mt-6 w-full pt-4 border-t border-slate-100">
                            <a href="#form-konseling" class="w-full py-2.5 bg-slate-50 hover:bg-[#f59e0b] text-slate-700 hover:text-white rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 border border-slate-200 hover:border-[#f59e0b]">
                                <i class="fas fa-comments text-[10px]"></i>
                                <span>Curhat & Konseling</span>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-4 text-center py-12 text-slate-400">
                        <i class="fas fa-users-slash text-4xl mb-3 text-slate-300"></i>
                        <p class="text-xs font-bold">Tim Konselor PIK-R REQUEST akan ditampilkan di sini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Section 5: Form Pengajuan Konseling Online -->
        <div id="form-konseling" class="py-16 lg:py-24 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                @if(session('success'))
                    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                        <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                        <p class="text-xs sm:text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="bg-gradient-to-br from-slate-50 to-amber-50/20 p-8 sm:p-12 rounded-[32px] border border-slate-100 shadow-xl space-y-8" data-aos="fade-up">
                    <div class="text-center max-w-xl mx-auto space-y-2">
                        <span class="px-3.5 py-1 bg-amber-100 text-[#f59e0b] rounded-full text-[11px] font-extrabold uppercase tracking-wider inline-block">
                            Formulir Rahasia & Aman
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900">
                            Ajukan Sesi <span class="text-[#f59e0b]">Konseling Sebaya</span>
                        </h2>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Isi formulir di bawah ini. Kerahasiaan identitas dan curhat kamu dijamin 100% aman oleh pengurus PIK-R REQUEST SMAN 1 Tasik Putri Puyu.
                        </p>
                    </div>

                    <form action="{{ route('konseling.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Nama Lengkap / Samaran -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-700">Nama Lengkap / Inisial <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" required placeholder="Contoh: Budi Santoso atau Inisial B" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-medium focus:ring-2 focus:ring-[#f59e0b]/20 focus:border-[#f59e0b] transition-all">
                            </div>

                            <!-- Kelas -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-700">Kelas & Jurusan <span class="text-rose-500">*</span></label>
                                <input type="text" name="student_class" required placeholder="Contoh: XI IPA 1 atau XII IPS 2" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-medium focus:ring-2 focus:ring-[#f59e0b]/20 focus:border-[#f59e0b] transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Topik Konseling -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-700">Topik Konseling <span class="text-rose-500">*</span></label>
                                <select name="topic" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-medium focus:ring-2 focus:ring-[#f59e0b]/20 focus:border-[#f59e0b] transition-all">
                                    <option value="">-- Pilih Topik Konseling --</option>
                                    <option value="Kesehatan Mental & Stres Belajar">Kesehatan Mental & Stres Belajar</option>
                                    <option value="Kesehatan Reproduksi Remaja">Kesehatan Reproduksi Remaja</option>
                                    <option value="Hubungan Teman Sebaya & Bullying">Hubungan Teman Sebaya & Bullying</option>
                                    <option value="Perencanaan Karir & Masa Depan">Perencanaan Karir & Masa Depan</option>
                                    <option value="Masalah Pribadi & Lainnya">Masalah Pribadi & Lainnya</option>
                                </select>
                            </div>

                            <!-- Preferensi Konselor -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-700">Konselor Preferensi / PJ (Opsional)</label>
                                <input type="text" name="counselor_name" placeholder="Contoh: Konselor Sebaya Putra / Putri / Bebas" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-medium focus:ring-2 focus:ring-[#f59e0b]/20 focus:border-[#f59e0b] transition-all">
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700">Tanggal Preferensi Konseling</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-medium focus:ring-2 focus:ring-[#f59e0b]/20 focus:border-[#f59e0b] transition-all">
                        </div>

                        <!-- Cerita Singkat -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700">Cerita / Keluhan Singkat <span class="text-rose-500">*</span></label>
                            <textarea name="description" rows="4" required placeholder="Tuliskan curhat atau topik yang ingin kamu konsultasikan secara singkat..." class="w-full p-4 bg-white border border-slate-200 rounded-2xl text-xs font-medium focus:ring-2 focus:ring-[#f59e0b]/20 focus:border-[#f59e0b] transition-all"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 text-center">
                            <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-[#f59e0b] hover:bg-[#d97706] text-white font-extrabold text-xs uppercase tracking-wider rounded-2xl shadow-lg shadow-amber-500/20 transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2 mx-auto">
                                <i class="fas fa-paper-plane"></i>
                                <span>Kirim Permohonan Konseling</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</x-layouts.app>
