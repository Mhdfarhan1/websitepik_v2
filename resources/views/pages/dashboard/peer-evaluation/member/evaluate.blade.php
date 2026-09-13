<x-layouts.dashboard title="Isi Penilaian Anggota | PIK-R">
    <div>
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.peer-evaluation.index') }}" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Beri Penilaian Rekan</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Periode Aktif: {{ $activeSchedule->title }}</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-5xl mx-auto w-full space-y-8">
            
            <!-- Evaluatee Info Profile Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center font-black text-sm text-blue-650 shrink-0">
                    {{ strtoupper(substr($peer->name, 0, 2)) }}
                </div>
                <div class="space-y-0.5">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Menilai Anggota</span>
                    <h2 class="text-sm font-black text-slate-700 block">{{ $peer->name }}</h2>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block">{{ str_replace('_', ' ', $peer->role) }}</span>
                </div>
            </div>

            <form action="{{ route('dashboard.peer-evaluation.submit', $peer->id) }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Table Card -->
                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/70 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-16">No</th>
                                    <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pertanyaan / Aspek Dinilai</th>
                                    <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-28">Buruk</th>
                                    <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-28">Sedang</th>
                                    <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-28">Baik</th>
                                    <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-32">Sangat Baik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($questions as $index => $q)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5 text-xs font-bold text-slate-400 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-5 text-xs font-bold text-slate-700 leading-normal">{{ $q->question_text }}</td>
                                    
                                    <!-- Buruk -->
                                    <td class="px-6 py-5 text-center">
                                        <label class="relative inline-flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" name="scores[{{ $q->id }}]" value="1" required class="sr-only peer">
                                            <div class="w-5 h-5 rounded-full border border-slate-300 bg-white flex items-center justify-center peer-checked:border-rose-500 peer-checked:bg-rose-500 transition-all shadow-sm">
                                                <i class="fas fa-check text-[9px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                            </div>
                                        </label>
                                    </td>

                                    <!-- Sedang -->
                                    <td class="px-6 py-5 text-center">
                                        <label class="relative inline-flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" name="scores[{{ $q->id }}]" value="2" required class="sr-only peer">
                                            <div class="w-5 h-5 rounded-full border border-slate-300 bg-white flex items-center justify-center peer-checked:border-amber-500 peer-checked:bg-amber-500 transition-all shadow-sm">
                                                <i class="fas fa-check text-[9px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                            </div>
                                        </label>
                                    </td>

                                    <!-- Baik -->
                                    <td class="px-6 py-5 text-center">
                                        <label class="relative inline-flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" name="scores[{{ $q->id }}]" value="3" required class="sr-only peer">
                                            <div class="w-5 h-5 rounded-full border border-slate-300 bg-white flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500 transition-all shadow-sm">
                                                <i class="fas fa-check text-[9px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                            </div>
                                        </label>
                                    </td>

                                    <!-- Sangat Baik -->
                                    <td class="px-6 py-5 text-center">
                                        <label class="relative inline-flex items-center justify-center cursor-pointer select-none">
                                            <input type="radio" name="scores[{{ $q->id }}]" value="4" required class="sr-only peer">
                                            <div class="w-5 h-5 rounded-full border border-slate-300 bg-white flex items-center justify-center peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition-all shadow-sm">
                                                <i class="fas fa-check text-[9px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Written Comment Card -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 lg:p-8 space-y-3 shadow-sm">
                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-widest ml-1">Komentar Masukan / Saran Perkembangan</label>
                    <textarea name="comment" rows="4" placeholder="Tulis komentar konstruktif Anda untuk membantu perkembangan kinerja rekan Anda..." 
                              class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-xs font-semibold text-slate-750 focus:ring-2 focus:ring-blue-500/20 transition-all"></textarea>
                </div>

                <!-- Submit buttons -->
                <div class="flex gap-4 pt-2">
                    <a href="{{ route('dashboard.peer-evaluation.index') }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-500 py-4 rounded-2xl font-bold text-xs uppercase tracking-wider text-center transition-all">
                        Kembali
                    </a>
                    <button type="submit" class="flex-[2] bg-blue-600 hover:bg-blue-750 text-white py-4 rounded-2xl font-bold text-xs uppercase tracking-wider text-center shadow-lg shadow-blue-600/20 transition-all">
                        Kirim Penilaian
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-layouts.dashboard>
