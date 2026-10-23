@extends('layouts.admin')

@section('title', 'Dashboard Studio')
@section('header_title', 'Ringkasan & Metrik Sistem')

@section('content')
<div class="space-y-8">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Messages Stat -->
        <div class="p-6 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Pesan Baru
                </span>
                <span class="w-2 h-2 rounded-full {{ $unreadMessagesCount > 0 ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500' }}"></span>
            </div>
            <div class="text-3xl font-extrabold text-neutral-900 dark:text-stone-100 font-mono">
                {{ $unreadMessagesCount }}
            </div>
            <a href="{{ route('admin.messages.index') }}" class="text-xs font-mono text-blue-600 dark:text-blue-400 mt-2 inline-block hover:underline">
                Buka Kotak Masuk &rarr;
            </a>
        </div>

        <!-- Projects Stat -->
        <div class="p-6 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Total Proyek
                </span>
                <span class="text-xs font-mono text-neutral-400">Arsip</span>
            </div>
            <div class="text-3xl font-extrabold text-neutral-900 dark:text-stone-100 font-mono">
                {{ $totalProjectsCount }}
            </div>
            <a href="{{ route('admin.projects.index') }}" class="text-xs font-mono text-blue-600 dark:text-blue-400 mt-2 inline-block hover:underline">
                Kelola Proyek &rarr;
            </a>
        </div>

        <!-- Published Stat -->
        <div class="p-6 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Proyek Aktif
                </span>
                <span class="text-xs font-mono text-emerald-500">Live</span>
            </div>
            <div class="text-3xl font-extrabold text-neutral-900 dark:text-stone-100 font-mono">
                {{ $publishedProjectsCount }}
            </div>
            <span class="text-xs font-mono text-neutral-400 mt-2 inline-block">
                Tampil di publik
            </span>
        </div>

        <!-- Skills Stat -->
        <div class="p-6 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Total Keahlian
                </span>
                <span class="text-xs font-mono text-neutral-400">Stack</span>
            </div>
            <div class="text-3xl font-extrabold text-neutral-900 dark:text-stone-100 font-mono">
                {{ $totalSkillsCount }}
            </div>
            <a href="{{ route('admin.skills.index') }}" class="text-xs font-mono text-blue-600 dark:text-blue-400 mt-2 inline-block hover:underline">
                Atur Keahlian &rarr;
            </a>
        </div>
    </div>

    <!-- Two Columns: Recent Messages & Recent Projects -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Messages -->
        <div class="p-6 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100 dark:border-neutral-800">
                <h2 class="text-sm font-bold tracking-tight text-neutral-900 dark:text-stone-100">
                    Pesan Masuk Terbaru
                </h2>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-mono text-neutral-500 hover:text-neutral-900 dark:hover:text-stone-200">
                    Semua ({{\App\Models\Message::count()}})
                </a>
            </div>

            <div class="divide-y divide-stone-100 dark:divide-neutral-800">
                @forelse($recentMessages as $msg)
                    <div class="py-3 flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-xs text-neutral-900 dark:text-stone-100 truncate">
                                    {{ $msg->sender_name }}
                                </span>
                                @if(!$msg->is_read)
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-mono bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Baru</span>
                                @endif
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 line-clamp-1">
                                {{ $msg->subject }} — {{ $msg->message_body }}
                            </p>
                        </div>
                        <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-mono text-blue-600 dark:text-blue-400 hover:underline shrink-0">
                            Buka &rarr;
                        </a>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs font-mono text-neutral-400">
                        Belum ada pesan masuk.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Projects -->
        <div class="p-6 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100 dark:border-neutral-800">
                <h2 class="text-sm font-bold tracking-tight text-neutral-900 dark:text-stone-100">
                    Daftar Proyek
                </h2>
                <a href="{{ route('admin.projects.create') }}" class="text-xs font-mono text-blue-600 dark:text-blue-400 hover:underline">
                    + Tambah Proyek
                </a>
            </div>

            <div class="divide-y divide-stone-100 dark:divide-neutral-800">
                @forelse($recentProjects as $proj)
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <h4 class="font-semibold text-xs text-neutral-900 dark:text-stone-100 truncate">
                                {{ $proj->title }}
                            </h4>
                            <span class="text-[11px] font-mono text-neutral-400">
                                {{ $proj->category }} &bull; {{ $proj->created_at->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('admin.projects.edit', $proj) }}" class="p-1 text-xs font-mono text-neutral-500 hover:text-neutral-900 dark:hover:text-stone-100">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs font-mono text-neutral-400">
                        Belum ada proyek dibuat.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

