<x-layouts.dashboard title="Tim Konselor & Pendidik Sebaya | Admin PIK-R">
    <div class="space-y-6">
        <!-- Header Strip -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-xl font-black text-slate-800">Tim Konselor & Pendidik Sebaya</h1>
                <p class="text-xs font-bold text-slate-400 mt-1">Kelola data profil Konselor Sebaya & Pendidik Sebaya yang tampil di halaman Layanan Konseling</p>
            </div>
            <a href="{{ route('dashboard.counselors.create') }}" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-blue-900/10 transition-all flex items-center justify-center gap-2 shrink-0">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Konselor / Pendidik</span>
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-xs font-bold text-emerald-700">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Integrated Table Component -->
        <x-dashboard.table :headers="['Foto', 'Nama Lengkap', 'Peran / Jabatan', 'Kelas / Sertifikasi', 'Urutan', 'Aksi']" title="Daftar Tim Konselor & Pendidik Sebaya" :paginator="$counselors">
            @forelse($counselors as $index => $counselor)
            <tr class="hover:bg-slate-50/50 transition-colors group border-b border-slate-100 last:border-0">
                <td class="pl-8 pr-4 py-5 text-center text-xs font-bold text-slate-400 w-16">
                    {{ ($counselors->currentPage() - 1) * $counselors->perPage() + $index + 1 }}
                </td>
                <td class="px-6 py-5 w-20">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gradient-to-tr from-[#17385c] to-blue-600 border border-slate-200 shrink-0 shadow-sm flex items-center justify-center text-white font-bold text-sm">
                        @if($counselor->photo)
                            <img src="{{ asset('storage/' . $counselor->photo) }}" class="w-full h-full object-cover" alt="Foto">
                        @else
                            <span>{{ strtoupper(substr($counselor->name, 0, 2)) }}</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-5">
                    <span class="text-sm font-bold text-slate-800 block leading-snug">{{ $counselor->name }}</span>
                    @if($counselor->bio_motto)
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5 truncate max-w-xs" title="{{ $counselor->bio_motto }}">"{{ $counselor->bio_motto }}"</span>
                    @endif
                </td>
                <td class="px-6 py-5">
                    @if($counselor->role_type === 'konselor_sebaya')
                        <span class="px-3 py-1 bg-amber-50 text-[#f59e0b] border border-amber-200 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block">
                            Konselor Sebaya
                        </span>
                    @elseif($counselor->role_type === 'pendidik_sebaya')
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block">
                            Pendidik Sebaya
                        </span>
                    @else
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block">
                            Konselor & Pendidik Sebaya
                        </span>
                    @endif
                </td>
                <td class="px-6 py-5 text-xs text-slate-600 font-bold">
                    {{ $counselor->class_or_title ?: '-' }}
                </td>
                <td class="px-6 py-5 text-center text-xs font-bold text-slate-500 w-20">
                    <span class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200 inline-flex items-center justify-center font-bold text-slate-700">{{ $counselor->order_index }}</span>
                </td>
                <td class="px-6 py-5 text-right w-32">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('dashboard.counselors.edit', $counselor) }}" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-all flex items-center justify-center shadow-sm">
                            <i class="fas fa-edit text-[11px]"></i>
                        </a>
                        <form action="{{ route('dashboard.counselors.destroy', $counselor) }}" method="POST" class="inline" id="delete-form-{{ $counselor->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="if(confirm('Apakah Anda yakin ingin menghapus data konselor ini?')) this.form.submit()"
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
                    <i class="fas fa-users-slash text-4xl mb-3 text-slate-300"></i>
                    <p class="text-xs font-medium">Belum ada tim konselor atau pendidik sebaya yang ditambahkan.</p>
                </td>
            </tr>
            @endforelse
        </x-dashboard.table>
    </div>
</x-layouts.dashboard>
