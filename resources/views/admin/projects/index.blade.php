@extends('layouts.admin')

@section('title', 'Kelola Proyek')
@section('header_title', 'Daftar Proyek')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 text-xs font-mono text-neutral-600 dark:text-neutral-300 hover:bg-stone-100 dark:hover:bg-neutral-800 transition-colors">
            <x-admin-icon name="back"/>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>
    <div class="flex items-center justify-between">
        <p class="text-xs font-mono text-neutral-500 dark:text-neutral-400">
            Total {{ $projects->total() }} proyek terdaftar di database.
        </p>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 text-xs font-mono font-medium transition-all active:scale-[0.98]">
            <x-admin-icon name="add" class="h-4 w-4"/>
            <span class="sr-only">Tambah proyek baru</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <form method="POST" action="{{ route('admin.projects.categories.store') }}" class="lg:col-span-1 p-5 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316] space-y-3">
            @csrf
            <h2 class="text-sm font-semibold text-neutral-900 dark:text-stone-100">Tambah Kategori Proyek</h2>
            <label for="project_category_name" class="sr-only">Nama kategori</label>
            <input type="text" name="name" id="project_category_name" required maxlength="100" placeholder="Nama kategori baru" class="w-full px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm">
            <div>
                <label for="project_category_sort" class="block text-xs font-mono text-neutral-600 dark:text-neutral-300 mb-1">Posisi kategori</label>
                <select name="sort_order" id="project_category_sort" class="w-full px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm">
                    @for($position = 1; $position <= $categories->count() + 1; $position++)
                        <option value="{{ $position }}" {{ $position === $categories->count() + 1 ? 'selected' : '' }}>{{ $position }}{{ $position === $categories->count() + 1 ? ' (paling akhir)' : '' }}</option>
                    @endfor
                </select>
                <p class="text-[11px] text-neutral-500 mt-1">Kategori lain akan bergeser otomatis.</p>
            </div>
            <button type="submit" aria-label="Simpan kategori proyek" title="Simpan kategori proyek" class="p-2 rounded-lg bg-neutral-900 text-white dark:bg-stone-100 dark:text-neutral-900">
                <x-admin-icon name="save"/>
            </button>
        </form>
        <div class="lg:col-span-2 p-5 rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <h2 class="text-sm font-semibold text-neutral-900 dark:text-stone-100 mb-3">Kategori Proyek</h2>
            <div class="flex flex-wrap gap-2">
                @forelse($categories as $category)
                    <div class="flex flex-wrap items-center gap-2 px-3 py-2 rounded-lg bg-stone-100 dark:bg-neutral-800 text-xs">
                        <span>{{ $category->name }} <span class="text-neutral-500">· {{ $category->projects_count }} proyek</span></span>
                        <form method="POST" action="{{ route('admin.projects.categories.order', $category) }}" class="flex items-center gap-1">
                            @csrf
                            @method('PATCH')
                            <label for="project_category_position_{{ $category->id }}" class="sr-only">Posisi kategori {{ $category->name }}</label>
                            <select name="sort_order" id="project_category_position_{{ $category->id }}" class="px-2 py-1 rounded border border-stone-300 dark:border-neutral-700 bg-white dark:bg-neutral-900">
                                @for($position = 1; $position <= $categories->count(); $position++)
                                    <option value="{{ $position }}" {{ $position === $category->sort_order ? 'selected' : '' }}>{{ $position }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="p-1 text-blue-600 dark:text-blue-400" aria-label="Simpan posisi kategori {{ $category->name }}" title="Simpan posisi">
                                <x-admin-icon name="sort"/>
                            </button>
                        </form>
                        @if($category->projects_count === 0)
                            <form method="POST" action="{{ route('admin.projects.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-red-600 dark:text-red-400" aria-label="Hapus kategori {{ $category->name }}" title="Hapus kategori">
                                    <x-admin-icon name="delete"/>
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-neutral-500">Belum ada kategori.</p>
                @endforelse
            </div>
            <p class="text-[11px] text-neutral-500 mt-3">Kategori yang sedang dipakai proyek tidak dapat dihapus.</p>
        </div>
    </div>

    <div class="rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-stone-200 dark:border-neutral-800 bg-stone-50/50 dark:bg-neutral-900/40 text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        <th class="py-3 px-4">Proyek</th>
                        <th class="py-3 px-4">Posisi Home</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Tech Stack</th>
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
                            <td class="py-3.5 px-4">
                                <form method="POST" action="{{ route('admin.projects.order', $proj) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="project_position_{{ $proj->id }}" class="sr-only">Posisi Home untuk {{ $proj->title }}</label>
                                    <select name="sort_order" id="project_position_{{ $proj->id }}" class="px-2 py-1.5 rounded border border-stone-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-xs">
                                        @for($position = 1; $position <= $projects->total(); $position++)
                                            <option value="{{ $position }}" {{ $position === $proj->sort_order ? 'selected' : '' }}>{{ $position }}</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="p-1 text-blue-600 dark:text-blue-400" aria-label="Simpan posisi Home untuk {{ $proj->title }}" title="Simpan posisi">
                                        <x-admin-icon name="sort"/>
                                    </button>
                                </form>
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
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('projects.show', $proj->slug) }}" target="_blank" class="p-1.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-stone-200" title="Preview Publik" aria-label="Preview proyek {{ $proj->title }}">
                                        <x-admin-icon name="view"/>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $proj) }}" class="p-1.5 text-blue-600 dark:text-blue-400" title="Edit proyek" aria-label="Edit proyek {{ $proj->title }}">
                                        <x-admin-icon name="edit"/>
                                    </a>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $proj) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 dark:text-red-400" title="Hapus proyek" aria-label="Hapus proyek {{ $proj->title }}">
                                            <x-admin-icon name="delete"/>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-xs font-mono text-neutral-400">
                                Belum ada proyek. Gunakan tombol tambah untuk memulai.
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
