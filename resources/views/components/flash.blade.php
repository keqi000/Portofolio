@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 flex items-start justify-between text-emerald-900 dark:text-emerald-200 text-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:hover:text-emerald-300 ml-4">
            &times;
        </button>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/60 flex items-start justify-between text-red-900 dark:text-red-200 text-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" @click="show = false" class="text-red-600 hover:text-red-800 dark:hover:text-red-300 ml-4">
            &times;
        </button>
    </div>
@endif

@if(session('info'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/60 flex items-start justify-between text-blue-900 dark:text-blue-200 text-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('info') }}</span>
        </div>
        <button type="button" @click="show = false" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-300 ml-4">
            &times;
        </button>
    </div>
@endif

@if($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/60 text-red-900 dark:text-red-200 text-sm">
        <div class="font-medium mb-1">Periksa kembali formulir Anda:</div>
        <ul class="list-disc list-inside space-y-1 text-xs opacity-90">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

