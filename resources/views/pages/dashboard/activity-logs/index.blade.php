<x-layouts.dashboard title="Log Aktivitas | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Log Aktivitas Sistem</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pantau riwayat aktivitas pengguna untuk transparansi dan keamanan</p>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full">
            <x-dashboard.table :headers="['Waktu', 'Pengguna', 'Aksi', 'Deskripsi', 'IP Address']" title="Daftar Aktivitas Terbaru" :paginator="$logs">
                @forelse($logs as $index => $log)
                <tr class="hover:bg-slate-50/50 transition-colors group border-b border-slate-100 last:border-0">
                    <td class="pl-10 pr-6 py-5 text-center text-xs font-bold text-slate-400 w-16">
                        {{ ($logs->currentPage() - 1) * $logs->perPage() + $index + 1 }}
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-xs font-bold text-slate-500">
                        {{ $log->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#1e3a8a]/10 text-[#1e3a8a] flex items-center justify-center font-black text-xs shrink-0">
                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-700 block truncate">{{ $log->user->name ?? 'System' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 block">{{ $log->user->role ?? 'Sistem Internal' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        @php
                            $actionClasses = [
                                'created' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                'updated' => 'bg-amber-50 text-amber-600 border-amber-200',
                                'deleted' => 'bg-rose-50 text-rose-600 border-rose-200',
                                'approved' => 'bg-blue-50 text-blue-600 border-blue-200',
                                'rejected' => 'bg-slate-100 text-slate-600 border-slate-200',
                            ];
                            $class = $actionClasses[$log->action] ?? 'bg-slate-50 text-slate-500 border-slate-200';
                        @endphp
                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $class }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-xs font-bold text-slate-600 block">{{ $log->description }}</span>
                        @if($log->model_type)
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1 block">Tipe: {{ class_basename($log->model_type) }} #{{ $log->model_id }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-xs text-slate-400 font-bold font-mono">
                        {{ $log->ip_address ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mb-4">
                                <i class="fas fa-history text-2xl text-slate-200"></i>
                            </div>
                            <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Belum ada log aktivitas tercatat</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </x-dashboard.table>
        </div>
</x-layouts.dashboard>
