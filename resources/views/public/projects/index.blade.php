@extends('layouts.app')

@section('title', 'Proyek & Studi Kasus — ' . ($settings['author_name'] ?? 'Kiki Maulana'))
@section('meta_description', 'Kumpulan proyek perangkat lunak dan studi kasus rekayasa web oleh Kiki Maulana.')

@section('content')
<div class="py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold mb-2 block">
                Works & Implementations
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 mb-4">
                Proyek & Studi Kasus
            </h1>
            <p class="text-base sm:text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed">
                Setiap proyek dikerjakan dengan fokus pada pemecahan masalah bisnis nyata, arsitektur database terstruktur, dan efisiensi sistem.
            </p>
        </div>

        <!-- Filter Bar -->
        <div class="flex flex-wrap items-center gap-2 mb-10 pb-4 border-b border-stone-200/70 dark:border-neutral-800">
            <a href="{{ route('projects.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-mono transition-colors {{ $selectedCategory === 'all' ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900 font-semibold' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-200/60 dark:hover:bg-neutral-800/80' }}">
                Semua Kategori ({{ \App\Models\Project::published()->count() }})
            </a>
            @foreach($categories as $category)
                <a href="{{ route('projects.index', ['category' => $category]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-mono transition-colors {{ $selectedCategory === $category ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900 font-semibold' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-200/60 dark:hover:bg-neutral-800/80' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
                <x-project-card :project="$project" />
            @empty
                <div class="col-span-full py-16 text-center text-neutral-500 dark:text-neutral-400 font-mono text-sm">
                    Tidak ada proyek yang sesuai dengan kategori ini.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $projects->links() }}
        </div>
    </div>
</div>
@endsection

