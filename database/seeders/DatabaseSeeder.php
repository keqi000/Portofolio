<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@kiki.dev'],
            [
                'name' => 'Kiki Maulana',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        // 2. Site Settings
        $settings = [
            'author_name' => 'Kiki Maulana',
            'author_title' => 'Software Engineer & Full-Stack Developer',
            'headline' => 'Crafting High-Performance Web Applications Through Thoughtful Engineering.',
            'bio_summary' => 'Spesialis dalam ekosistem PHP/Laravel, arsitektur database relasional terstruktur, dan antarmuka web modern yang bersih serta ramah performa.',
            'about_narrative' => 'Halo! Saya Kiki Maulana — Software Engineer yang berfokus pada pengembangan sistem web end-to-end yang tangguh, mudah dirawat, dan berorientasi pada penyelesaian masalah nyata. Memiliki ketertarikan mendalam pada clean architecture, optimasi query database relasional, dan perancangan antarmuka pengguna yang terstruktur tanpa distraksi visual.',
            'availability_status' => 'Available for full-time & freelance projects',
            'contact_email' => 'kiki.maulana.dev@gmail.com',
            'github_url' => 'https://github.com/kikimaulana',
            'linkedin_url' => 'https://linkedin.com/in/kikimaulana',
            'resume_pdf_url' => null,
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 3. Skill Categories & Skills
        $categoriesData = [
            [
                'name' => 'Backend Engineering',
                'slug' => 'backend-engineering',
                'sort_order' => 1,
                'skills' => [
                    ['name' => 'PHP 8.2+', 'proficiency_level' => 'production', 'sort_order' => 1],
                    ['name' => 'Laravel (Routing, Eloquent, Queues, Testing)', 'proficiency_level' => 'production', 'sort_order' => 2],
                    ['name' => 'RESTful API Design & OpenAPI Spec', 'proficiency_level' => 'production', 'sort_order' => 3],
                    ['name' => 'Redis Caching & Pub/Sub', 'proficiency_level' => 'learning', 'sort_order' => 4],
                    ['name' => 'Test-Driven Development (Pest PHP)', 'proficiency_level' => 'learning', 'sort_order' => 5],
                ],
            ],
            [
                'name' => 'Database & Storage',
                'slug' => 'database-storage',
                'sort_order' => 2,
                'skills' => [
                    ['name' => 'PostgreSQL (Supabase / Self-hosted)', 'proficiency_level' => 'production', 'sort_order' => 1],
                    ['name' => 'MySQL / MariaDB', 'proficiency_level' => 'production', 'sort_order' => 2],
                    ['name' => 'Database Normalization & Indexing Optimization', 'proficiency_level' => 'production', 'sort_order' => 3],
                    ['name' => 'S3-Compatible Object Storage', 'proficiency_level' => 'production', 'sort_order' => 4],
                    ['name' => 'SQLite for Microservices / Local Dev', 'proficiency_level' => 'production', 'sort_order' => 5],
                ],
            ],
            [
                'name' => 'Frontend & Presentation',
                'slug' => 'frontend-presentation',
                'sort_order' => 3,
                'skills' => [
                    ['name' => 'Tailwind CSS (v3 / v4)', 'proficiency_level' => 'production', 'sort_order' => 1],
                    ['name' => 'Laravel Blade Components & View Architecture', 'proficiency_level' => 'production', 'sort_order' => 2],
                    ['name' => 'Alpine.js (Lightweight UI State)', 'proficiency_level' => 'production', 'sort_order' => 3],
                    ['name' => 'Semantic HTML5 & Accessible UI (WCAG AA)', 'proficiency_level' => 'production', 'sort_order' => 4],
                    ['name' => 'TypeScript / Modern JavaScript (ES6+)', 'proficiency_level' => 'learning', 'sort_order' => 5],
                ],
            ],
            [
                'name' => 'DevOps & Workflow Tools',
                'slug' => 'devops-tools',
                'sort_order' => 4,
                'skills' => [
                    ['name' => 'Git, GitHub Flow & Version Control', 'proficiency_level' => 'production', 'sort_order' => 1],
                    ['name' => 'Docker & Containerization Basics', 'proficiency_level' => 'production', 'sort_order' => 2],
                    ['name' => 'Vercel Serverless Platform Deployment', 'proficiency_level' => 'production', 'sort_order' => 3],
                    ['name' => 'CI/CD Pipelines (GitHub Actions)', 'proficiency_level' => 'learning', 'sort_order' => 4],
                    ['name' => 'Linux Server Administration (Ubuntu / Nginx)', 'proficiency_level' => 'production', 'sort_order' => 5],
                ],
            ],
        ];

        foreach ($categoriesData as $catData) {
            $cat = SkillCategory::create([
                'name' => $catData['name'],
                'slug' => $catData['slug'],
                'sort_order' => $catData['sort_order'],
            ]);

            foreach ($catData['skills'] as $skill) {
                Skill::create([
                    'category_id' => $cat->id,
                    'name' => $skill['name'],
                    'proficiency_level' => $skill['proficiency_level'],
                    'sort_order' => $skill['sort_order'],
                ]);
            }
        }

        // 4. Showcase Projects
        $projects = [
            [
                'title' => 'LogistikHub — Multi-Warehouse Inventory Management',
                'slug' => 'logistikhub-inventory-management',
                'tagline' => 'Sistem manajemen logistik dan pergudangan terdistribusi dengan audit stok real-time.',
                'category' => 'Full-Stack',
                'problem_statement' => 'Klien kesulitan memantau pergerakan stok antar 4 gudang cabang yang terpisah. Sistem sebelumnya menggunakan spreadsheet manual yang sering menyebabkan selisih inventaris hingga 15% setiap bulan dan proses rekonsiliasi yang memakan waktu berhari-hari.',
                'solution_description' => 'Membangun aplikasi web sentral berbasis Laravel dengan PostgreSQL. Menerapkan database transaction locks untuk mencegah race conditions saat pergerakan stok bersamaan, audit log otomatis untuk setiap mutasi barang, serta dashboard reporting visual yang mempercepat rekonsiliasi bulanan dari 3 hari menjadi 15 menit.',
                'tech_stack' => ['Laravel 11', 'PostgreSQL', 'Tailwind CSS', 'Alpine.js', 'Chart.js'],
                'live_url' => 'https://demo-logistikhub.example.com',
                'github_url' => 'https://github.com/kikimaulana/logistikhub',
                'featured_image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'KlinikCare — SaaS Janji Temu & Rekam Medis Elektronik',
                'slug' => 'klinikcare-electronic-medical-records',
                'tagline' => 'Platform rekam medis klinik mandiri dengan integrasi antrean pasien dan WhatsApp gateway.',
                'category' => 'Full-Stack',
                'problem_statement' => 'Klinik mandiri mengalami antrean menumpuk di ruang tunggu dan sering kehilangan rekam medis pasien berbasis kertas. Diperlukan sistem digital terjangkau yang mudah dioperasikan oleh staf administrasi non-teknis.',
                'solution_description' => 'Merancang sistem multi-peran (Dokter, Resepsionis, Pasien) dengan validasi ketat dan enkripsi data sensitif pasien. Dilengkapi pengingat jadwal otomatis via WhatsApp notification service serta pencarian riwayat medis pasien secara instan.',
                'tech_stack' => ['PHP 8.2', 'Laravel', 'MySQL', 'Tailwind CSS', 'WhatsApp Business API'],
                'live_url' => 'https://klinikcare.example.com',
                'github_url' => 'https://github.com/kikimaulana/klinikcare-emr',
                'featured_image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'PaymentGateway Core — RESTful Microservice Orchestrator',
                'slug' => 'payment-gateway-microservice-orchestrator',
                'tagline' => 'Engine orkestrasi transaksi pembayaran multi-vendor dengan webhook idempotent.',
                'category' => 'Backend / API',
                'problem_statement' => 'Aplikasi e-commerce klien sering menerima duplikasi pemrosesan callback pembayaran (double charge) ketika jaringan tidak stabil dari pihak payment aggregator pihak ketiga.',
                'solution_description' => 'Membangun backend service dengan arsitektur Event-Driven dan Idempotency Keys di level database. Setiap payload callback diverifikasi signature HMAC-nya, diproses secara asinkron melalui Laravel Queue Worker, dan memiliki automated retry mechanism yang tahan banting.',
                'tech_stack' => ['Laravel 11', 'Redis Queue', 'PostgreSQL', 'Docker', 'OpenAPI 3.0'],
                'live_url' => null,
                'github_url' => 'https://github.com/kikimaulana/payment-gateway-engine',
                'featured_image' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'DevDocs Markdown CMS — Lightweight Knowledge Base',
                'slug' => 'devdocs-markdown-cms',
                'tagline' => 'Knowledge base developer internal bertenaga Git dengan full-text search.',
                'category' => 'Open Source',
                'problem_statement' => 'Tim developer internal membutuhkan platform dokumentasi teknis yang cepat, bisa ditulis langsung dengan sintaks Markdown, tanpa overhead database yang rumit.',
                'solution_description' => 'Membuat flat-file CMS berbasis parser CommonMark dengan caching otomatis di level filesystem. Dilengkapi fitur client-side search instan dan dark-mode syntax highlighting bawaan.',
                'tech_stack' => ['Laravel', 'Tailwind CSS', 'Alpine.js', 'Prism.js'],
                'live_url' => 'https://devdocs-demo.example.com',
                'github_url' => 'https://github.com/kikimaulana/devdocs-cms',
                'featured_image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $proj) {
            Project::create(array_merge($proj, ['user_id' => $admin->id]));
        }
    }
}
