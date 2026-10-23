@extends('layouts.admin')

@section('title', 'Tambah Proyek Baru')
@section('header_title', 'Tambah Proyek Baru')

@section('content')
<div class="max-w-3xl">
    <div class="p-8 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Judul Proyek <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: LogistikHub Multi-Warehouse" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Slug (Optional, auto-generated) -->
            <div>
                <label for="slug" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    URL Slug (Opsional, kosongkan untuk auto-generate)
                </label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="logistikhub-inventory" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Tagline & Category -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category" id="category" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="Full-Stack">Full-Stack</option>
                        <option value="Backend / API">Backend / API</option>
                        <option value="Open Source">Open Source</option>
                        <option value="Mobile App">Mobile App</option>
                    </select>
                </div>
                <div>
                    <label for="sort_order" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Urutan Tampilan
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Tagline -->
            <div>
                <label for="tagline" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Tagline Ringkas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="tagline" id="tagline" value="{{ old('tagline') }}" required placeholder="Sistem pergudangan terdistribusi dengan audit stok real-time" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Tech Stack (Comma separated) -->
            <div>
                <label for="tech_stack" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Tech Stack (Pisahkan dengan koma) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="tech_stack" id="tech_stack" value="{{ old('tech_stack', 'Laravel 12, PostgreSQL, Tailwind CSS, Alpine.js') }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Problem Statement -->
            <div>
                <label for="problem_statement" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Masalah & Tantangan Nyata <span class="text-red-500">*</span>
                </label>
                <textarea name="problem_statement" id="problem_statement" rows="4" required placeholder="Jelaskan masalah pengguna atau hambatan yang terjadi sebelum sistem dibuat..." class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('problem_statement') }}</textarea>
            </div>

            <!-- Solution Description -->
            <div>
                <label for="solution_description" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Solusi Rekayasa & Fitur Utama <span class="text-red-500">*</span>
                </label>
                <textarea name="solution_description" id="solution_description" rows="4" required placeholder="Jelaskan arsitektur yang dibangun, fitur-fitur penting, dan dampaknya..." class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('solution_description') }}</textarea>
            </div>

            <!-- URLs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="live_url" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Live Demo URL (Opsional)
                    </label>
                    <input type="url" name="live_url" id="live_url" value="{{ old('live_url') }}" placeholder="https://demo.example.com" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label for="github_url" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        GitHub URL (Opsional)
                    </label>
                    <input type="url" name="github_url" id="github_url" value="{{ old('github_url') }}" placeholder="https://github.com/user/repo" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Featured Image Upload (Supabase / Local) -->
            <div>
                <label for="featured_image" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Screenshot / Cover Proyek (PNG, JPG, WEBP - Max 2MB)
                </label>
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-xs font-mono text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-stone-100 dark:file:bg-stone-100 dark:file:text-neutral-900 hover:file:opacity-90">
            </div>

            <!-- Toggles: Featured & Published -->
            <div class="flex items-center gap-6 pt-2">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-mono text-neutral-700 dark:text-neutral-300">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-stone-300 text-blue-600 focus:ring-blue-500">
                    <span>Tampilkan di Halaman Utama (Featured)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-mono text-neutral-700 dark:text-neutral-300">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }} class="rounded border-stone-300 text-blue-600 focus:ring-blue-500">
                    <span>Publikasikan (Published)</span>
                </label>
            </div>

            <div class="pt-4 border-t border-stone-200 dark:border-neutral-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 text-xs font-mono text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-stone-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 text-xs font-mono font-medium transition-all active:scale-[0.98]">
                    Simpan Proyek &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

