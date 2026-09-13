<x-layouts.dashboard title="Kelola Kegiatan & Agenda | Admin PIK-R">
    <div class="space-y-6">
        <!-- Header Strip -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-xl font-black text-slate-800">Manajemen Agenda Kegiatan</h1>
                <p class="text-xs font-bold text-slate-400 mt-1">Kelola agenda kegiatan, sosialisasi, dan event terdaftar PIK-R REQUEST</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('dashboard.activities.settings') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-2xl font-bold text-xs transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-sliders-h"></i>
                    <span>Pengaturan Banner</span>
                </a>
                <a href="{{ route('dashboard.activities.create') }}" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-blue-900/10 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Agenda Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-xs font-bold text-emerald-700">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filter Status Quick Bar -->
        <div class="flex items-center gap-2 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-xs font-bold text-slate-500 px-3">Filter Status:</span>
            <a href="{{ route('dashboard.activities.index') }}" @class([
                'px-4 py-1.5 rounded-xl text-xs font-bold transition-all',
                'bg-blue-600 text-white shadow-sm' => !request('status'),
                'bg-slate-50 text-slate-600 hover:bg-slate-100' => request('status'),
            ])>Semua</a>
            <a href="{{ route('dashboard.activities.index', ['status' => 'upcoming']) }}" @class([
                'px-4 py-1.5 rounded-xl text-xs font-bold transition-all',
                'bg-[#f59e0b] text-white shadow-sm' => request('status') === 'upcoming',
                'bg-slate-50 text-slate-600 hover:bg-slate-100' => request('status') !== 'upcoming',
            ])>Mendatang</a>
            <a href="{{ route('dashboard.activities.index', ['status' => 'completed']) }}" @class([
                'px-4 py-1.5 rounded-xl text-xs font-bold transition-all',
                'bg-slate-700 text-white shadow-sm' => request('status') === 'completed',
                'bg-slate-50 text-slate-600 hover:bg-slate-100' => request('status') !== 'completed',
            ])>Selesai</a>
        </div>

        <!-- Integrated Table Component -->
        <x-dashboard.table :headers="['Poster', 'Nama Kegiatan & Kategori', 'Waktu & Lokasi', 'Status', 'Pembuat (User FK)', 'Aksi']" title="Daftar Agenda Kegiatan" :paginator="$activities">
            @forelse($activities as $index => $act)
            <tr class="hover:bg-slate-50/50 transition-colors group border-b border-slate-100 last:border-0">
                <td class="pl-8 pr-4 py-5 text-center text-xs font-bold text-slate-400 w-16">
                    {{ ($activities->currentPage() - 1) * $activities->perPage() + $index + 1 }}
                </td>
                <td class="px-6 py-5 w-24">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 shadow-sm">
                        @if($act->image)
                            <img src="{{ asset('storage/' . $act->image) }}" class="w-full h-full object-cover" alt="Poster">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-blue-50 text-blue-600 font-bold">
                                <i class="fas fa-calendar-alt text-base"></i>
                            </div>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-5">
                    <span class="text-sm font-bold text-slate-800 block max-w-sm leading-snug" title="{{ $act->title }}">{{ $act->title }}</span>
                    <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-[#f59e0b] border border-amber-100">
                        {{ $act->category }}
                    </span>
                </td>
                <td class="px-6 py-5">
                    <div class="flex items-center gap-1.5 font-bold text-slate-800 text-xs">
                        <i class="far fa-calendar-alt text-[#f59e0b]"></i>
                        <span>{{ $act->event_date ? $act->event_date->format('d M Y') : '-' }}</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1 flex flex-col gap-0.5">
                        <span><i class="far fa-clock text-slate-400"></i> {{ $act->time_start }} WIB</span>
                        <span class="truncate max-w-[180px]" title="{{ $act->location }}"><i class="fas fa-map-marker-alt text-rose-500"></i> {{ $act->location }}</span>
                    </div>
                </td>
                <td class="px-6 py-5 text-center">
                    <span @class([
                        'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block',
                        'bg-amber-50 text-[#f59e0b] border border-amber-200' => $act->status === 'upcoming',
                        'bg-emerald-50 text-emerald-600 border border-emerald-200' => $act->status === 'ongoing',
                        'bg-slate-100 text-slate-500 border border-slate-200' => $act->status === 'completed',
                    ])>
                        {{ $act->status === 'upcoming' ? 'Mendatang' : ($act->status === 'ongoing' ? 'Berlangsung' : 'Selesai') }}
                    </span>
                </td>
                <td class="px-6 py-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-[10px] shrink-0">
                            {{ $act->creator ? strtoupper(substr($act->creator->name, 0, 2)) : 'AD' }}
                        </div>
                        <span class="text-xs font-bold text-slate-700 truncate max-w-[120px]">{{ $act->creator ? $act->creator->name : 'Admin' }}</span>
                    </div>
                </td>
                <td class="px-6 py-5 text-right w-32">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('dashboard.activities.edit', $act) }}" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-all flex items-center justify-center shadow-sm">
                            <i class="fas fa-edit text-[11px]"></i>
                        </a>
                        <form action="{{ route('dashboard.activities.destroy', $act) }}" method="POST" class="inline" id="delete-form-{{ $act->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="if(confirm('Apakah Anda yakin ingin menghapus agenda kegiatan ini?')) this.form.submit()"
                                    class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                <i class="fas fa-trash-alt text-[11px]"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-12 text-center text-slate-400">
                    <i class="fas fa-calendar-times text-4xl mb-3 text-slate-300"></i>
                    <p class="text-xs font-medium">Belum ada agenda kegiatan yang ditambahkan.</p>
                </td>
            </tr>
            @endforelse
        </x-dashboard.table>
    </div>
</x-layouts.dashboard>
