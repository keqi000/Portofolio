@extends('layouts.guest')

@section('title', 'Masuk ke CMS')

@section('content')
<div class="p-8 rounded-2xl border border-stone-200 dark:border-neutral-800 bg-white dark:bg-[#121316] shadow-sm">
    <div class="mb-8 text-center">
        <span class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-mono font-bold text-sm mx-auto mb-3">
            CMS
        </span>
        <h1 class="text-xl font-bold tracking-tight text-neutral-900 dark:text-stone-100">
            Portfolio Management Studio
        </h1>
        <p class="text-xs text-neutral-500 dark:text-neutral-400 font-mono mt-1">
            Masuk dengan kredensial administrator.
        </p>
    </div>

    <x-flash />

    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4" autocomplete="off">
        @csrf

        <div>
            <label for="email" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                Alamat Email
            </label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="off" required autofocus class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
        </div>

        <div>
            <label for="password" class="block text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">
                Kata Sandi
            </label>
            <input type="password" name="password" id="password" autocomplete="off" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-300 dark:border-neutral-700 bg-stone-50 dark:bg-neutral-900 text-neutral-900 dark:text-stone-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
        </div>

        <div class="flex items-center justify-between text-xs font-mono pt-1">
            <label class="flex items-center gap-2 cursor-pointer text-neutral-600 dark:text-neutral-400">
                <input type="checkbox" name="remember" class="rounded border-stone-300 text-blue-600 focus:ring-blue-500">
                <span>Ingat sesi saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-2.5 px-4 rounded-lg bg-neutral-900 text-stone-100 hover:bg-neutral-800 dark:bg-stone-100 dark:text-neutral-950 dark:hover:bg-stone-200 text-sm font-medium tracking-wide transition-all active:scale-[0.98]">
                Masuk ke Studio &rarr;
            </button>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-stone-100 dark:border-neutral-800 text-center">
        <a href="{{ route('home') }}" class="text-xs font-mono text-neutral-500 hover:text-neutral-800 dark:hover:text-stone-300 transition-colors">
            &larr; Kembali ke Website Publik
        </a>
    </div>
</div>
@endsection
