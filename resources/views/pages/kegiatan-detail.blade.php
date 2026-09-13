<x-layouts.app>
    <!-- Page Header (Small Header matching Berita Detail Page) -->
    <div class="pt-36 sm:pt-40 pb-10 bg-slate-50 border-b border-slate-100/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="hover:text-[#f59e0b] transition-colors flex items-center gap-1.5">
                            <i class="fas fa-home text-[10px]"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-[8px] mx-2 text-slate-300"></i>
                            <a href="{{ route('kegiatan') }}" class="hover:text-[#f59e0b] transition-colors">Agenda Kegiatan</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-[8px] mx-2 text-slate-300"></i>
                            <span class="text-slate-400 truncate max-w-[200px] sm:max-w-[320px]" title="{{ $activity->title }}">{{ Str::limit($activity->title, 30) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content Section -->
    <section class="py-12 lg:py-16 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                
                <!-- Left: Activity Content (65% width) -->
                <div class="lg:w-[65%]" data-aos="fade-up">
                    
                    <!-- Category & Status Badge Row -->
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <span class="px-3.5 py-1 bg-amber-50 text-[#f59e0b] border border-amber-200/80 rounded-full text-xs font-extrabold shadow-sm">
                            <i class="fas fa-tag mr-1 text-[10px]"></i> {{ $activity->category }}
                        </span>
                        <span @class([
                            'px-3.5 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider shadow-sm',
                            'bg-[#f59e0b] text-white' => $activity->status === 'upcoming',
                            'bg-emerald-500 text-white' => $activity->status === 'ongoing',
                            'bg-slate-700 text-slate-200' => $activity->status === 'completed',
                        ])>
                            {{ $activity->status === 'upcoming' ? 'Mendatang' : ($activity->status === 'ongoing' ? 'Berlangsung' : 'Selesai') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 leading-[1.25] tracking-tight mb-6">
                        {{ $activity->title }}
                    </h1>
                    
                    <!-- Author & Share Row -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-100">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-[#17385c] to-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-md">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-extrabold text-slate-800">{{ $activity->creator ? $activity->creator->name : 'Super Admin PIK-R' }}</span>
                                <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5 mt-0.5">
                                    <i class="far fa-calendar-alt text-[#f59e0b]"></i>
                                    <span>{{ $activity->event_date ? $activity->event_date->format('d M Y') : 'Tanggal Belum Ditetapkan' }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Share Buttons -->
                        <div class="flex items-center gap-2" x-data="{ copied: false }">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mr-1">SHARE:</span>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($activity->title . ' - ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all duration-300 shadow-sm" title="Bagikan ke WhatsApp">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all duration-300 shadow-sm" title="Bagikan ke Facebook">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($activity->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all duration-300 shadow-sm" title="Bagikan ke Twitter">
                                <i class="fab fa-twitter text-sm"></i>
                            </a>
                            <button @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 2000)" class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all duration-300 shadow-sm" title="Salin Tautan">
                                <i class="fas fa-link text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Main Image Banner -->
                    <div class="relative rounded-2xl overflow-hidden mb-10 shadow-xl shadow-slate-200/60 bg-slate-900 border border-slate-100 group">
                        @if($activity->image)
                            <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" class="w-full h-auto max-h-[500px] object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-72 sm:h-80 bg-gradient-to-br from-[#17385c] via-[#21517a] to-[#7bb3ce] flex flex-col items-center justify-center text-white p-8 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-[#f59e0b] mb-3 text-3xl shadow-inner">
                                    <i class="fas fa-calendar-star"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white max-w-md mb-1">{{ $activity->title }}</h3>
                                <span class="text-xs font-bold uppercase tracking-wider text-white/80">{{ $activity->category }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Key Event Details Grid Box -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        <div class="p-4 sm:p-5 bg-gradient-to-br from-amber-50/80 to-amber-50/20 rounded-2xl border border-amber-100 flex items-start gap-3.5 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-amber-500/20">
                                <i class="far fa-calendar-alt text-base"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold text-amber-800/60 uppercase tracking-widest block">Tanggal Pelaksanaan</span>
                                <strong class="text-slate-800 font-extrabold text-xs sm:text-sm block mt-0.5 truncate">{{ $activity->event_date ? $activity->event_date->format('d F Y') : '-' }}</strong>
                            </div>
                        </div>

                        <div class="p-4 sm:p-5 bg-gradient-to-br from-blue-50/80 to-blue-50/20 rounded-2xl border border-blue-100 flex items-start gap-3.5 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-blue-600/20">
                                <i class="far fa-clock text-base"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold text-blue-800/60 uppercase tracking-widest block">Waktu / Operasional</span>
                                <strong class="text-slate-800 font-extrabold text-xs sm:text-sm block mt-0.5 truncate">{{ $activity->time_start }} WIB {{ $activity->time_end ? '- ' . $activity->time_end . ' WIB' : '' }}</strong>
                            </div>
                        </div>

                        <div class="p-4 sm:p-5 bg-gradient-to-br from-rose-50/80 to-rose-50/20 rounded-2xl border border-rose-100 flex items-start gap-3.5 sm:col-span-2 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-rose-500/20">
                                <i class="fas fa-map-marker-alt text-base"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold text-rose-800/60 uppercase tracking-widest block">Lokasi Tempat</span>
                                <strong class="text-slate-800 font-extrabold text-xs sm:text-sm block mt-0.5 break-words">{{ $activity->location }}</strong>
                            </div>
                        </div>

                        @if($activity->creator)
                        <div class="p-4 sm:p-5 bg-gradient-to-br from-purple-50/80 to-purple-50/20 rounded-2xl border border-purple-100 flex items-start gap-3.5 sm:col-span-2 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-purple-600/20">
                                <i class="fas fa-user-circle text-base"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold text-purple-800/60 uppercase tracking-widest block">Penyelenggara / Penanggung Jawab</span>
                                <strong class="text-slate-800 font-extrabold text-xs sm:text-sm block mt-0.5 truncate">{{ $activity->creator->name }}</strong>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Article Body / Description -->
                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-base space-y-6 font-medium border-t border-slate-100 pt-8">
                        <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#f59e0b]"></span>
                            <span>Deskripsi & Rincian Lengkap Kegiatan</span>
                        </h3>
                        <div class="bg-slate-50/80 p-6 sm:p-8 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed space-y-4">
                            {!! nl2br(e($activity->description)) !!}
                        </div>
                    </div>

                    <!-- Bottom CTA Banner for Participation -->
                    <div class="mt-10 p-6 sm:p-8 bg-gradient-to-r from-[#17385c] via-[#1e40af] to-[#2563eb] rounded-3xl text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="space-y-1 text-center sm:text-left">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-amber-300">Pusat Informasi & Konseling Remaja</span>
                            <h4 class="text-lg font-black text-white">Ingin Mengikuti Kegiatan Ini?</h4>
                            <p class="text-xs text-blue-100 max-w-md">Hubungi pengurus PIK-R REQUEST SMAN 1 Tasik Putri Puyu untuk pendaftaran dan info lebih lanjut.</p>
                        </div>
                        <a href="https://wa.me/?text={{ urlencode('Halo Admin PIK-R REQUEST, saya ingin bertanyakan mengenai kegiatan: ' . $activity->title) }}" target="_blank" class="px-6 py-3.5 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-xl font-bold text-xs shadow-lg shadow-amber-500/20 transition-all hover:scale-105 shrink-0 flex items-center gap-2">
                            <i class="fab fa-whatsapp text-sm"></i>
                            <span>Hubungi Pengurus</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Sidebar (35% width) -->
                <div class="lg:w-[35%]" data-aos="fade-left">
                    <div class="sticky top-32 space-y-8">
                        
                        <!-- Recent Activities List (Matching Berita Terkini Sidebar Style) -->
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                            <h3 class="text-base font-extrabold text-slate-900 mb-6 pb-3 border-b border-slate-100 flex items-center justify-between">
                                <span>Agenda Terbaru</span>
                                <a href="{{ route('kegiatan') }}" class="text-xs font-bold text-[#f59e0b] hover:underline">Lihat Semua</a>
                            </h3>

                            <div class="space-y-5">
                                @forelse($relatedActivities ?? [] as $recent)
                                    @if($recent->id !== $activity->id)
                                    <a href="{{ route('kegiatan.show', $recent->slug) }}" class="group block border-b border-slate-50 pb-4 last:border-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-amber-50 text-[#f59e0b] border border-amber-100">
                                                {{ $recent->category }}
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-slate-800 group-hover:text-[#f59e0b] transition-colors text-xs sm:text-sm leading-snug mb-1">
                                            {{ $recent->title }}
                                        </h4>
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                                            <i class="far fa-calendar-alt mr-1 text-[#f59e0b]"></i> {{ $recent->event_date ? $recent->event_date->format('M d, Y') : '' }}
                                        </span>
                                    </a>
                                    @endif
                                @empty
                                    <p class="text-slate-400 text-xs italic">Belum ada agenda kegiatan lainnya.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>
