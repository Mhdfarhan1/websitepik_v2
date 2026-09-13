<x-layouts.dashboard title="Manajemen Pendaftaran | Admin PIK-R">
    <div class="mb-10">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Daftar Pendaftaran Baru</h2>
        <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-widest text-emerald-600">Review Calon Anggota Baru</p>
    </div>

    @if(session('approval_success'))
        <div class="mb-10 bg-white rounded-[32px] border border-emerald-100 shadow-xl shadow-emerald-500/5 overflow-hidden animate-fade-in">
            <div class="bg-emerald-500 px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-white"></i>
                    <h4 class="text-xs font-black text-white uppercase tracking-widest">Pendaftaran Berhasil Disetujui</h4>
                </div>
                <span class="text-[10px] font-bold text-emerald-100 uppercase tracking-widest">Baru Saja</span>
            </div>
            <div class="p-8 lg:p-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="space-y-2">
                    <p class="text-sm font-bold text-slate-800">Akun untuk <span class="text-emerald-600 underline underline-offset-4 decoration-2 decoration-emerald-200">{{ session('approval_success')['name'] }}</span> telah aktif.</p>
                    <p class="text-xs text-slate-400 font-medium">Silahkan salin password di samping dan kirimkan ke anggota melalui WA/Email.</p>
                </div>
                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 group">
                    <div class="px-6 py-3 bg-white rounded-xl border border-slate-200 shadow-sm">
                        <code class="text-lg font-black text-slate-800 tracking-wider">{{ session('approval_success')['password'] }}</code>
                    </div>
                    <button onclick="copyToClipboard('{{ session('approval_success')['password'] }}')" class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-95 group">
                        <i class="fas fa-copy group-hover:rotate-12 transition-transform"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <p class="text-sm font-bold text-emerald-600">{{ session('success') }}</p>
        </div>
    @endif

    <x-dashboard.table :headers="['Calon Anggota', 'Kontak', 'Alasan Bergabung', 'Status', 'Aksi']" title="Pendaftaran Anggota" :paginator="$registrations">
        @forelse($registrations as $reg)
        <tr class="hover:bg-slate-50/50 transition-colors border-b border-slate-50 last:border-0">
            <td class="pl-10 pr-6 py-5">
                <span class="text-[11px] font-black text-slate-400">{{ $loop->iteration }}</span>
            </td>
            <td class="px-8 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs uppercase">
                        {{ substr($reg->name, 0, 2) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ $reg->name }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">{{ $reg->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </td>
            <td class="px-8 py-5">
                <p class="text-xs font-bold text-slate-600">{{ $reg->email }}</p>
                <p class="text-[10px] text-slate-400 font-medium">{{ $reg->phone }}</p>
            </td>
            <td class="px-8 py-5">
                <p class="text-xs text-slate-500 leading-relaxed max-w-xs truncate" title="{{ $reg->reason }}">
                    {{ $reg->reason }}
                </p>
            </td>
            <td class="px-8 py-5 text-center">
                @if($reg->status === 'pending')
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[9px] font-black uppercase tracking-widest border border-orange-100">Pending</span>
                @elseif($reg->status === 'approved')
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest border border-emerald-100">Disetujui</span>
                @else
                    <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest border border-rose-100">Ditolak</span>
                @endif
            </td>
            <td class="px-8 py-5 pr-10">
                <div class="flex items-center justify-end gap-2">
                    @if($reg->status === 'pending')
                    <form action="{{ route('dashboard.registrations.approve', $reg) }}" method="POST" id="approve-form-{{ $reg->id }}">
                        @csrf
                        <button type="button" 
                                onclick="confirmAction('approve-form-{{ $reg->id }}', 'Setujui pendaftaran ini?', 'Akun akan otomatis dibuatkan oleh sistem.')"
                                class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-user-plus text-[10px]"></i>
                        </button>
                    </form>
                    <form action="{{ route('dashboard.registrations.reject', $reg) }}" method="POST" id="reject-form-{{ $reg->id }}">
                        @csrf
                        <button type="button" 
                                onclick="confirmAction('reject-form-{{ $reg->id }}', 'Tolak pendaftaran ini?', 'Data pendaftaran akan ditandai sebagai ditolak.')"
                                class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-times text-[10px]"></i>
                        </button>
                    </form>
                    @else
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Processed</span>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-6 py-20 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mb-4">
                        <i class="fas fa-inbox text-2xl text-slate-200"></i>
                    </div>
                    <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Belum ada pendaftaran baru</p>
                </div>
            </td>
        </tr>
        @endforelse
    </x-dashboard.table>

    @push('scripts')
    <script>
        function confirmAction(formId, title, text) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e40af',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest',
                    cancelButton: 'px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-slate-400'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Password disalin!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        }
    </script>
    @endpush
</x-layouts.dashboard>
