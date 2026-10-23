<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') — {{ config('app.name', 'Portfolio CMS') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-100 dark:bg-[#0A0A0C] text-neutral-900 dark:text-stone-100 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 md:sticky md:top-0 md:h-screen bg-white dark:bg-[#121316] border-r border-stone-200 dark:border-neutral-800 flex flex-col justify-between shrink-0">
            <div>
                <!-- Brand & Mobile toggle -->
                <div class="h-16 px-6 border-b border-stone-200 dark:border-neutral-800 flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 font-bold tracking-tight text-neutral-900 dark:text-stone-100">
                        <span class="w-7 h-7 rounded bg-blue-600 text-white flex items-center justify-center font-mono text-xs">CMS</span>
                        <span>Portfolio Studio</span>
                    </a>
                    <button type="button" @click="sidebarOpen = !sidebarOpen" class="md:hidden p-1.5 rounded text-neutral-500 hover:bg-stone-100 dark:hover:bg-neutral-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Nav Items -->
                <nav class="p-4 space-y-1 text-sm font-medium md:block" :class="{'hidden': !sidebarOpen, 'block': sidebarOpen}">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-100 dark:hover:bg-neutral-800/60' }}">
                        <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.projects.*') ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-100 dark:hover:bg-neutral-800/60' }}">
                        <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Projects</span>
                    </a>

                    <a href="{{ route('admin.skills.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.skills.*') ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-100 dark:hover:bg-neutral-800/60' }}">
                        <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                        <span>Skills & Tools</span>
                    </a>

                    <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.messages.*') ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-100 dark:hover:bg-neutral-800/60' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Inbox Pesan</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-100 dark:hover:bg-neutral-800/60' }}">
                        <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Pengaturan Profil</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom info: Public link & Logout -->
            <div class="p-4 border-t border-stone-200 dark:border-neutral-800 space-y-2">
                <a href="{{ route('home') }}" target="_blank" class="w-full flex items-center justify-between px-3 py-2 text-xs font-mono text-neutral-600 dark:text-neutral-400 hover:bg-stone-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                    <span>Buka Web Publik</span>
                    <span>↗</span>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-16 px-6 bg-white dark:bg-[#121316] border-b border-stone-200 dark:border-neutral-800 flex items-center justify-between">
                <div>
                    <h1 class="text-base font-semibold text-neutral-900 dark:text-stone-100">
                        @yield('header_title', 'Studio Dashboard')
                    </h1>
                </div>
                <div class="flex items-center gap-4">
                    <button type="button" onclick="toggleTheme()" class="p-2 rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-stone-100 dark:hover:bg-neutral-800 transition-colors" title="Toggle Mode">
                        <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                    <div class="text-xs font-mono text-neutral-500 dark:text-neutral-400">
                        {{ auth()->user()->email }}
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <div class="p-6 md:p-8 flex-1 max-w-7xl w-full mx-auto">
                <x-flash />
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
