<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@kiki.dev'],
            [
                'name' => 'Febrian Rezki Hemeto',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );
        $admin->update(['name' => 'Febrian Rezki Hemeto']);

        $settings = [
            'author_name' => 'Febrian Rezki Hemeto',
            'author_title' => 'Full Stack Web Developer',
            'headline' => 'Lulusan Teknik Informatika yang berfokus pada pengembangan web dan sistem informasi.',
            'bio_summary' => 'Lulusan S1 Teknik Informatika Universitas Sam Ratulangi dengan IPK 3,98. Berpengalaman mengembangkan aplikasi web melalui proyek akademik, freelance, dan magang di Direktorat Jenderal Pajak.',
            'about_narrative' => 'Saya Febrian Rezki Hemeto, lulusan S1 Teknik Informatika Universitas Sam Ratulangi dengan IPK 3,98. Saya memiliki minat dan kompetensi dalam Full Stack Web Development, pengembangan sistem informasi, dan teknologi informasi. Berpengalaman mengembangkan berbagai aplikasi berbasis web melalui proyek akademik, freelance, serta magang di Direktorat Jenderal Pajak Kementerian Keuangan Republik Indonesia.',
            'availability_status' => 'Full Stack Web Development | Pengembangan Sistem Informasi',
            'contact_email' => 'febrianhemeto04@gmail.com',
            'contact_phone' => '082290581860',
            'author_location' => 'Datahu, Kec. Tibawa, Kab. Gorontalo, Provinsi Gorontalo',
            'github_url' => null,
            'linkedin_url' => 'https://www.linkedin.com/in/febrian-rezki-hemeto-4a788a287/',
            'instagram_url' => null,
            'resume_pdf_url' => null,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        foreach (['Full-Stack', 'Backend / API', 'Open Source', 'Mobile App'] as $sortOrder => $categoryName) {
            ProjectCategory::updateOrCreate(
                ['name' => $categoryName],
                ['sort_order' => $sortOrder + 1]
            );
        }

        SkillCategory::whereIn('slug', [
            'backend-engineering',
            'database-storage',
            'frontend-presentation',
            'devops-tools',
        ])->delete();

        $categories = [
            [
                'name' => 'Technical Skills',
                'slug' => 'technical-skills',
                'sort_order' => 1,
                'skills' => [
                    'PHP',
                    'Laravel',
                    'JavaScript',
                    'HTML',
                    'CSS',
                    'Bootstrap',
                    'MySQL',
                    'Python',
                    'Git & GitHub',
                    'Full Stack Web Development',
                    'Android/Mobile Application Development',
                    'Desktop Application Development',
                    'Object-Oriented Programming (OOP)',
                    'Software Development Life Cycle (SDLC)',
                    'Database Design',
                    'Debugging & Troubleshooting',
                ],
            ],
            [
                'name' => 'Soft Skills',
                'slug' => 'soft-skills',
                'sort_order' => 2,
                'skills' => [
                    'Problem Solving',
                    'Analytical Thinking',
                    'Communication',
                    'Teamwork',
                    'Adaptability',
                    'Time Management',
                ],
            ],
            [
                'name' => 'Microsoft Office',
                'slug' => 'microsoft-office',
                'sort_order' => 3,
                'skills' => [
                    'Microsoft Word',
                    'Microsoft Excel',
                    'Microsoft PowerPoint',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = SkillCategory::updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'sort_order' => $categoryData['sort_order'],
                ]
            );

            foreach ($categoryData['skills'] as $sortOrder => $skillName) {
                Skill::updateOrCreate(
                    ['category_id' => $category->id, 'name' => $skillName],
                    [
                        'proficiency_level' => 'production',
                        'sort_order' => $sortOrder + 1,
                    ]
                );
            }
        }

        Project::whereIn('slug', [
            'logistikhub-inventory-management',
            'klinikcare-electronic-medical-records',
            'payment-gateway-microservice-orchestrator',
            'devdocs-markdown-cms',
        ])->delete();

        $projects = [
            [
                'title' => 'Sistem Administrasi Keuangan dan Perjalanan Dinas',
                'slug' => 'sistem-administrasi-keuangan-perjalanan-dinas',
                'tagline' => 'Aplikasi web untuk administrasi perjalanan dinas dan pengelolaan gaji.',
                'category' => 'Full-Stack',
                'problem_statement' => 'Dibutuhkan aplikasi berbasis web untuk mendukung administrasi perjalanan dinas serta pengelolaan data gaji.',
                'solution_description' => 'Mengembangkan aplikasi dengan autentikasi pengguna, dashboard, fitur CRUD, ekspor PDF dan Excel, serta manajemen data gaji dan perjalanan dinas.',
                'tech_stack' => ['PHP', 'MySQL', 'JavaScript', 'CSS'],
                'live_url' => null,
                'github_url' => null,
                'featured_image' => null,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Sistem Absensi Mahasiswa Magang',
                'slug' => 'sistem-absensi-mahasiswa-magang',
                'tagline' => 'Sistem absensi mahasiswa magang berbasis GPS dengan laporan dan pengelolaan data.',
                'category' => 'Full-Stack',
                'problem_statement' => 'Diperlukan sistem untuk mencatat kehadiran mahasiswa magang dan memudahkan pemantauan serta pelaporan absensi.',
                'solution_description' => 'Mengembangkan sistem absensi berbasis GPS dengan dashboard statistik, manajemen role, fitur import dan export data, serta laporan absensi.',
                'tech_stack' => ['PHP', 'MySQL', 'JavaScript', 'CSS'],
                'live_url' => null,
                'github_url' => null,
                'featured_image' => null,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Sistem Informasi Data Desa',
                'slug' => 'sistem-informasi-data-desa',
                'tagline' => 'Sistem informasi desa untuk mendukung pengelolaan data dan pengambilan keputusan.',
                'category' => 'Full-Stack',
                'problem_statement' => 'Pemerintah desa memerlukan sistem terintegrasi untuk mengelola data kependudukan, pendidikan, ekonomi, dan infrastruktur.',
                'solution_description' => 'Merancang dan mengembangkan sistem informasi data desa sebagai penelitian skripsi. Hasil penelitian diterbitkan pada Jurnal Nasional Terakreditasi SINTA 5.',
                'tech_stack' => ['PHP', 'MySQL', 'JavaScript', 'CSS'],
                'live_url' => null,
                'github_url' => null,
                'featured_image' => null,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Website Desa (Program KKN/KKT)',
                'slug' => 'website-desa-program-kkn-kkt',
                'tagline' => 'Website profil desa untuk publikasi informasi pemerintahan dan potensi desa.',
                'category' => 'Full-Stack',
                'problem_statement' => 'Dibutuhkan media daring untuk menyampaikan informasi pemerintahan desa, potensi wilayah, dan layanan kepada masyarakat.',
                'solution_description' => 'Mengembangkan website profil desa yang menyediakan berita, galeri, profil desa, perangkat desa, dan informasi layanan masyarakat.',
                'tech_stack' => ['PHP', 'MySQL', 'JavaScript', 'CSS'],
                'live_url' => null,
                'github_url' => null,
                'featured_image' => null,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                array_merge($project, ['user_id' => $admin->id])
            );
        }
    }
}
