@extends('layouts.admin')

@section('title', 'Edit Proyek: ' . $project->title)
@section('header_title', 'Edit Proyek: ' . $project->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="p-8 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Judul Proyek <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    URL Slug
                </label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $project->slug) }}" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Tagline & Category -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category" id="category" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" {{ old('category', $project->category) === $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="sort_order" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Posisi di Home
                    </label>
                    <select name="sort_order" id="sort_order" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @for($position = 1; $position <= $projectCount; $position++)
                            <option value="{{ $position }}" {{ (int) old('sort_order', $project->sort_order) === $position ? 'selected' : '' }}>{{ $position }}</option>
                        @endfor
                    </select>
                    <p class="text-[11px] text-neutral-500 mt-1">Proyek lain akan bergeser otomatis mengikuti posisi ini.</p>
                </div>
            </div>

            <!-- Tagline -->
            <div>
                <label for="tagline" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Tagline Ringkas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $project->tagline) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Tech Stack (Comma separated) -->
            <div>
                <label for="tech_stack" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Tech Stack (Pisahkan dengan koma) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="tech_stack" id="tech_stack" value="{{ old('tech_stack', is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : $project->tech_stack) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Problem Statement -->
            <div>
                <label for="problem_statement" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Masalah & Tantangan Nyata <span class="text-red-500">*</span>
                </label>
                <textarea name="problem_statement" id="problem_statement" rows="4" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('problem_statement', $project->problem_statement) }}</textarea>
            </div>

            <!-- Solution Description -->
            <div>
                <label for="solution_description" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Solusi Rekayasa & Fitur Utama <span class="text-red-500">*</span>
                </label>
                <textarea name="solution_description" id="solution_description" rows="4" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('solution_description', $project->solution_description) }}</textarea>
            </div>

            <!-- URLs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="live_url" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Live Demo URL (Opsional)
                    </label>
                    <input type="url" name="live_url" id="live_url" value="{{ old('live_url', $project->live_url) }}" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label for="github_url" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        GitHub URL (Opsional)
                    </label>
                    <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $project->github_url) }}" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Featured Image Preview & Upload -->
            <div>
                <label for="featured_image" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Foto Sampul Proyek
                </label>
                @if($project->featured_image)
                    <div class="mb-3 w-48 aspect-16/10 rounded-lg overflow-hidden border border-stone-200 dark:border-neutral-800 bg-neutral-100">
                        <img src="{{ $project->featured_image }}" alt="Cover" class="w-full h-full object-cover">
                    </div>
                @endif
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-xs font-mono text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-stone-100 dark:file:bg-stone-100 dark:file:text-neutral-900 hover:file:opacity-90">
                <p class="text-[10px] font-mono text-neutral-400 mt-1">Unggah berkas baru hanya jika ingin mengganti gambar sampul.</p>
            </div>

            <div class="pt-4 border-t border-stone-200 dark:border-neutral-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 text-xs font-mono text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-stone-200">
                    <x-admin-icon name="close" class="h-4 w-4"/>
                    <span class="sr-only">Batal</span>
                </a>
                <button type="submit" aria-label="Perbarui proyek" title="Perbarui proyek" class="p-2.5 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 transition-all active:scale-[0.98]">
                    <x-admin-icon name="save" class="h-5 w-5"/>
                </button>
            </div>
        </form>

        <section class="mt-8 border-t border-stone-200 dark:border-neutral-800 pt-6" aria-labelledby="gallery-heading">
            <h2 id="gallery-heading" class="text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-2">
                Kelola Foto Carousel
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Gambar yang sudah ada akan tetap tersimpan saat Anda menambahkan gambar baru. Hapus hanya gambar yang memang ingin dihapus.
                Setiap gambar maksimal 2MB.
            </p>

            <div id="gallery-images" class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4" aria-live="polite">
                @forelse($project->images as $image)
                    <article class="rounded-lg border border-stone-200 dark:border-neutral-700 overflow-hidden" data-gallery-card>
                        <img src="{{ $image->image_path }}" alt="Screenshot carousel" class="w-full aspect-video object-cover">
                        <div class="flex items-center justify-between gap-2 p-2">
                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400">Gambar carousel</span>
                            <button type="button" data-delete-url="{{ route('admin.projects.images.destroy', [$project, $image]) }}" class="text-[11px] font-medium text-red-600 hover:text-red-700 dark:text-red-400" aria-label="Hapus gambar carousel">
                                Hapus
                            </button>
                        </div>
                    </article>
                @empty
                    <p id="gallery-empty" class="col-span-full text-sm text-neutral-500 dark:text-neutral-400">Belum ada gambar carousel.</p>
                @endforelse
            </div>

            <label for="gallery_images" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                Tambahkan Gambar
            </label>
            <input type="file" id="gallery_images" accept="image/jpeg,image/png,image/webp" multiple class="w-full text-xs font-mono text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-stone-100 dark:file:bg-stone-100 dark:file:text-neutral-900 hover:file:opacity-90">
            <p class="text-[10px] font-mono text-neutral-400 mt-1">Pilih satu atau beberapa file. Masing-masing akan diunggah dalam request terpisah.</p>
            <div id="gallery-upload-queue" class="mt-4 space-y-3" aria-live="polite"></div>
            <p id="gallery-feedback" class="mt-3 text-sm" role="status" aria-live="polite"></p>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const galleryInput = document.getElementById('gallery_images');
    const galleryGrid = document.getElementById('gallery-images');
    const uploadQueue = document.getElementById('gallery-upload-queue');
    const galleryFeedback = document.getElementById('gallery-feedback');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const uploadUrl = @json(route('admin.projects.images.store', $project));
    let queuePromise = Promise.resolve();

    function setFeedback(message, isError = false) {
        galleryFeedback.textContent = message;
        galleryFeedback.className = `mt-3 text-sm ${isError ? 'text-red-600 dark:text-red-400' : 'text-neutral-600 dark:text-neutral-300'}`;
    }

    function makeGalleryCard(image) {
        const card = document.createElement('article');
        card.className = 'rounded-lg border border-stone-200 dark:border-neutral-700 overflow-hidden';
        card.setAttribute('data-gallery-card', '');

        const preview = document.createElement('img');
        preview.src = image.url;
        preview.alt = 'Screenshot carousel';
        preview.className = 'w-full aspect-video object-cover';

        const footer = document.createElement('div');
        footer.className = 'flex items-center justify-between gap-2 p-2';

        const label = document.createElement('span');
        label.className = 'text-[11px] text-neutral-500 dark:text-neutral-400';
        label.textContent = 'Gambar carousel';

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.dataset.deleteUrl = image.delete_url;
        deleteButton.className = 'text-[11px] font-medium text-red-600 hover:text-red-700 dark:text-red-400';
        deleteButton.setAttribute('aria-label', 'Hapus gambar carousel');
        deleteButton.textContent = 'Hapus';

        footer.append(label, deleteButton);
        card.append(preview, footer);
        return card;
    }

    function uploadFile(file, item) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            const formData = new FormData();
            const status = item.querySelector('[data-upload-status]');
            const progress = item.querySelector('[data-upload-progress]');
            const retry = item.querySelector('[data-upload-retry]');
            formData.append('image', file);

            status.textContent = 'Mengunggah...';
            status.className = 'text-xs text-neutral-500 dark:text-neutral-400';
            progress.hidden = false;
            retry.hidden = true;

            xhr.open('POST', uploadUrl);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.upload.addEventListener('progress', (event) => {
                if (event.lengthComputable) {
                    progress.value = Math.round((event.loaded / event.total) * 100);
                }
            });
            xhr.addEventListener('load', () => {
                if (xhr.status === 413) {
                    reject(new Error('Ukuran gambar terlalu besar untuk diproses server. Kompres gambar lalu coba lagi.'));
                    return;
                }

                let response;
                try {
                    response = JSON.parse(xhr.responseText);
                } catch {
                    reject(new Error('Respons server tidak dapat dibaca.'));
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject(new Error(response.errors?.image?.[0] || response.message || 'Gagal mengunggah gambar.'));
                    return;
                }

                galleryGrid.querySelector('#gallery-empty')?.remove();
                galleryGrid.append(makeGalleryCard(response));
                status.textContent = 'Berhasil diunggah';
                status.className = 'text-xs text-green-700 dark:text-green-400';
                progress.value = 100;
                resolve();
            });
            xhr.addEventListener('error', () => reject(new Error('Koneksi terputus. Periksa internet lalu coba lagi.')));
            xhr.addEventListener('abort', () => reject(new Error('Upload dibatalkan.')));
            xhr.send(formData);
        }).catch((error) => {
            const status = item.querySelector('[data-upload-status]');
            const retry = item.querySelector('[data-upload-retry]');
            status.textContent = error.message;
            status.className = 'text-xs text-red-600 dark:text-red-400';
            retry.hidden = false;
            retry.disabled = false;
            throw error;
        });
    }

    function makeQueueItem(file) {
        const item = document.createElement('div');
        item.className = 'rounded-lg border border-stone-200 dark:border-neutral-700 p-3';

        const heading = document.createElement('div');
        heading.className = 'flex items-center justify-between gap-3';

        const filename = document.createElement('span');
        filename.className = 'min-w-0 truncate text-xs text-neutral-700 dark:text-neutral-300';
        filename.textContent = file.name;

        const status = document.createElement('span');
        status.className = 'text-xs text-neutral-500 dark:text-neutral-400';
        status.dataset.uploadStatus = '';
        status.textContent = 'Menunggu...';

        const progress = document.createElement('progress');
        progress.className = 'mt-2 h-1.5 w-full accent-blue-600';
        progress.max = 100;
        progress.value = 0;
        progress.hidden = true;
        progress.dataset.uploadProgress = '';

        const retry = document.createElement('button');
        retry.type = 'button';
        retry.className = 'mt-2 text-xs font-medium text-blue-700 hover:underline dark:text-blue-400';
        retry.textContent = 'Coba lagi';
        retry.hidden = true;
        retry.dataset.uploadRetry = '';
        retry.addEventListener('click', () => {
            retry.disabled = true;
            queuePromise = queuePromise.then(() => uploadFile(file, item)).catch(() => {});
        });

        heading.append(filename, status);
        item.append(heading, progress, retry);
        uploadQueue.append(item);
        return item;
    }

    galleryInput.addEventListener('change', () => {
        const files = Array.from(galleryInput.files || []);
        galleryInput.value = '';
        if (files.length === 0) return;

        const items = files.map(makeQueueItem);
        galleryInput.disabled = true;
        setFeedback(`Menyiapkan ${files.length} gambar untuk diunggah satu per satu.`);

        queuePromise = queuePromise.then(async () => {
            let completed = 0;
            for (let index = 0; index < files.length; index += 1) {
                try {
                    await uploadFile(files[index], items[index]);
                    completed += 1;
                    setFeedback(`${completed} dari ${files.length} gambar berhasil diunggah.`);
                } catch {
                    setFeedback(`Upload "${files[index].name}" gagal. Anda dapat mencoba ulang gambar tersebut.`, true);
                }
            }
            galleryInput.disabled = false;
        });
    });

    galleryGrid.addEventListener('click', (event) => {
        const button = event.target.closest('[data-delete-url]');
        if (!button || !window.confirm('Hapus gambar carousel ini? Gambar akan langsung dihapus.')) return;

        button.disabled = true;
        setFeedback('Menghapus gambar...');
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', button.dataset.deleteUrl);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.addEventListener('load', () => {
            let response = {};
            try {
                response = JSON.parse(xhr.responseText);
            } catch {
                setFeedback('Respons server tidak dapat dibaca.', true);
            }

            if (xhr.status >= 200 && xhr.status < 300) {
                button.closest('[data-gallery-card]').remove();
                if (!galleryGrid.querySelector('[data-gallery-card]')) {
                    const empty = document.createElement('p');
                    empty.id = 'gallery-empty';
                    empty.className = 'col-span-full text-sm text-neutral-500 dark:text-neutral-400';
                    empty.textContent = 'Belum ada gambar carousel.';
                    galleryGrid.append(empty);
                }
                setFeedback(response.message || 'Gambar berhasil dihapus.');
                return;
            }

            button.disabled = false;
            setFeedback(response.message || 'Gagal menghapus gambar. Silakan coba lagi.', true);
        });
        xhr.addEventListener('error', () => {
            button.disabled = false;
            setFeedback('Koneksi terputus. Periksa internet lalu coba lagi.', true);
        });
        xhr.send();
    });
</script>
@endpush
