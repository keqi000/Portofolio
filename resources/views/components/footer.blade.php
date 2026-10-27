@props(['settings' => []])

<footer class="w-full border-t border-stone-200/70 dark:border-neutral-800 bg-stone-50 dark:bg-[#0C0D0E] py-12 transition-colors duration-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-8 border-b border-stone-200/60 dark:border-neutral-800/80">
            <div class="flex min-w-0 flex-col items-start gap-3 text-neutral-600 dark:text-neutral-400 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-4 sm:gap-y-3">
                <a href="{{ $settings['instagram_url'] ?: 'https://www.instagram.com/kikihemeto/' }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-w-0 max-w-full items-center gap-2 hover:text-pink-600 dark:hover:text-pink-400 transition-colors" aria-label="Instagram: kikihemeto" title="Instagram: kikihemeto">
                    <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="1.8"/>
                        <circle cx="12" cy="12" r="4" stroke-width="1.8"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                    <span class="break-words">kikihemeto</span>
                </a>
                <a href="{{ $settings['linkedin_url'] ?: 'https://www.linkedin.com/in/febrian-rezki-hemeto-4a788a287/' }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-w-0 max-w-full items-center gap-2 hover:text-blue-700 dark:hover:text-blue-400 transition-colors" aria-label="LinkedIn: febrian-rezki-hemeto-4a788a287" title="LinkedIn: febrian-rezki-hemeto-4a788a287">
                    <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M5.2 3.5a1.8 1.8 0 1 0 0 3.6 1.8 1.8 0 0 0 0-3.6ZM3.7 8.5h3v11h-3v-11Zm5 0h2.9V10h.04a3.2 3.2 0 0 1 2.88-1.58c3.08 0 3.65 2.02 3.65 4.65v6.43h-3v-5.7c0-1.36-.03-3.1-1.89-3.1-1.89 0-2.18 1.48-2.18 3v5.8h-3v-11Z"/>
                    </svg>
                    <span class="break-words">febrian-rezki-hemeto-4a788a287</span>
                </a>
                <a href="mailto:{{ $settings['contact_email'] ?? 'febrianhemeto04@gmail.com' }}" class="inline-flex min-w-0 max-w-full items-center gap-2 hover:text-neutral-900 dark:hover:text-stone-100 transition-colors" aria-label="Email: {{ $settings['contact_email'] ?? 'febrianhemeto04@gmail.com' }}" title="{{ $settings['contact_email'] ?? 'febrianhemeto04@gmail.com' }}">
                    <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.8"/>
                        <path d="m4 7 8 6 8-6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="break-words">{{ $settings['contact_email'] ?? 'febrianhemeto04@gmail.com' }}</span>
                </a>
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500 dark:text-neutral-500 font-mono">
            <div>
                &copy; {{ date('Y') }} {{ $settings['author_name'] ?? 'Febrian Rezki Hemeto' }}. Built with Laravel, Blade & Tailwind.
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.login') }}" class="hover:text-neutral-700 dark:hover:text-neutral-300 transition-colors">
                    Admin CMS
                </a>
            </div>
        </div>
    </div>
</footer>
