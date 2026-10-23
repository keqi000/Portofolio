@extends('layouts.app')

@section('title', 'Tentang Saya — ' . ($settings['author_name'] ?? 'Kiki Maulana'))
@section('meta_description', 'Latar belakang profesional, filosofi rekayasa, dan pengalaman proyek oleh Kiki Maulana.')

@section('content')
<div class="py-16 md:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-14">
            <span class="text-xs font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold mb-2 block">
                Personal Background & Philosophy
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 mb-6">
                Membangun Solusi Digital dengan Ketelitian Rekayasa.
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed font-mono">
                {{ $settings['author_title'] ?? 'Software Engineer & Full-Stack Developer' }}
            </p>
        </header>

        <!-- Narrative Section -->
        <section class="prose dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300 text-base sm:text-lg leading-relaxed space-y-6 mb-16 pb-14 border-b border-stone-200/70 dark:border-neutral-800">
            <p>
                {{ $settings['about_narrative'] ?? 'Halo! Saya Kiki Maulana — Software Engineer yang berfokus pada pengembangan sistem web end-to-end yang tangguh, mudah dirawat, dan berorientasi pada penyelesaian masalah nyata.' }}
            </p>
            <p>
                Fokus utama saya adalah arsitektur backend berbasis Laravel dan optimasi database relasional (PostgreSQL & MySQL). Saya mengutamakan kode yang dapat dipelihara (*maintainable code*), pemisahan tanggung jawab logika yang tegas (*separation of concerns*), serta antarmuka web modern dengan Tailwind CSS yang nyaman dipandang tanpa efek visual berlebihan.
            </p>
            <p>
                Di luar penulisan kode harian, saya aktif mendalami topik ketahanan sistem, pola arsitektur *event-driven*, dan bagaimana arsitektur *serverless* modern (seperti Vercel dan Supabase) dapat dimanfaatkan untuk menghadirkan performa maksimal dengan efisiensi biaya infrastruktur.
            </p>
        </section>

        <!-- Experience Timeline -->
        <section class="mb-16 pb-14 border-b border-stone-200/70 dark:border-neutral-800">
            <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-8">
                Linimasa Pengalaman & Milestone
            </h2>

            <div class="space-y-10 relative before:absolute before:inset-0 before:left-3 before:w-0.5 before:bg-stone-200 dark:before:bg-neutral-800">
                @foreach($experiences as $exp)
                    <div class="relative pl-10">
                        <!-- Dot Indicator -->
                        <div class="absolute left-1.5 top-1.5 w-3.5 h-3.5 -translate-x-1/2 rounded-full border-2 border-white dark:border-[#0C0D0E] bg-neutral-900 dark:bg-stone-100"></div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                            <h3 class="text-base font-semibold text-neutral-950 dark:text-stone-50">
                                {{ $exp['role'] }}
                            </h3>
                            <span class="text-xs font-mono text-neutral-500 dark:text-neutral-400">
                                {{ $exp['period'] }}
                            </span>
                        </div>
                        <div class="text-xs font-mono text-blue-600 dark:text-blue-400 mb-2">
                            {{ $exp['company'] }}
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
                            {{ $exp['description'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Resume Callout Strip -->
        <div class="p-8 rounded-2xl bg-stone-100/60 dark:bg-[#141618] border border-stone-200/80 dark:border-neutral-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div>
                <h3 class="font-bold text-neutral-900 dark:text-stone-100 text-lg">
                    Butuh Salinan CV Lengkap?
                </h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 font-mono">
                    Tersedia dalam format PDF yang siap diunduh atau ditinjau secara langsung.
                </p>
            </div>
            <a href="{{ route('resume.download') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-xs font-mono font-medium tracking-wide bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-950 dark:hover:bg-stone-200 transition-all active:scale-[0.98] shrink-0">
                <span>Unduh CV / Resume (PDF)</span>
                <span>&darr;</span>
            </a>
        </div>
    </div>
</div>
@endsection

