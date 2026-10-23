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
                'period' => 'Juni 2025 — Agustus 2025',
                'role' => 'IT Staff Intern',
                'company' => 'Kementerian Keuangan — Direktorat Jenderal Pajak, Suluttenggomalut',
                'description' => 'Melakukan digitalisasi dokumen administrasi perpajakan dan data keuangan pegawai. Mengembangkan aplikasi administrasi perjalanan dinas dan absensi mahasiswa magang, merancang database MySQL, menguji dan memperbaiki aplikasi, melakukan deployment, serta menyusun dokumentasi teknis.',
            ],
        ];

        $education = [
            'institution' => 'Universitas Sam Ratulangi',
            'location' => 'Manado, Sulawesi Utara',
            'period' => '2022 — 2026',
            'program' => 'S1 Teknik Informatika',
            'achievement' => 'IPK 3,98',
        ];

        $certifications = [
            [
                'name' => 'TOEFL',
                'period' => 'Maret 2026 — Maret 2028',
                'issuer' => 'Universitas Sam Ratulangi — UPA Bahasa',
            ],
        ];

        $training = [
            ['name' => 'Junior Web Developer', 'period' => 'September 2025 — Oktober 2025', 'issuer' => 'BPSDMP Manado'],
            ['name' => 'Linear Models in Machine Learning', 'period' => 'Mei 2025', 'issuer' => 'Pusat Pengembangan Talenta Digital'],
            ['name' => 'Python Essentials 2', 'period' => 'Maret 2025', 'issuer' => 'Cisco Networking Academy & OpenEDG'],
            ['name' => 'Python Essentials 1', 'period' => 'Maret 2025', 'issuer' => 'Cisco Networking Academy & OpenEDG Python Institute'],
            ['name' => 'Web Development', 'period' => 'Agustus 2023', 'issuer' => 'SoloLearn'],
        ];

        $achievements = [
            'Artikel ilmiah tentang perancangan sistem informasi data desa diterbitkan pada Jurnal Nasional Terakreditasi SINTA 5 (2026).',
            'Lulus S1 Teknik Informatika dengan IPK 3,98.',
            'Juara 1 kelas dan Juara Umum secara konsisten sejak jenjang SD hingga SMA.',
        ];

        return view('public.about', compact(
            'settings',
            'experiences',
            'education',
            'certifications',
            'training',
            'achievements'
        ));
    }
}
