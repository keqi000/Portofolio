<?php

namespace App\Services;

use App\Models\Setting;

class SiteSettingService
{
    public static function all(): array
    {
        return [
            'author_name' => Setting::get('author_name', 'Febrian Rezki Hemeto'),
            'author_title' => Setting::get('author_title', 'Full Stack Web Developer'),
            'headline' => Setting::get('headline', 'Lulusan Teknik Informatika yang berfokus pada pengembangan web dan sistem informasi.'),
            'bio_summary' => Setting::get('bio_summary', 'Lulusan S1 Teknik Informatika Universitas Sam Ratulangi dengan IPK 3,98. Berpengalaman mengembangkan aplikasi web melalui proyek akademik, freelance, dan magang di Direktorat Jenderal Pajak.'),
            'about_narrative' => Setting::get('about_narrative', 'Saya Febrian Rezki Hemeto, lulusan S1 Teknik Informatika Universitas Sam Ratulangi dengan IPK 3,98. Saya memiliki minat dan kompetensi dalam Full Stack Web Development, pengembangan sistem informasi, dan teknologi informasi.'),
            'availability_status' => Setting::get('availability_status', 'Full Stack Web Development | Pengembangan Sistem Informasi'),
            'contact_email' => Setting::get('contact_email', 'febrianhemeto04@gmail.com'),
            'contact_phone' => Setting::get('contact_phone', '082290581860'),
            'author_location' => Setting::get('author_location', 'Datahu, Kec. Tibawa, Kab. Gorontalo, Provinsi Gorontalo'),
            'github_url' => Setting::get('github_url'),
            'linkedin_url' => Setting::get('linkedin_url') ?: 'https://www.linkedin.com/in/febrian-rezki-hemeto-4a788a287/',
            'instagram_url' => Setting::get('instagram_url'),
            'resume_pdf_url' => app(MediaUploadService::class)->publicUrl(Setting::get('resume_pdf_url')),
            'profile_image_url' => app(MediaUploadService::class)->publicUrl(Setting::get('profile_image_url')),
        ];
    }
}
