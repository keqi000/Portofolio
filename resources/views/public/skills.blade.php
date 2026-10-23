@extends('layouts.app')

@section('title', 'Keahlian & Perangkat Pengembangan — ' . ($settings['author_name'] ?? 'Febrian Rezki Hemeto'))
@section('meta_description', 'Matriks keahlian teknologi teknis, bahasa pemrograman, framework, dan alur kerja pengembangan perangkat lunak.')

@section('content')
<div class="py-16 md:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-14">
            <span class="text-xs font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold mb-2 block">
                Technical Capabilities
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 mb-4">
                Keahlian & Perangkat
            </h1>
            <p class="text-base sm:text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed max-w-2xl">
                Keahlian teknis, kemampuan interpersonal, dan perangkat kerja yang tercantum dalam profil.
            </p>

            <!-- Legend Badge Strip -->
            <div class="flex flex-wrap items-center gap-4 mt-6 pt-6 border-t border-stone-200/70 dark:border-neutral-800 text-xs font-mono">
                <div class="flex items-center gap-2 text-neutral-800 dark:text-neutral-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Core / Production Stack</span>
                </div>
                <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Currently Exploring / Learning</span>
                </div>
            </div>
        </header>

        <!-- Categories & Skills Grid -->
        <div class="space-y-12 mb-16">
            @foreach($categories as $category)
                <div class="p-6 sm:p-8 rounded-2xl border border-stone-200/90 dark:border-neutral-800 bg-white dark:bg-[#141618]">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold tracking-tight text-neutral-950 dark:text-stone-50">
                            {{ $category->name }}
                        </h2>
                        <span class="text-xs font-mono text-neutral-400">
                            {{ $category->skills->count() }} teknologi
                        </span>
                    </div>

                    <!-- Skills List -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($category->skills as $skill)
                            <div class="flex items-center justify-between p-3 rounded-lg border border-stone-100 dark:border-neutral-800/80 bg-stone-50/50 dark:bg-neutral-900/40 text-sm">
                                <div class="flex items-center gap-2.5">
                                    @if($skill->proficiency_level === 'production')
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0" title="Core Stack"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0" title="Exploring"></span>
                                    @endif
                                    <span class="font-medium text-neutral-900 dark:text-stone-100">
                                        {{ $skill->name }}
                                    </span>
                                </div>
                                <span class="text-[10px] font-mono {{ $skill->proficiency_level === 'production' ? 'text-emerald-700 dark:text-emerald-400 font-semibold' : 'text-neutral-400 dark:text-neutral-500' }}">
                                    {{ $skill->proficiency_level === 'production' ? 'Production' : 'Learning' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Workflow & Engineering Practices Section -->
        <div class="p-8 rounded-2xl bg-stone-100/40 dark:bg-[#101114] border border-stone-200/80 dark:border-neutral-800">
            <h3 class="text-xs font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400 font-bold mb-4">
                Standar & Disiplin Rekayasa
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                <div class="space-y-1">
                    <strong class="text-neutral-900 dark:text-stone-200 block text-sm">Clean MVC & Service Layer:</strong>
                    <p class="text-xs leading-relaxed">Menjaga controller tetap tipis (*skinny controllers*) dan memisahkan proses bisnis ke dalam Service terisolasi.</p>
                </div>
                <div class="space-y-1">
                    <strong class="text-neutral-900 dark:text-stone-200 block text-sm">Git Flow & Semantic Commits:</strong>
                    <p class="text-xs leading-relaxed">Riwayat versi yang rapi, *pull request review*, dan deskripsi perubahan yang konsisten.</p>
                </div>
                <div class="space-y-1">
                    <strong class="text-neutral-900 dark:text-stone-200 block text-sm">Database Indexing & Hygiene:</strong>
                    <p class="text-xs leading-relaxed">Menghindari N+1 query problem melalui Eager Loading (`with()`) dan pengindeksan foreign keys.</p>
                </div>
                <div class="space-y-1">
                    <strong class="text-neutral-900 dark:text-stone-200 block text-sm">OWASP Top 10 Best Practices:</strong>
                    <p class="text-xs leading-relaxed">Proteksi bawaan dari injeksi SQL, XSS, CSRF tokens, dan rate limiting ketat.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
