<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\SiteSettingService;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $settings = SiteSettingService::all();

        $experiences = [
            [
                'period' => '2024 — Sekarang',
                'role' => 'Full-Stack Software Engineer',
                'company' => 'Freelance & Independent Client Projects',
                'description' => 'Merancang dan mengimplementasikan aplikasi web berbasis Laravel dan PostgreSQL untuk berbagai kebutuhan bisnis (SaaS, sistem pergudangan, dan platform rekam medis). Memastikan skalabilitas query database dan waktu respons API di bawah 200ms.',
            ],
            [
                'period' => '2023 — 2024',
                'role' => 'Backend Developer Intern',
                'company' => 'Tech Solutions Enterprise',
                'description' => 'Membangun integrasi RESTful API, webhook aggregator, dan automated database backup systems. Berkolaborasi menggunakan Git Flow dan menerapkan standar PSR-12 serta PHPStan level 5.',
            ],
            [
                'period' => '2022 — 2023',
                'role' => 'Junior Web Developer',
                'company' => 'Digital Agency Project',
                'description' => 'Mengembangkan antarmuka responsif ramah pengguna menggunakan Blade dan Tailwind CSS. Mengoptimasi skor Google Lighthouse hingga mencapai rata-rata 95+ untuk metrik Accessibility dan Performance.',
            ],
        ];

        return view('public.about', compact('settings', 'experiences'));
    }
}

