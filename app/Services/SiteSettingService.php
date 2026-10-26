<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SiteSettingService
{
    public static function all(): array
    {
        $settings = array_merge([
            'author_name' => 'Febrian Rezki Hemeto',
            'author_title' => 'Full Stack Web Developer',
            'headline' => 'Lulusan Teknik Informatika yang berfokus pada pengembangan web dan sistem informasi.',
            'bio_summary' => 'Lulusan S1 Teknik Informatika Universitas Sam Ratulangi dengan IPK 3,98. Berpengalaman mengembangkan aplikasi web melalui proyek akademik, freelance, dan magang di Direktorat Jenderal Pajak.',
            'about_narrative' => 'Saya Febrian Rezki Hemeto, lulusan S1 Teknik Informatika Universitas Sam Ratulangi dengan IPK 3,98. Saya memiliki minat dan kompetensi dalam Full Stack Web Development, pengembangan sistem informasi, dan teknologi informasi.',
            'availability_status' => 'Full Stack Web Development | Pengembangan Sistem Informasi',
            'contact_email' => 'febrianhemeto04@gmail.com',
            'contact_phone' => '082290581860',
            'author_location' => 'Datahu, Kec. Tibawa, Kab. Gorontalo, Provinsi Gorontalo',
            'github_url' => null,
            'linkedin_url' => null,
            'instagram_url' => null,
            'resume_pdf_url' => null,
            'profile_image_url' => null,
        ], Cache::rememberForever('site_settings', fn (): array => Setting::query()->pluck('value', 'key')->all()));

        return [
            ...$settings,
            'linkedin_url' => $settings['linkedin_url'] ?: 'https://www.linkedin.com/in/febrian-rezki-hemeto-4a788a287/',
            'resume_pdf_url' => app(MediaUploadService::class)->publicUrl($settings['resume_pdf_url']),
            'profile_image_url' => app(MediaUploadService::class)->publicUrl($settings['profile_image_url']),
        ];
    }
}
