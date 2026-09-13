<x-layouts.dashboard title="Kelola Program Kerja | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Manajemen Program Kerja</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola Program Kerja Organisasi</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.work-programs.settings') }}" class="bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-200 px-4 py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                    <i class="fas fa-cog"></i>
                    <span class="hidden sm:inline">Pengaturan Banner</span>
                </a>
                <a href="{{ route('dashboard.work-programs.create') }}" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Proker
                </a>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <x-dashboard.table :headers="['Foto', 'Judul Program', 'Deskripsi Singkat', 'Aksi']" title="Daftar Program Kerja" :paginator="$workPrograms">
                @forelse($workPrograms as $index => $proker)
                <tr class="hover:bg-slate-50/50 transition-colors group border-b border-slate-100 last:border-0">
                    <td class="pl-10 pr-6 py-5 text-center text-xs font-bold text-slate-400 w-16">
                        {{ ($workPrograms->currentPage() - 1) * $workPrograms->perPage() + $index + 1 }}
                    </td>
                    <td class="px-6 py-5 w-24">
                        <div class="w-16 h-12 rounded-lg overflow-hidden border border-slate-100 bg-slate-50 shadow-sm shrink-0">
                            @if(str_starts_with($proker->image ?? '', 'http'))
                                <img src="{{ $proker->image }}" class="w-full h-full object-cover" alt="Thumbnail">
                            @elseif($proker->image)
                                <img src="{{ asset('storage/' . $proker->image) }}" class="w-full h-full object-cover" alt="Thumbnail">
                            @else
                                <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&q=80&w=1200" class="w-full h-full object-cover" alt="Thumbnail">
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-700 block max-w-md truncate" title="{{ $proker->title }}">{{ $proker->title }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-xs text-slate-500 font-bold block max-w-md truncate">{{ Str::limit($proker->desc, 50) }}</span>
                    </td>
                    <td class="px-6 py-5 text-right w-32">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('dashboard.work-programs.edit', $proker) }}" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-[#1e3a8a] transition-all flex items-center justify-center border border-slate-100 shadow-sm">
                                <i class="fas fa-edit text-[10px]"></i>
                            </a>
                            <form action="{{ route('dashboard.work-programs.destroy', $proker) }}" method="POST" class="inline" id="delete-form-{{ $proker->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete('delete-form-{{ $proker->id }}')"
                                        class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center border border-rose-100 shadow-sm">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mb-4">
                                <i class="fas fa-tasks text-2xl text-slate-200"></i>
                            </div>
                            <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Belum ada program kerja yang ditambahkan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </x-dashboard.table>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Hapus data program kerja ini?',
                text: "Data program kerja yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest',
                    cancelButton: 'px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest text-slate-400'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    @endpush
</x-layouts.dashboard>
