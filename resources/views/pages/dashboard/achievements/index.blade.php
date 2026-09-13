<x-layouts.dashboard title="Kelola Prestasi | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Manajemen Prestasi</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola Apresiasi dan Capaian Prestasi Organisasi</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.achievements.settings') }}" class="bg-white border border-slate-200 text-slate-700 hover:text-blue-600 hover:border-blue-200 px-4 py-2.5 rounded-xl font-bold text-xs shadow-sm transition-all flex items-center gap-2">
                    <i class="fas fa-sliders-h text-slate-400"></i>
                    Pengaturan Banner
                </a>
                <a href="{{ route('dashboard.achievements.create') }}" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Prestasi
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

            <x-dashboard.table :headers="['Foto Cover', 'Judul Penghargaan', 'Dokumentasi Foto', 'Tanggal Penerimaan', 'Penyelenggara', 'Aksi']" title="Daftar Prestasi" :paginator="$achievementList">
                @forelse($achievementList as $index => $achievement)
                <tr class="hover:bg-slate-50/50 transition-colors group border-b border-slate-100 last:border-0">
                    <td class="pl-10 pr-6 py-5 text-center text-xs font-bold text-slate-400 w-16">
                        {{ ($achievementList->currentPage() - 1) * $achievementList->perPage() + $index + 1 }}
                    </td>
                    <td class="px-6 py-5 w-24">
                        <div class="w-16 h-12 rounded-lg overflow-hidden border border-slate-100 bg-slate-50 shadow-sm shrink-0">
                            @if(str_starts_with($achievement->image ?? '', 'http'))
                                <img src="{{ $achievement->image }}" class="w-full h-full object-cover" alt="Thumbnail">
                            @else
                                <img src="{{ asset($achievement->image ?? 'assets/img/bg_utama.JPG') }}" class="w-full h-full object-cover" alt="Thumbnail">
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-700 block max-w-md truncate" title="{{ $achievement->title }}">{{ $achievement->title }}</span>
                        @if($achievement->description)
                            <span class="text-[10px] text-slate-400 font-semibold block max-w-md truncate mt-1">{{ $achievement->description }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        @php $photoCount = $achievement->images->count(); @endphp
                        @if($photoCount > 0)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                <i class="fas fa-images text-[10px]"></i> {{ $photoCount }} Foto
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-50 text-slate-400 text-[10px] font-semibold border border-slate-150">
                                1 Foto Cover
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-xs text-slate-500 font-bold">
                        {{ $achievement->date ? $achievement->date->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-5 text-xs text-slate-600 font-bold">
                        {{ $achievement->author }}
                    </td>
                    <td class="px-6 py-5 text-right w-36">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('prestasi.show', $achievement->id) }}" target="_blank" title="Lihat Halaman Publik" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-all flex items-center justify-center border border-slate-100 shadow-sm">
                                <i class="fas fa-external-link-alt text-[10px]"></i>
                            </a>
                            <a href="{{ route('dashboard.achievements.edit', $achievement) }}" title="Edit Prestasi & Foto" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-[#1e3a8a] hover:bg-blue-50 transition-all flex items-center justify-center border border-slate-100 shadow-sm">
                                <i class="fas fa-edit text-[10px]"></i>
                            </a>
                            <form action="{{ route('dashboard.achievements.destroy', $achievement) }}" method="POST" class="inline" id="delete-form-{{ $achievement->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete('delete-form-{{ $achievement->id }}')"
                                        title="Hapus Prestasi"
                                        class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center border border-rose-100 shadow-sm cursor-pointer">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mb-4">
                                <i class="fas fa-trophy text-2xl text-slate-200"></i>
                            </div>
                            <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Belum ada prestasi yang ditambahkan</p>
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
                title: 'Hapus data prestasi ini?',
                text: "Data prestasi beserta seluruh dokumentasi foto terkait akan dihapus permanen!",
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
