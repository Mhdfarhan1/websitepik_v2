<x-layouts.dashboard title="Kelola Galeri & Kegiatan | Admin PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Galeri & Kegiatan</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Unggah dan Kelola Foto Potret Kegiatan</p>
            </div>
            <a href="{{ route('dashboard.gallery.create') }}" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-[#1e3a8a]/20 transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Foto
            </a>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <x-dashboard.table :headers="['Foto', 'Judul/Keterangan', 'Urutan', 'Tipe', 'Aksi']" title="Daftar Foto Galeri" :paginator="$galleryList">
                @forelse($galleryList as $index => $gallery)
                <tr class="hover:bg-slate-50/50 transition-colors group border-b border-slate-100 last:border-0">
                    <td class="pl-10 pr-6 py-5 text-center text-xs font-bold text-slate-400 w-16">
                        {{ ($galleryList->currentPage() - 1) * $galleryList->perPage() + $index + 1 }}
                    </td>
                    <td class="px-6 py-5 w-28">
                        <div class="w-20 h-14 rounded-lg overflow-hidden border border-slate-100 bg-slate-50 shadow-sm shrink-0">
                            @if(str_starts_with($gallery->image ?? '', 'http'))
                                <img src="{{ $gallery->image }}" class="w-full h-full object-cover" alt="Thumbnail">
                            @else
                                <img src="{{ asset($gallery->image ?? 'assets/img/bg_utama.JPG') }}" class="w-full h-full object-cover" alt="Thumbnail">
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-700 block max-w-md truncate" title="{{ $gallery->title }}">{{ $gallery->title ?? 'Tanpa Judul' }}</span>
                    </td>
                    <td class="px-6 py-5 text-xs text-slate-600 font-bold">
                        {{ $gallery->order_index }}
                    </td>
                    <td class="px-6 py-5 text-xs text-slate-400 font-bold uppercase tracking-widest">
                        <span class="px-3 py-1.5 rounded-lg {{ $gallery->type === 'video' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }} text-[9px] font-black uppercase tracking-wider">
                            {{ $gallery->type }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right w-32">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('dashboard.gallery.edit', $gallery) }}" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-[#1e3a8a] transition-all flex items-center justify-center border border-slate-100 shadow-sm">
                                <i class="fas fa-edit text-[10px]"></i>
                            </a>
                            <form action="{{ route('dashboard.gallery.destroy', $gallery) }}" method="POST" class="inline" id="delete-form-{{ $gallery->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete('delete-form-{{ $gallery->id }}')"
                                        class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center border border-rose-100 shadow-sm">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mb-4">
                                <i class="fas fa-images text-2xl text-slate-200"></i>
                            </div>
                            <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Belum ada foto galeri diunggah</p>
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
                title: 'Hapus foto galeri ini?',
                text: "Foto yang dihapus tidak dapat dikembalikan!",
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
