<x-layouts.dashboard title="Manajemen Kepengurusan | Admin PIK-R">
    <div x-data="{ showModal: false }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Manajemen Kepengurusan</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola Struktur Organisasi PIK-R</p>
            </div>
            <div class="flex items-center gap-3">
                <x-dashboard.button @click="$dispatch('open-modal', { name: 'settings-modal' })" variant="secondary" icon="fas fa-sitemap">
                    Bagan & Periode
                </x-dashboard.button>
                <x-dashboard.button @click="$dispatch('open-modal', { name: 'add-structure' })" variant="primary" icon="fas fa-plus">
                    Tambah Pengurus
                </x-dashboard.button>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <x-dashboard.table :headers="['Foto', 'Nama Lengkap', 'Jabatan', 'Urutan', 'Aksi']" title="Daftar Pengurus (Inti Kepengurusan)" :paginator="$structures">
                @forelse($structures as $index => $structure)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="pl-10 pr-6 py-5 w-24">
                        <div class="w-16 h-16 rounded-xl overflow-hidden border border-slate-100 bg-slate-50 shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                            @if(str_starts_with($structure->image ?? '', 'http'))
                                <img src="{{ $structure->image }}" class="w-full h-full object-cover" alt="{{ $structure->name }}">
                            @elseif($structure->image)
                                <img src="{{ asset($structure->image) }}" class="w-full h-full object-cover" alt="{{ $structure->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fas fa-user text-2xl"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $structure->name }}</td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest border border-blue-100">
                            {{ $structure->position }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-xs text-slate-500 font-bold">
                        {{ $structure->order_index }}
                    </td>
                    <td class="px-6 py-5 text-right w-32">
                        <div class="flex justify-end gap-2">
                            <x-dashboard.button 
                                @click="$dispatch('open-modal', { name: 'edit-structure', data: { id: {{ $structure->id }}, name: '{{ addslashes($structure->name) }}', position: '{{ addslashes($structure->position) }}', order_index: {{ $structure->order_index }}, image: '{{ $structure->image ? (str_starts_with($structure->image, 'http') ? $structure->image : asset($structure->image)) : '' }}' } })"
                                variant="ghost" size="sm" icon="fas fa-edit" class="!shadow-none text-slate-400 hover:text-blue-600"></x-dashboard.button>
                            <form action="{{ route('dashboard.organization-structures.destroy', $structure->id) }}" method="POST" class="inline" id="delete-form-{{ $structure->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete('delete-form-{{ $structure->id }}')"
                                        class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                <i class="fas fa-users-slash text-2xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-400">Belum ada data pengurus</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </x-dashboard.table>
        </div>

        <!-- Add Structure Modal -->
        <x-dashboard.modal name="add-structure" title="Tambah Pengurus Baru" :show="$errors->any() && !old('id')">
            <form action="{{ route('dashboard.organization-structures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="text" name="name" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="Contoh: Ahmad Riyad Firdaus">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Jabatan</label>
                    <div class="relative group">
                        <i class="fas fa-id-badge absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="text" name="position" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="Contoh: Ketua Umum">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Urutan Tampil (Order)</label>
                    <div class="relative group">
                        <i class="fas fa-sort-numeric-down absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="number" name="order_index" value="0" min="0" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="Contoh: 1">
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest ml-1">* Semakin kecil angka, semakin awal ditampilkan.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Foto Pengurus</label>
                    <div class="relative group">
                        <input type="file" name="image" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 hover:border-blue-500/30 rounded-2xl p-8 text-xs font-bold text-slate-400 text-center cursor-pointer transition-all">
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest ml-1">* Format: JPG, PNG (Opsional, direkomendasikan potret)</p>
                </div>

                <div class="pt-6 flex gap-3">
                    <x-dashboard.button @click="$dispatch('close-modal', { name: 'add-structure' })" variant="secondary" class="flex-1 !rounded-2xl py-4">Kembali</x-dashboard.button>
                    <x-dashboard.button type="submit" variant="success" class="flex-[2] !rounded-2xl py-4">Simpan Data</x-dashboard.button>
                </div>
            </form>
        </x-dashboard.modal>

        <!-- Edit Structure Modal -->
        <x-dashboard.modal name="edit-structure" title="Perbarui Pengurus" :show="$errors->any() && old('id')">
            <div x-data="{ id: '{{ old('id') }}', name: '{{ old('name') }}', position: '{{ old('position') }}', order_index: '{{ old('order_index', 0) }}', imageUrl: '' }" 
                 @open-modal.window="if($event.detail.name === 'edit-structure') { id = $event.detail.data.id; name = $event.detail.data.name; position = $event.detail.data.position; order_index = $event.detail.data.order_index; imageUrl = $event.detail.data.image; }">
                <form :action="`{{ url('dashboard/organization-structures') }}/${id}`" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" :value="id">
                    
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="text" name="name" x-model="name" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 ml-1">Jabatan</label>
                        <div class="relative group">
                            <i class="fas fa-id-badge absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="text" name="position" x-model="position" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 ml-1">Urutan Tampil (Order)</label>
                        <div class="relative group">
                            <i class="fas fa-sort-numeric-down absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="number" name="order_index" x-model="order_index" min="0" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 ml-1">Update Foto (Kosongkan jika tidak diganti)</label>
                        <div class="flex items-center gap-4">
                            <template x-if="imageUrl">
                                <div class="w-16 h-16 bg-white rounded-xl border border-slate-100 flex items-center justify-center p-1 shadow-sm shrink-0 overflow-hidden">
                                    <img :src="imageUrl" class="w-full h-full object-cover rounded-lg">
                                </div>
                            </template>
                            <input type="file" name="image" class="flex-1 text-xs font-bold text-slate-400">
                        </div>
                    </div>

                    <div class="pt-6 flex gap-3">
                        <x-dashboard.button @click="$dispatch('close-modal', { name: 'edit-structure' })" variant="secondary" class="flex-1 !rounded-2xl py-4">Kembali</x-dashboard.button>
                        <x-dashboard.button type="submit" variant="primary" class="flex-[2] !rounded-2xl py-4">Update Data</x-dashboard.button>
                    </div>
                </form>
            </div>
        </x-dashboard.modal>

        <!-- Settings Modal (Periode, Subtitle, Bagan Image & Bagan PDF) -->
        <x-dashboard.modal name="settings-modal" title="Pengaturan Bagan & Periode Struktur">
            <div class="p-6">
                <form action="{{ route('dashboard.organization-structures.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 ml-1">Periode Kepengurusan</label>
                        <div class="relative group">
                            <i class="fas fa-calendar-alt absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="text" name="periode" value="{{ $settings['periode'] ?? 'Periode 2025/2026' }}" required placeholder="Contoh: Periode 2025/2026" class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-3.5 text-xs sm:text-sm font-bold text-slate-700 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 ml-1">Sub-judul / Slogan Halaman</label>
                        <textarea name="subtitle" rows="3" placeholder="Deskripsi singkat struktur..." class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl p-4 text-xs sm:text-sm font-bold text-slate-700 transition-all shadow-sm">{{ $settings['subtitle'] ?? '' }}</textarea>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                        <label class="block text-xs font-black text-slate-800">
                            <i class="fas fa-image text-blue-500 mr-1.5"></i> Gambar Bagan Struktur (Diagram)
                        </label>
                        @if(!empty($settings['bagan_image']))
                            <div class="relative w-full h-32 rounded-xl overflow-hidden border border-slate-200 bg-white">
                                <img src="{{ asset($settings['bagan_image']) }}" class="w-full h-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="bagan_image" accept="image/*" class="w-full text-xs font-bold text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                        <p class="text-[10px] text-slate-400">Format: JPG, PNG, WebP. Otomatis dikompresi menjadi WebP ringan.</p>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                        <label class="block text-xs font-black text-slate-800">
                            <i class="fas fa-file-pdf text-rose-500 mr-1.5"></i> File Bagan Struktur (PDF)
                        </label>
                        @if(!empty($settings['bagan_pdf']))
                            <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-file-pdf text-rose-500 text-lg"></i>
                                    <span class="text-xs font-bold text-slate-700 truncate max-w-xs">{{ basename($settings['bagan_pdf']) }}</span>
                                </div>
                                <a href="{{ asset($settings['bagan_pdf']) }}" target="_blank" class="text-xs font-black text-blue-600 hover:underline">Lihat PDF</a>
                            </div>
                        @endif
                        <input type="file" name="bagan_pdf" accept="application/pdf" class="w-full text-xs font-bold text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
                        <p class="text-[10px] text-slate-400">Format: PDF (Maksimal 15MB). Tombol unduh bagan di halaman publik akan aktif jika PDF diunggah.</p>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <x-dashboard.button @click="$dispatch('close-modal', { name: 'settings-modal' })" variant="secondary" class="flex-1 !rounded-2xl py-3.5">Batal</x-dashboard.button>
                        <x-dashboard.button type="submit" variant="primary" class="flex-[2] !rounded-2xl py-3.5">Simpan Pengaturan</x-dashboard.button>
                    </div>
                </form>
            </div>
        </x-dashboard.modal>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Hapus data pengurus ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
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
