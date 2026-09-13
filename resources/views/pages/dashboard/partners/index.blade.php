<x-layouts.dashboard title="Manajemen Mitra | Admin PIK-R">
    <div x-data="{ showModal: false }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Jejaring Mitra</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola Partner & Kolaborasi</p>
            </div>
            <x-dashboard.button @click="$dispatch('open-modal', { name: 'add-partner' })" variant="primary" icon="fas fa-plus">
                Tambah Mitra
            </x-dashboard.button>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full">
            <x-dashboard.table :headers="['Logo', 'Nama Mitra', 'Aksi']" :paginator="$partners">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-8 py-5 text-xs font-bold text-slate-400">{{ ($partners->currentPage() - 1) * $partners->perPage() + $index + 1 }}</td>
                    <td class="px-8 py-5">
                        <div class="w-16 h-12 bg-white rounded-xl border border-slate-100 flex items-center justify-center p-2 shadow-sm overflow-hidden group-hover:scale-105 transition-transform">
                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain">
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm font-bold text-slate-700">{{ $partner->name }}</td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <x-dashboard.button 
                                @click="$dispatch('open-modal', { name: 'edit-partner', data: { id: {{ $partner->id }}, name: '{{ $partner->name }}', logo: '{{ asset('storage/' . $partner->logo) }}' } })"
                                variant="ghost" size="sm" icon="fas fa-edit" class="!shadow-none text-slate-400 hover:text-blue-600"></x-dashboard.button>
                            <form action="{{ route('dashboard.partners.destroy', $partner) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-10 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                <i class="fas fa-handshake-slash text-2xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-400">Belum ada data mitra</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </x-dashboard.table>
        </div>

        <!-- Add Partner Modal -->
        <x-dashboard.modal name="add-partner" title="Tambah Mitra Baru" :show="$errors->any() && !old('id')">
            <form action="{{ route('dashboard.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Nama Mitra</label>
                    <div class="relative group">
                        <i class="fas fa-building absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="text" name="name" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="Contoh: Dinas Kesehatan">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Logo Mitra</label>
                    <div class="relative group">
                        <input type="file" name="logo" required class="w-full bg-slate-50 border-2 border-dashed border-slate-200 hover:border-blue-500/30 rounded-2xl p-8 text-xs font-bold text-slate-400 text-center cursor-pointer transition-all">
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest ml-1">* Format: JPG, PNG, SVG (Maks. 5MB)</p>
                </div>

                <div class="pt-6 flex gap-3">
                    <x-dashboard.button @click="$dispatch('close-modal', { name: 'add-partner' })" variant="secondary" class="flex-1 !rounded-2xl py-4">Kembali</x-dashboard.button>
                    <x-dashboard.button type="submit" variant="success" class="flex-[2] !rounded-2xl py-4">Simpan Mitra</x-dashboard.button>
                </div>
            </form>
        </x-dashboard.modal>

        <!-- Edit Partner Modal -->
        <x-dashboard.modal name="edit-partner" title="Perbarui Mitra" :show="$errors->any() && old('id')">
            <div x-data="{ id: '{{ old('id') }}', name: '{{ old('name') }}', logoUrl: '' }" 
                 @open-modal.window="if($event.detail.name === 'edit-partner') { id = $event.detail.data.id; name = $event.detail.data.name; logoUrl = $event.detail.data.logo; }">
                <form :action="`{{ url('dashboard/partners') }}/${id}`" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" :value="id">
                    
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 ml-1">Nama Mitra</label>
                        <div class="relative group">
                            <i class="fas fa-building absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="text" name="name" x-model="name" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 ml-1">Update Logo (Kosongkan jika tidak diganti)</label>
                        <div class="flex items-center gap-4">
                            <template x-if="logoUrl">
                                <div class="w-16 h-12 bg-white rounded-xl border border-slate-100 flex items-center justify-center p-2 shadow-sm shrink-0">
                                    <img :src="logoUrl" class="max-w-full max-h-full object-contain">
                                </div>
                            </template>
                            <input type="file" name="logo" class="flex-1 text-xs font-bold text-slate-400">
                        </div>
                    </div>

                    <div class="pt-6 flex gap-3">
                        <x-dashboard.button @click="$dispatch('close-modal', { name: 'edit-partner' })" variant="secondary" class="flex-1 !rounded-2xl py-4">Kembali</x-dashboard.button>
                        <x-dashboard.button type="submit" variant="primary" class="flex-[2] !rounded-2xl py-4">Update Data</x-dashboard.button>
                    </div>
                </form>
            </div>
        </x-dashboard.modal>
    </div>
</x-layouts.dashboard>
