@extends('layouts.app')

@section('title', ($settings['author_name'] ?? 'Kiki Maulana') . ' — ' . ($settings['author_title'] ?? 'Software Engineer'))

@section('content')
<!-- Hero Section -->
<section class="relative pt-20 pb-24 md:pt-28 md:pb-32 overflow-hidden border-b border-stone-200/70 dark:border-neutral-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <!-- Availability Indicator -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/80 text-xs font-mono mb-8">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ $settings['availability_status'] ?? 'Available for full-time & freelance projects' }}</span>
            </div>

            <!-- Primary Headline -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 leading-[1.12] mb-6">
                {{ $settings['headline'] ?? 'Building Resilient Web Applications Through Thoughtful Engineering.' }}
            </h1>

            <!-- Subheadline / Pitch -->
            <p class="text-lg sm:text-xl text-neutral-600 dark:text-neutral-400 font-normal leading-relaxed mb-10 max-w-2xl">
                {{ $settings['bio_summary'] ?? 'Spesialis dalam ekosistem PHP/Laravel, arsitektur database relasional terstruktur, dan antarmuka web modern yang bersih serta ramah performa.' }}
            </p>

            <!-- Dual CTA Action Buttons -->
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-medium tracking-wide bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-950 dark:hover:bg-stone-200 transition-all active:scale-[0.98] shadow-sm">
                    <span>Lihat Proyek Unggulan</span>
                    <span class="text-xs font-mono">&darr;</span>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-medium tracking-wide border border-stone-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-stone-100 dark:hover:bg-neutral-800/60 transition-all active:scale-[0.98]">
                    <span>Hubungi Saya</span>
                    <span class="text-xs font-mono">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Core Engineering Stack Ribbon -->
<section class="py-10 border-b border-stone-200/70 dark:border-neutral-800 bg-stone-100/40 dark:bg-[#101114]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <span class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-semibold">
                Core Stack:
            </span>
            <div class="flex flex-wrap items-center gap-2">
                @foreach($coreSkills as $skill)
                    <x-tech-tag :name="$skill->name" />
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Selected Projects Section -->
<section class="py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div>
                <span class="text-xs font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold mb-2 block">
                    Portfolio Showcase
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-neutral-950 dark:text-stone-50">
                    Proyek Pilihan & Studi Kasus
                </h2>
            </div>
            <a href="{{ route('projects.index') }}" class="text-xs font-mono text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-stone-100 flex items-center gap-1 group">
                <span>Lihat Semua Proyek ({{ \App\Models\Project::published()->count() }})</span>
                <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
            </a>
        </div>

        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProjects as $project)
                <x-project-card :project="$project" />
            @empty
                <div class="col-span-full py-12 text-center text-neutral-500 font-mono text-sm">
                    Belum ada proyek unggulan yang dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Personal Narrative & Bio Preview -->
<section class="py-20 border-t border-stone-200/70 dark:border-neutral-800 bg-stone-100/30 dark:bg-[#0E0F12]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7">
                <span class="text-xs font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold mb-2 block">
                    Tentang Saya
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-neutral-950 dark:text-stone-50 mb-6">
                    Membangun kode dengan tujuan yang jelas dan arsitektur yang terukur.
                </h2>
                <div class="space-y-4 text-neutral-600 dark:text-neutral-400 leading-relaxed text-base">
                    <p>
                        {{ $settings['about_narrative'] ?? 'Halo! Saya Kiki Maulana — Software Engineer yang berfokus pada pengembangan sistem web end-to-end yang tangguh, mudah dirawat, dan berorientasi pada penyelesaian masalah nyata.' }}
                    </p>
                    <p>
                        Saya memandang rekayasa perangkat lunak bukan sekadar merangkai baris kode, melainkan mencari solusi paling efisien terhadap hambatan bisnis yang dihadapi pengguna.
                    </p>
                </div>
                <div class="mt-8">
                    <a href="{{ route('about') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-neutral-900 dark:text-stone-100 hover:underline">
                        <span>Baca profil dan pengalaman selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Fast Facts Column -->
            <div class="lg:col-span-5 bg-white dark:bg-[#141618] border border-stone-200/80 dark:border-neutral-800 p-8 rounded-2xl">
                <h3 class="text-sm font-mono uppercase tracking-wider text-neutral-900 dark:text-stone-100 font-bold mb-6">
                    Prinsip Kerja & Nilai
                </h3>
                <ul class="space-y-4 text-sm text-neutral-600 dark:text-neutral-400">
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-2 shrink-0"></span>
                        <div>
                            <strong class="text-neutral-900 dark:text-stone-200 font-medium">Reliability over Hype:</strong> Menggunakan alat dan framework stabil (Laravel, Postgres) yang terbukti tangguh untuk kebutuhan jangka panjang.
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-2 shrink-0"></span>
                        <div>
                            <strong class="text-neutral-900 dark:text-stone-200 font-medium">Security by Default:</strong> Perlindungan CSRF, sanitasi input, rate limiting, dan enkripsi data sensitif diterapkan secara proaktif.
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-2 shrink-0"></span>
                        <div>
                            <strong class="text-neutral-900 dark:text-stone-200 font-medium">Accessible & Performant:</strong> Web yang cepat dan mudah diakses di perangkat apapun, dari ponsel jaringan lambat hingga layar 4K.
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Direct Call to Action Banner -->
<section class="py-20 border-t border-stone-200/70 dark:border-neutral-800 text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 mb-4">
            Tertarik Berkolaborasi atau Rekrutmen?
        </h2>
        <p class="text-neutral-600 dark:text-neutral-400 text-base mb-8">
            Saya terbuka untuk diskusi peluang kerja penuh waktu (*full-time*), kontrak rekayasa perangkat lunak, maupun proyek freelance.
        </p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg text-sm font-medium tracking-wide bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-950 dark:hover:bg-stone-200 transition-all active:scale-[0.98]">
            <span>Mulai Percakapan</span>
            <span class="font-mono text-xs">&rarr;</span>
        </a>
    </div>
</section>
@endsection

