<x-layouts.dashboard title="Penilaian Peer Anggota | PIK-R">
    <div x-data="{ activeTab: 'evaluate', showModal: false, selectedEval: null }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div>
                <h1 class="text-xl font-black text-slate-800">Penilaian Rekan Anggota</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Berikan Umpan Balik Positif & Lihat Review Rekan Anda</p>
            </div>
            
            <!-- Tab Buttons (Clean Pills Style) -->
            <div class="bg-slate-100 p-1 rounded-xl flex gap-1 border border-slate-200 shadow-inner">
                <button @click="activeTab = 'evaluate'" 
                        :class="activeTab === 'evaluate' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer">
                    Beri Penilaian
                </button>
                <button @click="activeTab = 'feedback'" 
                        :class="activeTab === 'feedback' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer">
                    Hasil Penilaian Saya
                </button>
            </div>
        </header>

        <div class="p-6 lg:p-8 max-w-5xl mx-auto w-full">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-exclamation-circle text-rose-500"></i>
                    <p class="text-xs font-bold text-rose-600 uppercase tracking-widest">{{ session('error') }}</p>
                </div>
            @endif

            <!-- TAB 1: EVALUATE PEERS -->
            <div x-show="activeTab === 'evaluate'" x-transition class="space-y-6">
                
                @if($activeSchedule)
                    <!-- Unified Evaluation Card Container -->
                    <div class="bg-white border border-slate-200/60 rounded-xl overflow-hidden shadow-sm">
                        
                        <!-- 1. Card Header with Schedule & Progress -->
                        <div class="p-6 lg:px-8 border-b border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-[0.2em]">{{ $activeSchedule->title }}</h2>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-[8px] font-bold uppercase tracking-widest">
                                        <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Aktif
                                    </span>
                                </div>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">
                                    Periode: {{ $activeSchedule->start_date->format('d M Y') }} – {{ $activeSchedule->end_date->format('d M Y') }}
                                </p>
                            </div>

                            <!-- Progress Pill -->
                            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-slate-200/60 text-xs font-bold">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Progres:</span>
                                <span class="text-slate-800 font-black text-sm">{{ count($evaluatedPeerIds) }} / {{ count($peers) }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Anggota</span>
                            </div>
                        </div>

                        <!-- 2. Integrated Warning Alert Strip -->
                        <div class="px-6 lg:px-8 py-3 bg-amber-50/50 border-b border-amber-100/50 flex items-center gap-2 text-[10px] text-amber-800 font-semibold uppercase tracking-wider">
                            <i class="fas fa-exclamation-circle text-amber-500 shrink-0 text-xs"></i>
                            <span>Setiap rekan hanya dapat dinilai sekali per periode evaluasi secara objektif.</span>
                        </div>

                        <!-- 3. Table Listing -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left custom-table">
                                <thead>
                                    <tr>
                                        <th class="text-center w-16">No</th>
                                        <th>Nama Anggota</th>
                                        <th>Jabatan / Role</th>
                                        <th class="text-center w-40">Status</th>
                                        <th class="text-center w-44">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($peers as $index => $peer)
                                        @php
                                            $isEvaluated = in_array($peer->id, $evaluatedPeerIds);
                                        @endphp
                                        <tr>
                                            <td class="text-center font-bold text-slate-400 text-xs">{{ $index + 1 }}</td>
                                            <td>
                                                <span class="font-bold text-slate-700">{{ $peer->name }}</span>
                                            </td>
                                            <td>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">{{ str_replace('_', ' ', $peer->role) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($isEvaluated)
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-bold uppercase tracking-wider">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sudah Dinilai
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-600 border border-amber-100 text-[9px] font-bold uppercase tracking-wider">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Belum Diisi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($isEvaluated)
                                                    <button disabled class="bg-slate-50 text-slate-400 px-4 py-2 rounded-xl text-xs font-bold border border-slate-100 cursor-not-allowed inline-block w-full max-w-[130px] text-center">
                                                        Selesai
                                                    </button>
                                                @else
                                                    <a href="{{ route('dashboard.peer-evaluation.evaluate', $peer->id) }}" 
                                                       class="bg-[#1e3a8a] hover:bg-[#1a337a] text-white px-4 py-2 rounded-xl text-xs font-bold shadow-md shadow-blue-500/5 transition-all inline-block w-full max-w-[130px] text-center cursor-pointer">
                                                        Isi Sekarang
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest py-12 bg-slate-50/10">Belum ada rekan anggota lain terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <!-- No Active Schedule Banner -->
                    <div class="bg-white rounded-xl border border-slate-200/60 p-12 text-center shadow-sm max-w-xl mx-auto space-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mx-auto text-slate-350">
                            <i class="fas fa-calendar-times text-2xl"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-base font-black text-slate-700">Jadwal Evaluasi Belum Dibuka</h3>
                            <p class="text-xs text-slate-450 font-medium max-w-md mx-auto leading-relaxed">
                                Pengisian kuesioner saat ini sedang ditutup. Harap tunggu periode pengisian selanjutnya yang akan diatur oleh Super Admin.
                            </p>
                        </div>
                    </div>
                @endif

            </div>

            <!-- TAB 2: MY FEEDBACKS RECEIVED -->
            <div x-show="activeTab === 'feedback'" x-transition style="display: none;" class="space-y-8">
                
                <!-- Overall stats card -->
                @if(count($receivedEvaluations) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-8 rounded-xl border border-slate-200/60 shadow-sm flex items-center gap-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1e3a8a] border border-blue-100 flex items-center justify-center text-xl shadow-sm shrink-0">
                            <i class="fas fa-chart-line-up"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Rata-Rata Skor Saya</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="text-2xl font-black text-slate-800">{{ number_format($avgScore, 2) }}</span>
                                <span class="text-xs font-bold text-slate-400">/ 4.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-xl border border-slate-200/60 shadow-sm flex items-center gap-6">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-xl shadow-sm shrink-0">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Kategori Penilaian</span>
                            <span @class([
                                'px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest mt-1 block border shadow-sm w-max',
                                'bg-rose-50 text-rose-600 border-rose-100' => $verbalRating === 'Buruk',
                                'bg-amber-50 text-amber-600 border-amber-100' => $verbalRating === 'Sedang',
                                'bg-blue-50 text-blue-600 border-blue-100' => $verbalRating === 'Baik',
                                'bg-emerald-50 text-emerald-600 border-emerald-100' => $verbalRating === 'Sangat Baik',
                            ])>
                                {{ $verbalRating }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Feedbacks listing table -->
                <div class="space-y-6">
                    <x-dashboard.card title="Daftar Umpan Balik Rekan">
                        <div class="p-6 lg:p-8 space-y-4">
                            
                            <!-- Table Container -->
                            <div class="border border-slate-100 rounded-2xl overflow-hidden bg-white shadow-inner">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left custom-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center w-16">No</th>
                                                <th>Rekan Evaluator</th>
                                                <th class="text-center w-32">Rata-Rata</th>
                                                <th>Komentar / Masukan</th>
                                                <th class="text-center w-24">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($receivedEvaluations as $index => $eval)
                                                @php
                                                    $evalAvgScore = $eval->scores->avg('score');
                                                    $evaluatorName = $eval->evaluator->name ?? 'Anonim';
                                                    $evaluatorRole = $eval->evaluator->role ?? 'anggota';
                                                    $scoresData = $eval->scores->map(fn($s) => [
                                                        'question' => $s->question->question_text,
                                                        'score' => $s->score
                                                    ])->toArray();
                                                @endphp
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="text-center font-bold text-slate-400 text-xs">{{ $index + 1 }}</td>
                                                    <td>
                                                        <span class="font-bold text-slate-700 block leading-tight">{{ $evaluatorName }}</span>
                                                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider block mt-0.5">{{ $eval->created_at->format('d M Y H:i') }}</span>
                                                    </td>
                                                    <td class="text-center font-black text-slate-800">
                                                        {{ number_format($evalAvgScore, 2) }}
                                                    </td>
                                                    <td class="max-w-[240px]">
                                                        @if($eval->comment)
                                                            <span class="text-xs text-slate-500 truncate block font-medium" title="{{ $eval->comment }}">
                                                                {{ $eval->comment }}
                                                            </span>
                                                        @else
                                                            <span class="text-xs text-slate-350 italic font-medium">Tidak ada komentar</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <button @click="selectedEval = {{ json_encode([
                                                            'evaluator' => $evaluatorName,
                                                            'role' => strtoupper(str_replace('_', ' ', $evaluatorRole)),
                                                            'date' => $eval->created_at->format('d M Y - H:i'),
                                                            'comment' => $eval->comment,
                                                            'scores' => $scoresData
                                                        ]) }}; showModal = true" 
                                                                class="w-8 h-8 rounded-lg bg-blue-50 text-blue-650 hover:bg-blue-600 hover:text-white transition-all inline-flex items-center justify-center border border-blue-100 shadow-sm cursor-pointer">
                                                            <i class="fas fa-eye text-[10px]"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </x-dashboard.card>
                </div>
                @else
                <!-- No received reviews -->
                <div class="bg-white rounded-xl border border-slate-200/60 p-12 text-center shadow-sm max-w-xl mx-auto space-y-4">
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mx-auto text-slate-350">
                        <i class="fas fa-comment-slash text-2xl"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base font-black text-slate-700">Belum Ada Umpan Balik</h3>
                        <p class="text-xs text-slate-450 font-medium max-w-md mx-auto leading-relaxed">
                            Rekan anggota belum memberikan penilaian atau umpan balik untuk Anda dalam periode aktif.
                        </p>
                    </div>
                </div>
                @endif

            </div>

        </div>

        <!-- Detail Evaluation Modal -->
        <div x-show="showModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
             
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            
            <!-- Modal Body -->
            <div class="flex items-center justify-center min-h-screen p-4 relative z-10">
                <div class="bg-white rounded-3xl max-w-2xl w-full border border-slate-100 shadow-2xl overflow-hidden transform transition-all space-y-6 p-6 lg:p-8">
                    
                    <!-- Modal Header -->
                    <div class="flex justify-between items-start border-b border-slate-100 pb-4">
                        <div class="space-y-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Detail Penilaian Rekan</span>
                            <h3 class="text-base font-black text-slate-800" x-text="selectedEval ? selectedEval.evaluator : ''"></h3>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded bg-slate-50 border border-slate-200 text-[8px] font-bold text-slate-400 uppercase tracking-widest" x-text="selectedEval ? selectedEval.role : ''"></span>
                                <span class="text-slate-300 text-[10px]">|</span>
                                <span class="text-[10px] text-slate-400 font-semibold" x-text="selectedEval ? selectedEval.date : ''"></span>
                            </div>
                        </div>
                        <button @click="showModal = false" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-all cursor-pointer">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Scores breakdown list -->
                    <div class="space-y-3.5 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                        <template x-if="selectedEval">
                            <template x-for="(s, index) in selectedEval.scores" :key="index">
                                <div class="flex justify-between items-center py-2.5 border-b border-slate-50 last:border-0">
                                    <div class="flex gap-2.5 items-start pr-4">
                                        <span class="w-5 h-5 rounded bg-blue-50 text-[10px] font-bold text-blue-600 flex items-center justify-center shrink-0 mt-0.5" x-text="index + 1"></span>
                                        <span class="text-xs font-semibold text-slate-700 leading-normal" x-text="s.question"></span>
                                    </div>
                                    <span :class="{
                                        'bg-rose-50 text-rose-600': s.score === 1,
                                        'bg-amber-50 text-amber-600': s.score === 2,
                                        'bg-blue-50 text-blue-600': s.score === 3,
                                        'bg-emerald-50 text-emerald-600': s.score === 4
                                    }" class="px-2.5 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider shrink-0" x-text="s.score === 1 ? 'Buruk' : (s.score === 2 ? 'Sedang' : (s.score === 3 ? 'Baik' : 'Sangat Baik'))">
                                    </span>
                                </div>
                            </template>
                        </template>
                    </div>

                    <!-- Comment -->
                    <template x-if="selectedEval && selectedEval.comment">
                        <div class="bg-slate-50 border-l-4 border-blue-600 p-4 rounded-r-2xl shadow-sm space-y-1">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest block">Komentar Masukan</span>
                            <p class="text-xs text-slate-650 font-bold italic leading-relaxed" x-text="'&ldquo;' + selectedEval.comment + '&rdquo;'"></p>
                        </div>
                    </template>

                    <!-- Footer action -->
                    <div class="flex pt-2 justify-end">
                        <button @click="showModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.dashboard>

<style>
    /* Force exact styles to match table.blade.php */
    .custom-table th {
        padding: 1.25rem 1.5rem !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .custom-table td {
        padding: 1.25rem 1.5rem !important;
        font-size: 13px !important;
        color: #334155 !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f8fafc !important;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none !important;
    }
    .custom-table tbody tr:hover {
        background-color: rgba(248, 250, 252, 0.5) !important;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
