<?php

namespace App\Services;

use App\Models\Setting;

class SiteSettingService
{
    public static function all(): array
    {
        return [
            'author_name' => Setting::get('author_name', 'Rifki "Kiki" Maulana'),
            'author_title' => Setting::get('author_title', 'Software Engineer & Full-Stack Developer'),
            'headline' => Setting::get('headline', 'Crafting High-Performance Web Applications Through Thoughtful Engineering.'),
            'bio_summary' => Setting::get('bio_summary', 'Spesialis dalam ekosistem PHP/Laravel, arsitektur database relasional terstruktur, dan antarmuka web modern yang bersih serta ramah performa.'),
            'about_narrative' => Setting::get('about_narrative', 'Halo, saya Kiki — seorang pengembang perangkat lunak yang berfokus pada pembangunan solusi web yang tangguh, mudah dirawat, dan berorientasi pada nilai bisnis. Berpengalaman merancang sistem backend skalabel dengan Laravel dan menghadirkan antarmuka pengguna yang intuitif dengan Tailwind CSS.'),
            'availability_status' => Setting::get('availability_status', 'Available for full-time & freelance projects'),
            'contact_email' => Setting::get('contact_email', 'kikimaulana@example.com'),
            'github_url' => Setting::get('github_url', 'https://github.com/'),
            'linkedin_url' => Setting::get('linkedin_url', 'https://linkedin.com/in/'),
            'resume_pdf_url' => Setting::get('resume_pdf_url', null),
        ];
    }
}

