<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ResumeController extends Controller
{
    public function __invoke(): RedirectResponse|Response
    {
        $resumeUrl = Setting::get('resume_pdf_url');

        if ($resumeUrl) {
            return redirect()->away($resumeUrl);
        }

        return back()->with('info', 'File resume/CV sedang diperbarui. Silakan hubungi langsung melalui email.');
    }
}

