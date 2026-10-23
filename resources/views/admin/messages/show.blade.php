@extends('layouts.admin')

@section('title', 'Detail Pesan: ' . $message->subject)
@section('header_title', 'Detail Pesan Masuk')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.messages.index') }}" class="text-xs font-mono text-neutral-500 hover:text-neutral-900 dark:hover:text-stone-200">
            &larr; Kembali ke Kotak Masuk
        </a>

        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('admin.messages.toggle-archive', $message) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-3 py-1.5 rounded-lg border border-stone-300 dark:border-neutral-700 text-xs font-mono hover:bg-stone-100 dark:hover:bg-neutral-800 transition-colors">
                    {{ $message->is_archived ? 'Kembalikan ke Inbox' : 'Arsipkan Pesan' }}
                </button>
            </form>

            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-300 text-xs font-mono hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Message Body Container -->
    <div class="p-8 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316] space-y-6">
        <!-- Message Meta Header -->
        <div class="pb-6 border-b border-stone-100 dark:border-neutral-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] font-mono uppercase tracking-wider text-blue-600 dark:text-blue-400 font-semibold block mb-1">
                    {{ $message->subject }}
                </span>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-stone-100">
                    {{ $message->sender_name }}
                </h2>
                <a href="mailto:{{ $message->sender_email }}" class="text-xs font-mono text-neutral-500 dark:text-neutral-400 hover:underline">
                    {{ $message->sender_email }}
                </a>
            </div>

            <div class="text-right sm:text-right">
                <div class="text-xs font-mono text-neutral-500">
                    {{ $message->created_at->format('d F Y, H:i:s') }}
                </div>
                <div class="text-[10px] font-mono text-neutral-400 mt-1">
                    IP Pengirim: {{ $message->ip_address ?? 'Unknown' }}
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <div class="text-sm sm:text-base text-neutral-800 dark:text-stone-200 leading-relaxed whitespace-pre-line py-4">
            {{ $message->message_body }}
        </div>

        <!-- Quick Reply CTA -->
        <div class="pt-6 border-t border-stone-100 dark:border-neutral-800 flex items-center justify-between">
            <span class="text-xs font-mono text-neutral-400">
                Balas langsung melalui aplikasi email Anda.
            </span>
            <a href="mailto:{{ $message->sender_email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-900 dark:hover:bg-stone-200 text-xs font-mono font-medium transition-all active:scale-[0.98]">
                <span>Balas ke {{ $message->sender_email }}</span>
                <span>↗</span>
            </a>
        </div>
    </div>
</div>
@endsection

