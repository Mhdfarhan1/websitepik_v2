<x-layouts.dashboard title="Akun Anggota | Admin PIK-R">
    <div x-data="{ showModal: false }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Akun Anggota</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Daftar Anggota Aktif PIK-R</p>
            </div>
            <x-dashboard.button @click="$dispatch('open-modal', { name: 'add-anggota' })" variant="primary" icon="fas fa-plus">
                Tambah Anggota Manual
            </x-dashboard.button>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full">
            <x-dashboard.table :headers="['Nama Lengkap', 'Email', 'Status Keamanan', 'Aksi']" :paginator="$users">
                @forelse($users as $index => $user)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-8 py-5 text-xs font-bold text-slate-400">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 font-black text-xs border border-emerald-100 shadow-sm group-hover:scale-110 transition-transform">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-bold text-slate-700">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-500 font-medium">{{ $user->email }}</td>
                    <td class="px-8 py-5">
                        @if($user->must_change_password)
                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-widest border border-amber-100">Menunggu Reset</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest border border-emerald-100">Selesai Reset</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <x-dashboard.button 
                                @click="$dispatch('open-modal', { name: 'edit-anggota', data: { id: {{ $user->id }}, name: '{{ $user->name }}', email: '{{ $user->email }}' } })"
                                variant="ghost" size="sm" icon="fas fa-edit" class="!shadow-none text-slate-400 hover:text-blue-600"></x-dashboard.button>
                            <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun anggota ini?')">
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
                    <td colspan="5" class="px-8 py-10 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                <i class="fas fa-user-slash text-2xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-400">Belum ada akun anggota</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </x-dashboard.table>
        </div>

        <!-- Add User Modal -->
        <x-dashboard.modal name="add-anggota" title="Tambah Anggota Baru" :show="$errors->any() && !old('id')">
            <form action="{{ route('dashboard.users.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="anggota">
                
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="text" name="name" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="Nama Anggota">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Email Aktif</label>
                    <div class="relative group">
                        <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="email" name="email" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="email@anggota.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 ml-1">Password Baru</label>
                    <div class="relative group">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="password" name="password" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="Masukkan password...">
                    </div>
                </div>

                <div class="pt-6 flex gap-3">
                    <x-dashboard.button @click="$dispatch('close-modal', { name: 'add-anggota' })" variant="secondary" class="flex-1 !rounded-2xl py-4">Kembali</x-dashboard.button>
                    <x-dashboard.button type="submit" variant="success" class="flex-[2] !rounded-2xl py-4">Simpan Akun</x-dashboard.button>
                </div>
            </form>
        </x-dashboard.modal>

        <!-- Edit User Modal -->
        <x-dashboard.modal name="edit-anggota" title="Edit Akun Anggota" :show="$errors->any() && old('id')">
            <div x-data="{ id: '{{ old('id') }}', name: '{{ old('name') }}', email: '{{ old('email') }}' }" 
                 @open-modal.window="if($event.detail.name === 'edit-anggota') { id = $event.detail.data.id; name = $event.detail.data.name; email = $event.detail.data.email; }">
                <form :action="`{{ url('dashboard/users') }}/${id}`" method="POST" class="space-y-6">
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
                        <label class="block text-xs font-black text-slate-700 ml-1">Email Aktif</label>
                        <div class="relative group">
                            <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="email" name="email" x-model="email" required class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 ml-1">Password Baru (Kosongkan jika tidak diganti)</label>
                        <div class="relative group">
                            <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="password" name="password" class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500/10 focus:bg-white rounded-2xl px-12 py-4 text-sm font-bold text-slate-600 transition-all shadow-sm" placeholder="Masukkan password baru...">
                        </div>
                    </div>

                    <div class="pt-6 flex gap-3">
                        <x-dashboard.button @click="$dispatch('close-modal', { name: 'edit-anggota' })" variant="secondary" class="flex-1 !rounded-2xl py-4">Kembali</x-dashboard.button>
                        <x-dashboard.button type="submit" variant="primary" class="flex-[2] !rounded-2xl py-4">Perbarui Akun</x-dashboard.button>
                    </div>
                </form>
            </div>
        </x-dashboard.modal>
    </div>
</x-layouts.dashboard>
