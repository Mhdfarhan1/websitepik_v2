@props([
    'name',
    'title',
    'show' => false,
])

<div x-data="{ show: @js($show) }"
     x-show="show"
     x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') show = true"
     x-on:close-modal.window="if ($event.detail.name === '{{ $name }}') show = false"
     x-on:keydown.escape.window="show = false"
     style="display: none;"
     class="fixed inset-0 z-[100] overflow-y-auto">
    
    <!-- Backdrop with Blur -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-all"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="relative bg-white w-full max-w-lg rounded-[40px] shadow-2xl overflow-hidden z-10 border border-slate-50">
            
            <!-- Header -->
            <div class="pt-8 px-8 pb-2 flex items-center justify-between bg-white">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ $title }}</h3>
                    <div class="h-1 w-12 bg-blue-600 rounded-full mt-2"></div>
                </div>
                <button @click="show = false" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="pt-2 px-8 pb-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
