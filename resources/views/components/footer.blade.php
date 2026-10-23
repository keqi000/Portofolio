@props(['settings' => []])

<footer class="w-full border-t border-stone-200/70 dark:border-neutral-800 bg-stone-50 dark:bg-[#0C0D0E] py-12 transition-colors duration-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-8 border-b border-stone-200/60 dark:border-neutral-800/80">
            <div>
                <span class="font-bold tracking-tight text-neutral-900 dark:text-stone-100 text-lg">
                    {{ $settings['author_name'] ?? 'Kiki Maulana' }}
                </span>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 max-w-sm">
                    {{ $settings['author_title'] ?? 'Software Engineer & Full-Stack Developer' }}
                </p>
            </div>

            <!-- Social Links -->
            <div class="flex flex-wrap items-center gap-4 text-xs font-mono">
                @if(!empty($settings['github_url']))
                    <a href="{{ $settings['github_url'] }}" target="_blank" rel="noopener noreferrer" class="text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-100 transition-colors flex items-center gap-1">
                        <span>GitHub</span>
                        <span class="opacity-60">↗</span>
                    </a>
                @endif
                @if(!empty($settings['linkedin_url']))
                    <a href="{{ $settings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" class="text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-100 transition-colors flex items-center gap-1">
                        <span>LinkedIn</span>
                        <span class="opacity-60">↗</span>
                    </a>
                @endif
                @if(!empty($settings['contact_email']))
                    <a href="mailto:{{ $settings['contact_email'] }}" class="text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-100 transition-colors flex items-center gap-1">
                        <span>Email</span>
                        <span class="opacity-60">↗</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500 dark:text-neutral-500 font-mono">
            <div>
                &copy; {{ date('Y') }} {{ $settings['author_name'] ?? 'Kiki Maulana' }}. Built with Laravel, Blade & Tailwind.
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.login') }}" class="hover:text-neutral-700 dark:hover:text-neutral-300 transition-colors">
                    Admin CMS
                </a>
            </div>
        </div>
    </div>
</footer>

