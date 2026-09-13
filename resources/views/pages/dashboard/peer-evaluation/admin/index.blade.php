<x-layouts.dashboard title="Konfigurasi Kuesioner | Admin PIK-R">
    <div x-data="{ showScheduleModal: false, showQuestionModal: false, editQuestionId: null, editQuestionText: '' }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Konfigurasi Penilaian Peer</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Atur Jadwal Periode dan Indikator Pertanyaan Kuesioner</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dashboard.peer-evaluation.results') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
                    <i class="fas fa-chart-bar"></i>
                    Lihat Hasil Penilaian
                </a>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-10">
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-exclamation-circle text-rose-500"></i>
                    <p class="text-xs font-bold text-rose-600 uppercase tracking-widest">{{ session('error') }}</p>
                </div>
            @endif

            <!-- 1. Jadwal Evaluasi (Schedules) -->
            <x-dashboard.card title="Jadwal Periode Penilaian">
                <div class="p-8 space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sesi Aktif</p>
                            <p class="text-xs font-bold text-slate-500 mt-1">Hanya ada satu jadwal penilaian yang aktif dalam satu waktu.</p>
                        </div>
                        <button @click="showScheduleModal = true" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-[#1e3a8a]/10 transition-all flex items-center gap-2">
                            <i class="fas fa-plus text-[10px]"></i> Buat Jadwal Baru
                        </button>
                    </div>

                    <!-- Table Container -->
                    <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm bg-white">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/70 border-b border-slate-100">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Jadwal/Periode</th>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Mulai</th>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Selesai</th>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($schedules as $sched)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-5 text-xs font-bold text-slate-700">{{ $sched->title }}</td>
                                        <td class="px-8 py-5 text-xs text-slate-500 font-bold">{{ $sched->start_date->format('d M Y') }}</td>
                                        <td class="px-8 py-5 text-xs text-slate-500 font-bold">{{ $sched->end_date->format('d M Y') }}</td>
                                        <td class="px-8 py-5 text-center">
                                            <form action="{{ route('dashboard.peer-evaluation.schedules.toggle', $sched->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" @class([
                                                    'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest transition-all cursor-pointer hover:scale-105 active:scale-95 border',
                                                    'bg-emerald-50 text-emerald-600 border-emerald-200' => $sched->is_active,
                                                    'bg-slate-50 text-slate-400 border-slate-200' => !$sched->is_active,
                                                ])>
                                                    {{ $sched->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-8 py-5 text-right w-28">
                                            <form action="{{ route('dashboard.peer-evaluation.schedules.destroy', $sched->id) }}" method="POST" class="inline" id="delete-sched-{{ $sched->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('delete-sched-{{ $sched->id }}', 'Hapus jadwal evaluasi ini?')"
                                                        class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all inline-flex items-center justify-center border border-rose-100 shadow-sm">
                                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50/10">Belum ada jadwal yang dibuat</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- 2. Pertanyaan/Indikator (Questions) -->
            <x-dashboard.card title="Indikator & Pertanyaan Penilaian">
                <div class="p-8 space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Pertanyaan</p>
                            <p class="text-xs font-bold text-slate-500 mt-1">Aspek penilaian sesama rekan anggota menggunakan opsi respon (Buruk, Sedang, Baik, Sangat Baik).</p>
                        </div>
                        <button @click="showQuestionModal = true; editQuestionId = null; editQuestionText = ''" class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-[#1e3a8a]/10 transition-all flex items-center gap-2">
                            <i class="fas fa-plus text-[10px]"></i> Tambah Indikator
                        </button>
                    </div>

                    <!-- Table Container -->
                    <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm bg-white">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/70 border-b border-slate-100">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-16 text-center">No</th>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pertanyaan / Aspek Dinilai</th>
                                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($questions as $index => $q)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-5 text-xs font-bold text-slate-400 text-center">{{ $index + 1 }}</td>
                                        <td class="px-8 py-5 text-xs font-bold text-slate-700">{{ $q->question_text }}</td>
                                        <td class="px-8 py-5 text-right w-36">
                                            <div class="flex justify-end gap-2">
                                                <button @click="showQuestionModal = true; editQuestionId = {{ $q->id }}; editQuestionText = '{{ addslashes($q->question_text) }}'"
                                                        class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-[#1e3a8a] transition-all flex items-center justify-center border border-slate-100 shadow-sm">
                                                    <i class="fas fa-edit text-[10px]"></i>
                                                </button>
                                                <form action="{{ route('dashboard.peer-evaluation.questions.destroy', $q->id) }}" method="POST" class="inline" id="delete-q-{{ $q->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            onclick="confirmDelete('delete-q-{{ $q->id }}', 'Hapus indikator penilaian ini?')"
                                                            class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center border border-rose-100 shadow-sm">
                                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-12 text-center text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50/10">Belum ada indikator pertanyaan yang dibuat</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </x-dashboard.card>
        </div>

        <!-- Create Schedule Modal -->
        <div x-show="showScheduleModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showScheduleModal = false"></div>
                <div class="relative bg-white w-full max-w-lg rounded-[28px] shadow-2xl overflow-hidden p-8 space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-black text-slate-800">Buat Jadwal Baru</h3>
                        <button @click="showScheduleModal = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                    </div>
                    <form action="{{ route('dashboard.peer-evaluation.schedules.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama / Judul Jadwal</label>
                            <input type="text" name="title" required placeholder="Contoh: Evaluasi Akhir Semester 2026" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-slate-700">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Mulai</label>
                                <input type="date" name="start_date" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-slate-650">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Selesai</label>
                                <input type="date" name="end_date" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-slate-650">
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex gap-3">
                            <button type="button" @click="showScheduleModal = false" class="flex-1 bg-slate-50 py-3 rounded-xl font-bold text-xs text-slate-400 uppercase tracking-wide">Batal</button>
                            <button type="submit" class="flex-[2] bg-blue-600 py-3 rounded-xl font-bold text-xs text-white uppercase tracking-wide">Buat Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create/Edit Question Modal -->
        <div x-show="showQuestionModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showQuestionModal = false"></div>
                <div class="relative bg-white w-full max-w-lg rounded-[28px] shadow-2xl overflow-hidden p-8 space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-black text-slate-800" x-text="editQuestionId ? 'Edit Indikator Penilaian' : 'Tambah Indikator Penilaian'"></h3>
                        <button @click="showQuestionModal = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                    </div>
                    <form :action="editQuestionId ? '{{ url('/dashboard/peer-evaluation/questions') }}/' + editQuestionId : '{{ route('dashboard.peer-evaluation.questions.store') }}'" method="POST" class="space-y-4">
                        @csrf
                        <template x-if="editQuestionId">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pertanyaan / Pernyataan Penilaian</label>
                            <textarea name="question_text" required x-model="editQuestionText" rows="4" placeholder="Contoh: Apakah anggota ini aktif dalam menghadiri rapat mingguan?" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-semibold text-slate-700"></textarea>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex gap-3">
                            <button type="button" @click="showQuestionModal = false" class="flex-1 bg-slate-50 py-3 rounded-xl font-bold text-xs text-slate-400 uppercase tracking-wide">Batal</button>
                            <button type="submit" class="flex-[2] bg-blue-600 py-3 rounded-xl font-bold text-xs text-white uppercase tracking-wide" x-text="editQuestionId ? 'Simpan Perubahan' : 'Tambah Indikator'"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function confirmDelete(formId, titleText) {
            Swal.fire({
                title: titleText || 'Hapus data ini?',
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
