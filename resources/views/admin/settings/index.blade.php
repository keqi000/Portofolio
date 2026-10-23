@extends('layouts.admin')

@section('title', 'Pengaturan Profil & Konten')
@section('header_title', 'Pengaturan Profil & Situs Web')

@section('content')
<div class="max-w-3xl">
    <div class="p-8 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316]">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Author Name & Title -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="author_name" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author_name" id="author_name" value="{{ old('author_name', $settings['author_name']) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label for="author_title" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Profesi / Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author_title" id="author_title" value="{{ old('author_title', $settings['author_title']) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Primary Headline -->
            <div>
                <label for="headline" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Headline Utama (Hero) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="headline" id="headline" value="{{ old('headline', $settings['headline']) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Availability Status -->
            <div>
                <label for="availability_status" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Status Ketersediaan Kerja (Badge) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="availability_status" id="availability_status" value="{{ old('availability_status', $settings['availability_status']) }}" required placeholder="Contoh: Full Stack Web Development" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Bio Summary (Hero subhead) -->
            <div>
                <label for="bio_summary" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Ringkasan Singkat (Muncul di Hero) <span class="text-red-500">*</span>
                </label>
                <textarea name="bio_summary" id="bio_summary" rows="3" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('bio_summary', $settings['bio_summary']) }}</textarea>
            </div>

            <!-- Full About Narrative -->
            <div>
                <label for="about_narrative" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Narasi Profil Lengkap (Halaman About) <span class="text-red-500">*</span>
                </label>
                <textarea name="about_narrative" id="about_narrative" rows="5" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('about_narrative', $settings['about_narrative']) }}</textarea>
            </div>

            <!-- Contact Email -->
            <div>
                <label for="contact_email" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Email Kontak Publik <span class="text-red-500">*</span>
                </label>
                <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="contact_phone" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label for="author_location" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Domisili <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author_location" id="author_location" value="{{ old('author_location', $settings['author_location']) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Social Links -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="linkedin_url" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        LinkedIn URL
                    </label>
                    <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url']) }}" placeholder="https://linkedin.com/in/..." class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label for="instagram_url" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                        Instagram URL
                    </label>
                    <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $settings['instagram_url']) }}" placeholder="https://instagram.com/username" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="profile_image" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Foto Profil (JPEG, PNG, WEBP - Maks. 2MB)
                </label>
                @if(!empty($settings['profile_image_url']))
                    <div class="flex items-center gap-4 mb-3">
                        <img src="{{ $settings['profile_image_url'] }}" alt="Foto profil saat ini" class="w-20 h-20 rounded-full object-cover border border-stone-200 dark:border-neutral-700">
                        <label class="flex items-center gap-2 text-xs text-neutral-600 dark:text-neutral-300">
                            <input type="checkbox" name="remove_profile_image" value="1" class="rounded border-stone-300 text-red-600">
                            <x-admin-icon name="delete" class="h-4 w-4"/>
                            <span class="sr-only">Hapus foto saat ini</span>
                        </label>
                    </div>
                @endif
                <input type="file" name="profile_image" id="profile_image" accept="image/jpeg,image/png,image/webp" class="w-full text-xs font-mono text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-stone-100 dark:file:bg-stone-100 dark:file:text-neutral-900 hover:file:opacity-90">
                <p class="text-[10px] font-mono text-neutral-400 mt-1">Foto akan tampil pada halaman Home dan About.</p>
            </div>

            <!-- Resume / CV Upload -->
            <div>
                <label for="resume_pdf" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                    Upload Berkas CV / Resume (PDF - Max 5MB)
                </label>
                @if(!empty($settings['resume_pdf_url']))
                    <div class="mb-2 text-xs font-mono text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
                        <x-admin-icon name="check" class="h-4 w-4"/>
                        <a href="{{ $settings['resume_pdf_url'] }}" target="_blank" class="underline" aria-label="Lihat PDF" title="Lihat PDF">
                            <x-admin-icon name="external"/>
                        </a>
                    </div>
                @endif
                <input type="file" name="resume_pdf" id="resume_pdf" accept="application/pdf" class="w-full text-xs font-mono text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-stone-100 dark:file:bg-stone-100 dark:file:text-neutral-900 hover:file:opacity-90">
                <p class="text-[10px] font-mono text-neutral-400 mt-1">Berkas akan diunggah otomatis ke storage Supabase saat di-deploy di Vercel.</p>
            </div>

            <div class="pt-4 border-t border-stone-200 dark:border-neutral-800 flex items-center justify-end">
                <button type="submit" aria-label="Simpan perubahan" title="Simpan perubahan" class="p-2.5 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 transition-all active:scale-[0.98]">
                    <x-admin-icon name="save" class="h-5 w-5"/>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
