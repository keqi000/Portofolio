@extends('layouts.app')

@section('title', 'Tentang Saya — ' . ($settings['author_name'] ?? 'Febrian Rezki Hemeto'))
@section('meta_description', 'Profil, pendidikan, pengalaman, keterampilan, dan proyek oleh ' . ($settings['author_name'] ?? 'Febrian Rezki Hemeto') . '.')

@section('content')
<div class="py-16 md:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-14">
            @if(!empty($settings['profile_image_url']))
                <img src="{{ $settings['profile_image_url'] }}" alt="Foto profil {{ $settings['author_name'] ?? 'Febrian Rezki Hemeto' }}" class="w-36 h-36 rounded-full object-cover border-4 border-white dark:border-neutral-800 shadow-md mb-8">
            @endif
            <span class="text-xs font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold mb-2 block">
                Personal Background & Philosophy
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 mb-6">
                Membangun Solusi Digital dengan Ketelitian Rekayasa.
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed font-mono">
                {{ $settings['author_title'] ?? 'Full Stack Web Developer' }}
            </p>
        </header>

        <!-- Narrative Section -->
        <section class="prose dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300 text-base sm:text-lg leading-relaxed space-y-6 mb-16 pb-14 border-b border-stone-200/70 dark:border-neutral-800">
            <p>
                {{ $settings['about_narrative'] ?? 'Saya Febrian Rezki Hemeto, lulusan S1 Teknik Informatika Universitas Sam Ratulangi dengan IPK 3,98. Saya memiliki minat dan kompetensi dalam Full Stack Web Development, pengembangan sistem informasi, dan teknologi informasi.' }}
            </p>
            <p>
                Saya menguasai PHP, Laravel, MySQL, JavaScript, Bootstrap, HTML, dan CSS, serta memahami SDLC, analisis kebutuhan sistem, perancangan database, testing, deployment, dan dokumentasi aplikasi.
            </p>
            <p>
                Saya memiliki kemampuan analitis, pemecahan masalah, dan komunikasi, serta mampu bekerja secara mandiri maupun dalam tim. Saya dikenal disiplin, cepat belajar, bertanggung jawab, dan berorientasi pada hasil.
            </p>
        </section>

        <section class="mb-16 pb-14 border-b border-stone-200/70 dark:border-neutral-800">
            <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-6">
                Pendidikan
            </h2>
            <div class="p-6 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#141618]">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                    <div>
                        <h3 class="font-semibold text-neutral-950 dark:text-stone-50">{{ $education['institution'] }}</h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">{{ $education['program'] }} · {{ $education['location'] }}</p>
                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mt-2">{{ $education['achievement'] }}</p>
                    </div>
                    <span class="text-xs font-mono text-neutral-500 dark:text-neutral-400">{{ $education['period'] }}</span>
                </div>
            </div>
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

        <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16 pb-14 border-b border-stone-200/70 dark:border-neutral-800">
            <div>
                <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-5">
                    Sertifikasi
                </h2>
                <div class="space-y-4">
                    @foreach($certifications as $item)
                        <div class="p-5 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#141618]">
                            <h3 class="font-semibold text-neutral-900 dark:text-stone-100">{{ $item['name'] }}</h3>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-1">{{ $item['issuer'] }}</p>
                            <p class="text-[11px] font-mono text-neutral-500 mt-2">{{ $item['period'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-5">
                    Pelatihan
                </h2>
                <div class="space-y-3">
                    @foreach($training as $item)
                        <div class="p-4 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#141618]">
                            <h3 class="text-sm font-semibold text-neutral-900 dark:text-stone-100">{{ $item['name'] }}</h3>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-1">{{ $item['issuer'] }}</p>
                            <p class="text-[11px] font-mono text-neutral-500 mt-2">{{ $item['period'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mb-16 pb-14 border-b border-stone-200/70 dark:border-neutral-800">
            <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-bold mb-5">
                Publikasi & Pencapaian
            </h2>
            <ul class="space-y-3">
                @foreach($achievements as $achievement)
                    <li class="flex items-start gap-3 text-sm text-neutral-700 dark:text-neutral-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-2 shrink-0"></span>
                        <span>{{ $achievement }}</span>
                    </li>
                @endforeach
            </ul>
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
