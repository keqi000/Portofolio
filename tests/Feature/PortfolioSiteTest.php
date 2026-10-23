<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Kiki Maulana');
        $response->assertSee('Proyek Pilihan');
    }

    public function test_projects_page_loads_with_filters(): void
    {
        $response = $this->get('/projects');
        $response->assertStatus(200);
        $response->assertSee('Proyek &amp; Studi Kasus', false);
        $response->assertSee('Semua Kategori');
    }

    public function test_project_detail_page_loads_with_case_study(): void
    {
        $project = Project::published()->first();
        $response = $this->get('/projects/' . $project->slug);
        $response->assertStatus(200);
        $response->assertSee($project->title);
        $response->assertSee('Masalah');
    }

    public function test_about_page_loads_with_narrative(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Tentang Saya');
        $response->assertSee('Linimasa Pengalaman');
    }

    public function test_skills_page_loads_with_matrices(): void
    {
        $response = $this->get('/skills');
        $response->assertStatus(200);
        $response->assertSee('Keahlian &amp; Perangkat', false);
        $response->assertSee('Production');
    }

    public function test_contact_page_loads_and_form_submits_message(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Mari Terhubung');

        // Submit form
        $postResponse = $this->post('/contact', [
            'sender_name' => 'Recruiter Test',
            'sender_email' => 'recruiter@example.com',
            'subject' => 'Tawaran Pekerjaan Full-Time / Kontrak',
            'message_body' => 'Halo Kiki, kami tertarik dengan portofolio Anda dan ingin menjadwalkan interview.',
            'website_hp' => '', // Empty honeypot
        ]);

        $postResponse->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'sender_email' => 'recruiter@example.com',
        ]);
    }

    public function test_admin_login_and_protected_dashboard(): void
    {
        // Guest cannot access admin dashboard directly
        $guestResponse = $this->get('/admin');
        $guestResponse->assertRedirect('/admin/login');

        // Login as admin
        $admin = User::where('email', 'admin@kiki.dev')->first();
        $loginResponse = $this->actingAs($admin)->get('/admin');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('Ringkasan &amp; Metrik Sistem', false);
    }
}
