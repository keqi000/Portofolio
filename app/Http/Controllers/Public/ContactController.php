<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\SendContactMessageRequest;
use App\Models\Message;
use App\Services\SiteSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $settings = SiteSettingService::all();
        return view('public.contact', compact('settings'));
    }

    public function submit(SendContactMessageRequest $request): RedirectResponse
    {
        // 1. Honeypot check: If the hidden honeypot field has a value, it's a bot
        if (!empty($request->input('website_hp'))) {
            // Silently redirect without saving to prevent spam
            return back()->with('success', 'Pesan Anda telah berhasil terkirim. Terima kasih!');
        }

        // 2. Rate limiting by IP address: max 3 messages per hour
        $ip = $request->ip() ?? 'unknown';
        $throttleKey = 'contact_form:' . $ip;

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);
            return back()
                ->withInput()
                ->with('error', "Terlalu banyak pengiriman pesan. Silakan coba kembali dalam {$minutes} menit.");
        }

        RateLimiter::hit($throttleKey, 3600); // 1 hour window

        // 3. Persist validated message into Database (Supabase / SQLite)
        Message::create([
            'sender_name' => $request->input('sender_name'),
            'sender_email' => $request->input('sender_email'),
            'subject' => $request->input('subject'),
            'message_body' => $request->input('message_body'),
            'ip_address' => $ip,
            'is_read' => false,
            'is_archived' => false,
        ]);

        return back()->with('success', 'Terima kasih! Pesan Anda telah tersimpan dan akan segera saya balas melalui email.');
    }
}

