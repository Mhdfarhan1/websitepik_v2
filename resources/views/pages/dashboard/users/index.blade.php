<x-layouts.dashboard title="Manajemen Akun | Admin PIK-R">
    <div x-data="{ showModal: false }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Manajemen Akun</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola Admin, Pembina, & Ketua</p>
            </div>
            <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-blue-600/20 transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Akun
            </button>
        </header>

        <div class="p-6 lg:p-10 max-w-6xl mx-auto w-full">
            <x-dashboard.card title="Daftar Akun Terdaftar">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Nama Lengkap</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Email</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-center">Role</th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-black text-xs border border-blue-100 shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-bold text-slate-700">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-slate-500 font-medium">{{ $user->email }}</td>
                                <td class="px-8 py-5 text-center">
                                    <span @class([
                                        'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest',
                                        'bg-rose-50 text-rose-600' => $user->role === 'super_admin',
                                        'bg-blue-50 text-blue-600' => $user->role === 'pembina',
                                        'bg-orange-50 text-orange-600' => $user->role === 'ketua',
                                    ])>
                                        {{ str_replace('_', ' ', $user->role) }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-[10px] font-bold text-slate-300 uppercase italic">Your Account</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-dashboard.card>
        </div>

        <!-- Add User Modal -->
        <div x-show="showModal" 
             class="fixed inset-0 z-[100] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModal = false"></div>
                
                <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xl font-black text-slate-800">Tambah Akun Baru</h3>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form action="{{ route('dashboard.users.store') }}" method="POST" class="p-8 space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-blue-500/20 transition-all" placeholder="Masukkan nama lengkap...">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Aktif</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-blue-500/20 transition-all" placeholder="name@pikr.com">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Password Akun</label>
                            <input type="password" name="password" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-blue-500/20 transition-all" placeholder="Min. 8 karakter">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Role Akses</label>
                            <select name="role" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-blue-500/20 transition-all appearance-none cursor-pointer">
                                <option value="ketua">Ketua</option>
                                <option value="pembina">Pembina</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-sm shadow-xl shadow-blue-600/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                                Simpan Akun Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
