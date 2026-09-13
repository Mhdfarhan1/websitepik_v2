<x-layouts.dashboard title="Detail Penilaian Anggota | Admin PIK-R">
    <div x-data="{ showModal: false, selectedEval: null }">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.peer-evaluation.results', ['schedule_id' => $selectedScheduleId]) }}" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800">Laporan Detail Penilaian</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Umpan Balik Individu dan Nilai Per Indikator</p>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8">
            
            <!-- Member Profile Header -->
            <div class="bg-white p-6 lg:p-8 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col sm:flex-row items-center gap-6">
                <div class="w-16 h-16 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-650 text-xl font-black shadow-sm shrink-0">
                    {{ strtoupper(substr($report['member']->name, 0, 2)) }}
                </div>
                <div class="flex-1 text-center sm:text-left space-y-1.5">
                    <h2 class="text-lg font-black text-slate-850">{{ $report['member']->name }}</h2>
                    <div class="flex flex-wrap justify-center sm:justify-start items-center gap-3">
                        <span class="px-3 py-0.5 rounded-full bg-slate-50 text-slate-400 border border-slate-200/80 text-[9px] font-bold uppercase tracking-widest">
                            {{ strtoupper(str_replace('_', ' ', $report['member']->role)) }}
                        </span>
                        <span class="text-slate-200 text-xs">|</span>
                        <span class="text-xs font-bold text-slate-500">{{ $report['member']->email }}</span>
                    </div>
                </div>
                <div class="shrink-0 bg-slate-50/70 border border-slate-100 rounded-2xl px-6 py-4 text-center min-w-[140px]">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Total Evaluator</span>
                    <span class="text-2xl font-black text-slate-800 block mt-0.5">{{ count($report['evaluations']) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Left: Question Averages breakdown -->
                <div class="lg:col-span-1 space-y-6">
                    <x-dashboard.card title="Rata-Rata per Indikator">
                        <div class="p-6 lg:p-8 space-y-4">
                            @forelse($report['question_averages'] as $avg)
                            <div class="space-y-2 pb-3.5 border-b border-slate-50 last:border-0 last:pb-0">
                                <span class="text-xs font-bold text-slate-700 block leading-tight">{{ $avg['question'] }}</span>
                                <div class="flex items-center justify-between gap-4 pt-1">
                                    <div class="flex-1 bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-blue-600 h-full rounded-full" style="width: {{ ($avg['avg_score'] / 4) * 100 }}%"></div>
                                    </div>
                                    <span class="text-xs font-black text-slate-800 shrink-0">
                                        {{ number_format($avg['avg_score'], 2) }} <span class="text-[9px] text-slate-400 font-bold">/ 4</span>
                                    </span>
                                </div>
                            </div>
                            @empty
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider text-center py-6">Belum ada nilai terekam</p>
                            @endforelse
                        </div>
                    </x-dashboard.card>

                    <!-- Rating Scale Info -->
                    <div class="bg-white border border-slate-200/60 rounded-3xl p-6 space-y-4 shadow-sm">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider border-b border-slate-50 pb-2">Keterangan Skala Nilai</h4>
                        <div class="grid grid-cols-2 gap-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Buruk (1)</div>
                            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Sedang (2)</div>
                            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Baik (3)</div>
                            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Sangat Baik (4)</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Compact evaluations log table -->
                <div class="lg:col-span-2 space-y-6">
                    <x-dashboard.card title="Daftar Ulasan & Masukan Rekan">
                        <div class="p-6 lg:p-8 space-y-4">
                            
                            <!-- Table Container -->
                            <div class="border border-slate-100 rounded-2xl overflow-hidden bg-white shadow-inner">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left custom-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center w-16">No</th>
                                                <th>Nama Evaluator</th>
                                                <th class="text-center w-32">Rata-Rata</th>
                                                <th>Komentar / Masukan</th>
                                                <th class="text-center w-24">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @forelse($report['evaluations'] as $index => $eval)
                                                @php
                                                    $avgScore = $eval->scores->avg('score');
                                                    $evaluatorName = $eval->evaluator->name ?? 'Anonim';
                                                    $evaluatorRole = $eval->evaluator->role ?? 'anggota';
                                                    
                                                    // Prepare scores array for modal
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
                                                        {{ number_format($avgScore, 2) }}
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
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest py-12 bg-slate-50/10">Belum ada penilaian yang masuk.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </x-dashboard.card>
                </div>

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
