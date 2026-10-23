@extends('layouts.app')

@section('title', 'Hubungi Saya — ' . ($settings['author_name'] ?? 'Febrian Rezki Hemeto'))
@section('meta_description', 'Hubungi ' . ($settings['author_name'] ?? 'Febrian Rezki Hemeto') . ' untuk peluang kerja dan proyek web.')

@section('content')
@php
    $contactPhone = preg_replace('/\D/', '', $settings['contact_phone'] ?? '082290581860');
    $whatsappPhone = str_starts_with($contactPhone, '0')
        ? '62' . substr($contactPhone, 1)
        : $contactPhone;
@endphp
<div class="py-16 md:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-14">
            <span class="text-xs font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold mb-2 block">
                Get In Touch
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-neutral-950 dark:text-stone-50 mb-4">
                Mari Terhubung & Berdiskusi.
            </h1>
            <p class="text-base sm:text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed max-w-2xl">
                Apakah Anda memiliki proyek baru, tawaran kerja, atau sekadar ingin mendiskusikan arsitektur web modern? Silakan hubungi saya melalui formulir di bawah ini atau saluran langsung.
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Direct Channels (4 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Email Card -->
                <div class="p-6 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#141618]">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-neutral-400 block mb-1">
                        Surel Langsung
                    </span>
                    <a href="mailto:{{ $settings['contact_email'] ?? 'febrianhemeto04@gmail.com' }}" class="text-base font-semibold text-neutral-900 dark:text-stone-100 hover:text-blue-600 dark:hover:text-blue-400 transition-colors break-all">
                        {{ $settings['contact_email'] ?? 'febrianhemeto04@gmail.com' }}
                    </a>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">
                        Waktu respons rata-rata: dalam 1x24 jam kerja.
                    </p>
                </div>

                <div class="p-6 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#141618] space-y-4">
                    <div>
                        <span class="text-[11px] font-mono uppercase tracking-wider text-neutral-400 block mb-1">
                            WhatsApp
                        </span>
                        <a href="https://wa.me/{{ $whatsappPhone }}" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-neutral-900 dark:text-stone-100 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            {{ $contactPhone }}
                        </a>
                    </div>
                    <div>
                        <span class="text-[11px] font-mono uppercase tracking-wider text-neutral-400 block mb-1">
                            Domisili
                        </span>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300">
                            {{ $settings['author_location'] ?? 'Datahu, Kec. Tibawa, Kab. Gorontalo, Provinsi Gorontalo' }}
                        </p>
                    </div>
                </div>

                <div class="p-6 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#141618]">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-neutral-400 block mb-2">
                        LinkedIn
                    </span>
                    <a href="{{ $settings['linkedin_url'] ?: 'https://www.linkedin.com/in/febrian-rezki-hemeto-4a788a287/' }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-neutral-900 dark:text-stone-100 hover:text-blue-700 dark:hover:text-blue-400 transition-colors">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M5.2 3.5a1.8 1.8 0 1 0 0 3.6 1.8 1.8 0 0 0 0-3.6ZM3.7 8.5h3v11h-3v-11Zm5 0h2.9V10h.04a3.2 3.2 0 0 1 2.88-1.58c3.08 0 3.65 2.02 3.65 4.65v6.43h-3v-5.7c0-1.36-.03-3.1-1.89-3.1-1.89 0-2.18 1.48-2.18 3v5.8h-3v-11Z"/>
                        </svg>
                        <span>febrian-rezki-hemeto-4a788a287</span>
                    </a>
                </div>

                <!-- Availability Badge Box -->
                <div class="p-6 rounded-2xl border border-emerald-200/80 dark:border-emerald-800/60 bg-emerald-50/50 dark:bg-emerald-950/20 text-xs text-emerald-900 dark:text-emerald-300 font-mono">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Status Ketersediaan</span>
                    </div>
                    <p class="leading-relaxed opacity-90">
                        {{ $settings['availability_status'] ?? 'Full Stack Web Development | Pengembangan Sistem Informasi' }}
                    </p>
                </div>
            </div>

            <!-- Contact Form (7 cols) -->
            <div class="lg:col-span-7">
                <div class="p-8 rounded-2xl border border-stone-200/90 dark:border-neutral-800 bg-white dark:bg-[#141618]">
                    <h2 class="text-xl font-bold tracking-tight text-neutral-950 dark:text-stone-50 mb-2">
                        Kirim Pesan
                    </h2>
                    <p class="text-xs font-mono text-neutral-500 dark:text-neutral-400 mb-6">
                        Pesan Anda langsung masuk ke inbox dashboard admin.
                    </p>

                    <x-flash />

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                        @csrf

                        <!-- Honeypot anti-spam field (hidden from humans, trapped for bots) -->
                        <div class="hidden" aria-hidden="true">
                            <label for="website_hp">Leave this empty</label>
                            <input type="text" name="website_hp" id="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="sender_name" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="sender_name" id="sender_name" value="{{ old('sender_name') }}" required placeholder="Contoh: Budi Pratama" class="w-full px-4 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="sender_email" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-2">
                                Alamat Surel / Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="sender_email" id="sender_email" value="{{ old('sender_email') }}" required placeholder="nama@perusahaan.com" class="w-full px-4 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-2">
                                Topik / Subjek <span class="text-red-500">*</span>
                            </label>
                            <select name="subject" id="subject" required class="w-full px-4 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Pilih topik diskusi...</option>
                                <option value="Tawaran Pekerjaan Full-Time / Kontrak" {{ old('subject') == 'Tawaran Pekerjaan Full-Time / Kontrak' ? 'selected' : '' }}>Tawaran Pekerjaan Full-Time / Kontrak</option>
                                <option value="Proyek Pembuatan Web / Freelance" {{ old('subject') == 'Proyek Pembuatan Web / Freelance' ? 'selected' : '' }}>Proyek Pembuatan Web / Freelance</option>
                                <option value="Konsultasi Teknis & Arsitektur" {{ old('subject') == 'Konsultasi Teknis & Arsitektur' ? 'selected' : '' }}>Konsultasi Teknis & Arsitektur</option>
                                <option value="Lainnya" {{ old('subject') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Message Body -->
                        <div>
                            <label for="message_body" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-2">
                                Pesan Anda <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message_body" id="message_body" rows="5" required placeholder="Jelaskan kebutuhan proyek, jadwal, atau pertanyaan Anda..." class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all leading-relaxed">{{ old('message_body') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-medium tracking-wide bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-950 dark:hover:bg-stone-200 transition-all active:scale-[0.98]">
                                <span>Kirim Pesan Sekarang</span>
                                <span class="font-mono text-xs">&rarr;</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
