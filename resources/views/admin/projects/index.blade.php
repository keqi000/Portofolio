@extends('layouts.admin')

@section('title', 'Kelola Proyek')
@section('header_title', 'Daftar Proyek & Studi Kasus')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-xs font-mono text-neutral-500 dark:text-neutral-400">
            Total {{ $projects->total() }} proyek terdaftar di database.
        </p>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 text-xs font-mono font-medium transition-all active:scale-[0.98]">
            <span>+ Tambah Proyek Baru</span>
        </a>
    </div>

    <div class="rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-stone-200 dark:border-neutral-800 bg-stone-50/50 dark:bg-neutral-900/40 text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        <th class="py-3 px-4">Proyek</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Tech Stack</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 dark:divide-neutral-800">
                    @forelse($projects as $proj)
                        <tr class="hover:bg-stone-50/40 dark:hover:bg-neutral-800/30 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-neutral-900 dark:text-stone-100">
                                    {{ $proj->title }}
                                </div>
                                <div class="text-xs font-mono text-neutral-400 line-clamp-1 max-w-xs">
                                    {{ $proj->tagline }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-neutral-600 dark:text-neutral-400">
                                {{ $proj->category }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @if(is_array($proj->tech_stack))
                                        @foreach(array_slice($proj->tech_stack, 0, 3) as $tech)
                                            <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-stone-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <form method="POST" action="{{ route('admin.projects.toggle-publish', $proj) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-mono font-medium {{ $proj->is_published ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-stone-100 text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $proj->is_published ? 'bg-emerald-500' : 'bg-neutral-400' }}"></span>
                                        <span>{{ $proj->is_published ? 'Published' : 'Draft' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('projects.show', $proj->slug) }}" target="_blank" class="p-1.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-stone-200" title="Preview Publik">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $proj) }}" class="p-1.5 text-blue-600 dark:text-blue-400 hover:underline text-xs font-mono">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $proj) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 dark:text-red-400 hover:underline text-xs font-mono">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-xs font-mono text-neutral-400">
                                Belum ada proyek. Klik "+ Tambah Proyek Baru" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-stone-200 dark:border-neutral-800">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

