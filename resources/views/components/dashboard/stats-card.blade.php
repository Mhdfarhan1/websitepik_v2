@props(['title', 'value', 'icon', 'color' => 'blue'])

@php
    $colorMap = [
        'blue' => [
            'iconBg' => 'bg-blue-50 text-blue-600 border border-blue-100/60',
            'dot' => 'bg-blue-500',
        ],
        'green' => [
            'iconBg' => 'bg-emerald-50 text-emerald-600 border border-emerald-100/60',
            'dot' => 'bg-emerald-500',
        ],
        'orange' => [
            'iconBg' => 'bg-amber-50 text-amber-600 border border-amber-100/60',
            'dot' => 'bg-amber-500',
        ],
        'purple' => [
            'iconBg' => 'bg-indigo-50 text-indigo-600 border border-indigo-100/60',
            'dot' => 'bg-indigo-500',
        ],
    ];
    $theme = $colorMap[$color] ?? $colorMap['blue'];
@endphp

<div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-slate-300/80 transition-all duration-300 group">
    <div class="flex items-center justify-between">
        <div class="space-y-1 min-w-0">
            <div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full {{ $theme['dot'] }}"></span>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider truncate">{{ $title }}</h3>
            </div>
            <p class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">{{ $value }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-105 {{ $theme['iconBg'] }} shrink-0">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
</div>
