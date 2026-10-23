<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', ($settings['author_name'] ?? 'Febrian Rezki Hemeto') . ' — ' . ($settings['author_title'] ?? 'Full Stack Web Developer'))</title>
    <meta name="description" content="@yield('meta_description', $settings['bio_summary'] ?? 'Portofolio Software Engineer')">

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-stone-50 dark:bg-[#0C0D0E] text-neutral-900 dark:text-stone-100 font-sans antialiased selection:bg-neutral-900 selection:text-white dark:selection:bg-stone-100 dark:selection:text-neutral-900 min-h-screen flex flex-col justify-between transition-colors duration-200">
    <div>
        <!-- Minimalist Sticky Header -->
        <x-navbar :settings="$settings ?? []" />

        <!-- Main Content Area -->
        <main class="w-full">
            @yield('content')
        </main>
    </div>

    <!-- Semantic Footer -->
    <x-footer :settings="$settings ?? []" />

    @stack('scripts')
</body>
</html>
