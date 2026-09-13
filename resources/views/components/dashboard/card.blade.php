@props(['title' => ''])

<div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @if($title || isset($header))
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            @if($title)
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-tight">{{ $title }}</h2>
            @endif
            @isset($header)
                {{ $header }}
            @endisset
        </div>
    @endif
    
    <div class="overflow-hidden">
        {{ $slot }}
    </div>
</div>
