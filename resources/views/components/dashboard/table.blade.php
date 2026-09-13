@props([
    'headers' => [],
    'title' => null,
    'paginator' => null,
    'searchable' => true
])

<div class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden transition-all duration-300 relative" x-data="{ search: '{{ request('search') }}', perPage: '{{ request('per_page', 10) }}' }">
    <!-- 1. Integrated Header Section -->
    <div class="pt-8 pb-6 px-8 space-y-6">
        @if($title)
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-[0.2em]">{{ $title }}</h2>
                    <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Manajemen Data Sistem</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="window.location.reload()" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-[#1e3a8a] transition-colors flex items-center justify-center border border-slate-100">
                        <i class="fas fa-sync-alt text-[10px]"></i>
                    </button>
                </div>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Show</span>
                <div class="relative group">
                    <form id="perPageForm-{{ Str::slug($title) }}">
                        @foreach(request()->except('per_page', 'page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="per_page" x-model="perPage" @change="$el.closest('form').submit()" class="appearance-none bg-white border border-slate-200/80 rounded-xl text-xs font-bold text-slate-700 pl-4 pr-10 py-2 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 cursor-pointer transition-all">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </form>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none transition-transform group-hover:translate-y-[-40%]"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Entries</span>
            </div>
            
            @if($searchable)
            <div class="relative w-full md:w-72 group">
                <form id="searchForm-{{ Str::slug($title) }}">
                    @foreach(request()->except('search', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] group-focus-within:text-[#1e3a8a] transition-colors"></i>
                    <input type="text" name="search" x-model="search" placeholder="Search data..." 
                           class="bg-white border-slate-200/80 border rounded-xl py-2 pl-10 pr-4 text-xs font-bold text-slate-600 placeholder:text-slate-300 focus:ring-4 focus:ring-blue-500/5 focus:border-[#1e3a8a]/20 w-full transition-all">
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- 2. The Table Section -->
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left custom-table">
            <thead class="bg-white border-b border-slate-100">
                <tr>
                    <th class="text-center w-16">
                        NO
                    </th>
                    @foreach($headers as $header)
                        @php
                            $lowerHeader = strtolower($header);
                            $isCenter = str_contains($lowerHeader, 'role') || 
                                        str_contains($lowerHeader, 'status') || 
                                        str_contains($lowerHeader, 'aksi') || 
                                        str_contains($lowerHeader, 'action') || 
                                        str_contains($lowerHeader, 'kode') ||
                                        str_contains($lowerHeader, 'no');
                        @endphp
                        <th class="{{ $isCenter ? 'text-center' : 'text-left' }}">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- 3. Integrated Footer Section -->
    @if($paginator)
    <div class="py-6 px-8 bg-white border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-1.5 rounded-full bg-[#1e3a8a] shadow-[0_0_10px_rgba(30,58,138,0.4)]"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Showing <span class="text-slate-800">{{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }}</span> of <span class="text-slate-800">{{ $paginator->total() }}</span> Entries
            </p>
        </div>
        
        <div class="flex items-center gap-1.5">
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center shadow-sm cursor-not-allowed">
                    <i class="fas fa-chevron-left text-[10px]"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('per_page') ? '&per_page='.request('per_page') : '' }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all flex items-center justify-center shadow-sm group">
                    <i class="fas fa-chevron-left text-[10px] group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
            @endif

            <div class="flex items-center gap-1">
                @foreach ($paginator->getUrlRange(max($paginator->currentPage() - 2, 1), min($paginator->currentPage() + 2, $paginator->lastPage())) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="w-8 h-8 rounded-lg bg-[#1e3a8a] text-white font-bold text-xs shadow-md">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('per_page') ? '&per_page='.request('per_page') : '' }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 font-bold text-xs hover:bg-slate-50 transition-all shadow-sm flex items-center justify-center">{{ $page }}</a>
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('per_page') ? '&per_page='.request('per_page') : '' }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all flex items-center justify-center shadow-sm group">
                    <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            @else
                <span class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center shadow-sm cursor-not-allowed">
                    <i class="fas fa-chevron-right text-[10px]"></i>
                </span>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 4px;
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

    /* Force exact styles to match the mockup */
    .custom-table th {
        padding: 1.25rem 1.5rem !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important; /* slate-400 */
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .custom-table td {
        padding: 1.25rem 1.5rem !important;
        font-size: 13px !important;
        color: #334155 !important; /* slate-700 */
        vertical-align: middle !important;
        border-bottom: 1px solid #f8fafc !important;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none !important;
    }
    .custom-table tbody tr:hover {
        background-color: rgba(248, 250, 252, 0.5) !important; /* subtle hover bg */
    }
</style>
