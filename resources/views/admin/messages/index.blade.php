@extends('layouts.admin')

@section('title', 'Kotak Masuk Pesan')
@section('header_title', 'Kotak Masuk Pesan & Pertanyaan')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-stone-300 dark:border-neutral-700 text-xs font-mono text-neutral-600 dark:text-neutral-300 hover:bg-stone-100 dark:hover:bg-neutral-800 transition-colors">
            <x-admin-icon name="back"/>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>
    <!-- Filter Tabs -->
    <div class="flex items-center justify-between pb-4 border-b border-stone-200 dark:border-neutral-800">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.messages.index', ['status' => 'inbox']) }}" class="px-3 py-1.5 rounded-lg text-xs font-mono transition-colors {{ $status === 'inbox' ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900 font-semibold' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-200/60 dark:hover:bg-neutral-800' }}">
                Kotak Masuk Aktif
                @if($unreadCount > 0)
                    <span class="ml-1.5 px-1.5 py-0.2 rounded-full text-[10px] bg-amber-500 text-neutral-950 font-bold">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'archived']) }}" class="px-3 py-1.5 rounded-lg text-xs font-mono transition-colors {{ $status === 'archived' ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900 font-semibold' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-200/60 dark:hover:bg-neutral-800' }}">
                Arsip (Archived)
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'all']) }}" class="px-3 py-1.5 rounded-lg text-xs font-mono transition-colors {{ $status === 'all' ? 'bg-neutral-900 text-stone-100 dark:bg-stone-100 dark:text-neutral-900 font-semibold' : 'text-neutral-600 dark:text-neutral-400 hover:bg-stone-200/60 dark:hover:bg-neutral-800' }}">
                Semua Pesan
            </a>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="rounded-xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-stone-200 dark:border-neutral-800 bg-stone-50/50 dark:bg-neutral-900/40 text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        <th class="py-3 px-4">Pengirim</th>
                        <th class="py-3 px-4">Subjek & Pesan</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 dark:divide-neutral-800">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-stone-50/40 dark:hover:bg-neutral-800/30 transition-colors {{ !$msg->is_read ? 'bg-blue-50/20 dark:bg-blue-950/10' : '' }}">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2">
                                    @if(!$msg->is_read)
                                        <span class="w-2 h-2 rounded-full bg-blue-600 shrink-0" title="Belum dibaca"></span>
                                    @endif
                                    <div class="font-semibold text-neutral-900 dark:text-stone-100 text-xs">
                                        {{ $msg->sender_name }}
                                    </div>
                                </div>
                                <div class="text-[11px] font-mono text-neutral-400 truncate max-w-xs">
                                    {{ $msg->sender_email }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="font-medium text-neutral-900 dark:text-stone-100 hover:text-blue-600 dark:hover:text-blue-400 text-xs block">
                                    {{ $msg->subject }}
                                </a>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 line-clamp-1 max-w-md">
                                    {{ $msg->message_body }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-neutral-500 whitespace-nowrap">
                                {{ $msg->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="p-1.5 text-blue-600 dark:text-blue-400" title="Buka pesan" aria-label="Buka pesan dari {{ $msg->sender_name }}">
                                        <x-admin-icon name="view"/>
                                    </a>
                                    <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-neutral-400 hover:text-red-600" title="Hapus pesan" aria-label="Hapus pesan dari {{ $msg->sender_name }}">
                                            <x-admin-icon name="delete"/>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-xs font-mono text-neutral-400">
                                Tidak ada pesan dalam kotak masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-stone-200 dark:border-neutral-800">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
