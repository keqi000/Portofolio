@props(['project'])

<article class="group rounded-xl border border-stone-200/90 dark:border-neutral-800 bg-white dark:bg-[#141618] overflow-hidden flex flex-col justify-between transition-all duration-200 hover:border-neutral-400 dark:hover:border-neutral-700">
    <div>
        <!-- Screenshot Preview -->
        @if($project->featured_image)
            <div class="aspect-16/10 w-full overflow-hidden bg-neutral-100 dark:bg-neutral-900 border-b border-stone-200/80 dark:border-neutral-800">
                <img src="{{ $project->featured_image }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300" loading="lazy">
            </div>
        @else
            <div class="aspect-16/10 w-full overflow-hidden bg-stone-100 dark:bg-neutral-900/60 border-b border-stone-200/80 dark:border-neutral-800 flex items-center justify-center text-neutral-400 font-mono text-xs">
                No Preview Screenshot
            </div>
        @endif

        <div class="p-6">
            <!-- Meta row: Category & Status -->
            <div class="flex items-center justify-between gap-2 mb-2.5">
                <span class="text-[11px] font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold">
                    {{ $project->category }}
                </span>
                <span class="text-[11px] font-mono text-neutral-400 dark:text-neutral-500">
                    {{ $project->created_at->format('Y') }}
                </span>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-semibold tracking-tight text-neutral-950 dark:text-stone-50 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                <a href="{{ route('projects.show', $project->slug) }}">
                    {{ $project->title }}
                </a>
            </h3>

            <!-- Tagline -->
            <p class="text-xs font-mono text-neutral-500 dark:text-neutral-400 mt-1 mb-3 line-clamp-1">
                {{ $project->tagline }}
            </p>

            <!-- Problem / Solution brief -->
            <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2 leading-relaxed mb-4">
                {{ $project->problem_statement }}
            </p>

            <!-- Tech Stack Tags -->
            <div class="flex flex-wrap gap-1.5 mb-6">
                @if(is_array($project->tech_stack))
                    @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                        <x-tech-tag :name="$tech" />
                    @endforeach
                    @if(count($project->tech_stack) > 4)
                        <span class="text-[10px] font-mono text-neutral-400 self-center">+{{ count($project->tech_stack) - 4 }}</span>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Card Action Footer -->
    <div class="px-6 py-4 border-t border-stone-100 dark:border-neutral-800/80 bg-stone-50/50 dark:bg-neutral-900/30 flex items-center justify-between text-xs font-mono">
        <a href="{{ route('projects.show', $project->slug) }}" class="text-neutral-900 dark:text-stone-200 font-semibold hover:underline flex items-center gap-1">
            <span>Studi Kasus</span>
            <span>&rarr;</span>
        </a>

        <div class="flex items-center gap-3">
            @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="text-neutral-500 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-stone-100 flex items-center gap-1 transition-colors" title="Buka Live Demo">
                    <span>Demo</span>
                    <span class="text-[10px]">↗</span>
                </a>
            @endif
            @if($project->github_url)
                <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="text-neutral-500 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-stone-100 flex items-center gap-1 transition-colors" title="Lihat Source Code">
                    <span>GitHub</span>
                    <span class="text-[10px]">↗</span>
                </a>
            @endif
        </div>
    </div>
</article>

