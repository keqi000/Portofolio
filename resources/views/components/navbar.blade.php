@props(['settings' => []])

<nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 w-full backdrop-blur-md bg-stone-50/80 dark:bg-[#0C0D0E]/80 border-b border-stone-200/70 dark:border-neutral-800 transition-colors duration-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Brand / Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="group flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900 flex items-center justify-center font-mono font-bold text-sm tracking-tighter group-hover:scale-95 transition-transform">
                        K
                    </span>
                    <div class="flex flex-col">
                        <span class="font-semibold text-sm tracking-tight text-neutral-900 dark:text-stone-100">
                            {{ $settings['author_name'] ?? 'Kiki Maulana' }}
                        </span>
                        <span class="text-[10px] text-neutral-500 dark:text-neutral-400 font-mono flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Available
                        </span>
                    </div>
                </a>
            </div>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-3.5 py-1.5 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-neutral-900 dark:text-stone-100 bg-neutral-200/50 dark:bg-neutral-800/60' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-200' }}">
                    Home
                </a>
                <a href="{{ route('projects.index') }}" class="px-3.5 py-1.5 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('projects.*') ? 'text-neutral-900 dark:text-stone-100 bg-neutral-200/50 dark:bg-neutral-800/60' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-200' }}">
                    Projects
                </a>
                <a href="{{ route('about') }}" class="px-3.5 py-1.5 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'text-neutral-900 dark:text-stone-100 bg-neutral-200/50 dark:bg-neutral-800/60' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-200' }}">
                    About Me
                </a>
                <a href="{{ route('skills') }}" class="px-3.5 py-1.5 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('skills') ? 'text-neutral-900 dark:text-stone-100 bg-neutral-200/50 dark:bg-neutral-800/60' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-200' }}">
                    Skills
                </a>
                <a href="{{ route('contact') }}" class="px-3.5 py-1.5 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-neutral-900 dark:text-stone-100 bg-neutral-200/50 dark:bg-neutral-800/60' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-200' }}">
                    Contact
                </a>
            </div>

            <!-- Right Actions: Theme Toggle & Resume CTA -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Theme Toggle Button -->
                <button type="button" onclick="toggleTheme()" class="p-2 rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200/50 dark:hover:bg-neutral-800/60 transition-colors" aria-label="Toggle dark mode">
                    <!-- Sun Icon (shows in dark mode) -->
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Moon Icon (shows in light mode) -->
                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- CV / Resume Button -->
                <a href="{{ route('resume.download') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-mono font-medium tracking-wide bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 transition-all active:scale-[0.98]">
                    <span>CV / Resume</span>
                    <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex items-center gap-2 md:hidden">
                <button type="button" onclick="toggleTheme()" class="p-2 rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200/50 dark:hover:bg-neutral-800 transition-colors" aria-label="Toggle theme">
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-neutral-600 dark:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-neutral-800" aria-label="Open navigation menu">
                    <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Drawer -->
    <div x-show="mobileMenuOpen" x-transition class="md:hidden border-b border-stone-200 dark:border-neutral-800 bg-stone-50/95 dark:bg-[#0C0D0E]/95 px-4 pt-2 pb-4 space-y-1" style="display: none;">
        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-neutral-200/60 dark:bg-neutral-800 text-neutral-900 dark:text-stone-100' : 'text-neutral-700 dark:text-neutral-300' }}">Home</a>
        <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('projects.*') ? 'bg-neutral-200/60 dark:bg-neutral-800 text-neutral-900 dark:text-stone-100' : 'text-neutral-700 dark:text-neutral-300' }}">Projects</a>
        <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'bg-neutral-200/60 dark:bg-neutral-800 text-neutral-900 dark:text-stone-100' : 'text-neutral-700 dark:text-neutral-300' }}">About Me</a>
        <a href="{{ route('skills') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('skills') ? 'bg-neutral-200/60 dark:bg-neutral-800 text-neutral-900 dark:text-stone-100' : 'text-neutral-700 dark:text-neutral-300' }}">Skills</a>
        <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-neutral-200/60 dark:bg-neutral-800 text-neutral-900 dark:text-stone-100' : 'text-neutral-700 dark:text-neutral-300' }}">Contact</a>
        <div class="pt-2">
            <a href="{{ route('resume.download') }}" target="_blank" class="w-full text-center block px-3 py-2 rounded-md text-sm font-mono font-medium bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900">
                Download CV / Resume
            </a>
        </div>
    </div>
</nav>

