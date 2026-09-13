@props([
    'activities' => [],
    'showViewAll' => true,
    'showPagination' => false
])

<!-- Agenda Kegiatan Terjadwal Section -->
<section id="kegiatan" class="py-16 sm:py-24 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header (Matching Berita Terkini & Galeri Header Style) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 sm:mb-10 gap-4" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-[2.25rem] font-bold text-slate-900 tracking-tight">
                <span class="text-[#f59e0b]">Agenda</span> Kegiatan
            </h2>

            @if($showViewAll && count($activities ?? []) > 3)
            <a href="{{ route('kegiatan') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#f59e0b] hover:text-[#d97706] transition-colors group">
                <span>Lihat Semua Agenda</span>
                <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </a>
            @endif
        </div>

        @if(count($activities ?? []) > 0)
        @php
            $displayItems = $showViewAll ? collect($activities)->take(3) : $activities;
        @endphp

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($displayItems as $index => $act)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden group" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                <div>
                    <!-- Image Banner -->
                    <div class="relative h-44 sm:h-48 bg-slate-900 overflow-hidden">
                        @if($act->image)
                            <img src="{{ asset('storage/' . $act->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $act->title }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#17385c] via-[#21517a] to-[#7bb3ce] flex flex-col items-center justify-center text-white/80 p-6 text-center">
                                <i class="fas fa-calendar-star text-3xl sm:text-4xl mb-2 text-[#f59e0b]"></i>
                                <span class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-white/90">{{ $act->category }}</span>
                            </div>
                        @endif

                        <!-- Date Badge Overlay -->
                        <div class="absolute top-3 left-3 sm:top-4 sm:left-4 bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-xl shadow-md text-center border border-white/50">
                            <span class="block text-sm sm:text-base font-bold text-slate-900 leading-none">{{ $act->event_date ? $act->event_date->format('d') : '01' }}</span>
                            <span class="block text-[8px] sm:text-[9px] font-bold uppercase tracking-widest text-[#f59e0b] mt-0.5">{{ $act->event_date ? $act->event_date->format('M Y') : 'JAN' }}</span>
                        </div>

                        <!-- Status Badge Overlay -->
                        <div class="absolute top-3 right-3 sm:top-4 sm:right-4">
                            <span @class([
                                'px-2.5 sm:px-3 py-1 rounded-full text-[9px] sm:text-[10px] font-bold uppercase tracking-wider shadow-sm backdrop-blur-md',
                                'bg-[#f59e0b] text-white' => $act->status === 'upcoming',
                                'bg-emerald-500 text-white' => $act->status === 'ongoing',
                                'bg-slate-700/80 text-slate-200' => $act->status === 'completed',
                            ])>
                                {{ $act->status === 'upcoming' ? 'Mendatang' : ($act->status === 'ongoing' ? 'Berlangsung' : 'Selesai') }}
                            </span>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-[#f59e0b] border border-amber-100">
                                {{ $act->category }}
                            </span>
                        </div>

                        <a href="{{ route('kegiatan.show', $act->slug) }}">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#f59e0b] transition-colors leading-snug line-clamp-2 mb-2.5">
                                {{ $act->title }}
                            </h3>
                        </a>

                        <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed mb-4">
                            {{ $act->description }}
                        </p>

                        <!-- Details (Time & Location) -->
                        <div class="space-y-2 pt-3 border-t border-slate-100 text-xs font-medium text-slate-600">
                            <div class="flex items-center gap-2">
                                <i class="far fa-clock text-[#f59e0b] w-4 shrink-0"></i>
                                <span class="truncate">{{ $act->time_start }} WIB {{ $act->time_end ? '- ' . $act->time_end . ' WIB' : '' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-rose-500 w-4 shrink-0"></i>
                                <span class="truncate" title="{{ $act->location }}">{{ $act->location }}</span>
                            </div>
                            @if($act->creator)
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <i class="fas fa-user-circle text-slate-400 w-4 shrink-0"></i>
                                <span class="truncate">Penyelenggara: <strong class="text-slate-700">{{ $act->creator->name }}</strong></span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer Action Link -->
                <div class="p-5 sm:p-6 pt-0">
                    <a href="{{ route('kegiatan.show', $act->slug) }}" 
                       class="w-full py-3 px-4 bg-slate-50 hover:bg-[#f59e0b] text-slate-700 hover:text-white rounded-xl text-xs font-bold transition-all duration-200 flex items-center justify-center gap-2 border border-slate-200 hover:border-[#f59e0b] active:scale-95">
                        <span>Lihat Detail Agenda</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Mode 1: Landing Page Button (Lihat Semua) -->
        @if($showViewAll && count($activities ?? []) > 3)
        <div class="mt-10 sm:mt-12 text-center" data-aos="fade-up">
            <a href="{{ route('kegiatan') }}" class="inline-flex items-center gap-2 bg-[#f59e0b] hover:bg-[#d97706] text-white px-7 sm:px-8 py-3.5 rounded-xl font-bold text-xs shadow-lg shadow-amber-500/20 transition-all hover:scale-105 active:scale-95">
                <span>Lihat Semua Agenda Kegiatan</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        @endif

        <!-- Mode 2: Dedicated /kegiatan Page Pagination (Entries & Page 1 2 3...) -->
        @if($showPagination && method_exists($activities, 'hasPages'))
        <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-200/80 pt-8" data-aos="fade-up">
            <div class="flex items-center gap-2.5">
                <div class="w-2.5 h-2.5 rounded-full bg-[#f59e0b] shadow-[0_0_10px_rgba(245,158,11,0.5)]"></div>
                <p class="text-xs font-bold text-slate-500">
                    Menampilkan <span class="text-slate-900 font-extrabold">{{ $activities->firstItem() ?? 0 }} - {{ $activities->lastItem() ?? 0 }}</span> dari <span class="text-slate-900 font-extrabold">{{ $activities->total() }}</span> Total Agenda Kegiatan
                </p>
            </div>

            @if($activities->hasPages())
            <div class="flex flex-wrap items-center justify-center gap-2">
                {{-- Previous Page Link --}}
                @if ($activities->onFirstPage())
                    <span class="px-3.5 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 font-bold text-xs flex items-center gap-1.5 cursor-not-allowed select-none">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                        <span>Sebelumnya</span>
                    </span>
                @else
                    <a href="{{ $activities->previousPageUrl() }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-[#f59e0b] hover:text-white hover:border-[#f59e0b] transition-all flex items-center gap-1.5 shadow-sm active:scale-95">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                        <span>Sebelumnya</span>
                    </a>
                @endif

                {{-- Page Numbers (1, 2, 3...) --}}
                <div class="flex items-center gap-1">
                    @foreach ($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                        @if ($page == $activities->currentPage())
                            <span class="w-9 h-9 rounded-xl bg-[#f59e0b] text-white font-black text-xs flex items-center justify-center shadow-md shadow-amber-500/20 select-none">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-100 transition-all flex items-center justify-center shadow-sm active:scale-95">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($activities->hasMorePages())
                    <a href="{{ $activities->nextPageUrl() }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-[#f59e0b] hover:text-white hover:border-[#f59e0b] transition-all flex items-center gap-1.5 shadow-sm active:scale-95">
                        <span>Selanjutnya</span>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                @else
                    <span class="px-3.5 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 font-bold text-xs flex items-center gap-1.5 cursor-not-allowed select-none">
                        <span>Selanjutnya</span>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </span>
                @endif
            </div>
            @endif
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-2xl border border-slate-100 shadow-sm max-w-xl mx-auto px-4">
            <i class="fas fa-calendar-times text-slate-300 text-5xl mb-4"></i>
            <h4 class="text-slate-800 font-bold text-lg">Belum Ada Agenda Terjadwal</h4>
            <p class="text-slate-500 text-xs mt-1">Agenda kegiatan terbaru akan ditampilkan di sini setelah ditambahkan oleh pengurus.</p>
        </div>
        @endif
    </div>
</section>

<!-- Activity Detail Modal Script (SweetAlert2) -->
@push('scripts')
<script>
    function showActivityDetail(title, category, date, time, location, organizer, status, description, image) {
        let statusBadge = '';
        if (status === 'upcoming') {
            statusBadge = '<span class="px-2.5 py-0.5 bg-[#f59e0b] text-white text-[9px] sm:text-[10px] font-bold uppercase rounded-full shadow-sm">Mendatang</span>';
        } else if (status === 'ongoing') {
            statusBadge = '<span class="px-2.5 py-0.5 bg-emerald-500 text-white text-[9px] sm:text-[10px] font-bold uppercase rounded-full shadow-sm">Berlangsung</span>';
        } else {
            statusBadge = '<span class="px-2.5 py-0.5 bg-slate-600 text-white text-[9px] sm:text-[10px] font-bold uppercase rounded-full shadow-sm">Selesai</span>';
        }

        let imageHeader = '';
        if (image) {
            imageHeader = `
                <div class="relative h-44 sm:h-52 w-full overflow-hidden">
                    <img src="${image}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                    <div class="absolute top-3 left-3 sm:top-4 sm:left-4 flex flex-wrap gap-1.5 sm:gap-2 items-center z-10">
                        <span class="px-2.5 py-0.5 bg-[#f59e0b] text-white font-bold text-[9px] sm:text-[10px] uppercase rounded-full shadow-md">${category}</span>
                        ${statusBadge}
                    </div>
                    <div class="absolute bottom-3 left-4 right-4 sm:bottom-4 sm:left-6 sm:right-6 text-white text-left z-10">
                        <h3 class="text-base sm:text-xl font-extrabold leading-tight text-white">${title}</h3>
                    </div>
                </div>`;
        } else {
            imageHeader = `
                <div class="relative p-4 sm:p-6 bg-gradient-to-r from-[#17385c] via-[#21517a] to-[#7bb3ce] text-white text-left">
                    <div class="flex flex-wrap gap-1.5 sm:gap-2 items-center mb-2.5">
                        <span class="px-2.5 py-0.5 bg-[#f59e0b] text-white font-bold text-[9px] sm:text-[10px] uppercase rounded-full shadow-md">${category}</span>
                        ${statusBadge}
                    </div>
                    <h3 class="text-base sm:text-xl font-extrabold leading-tight text-white">${title}</h3>
                </div>`;
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                html: `
                    <div class="text-left font-sans -m-4 sm:-m-6 overflow-hidden">
                        ${imageHeader}
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4 bg-white">
                            <!-- Info Grid: Stack 1-Col on Mobile, 2-Col on SM+ -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 text-xs">
                                <div class="p-3 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 flex items-start gap-2.5">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-amber-50 text-[#f59e0b] flex items-center justify-center shrink-0">
                                        <i class="far fa-calendar-alt text-xs sm:text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Pelaksanaan</span>
                                        <strong class="text-slate-800 font-bold leading-tight block mt-0.5 text-xs truncate">${date}</strong>
                                    </div>
                                </div>

                                <div class="p-3 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 flex items-start gap-2.5">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="far fa-clock text-xs sm:text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Waktu / Jam</span>
                                        <strong class="text-slate-800 font-bold leading-tight block mt-0.5 text-xs truncate">${time}</strong>
                                    </div>
                                </div>

                                <div class="p-3 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 flex items-start gap-2.5 sm:col-span-2">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                                        <i class="fas fa-map-marker-alt text-xs sm:text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lokasi Tempat</span>
                                        <strong class="text-slate-800 font-bold leading-tight block mt-0.5 text-xs break-words">${location}</strong>
                                    </div>
                                </div>

                                ${organizer ? `
                                <div class="p-3 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 flex items-start gap-2.5 sm:col-span-2">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                        <i class="fas fa-user-circle text-xs sm:text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Penyelenggara / PJ</span>
                                        <strong class="text-slate-800 font-bold leading-tight block mt-0.5 text-xs truncate">${organizer}</strong>
                                    </div>
                                </div>
                                ` : ''}
                            </div>

                            <div class="pt-2 sm:pt-3 border-t border-slate-100">
                                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi Agenda:</span>
                                <p class="text-xs text-slate-600 leading-relaxed font-medium bg-slate-50 p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-100 max-h-40 overflow-y-auto">${description}</p>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Tutup Detail Agenda',
                confirmButtonColor: '#f59e0b',
                customClass: {
                    popup: '!rounded-2xl sm:!rounded-[28px] !p-0 !overflow-hidden !border-0 shadow-2xl !w-[92vw] sm:!w-[480px] max-w-lg',
                    confirmButton: '!rounded-xl sm:!rounded-2xl !px-6 sm:!px-8 !py-2.5 sm:!py-3 !text-xs !font-bold !shadow-lg my-3'
                }
            });
        } else {
            alert(`${title}\n\nTanggal: ${date}\nWaktu: ${time}\nLokasi: ${location}\n\nDeskripsi:\n${description}`);
        }
    }
</script>
@endpush
