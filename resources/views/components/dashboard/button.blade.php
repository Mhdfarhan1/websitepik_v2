@props([
    'variant' => 'primary', // primary, danger, warning, secondary, ghost
    'size' => 'md',      // sm, md, lg
    'icon' => null,
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-600/20',
        'success' => 'bg-emerald-500 hover:bg-emerald-600 text-white shadow-emerald-500/20',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-rose-600/20',
        'warning' => 'bg-orange-600 hover:bg-orange-700 text-white shadow-orange-600/20',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-700 shadow-slate-200/20',
        'ghost' => 'bg-transparent hover:bg-slate-50 text-slate-500 shadow-none',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-[11px] rounded-lg',
        'md' => 'px-6 py-2.5 text-xs rounded-xl',
        'lg' => 'px-8 py-3.5 text-sm rounded-2xl',
    ];

    $baseClasses = 'font-bold uppercase tracking-widest transition-all hover:scale-[1.03] active:scale-[0.97] flex items-center justify-center gap-2 shadow-lg';
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => "$baseClasses $variantClass $sizeClass"]) }}>
    @if($icon)
        <i class="{{ $icon }} {{ $size === 'sm' ? 'text-[10px]' : 'text-sm' }}"></i>
    @endif
    <span>{{ $slot }}</span>
</button>
