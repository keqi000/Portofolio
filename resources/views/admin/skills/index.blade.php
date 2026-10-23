@extends('layouts.admin')

@section('title', 'Kelola Keahlian & Kategori')
@section('header_title', 'Matriks Keahlian & Kategori Stack')

@section('content')
<div class="space-y-10">
    <!-- Top action forms: Add Category & Add Skill -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Add Skill Form -->
        <div class="p-6 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <h2 class="text-sm font-bold tracking-tight text-neutral-900 dark:text-stone-100 mb-4 pb-2 border-b border-stone-100 dark:border-neutral-800">
                + Tambah Keahlian (Skill) Baru
            </h2>
            <form method="POST" action="{{ route('admin.skills.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="category_id" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">
                        Pilih Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required class="w-full px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="name" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">
                            Nama Teknologi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required placeholder="Contoh: Redis Caching" class="w-full px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label for="proficiency_level" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">
                            Tingkat Kemahiran <span class="text-red-500">*</span>
                        </label>
                        <select name="proficiency_level" id="proficiency_level" required class="w-full px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="production">Core / Production</option>
                            <option value="learning">Currently Exploring / Learning</option>
                        </select>
                    </div>
                </div>

                <div class="pt-2 text-right">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 text-xs font-mono font-medium transition-all active:scale-[0.98]">
                        Simpan Keahlian &rarr;
                    </button>
                </div>
            </form>
        </div>

        <!-- Add Category Form -->
        <div class="p-6 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
            <h2 class="text-sm font-bold tracking-tight text-neutral-900 dark:text-stone-100 mb-4 pb-2 border-b border-stone-100 dark:border-neutral-800">
                + Tambah Kategori Baru
            </h2>
            <form method="POST" action="{{ route('admin.skills.category.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="cat_name" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="cat_name" required placeholder="Contoh: Cloud Architecture & Testing" class="w-full px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label for="cat_sort_order" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">
                        Urutan Tampilan
                    </label>
                    <input type="number" name="sort_order" id="cat_sort_order" value="0" class="w-full px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="pt-2 text-right">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 text-xs font-mono font-medium transition-all active:scale-[0.98]">
                        Simpan Kategori &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Existing Categories and Skills List -->
    <div class="space-y-6">
        <h2 class="text-base font-bold tracking-tight text-neutral-900 dark:text-stone-100">
            Daftar Kategori & Keahlian Aktif
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($categories as $category)
                <div class="p-6 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-stone-100 dark:border-neutral-800">
                        <div>
                            <h3 class="font-bold text-neutral-900 dark:text-stone-100 text-sm">
                                {{ $category->name }}
                            </h3>
                            <span class="text-[10px] font-mono text-neutral-400">
                                Slug: {{ $category->slug }} &bull; {{ $category->skills->count() }} items
                            </span>
                        </div>
                        <form method="POST" action="{{ route('admin.skills.category.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini beserta seluruh keahlian di dalamnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-mono text-red-600 dark:text-red-400 hover:underline">
                                Hapus Kategori
                            </button>
                        </form>
                    </div>

                    <!-- Skills items -->
                    <div class="space-y-2">
                        @forelse($category->skills as $skill)
                            <div class="flex items-center justify-between p-2.5 rounded-lg border border-stone-100 dark:border-neutral-800 bg-stone-50/50 dark:bg-neutral-900/40 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $skill->proficiency_level === 'production' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                    <span class="font-medium text-neutral-900 dark:text-stone-100">
                                        {{ $skill->name }}
                                    </span>
                                    <span class="text-[10px] font-mono text-neutral-400">
                                        ({{ $skill->proficiency_level }})
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Hapus keahlian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-neutral-400 hover:text-red-600 font-mono text-xs">
                                        &times;
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="py-4 text-center text-xs font-mono text-neutral-400">
                                Belum ada keahlian di kategori ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs font-mono text-neutral-400">
                    Belum ada kategori keahlian.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

