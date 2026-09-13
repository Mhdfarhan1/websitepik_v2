<x-layouts.dashboard title="Hasil Kuesioner Penilaian | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.peer-evaluation.config') }}" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Hasil Penilaian Peer</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Rekapitulasi Evaluasi Dan Penilaian Rekan Anggota</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8">
            
            <!-- Filters -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-700">Filter Periode Jadwal</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Pilih jadwal evaluasi untuk menyaring data</p>
                </div>
                <form action="{{ route('dashboard.peer-evaluation.results') }}" method="GET" class="flex gap-2">
                    <select name="schedule_id" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 cursor-pointer focus:ring-2 focus:ring-blue-500/20">
                        @foreach($schedules as $sched)
                            <option value="{{ $sched->id }}" {{ $selectedScheduleId == $sched->id ? 'selected' : '' }}>
                                {{ $sched->title }} {{ $sched->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Table of Results -->
            <x-dashboard.card title="Rekapitulasi Penilaian Anggota">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest w-16 text-center">No</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Nama Lengkap</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-center">Ulasan Masuk</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-center">Rata-Rata Skor</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-center">Kategori Penilaian</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-right">Laporan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($summary as $index => $row)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5 text-xs font-bold text-slate-400 text-center">{{ $index + 1 }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center font-black text-xs text-blue-600 shadow-sm shrink-0">
                                            {{ strtoupper(substr($row['member']->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="text-sm font-bold text-slate-700 block">{{ $row['member']->name }}</span>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mt-0.5">{{ str_replace('_', ' ', $row['member']->role) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center text-xs font-bold text-slate-650">
                                    {{ $row['total_reviews'] }} ulasan
                                </td>
                                <td class="px-8 py-5 text-center text-sm font-black text-slate-700">
                                    {{ $row['total_reviews'] > 0 ? number_format($row['average_score'], 2) : '-' }}
                                    @if($row['total_reviews'] > 0)
                                        <span class="text-[10px] text-slate-400 font-bold">/ 4.00</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span @class([
                                        'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border shadow-sm',
                                        'bg-slate-50 text-slate-400 border-slate-200' => $row['verbal_rating'] === 'Belum Dinilai',
                                        'bg-rose-50 text-rose-600 border-rose-100' => $row['verbal_rating'] === 'Buruk',
                                        'bg-amber-50 text-amber-600 border-amber-100' => $row['verbal_rating'] === 'Sedang',
                                        'bg-blue-50 text-blue-600 border-blue-100' => $row['verbal_rating'] === 'Baik',
                                        'bg-emerald-50 text-emerald-600 border-emerald-100' => $row['verbal_rating'] === 'Sangat Baik',
                                    ])>
                                        {{ $row['verbal_rating'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right w-28">
                                    @if($row['total_reviews'] > 0)
                                    <a href="{{ route('dashboard.peer-evaluation.results.detail', ['memberId' => $row['member']->id, 'schedule_id' => $selectedScheduleId]) }}" 
                                       class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all inline-flex items-center justify-center border border-slate-100 shadow-sm">
                                        <i class="fas fa-file-invoice text-[10px]"></i>
                                    </a>
                                    @else
                                    <span class="text-[10px] text-slate-300 font-bold uppercase italic">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-10 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">Tidak ada anggota yang terdaftar</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-dashboard.card>

        </div>
    </div>
</x-layouts.dashboard>
