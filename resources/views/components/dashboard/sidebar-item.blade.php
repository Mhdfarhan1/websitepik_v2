@props(['href' => '#', 'icon' => '', 'active' => false, 'subtitle' => null, 'isDropdown' => false, 'badge' => null])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="w-full">
    <a @if($isDropdown) @click.prevent="open = !open" href="#" @else href="{{ $href }}" @endif
       :class="!sidebarOpen && !isMobile ? 'justify-center px-0' : 'px-3'"
       @class([
        'flex items-center gap-3 py-2.5 rounded-xl transition-all duration-200 group relative cursor-pointer select-none',
        'bg-blue-50/80 text-blue-700 font-bold shadow-[inset_0_0_0_1px_rgba(59,130,246,0.15)]' => $active && !$isDropdown,
        'hover:bg-slate-100/70 text-slate-600 hover:text-slate-900' => !$active,
        'text-slate-800 font-semibold' => $active && $isDropdown,
    ])>
        @if($active && !$isDropdown)
            <div class="absolute left-1 top-2 bottom-2 w-1 bg-blue-600 rounded-full"></div>
        @endif

        @if($icon)
            <div @class([
                'w-8 h-8 rounded-lg flex items-center justify-center shrink-0 transition-all duration-200',
                'bg-blue-600 text-white shadow-sm shadow-blue-500/25' => $active,
                'bg-slate-100/80 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600' => !$active,
            ])>
                <i class="{{ $icon }} text-xs"></i>
            </div>
        @endif

        <div x-show="isMobile || sidebarOpen" 
             x-transition:enter="transition ease-out duration-150" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             class="flex-1 min-w-0 flex items-center justify-between">
            <div class="flex flex-col min-w-0">
                <span @class([
                    'text-[13px] tracking-tight leading-tight truncate transition-colors',
                    'font-bold text-blue-900' => $active && !$isDropdown,
                    'font-semibold text-slate-700 group-hover:text-slate-900' => !$active,
                    'font-bold text-slate-800' => $active && $isDropdown,
                ])>{{ $slot }}</span>
                @if($subtitle)
                    <span class="text-[10px] font-medium text-slate-400 mt-0.5 truncate">{{ $subtitle }}</span>
                @endif
            </div>

            <div class="flex items-center gap-1.5 shrink-0 ml-2">
                @if($badge)
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-blue-100 text-blue-700">{{ $badge }}</span>
                @endif

                @if($isDropdown)
                    <i class="fas fa-chevron-right text-[10px] transition-transform duration-200" 
                       :class="open ? 'rotate-90 text-blue-600' : 'text-slate-300 group-hover:text-slate-500'"></i>
                @endif
            </div>
        </div>
    </a>

    @if($isDropdown)
        <div x-show="open && (isMobile || sidebarOpen)" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mt-1 ml-5 pl-3 border-l-2 border-slate-100 space-y-0.5">
            {{ $children }}
        </div>
    @endif
</div>
