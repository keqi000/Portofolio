@extends('layouts.app')

@section('title', $project->title)
@section('meta_description', $project->tagline)

@section('content')
<article class="py-16 md:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs font-mono text-neutral-500 dark:text-neutral-400 mb-8">
            <a href="{{ route('home') }}" class="hover:underline">&larr; Kembali ke Home</a>
            <span>/</span>
            <a href="{{ route('projects.index') }}" class="hover:underline">Projects</a>
            <span>/</span>
            <span class="text-neutral-900 dark:text-stone-200 truncate">{{ $project->title }}</span>
        </nav>

        <!-- Header -->
        <header class="mb-10">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="px-2.5 py-1 rounded text-xs font-mono uppercase tracking-wider bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800/60 font-semibold">
                    {{ $project->category }}
                </span>
                <span class="text-xs font-mono text-neutral-400">
                    Tahun Rilis: {{ $project->created_at->format('Y') }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 leading-tight mb-4">
                {{ $project->title }}
            </h1>

            <p class="text-lg text-neutral-600 dark:text-neutral-400 font-mono leading-relaxed">
                {{ $project->tagline }}
            </p>

            <!-- Action Links Row -->
            <div class="flex flex-wrap items-center gap-4 mt-8 pt-6 border-t border-stone-200/70 dark:border-neutral-800">
                @if($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-xs font-mono font-medium tracking-wide bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 transition-all active:scale-[0.98]">
                        <span>Buka Live Demo</span>
                        <span>↗</span>
                    </a>
                @endif
                @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-xs font-mono font-medium tracking-wide border border-stone-300 dark:border-neutral-700 text-neutral-800 dark:text-stone-200 hover:bg-stone-100 dark:hover:bg-neutral-800 transition-all active:scale-[0.98]">
                        <span>Lihat Source Code</span>
                        <span>↗</span>
                    </a>
                @endif
            </div>
        </header>

        <!-- Project screenshot gallery -->
        @php
            $galleryImages = collect([$project->featured_image])
                ->merge($project->images->pluck('image_path'))
                ->filter()
                ->unique()
                ->values();
        @endphp
        @if($galleryImages->isNotEmpty())
            <div class="mb-14">
                <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth touch-pan-x pb-3" role="region" aria-label="Carousel screenshot proyek">
                    @foreach($galleryImages as $image)
                        <figure class="min-w-[88%] sm:min-w-[75%] snap-start rounded-2xl overflow-hidden border border-stone-200/80 dark:border-neutral-800 shadow-sm bg-neutral-100 dark:bg-neutral-900">
                            <img src="{{ $image }}" alt="{{ $project->title }} screenshot" class="w-full h-auto max-h-[440px] object-contain" loading="lazy">
                        </figure>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Case Study Sections -->
        <div class="space-y-12 text-neutral-800 dark:text-stone-200 leading-relaxed text-base">
            <!-- 1. The Problem -->
            <section class="border-b border-stone-200/70 dark:border-neutral-800 pb-10">
                <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-4">
                    01. Masalah & Tantangan Nyata
                </h2>
                <div class="text-base sm:text-lg text-neutral-700 dark:text-neutral-300 leading-relaxed whitespace-pre-line">
                    {{ $project->problem_statement }}
                </div>
            </section>

            <!-- 2. The Solution & Architecture -->
            <section class="border-b border-stone-200/70 dark:border-neutral-800 pb-10">
                <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-4">
                    02. Solusi Rekayasa & Arsitektur
                </h2>
                <div class="text-base sm:text-lg text-neutral-700 dark:text-neutral-300 leading-relaxed whitespace-pre-line">
                    {{ $project->solution_description }}
                </div>
            </section>

            <!-- 3. Tech Stack Deep Dive -->
            <section class="border-b border-stone-200/70 dark:border-neutral-800 pb-10">
                <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-4">
                    03. Teknologi yang Digunakan
                </h2>
                <div class="flex flex-wrap gap-2 pt-2">
                    @if(is_array($project->tech_stack))
                        @foreach($project->tech_stack as $tech)
                            <span class="px-3 py-1.5 rounded-md text-xs font-mono bg-stone-100 text-neutral-800 dark:bg-neutral-800/90 dark:text-stone-200 border border-stone-200 dark:border-neutral-700">
                                {{ $tech }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </section>
        </div>

        <!-- Related Projects Navigation -->
        @if($relatedProjects->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-stone-200/70 dark:border-neutral-800">
                <h3 class="text-sm font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400 font-bold mb-6">
                    Lihat Proyek Lainnya
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($relatedProjects as $related)
                        <a href="{{ route('projects.show', $related->slug) }}" class="p-6 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#141618] hover:border-neutral-400 dark:hover:border-neutral-700 transition-all group">
                            <span class="text-[10px] font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-1">
                                {{ $related->category }}
                            </span>
                            <h4 class="font-semibold text-neutral-900 dark:text-stone-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $related->title }}
                            </h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 line-clamp-1">
                                {{ $related->tagline }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>
@endsection
