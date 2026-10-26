<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\SkillCategory;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Debug\ExceptionHandler;
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
        $response->assertSee('Febrian Rezki Hemeto');
        $response->assertSee('aria-label="Instagram: kikihemeto"', false);
        $response->assertSee('aria-label="LinkedIn: febrian-rezki-hemeto-4a788a287"', false);
        $response->assertSee('href="https://www.linkedin.com/in/febrian-rezki-hemeto-4a788a287/"', false);
        $response->assertSee('febrian-rezki-hemeto-4a788a287');
        $response->assertSee('kikihemeto');
        $response->assertSee('febrianhemeto04@gmail.com');
        $response->assertSee('aria-label="Email: febrianhemeto04@gmail.com"', false);
        $response->assertSee('Proyek');
        $response->assertDontSee('Studi Kasus');
        $response->assertDontSee('Geser ke proyek berikutnya');
        $response->assertDontSee('Geser ke proyek sebelumnya');
        $this->assertSame(4, substr_count($response->getContent(), 'snap-start'));
        $response->assertSeeInOrder([
            'Sistem Administrasi Keuangan dan Perjalanan Dinas',
            'Sistem Absensi Mahasiswa Magang',
            'Sistem Informasi Data Desa',
            'Website Desa (Program KKN/KKT)',
        ]);
    }

    public function test_home_page_uses_https_asset_urls_behind_a_proxy(): void
    {
        $response = $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
        ])->get('/');

        $response->assertOk();
        $response->assertSee('href="https://localhost/build/assets/', false);
        $response->assertSee('src="https://localhost/build/assets/', false);
    }

    public function test_projects_page_loads_with_filters(): void
    {
        $response = $this->get('/projects');
        $response->assertStatus(200);
        $response->assertSee('Proyek');
        $response->assertDontSee('Studi Kasus');
        $response->assertSee('Semua Kategori');
    }

    public function test_project_detail_page_loads_with_case_study(): void
    {
        $project = Project::published()->first();
        $response = $this->get('/projects/' . $project->slug);
        $response->assertStatus(200);
        $response->assertSee($project->title);
        $response->assertSee('Masalah');
        $response->assertSee('Kembali ke Home');
    }

    public function test_about_page_loads_with_narrative(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Tentang Saya');
        $response->assertSee('Linimasa Pengalaman');
        $response->assertSee('Universitas Sam Ratulangi');
        $response->assertSee('SINTA 5');
    }

    public function test_skills_page_loads_with_matrices(): void
    {
        $response = $this->get('/skills');
        $response->assertStatus(200);
        $response->assertSee('Keahlian &amp; Perangkat', false);
        $response->assertSee('Production');
        $response->assertSee('Microsoft Excel');
    }

    public function test_login_form_does_not_prefill_credentials(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
        $response->assertDontSee('value="admin@kiki.dev"', false);
        $response->assertDontSee('value="password123"', false);
    }

    public function test_contact_page_loads_and_form_submits_message(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Mari Terhubung');
        $response->assertSee('Pesan Anda langsung masuk ke inbox dashboard admin.');
        $response->assertDontSee('database Supabase');
        $response->assertSee('WhatsApp');
        $response->assertSee('https://wa.me/6282290581860');
        $response->assertSee('082290581860');

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

    public function test_admin_projects_page_links_back_to_dashboard_and_create_has_cancel_action(): void
    {
        $admin = User::where('email', 'admin@kiki.dev')->first();

        $this->actingAs($admin)
            ->get(route('admin.projects.index'))
            ->assertOk()
            ->assertSee('Kembali ke Dashboard')
            ->assertSee('4 proyek')
            ->assertSee('Posisi Home');

        $this->actingAs($admin)
            ->get(route('admin.projects.create'))
            ->assertOk()
            ->assertDontSee('Kembali ke Proyek')
            ->assertSee('Batal')
            ->assertSee('Posisi di Home')
            ->assertDontSee('Publikasikan (Published)')
            ->assertDontSee('Tampilkan di Halaman Utama (Featured)');

        $this->actingAs($admin)
            ->get(route('admin.projects.edit', Project::firstOrFail()))
            ->assertOk()
            ->assertDontSee('Kembali ke Proyek');
    }

    public function test_moving_a_project_to_a_new_position_shifts_the_other_projects(): void
    {
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();
        $projects = Project::orderBy('sort_order')->orderBy('id')->get();
        $movingProject = $projects->last();
        $expectedIds = array_merge(
            [$movingProject->id],
            $projects->slice(0, -1)->pluck('id')->all()
        );

        $this->actingAs($admin)
            ->patch(route('admin.projects.order', $movingProject), ['sort_order' => 1])
            ->assertRedirect();

        $reordered = Project::orderBy('sort_order')->orderBy('id')->get();
        $this->assertSame($expectedIds, $reordered->pluck('id')->all());
        $this->assertSame([1, 2, 3, 4], $reordered->pluck('sort_order')->all());
        $this->get('/')->assertSeeInOrder($reordered->pluck('title')->all());
    }

    public function test_project_and_skill_category_positions_shift_when_moved(): void
    {
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();
        $projectCategories = ProjectCategory::orderBy('sort_order')->orderBy('id')->get();
        $projectCategoryToMove = $projectCategories->last();

        $this->actingAs($admin)
            ->patch(route('admin.projects.categories.order', $projectCategoryToMove), ['sort_order' => 1])
            ->assertRedirect();

        $reorderedProjectCategories = ProjectCategory::orderBy('sort_order')->orderBy('id')->get();
        $this->assertSame($projectCategoryToMove->id, $reorderedProjectCategories->first()->id);
        $this->assertSame(
            range(1, $reorderedProjectCategories->count()),
            $reorderedProjectCategories->pluck('sort_order')->all()
        );
        $usedProjectCategories = Project::published()->pluck('category')->unique()->all();
        $this->get('/projects')->assertSeeInOrder(
            $reorderedProjectCategories->whereIn('name', $usedProjectCategories)->pluck('name')->all()
        );

        $skillCategories = SkillCategory::orderBy('sort_order')->orderBy('id')->get();
        $skillCategoryToMove = $skillCategories->last();

        $this->actingAs($admin)
            ->patch(route('admin.skills.category.order', $skillCategoryToMove), ['sort_order' => 1])
            ->assertRedirect();

        $reorderedSkillCategories = SkillCategory::orderBy('sort_order')->orderBy('id')->get();
        $this->assertSame($skillCategoryToMove->id, $reorderedSkillCategories->first()->id);
        $this->assertSame(
            range(1, $reorderedSkillCategories->count()),
            $reorderedSkillCategories->pluck('sort_order')->all()
        );
        $this->get('/skills')->assertSeeInOrder($reorderedSkillCategories->pluck('name')->all());
    }

    public function test_admin_can_add_project_categories_and_upload_gallery_images(): void
    {
        Storage::fake('public');
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.projects.categories.store'), [
                'name' => 'Web Application',
                'sort_order' => ProjectCategory::count() + 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('project_categories', ['name' => 'Web Application']);

        $this->actingAs($admin)
            ->post(route('admin.projects.store'), [
                'title' => 'Gallery Test Project',
                'slug' => 'gallery-test-project',
                'tagline' => 'A project with multiple screenshots.',
                'category' => 'Web Application',
                'problem_statement' => 'Test problem statement.',
                'solution_description' => 'Test solution description.',
                'tech_stack' => 'PHP, Laravel',
                'sort_order' => Project::count() + 1,
                'gallery_images' => [
                    $this->fakePng('screen-one.png'),
                    $this->fakePng('screen-two.png'),
                ],
            ])
            ->assertRedirect(route('admin.projects.index'));

        $project = Project::where('slug', 'gallery-test-project')->firstOrFail();
        $this->assertCount(2, $project->images);
        $this->assertStringContainsString('project-screenshot-1.png', $project->images->first()->image_path);
        $this->assertStringContainsString('project-screenshot-2.png', $project->images->last()->image_path);
        $this->assertTrue($project->is_featured);
        $this->assertTrue($project->is_published);

        $this->get(route('projects.show', $project->slug))
            ->assertOk()
            ->assertSee('Carousel screenshot proyek')
            ->assertDontSee('Foto berikutnya')
            ->assertDontSee('Tampilkan foto');

        $this->actingAs($admin)
            ->delete(route('admin.projects.categories.destroy', ProjectCategory::where('name', 'Web Application')->firstOrFail()))
            ->assertSessionHas('error');
    }

    public function test_admin_can_remove_project_gallery_images(): void
    {
        Storage::fake('public');
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();
        $project = Project::firstOrFail();
        $image = $project->images()->create([
            'image_path' => app(\App\Services\MediaUploadService::class)->upload($this->fakePng('gallery.png'), 'projects'),
            'sort_order' => 1,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.projects.update', $project), [
                'title' => $project->title,
                'slug' => $project->slug,
                'tagline' => $project->tagline,
                'category' => $project->category,
                'problem_statement' => $project->problem_statement,
                'solution_description' => $project->solution_description,
                'tech_stack' => implode(', ', $project->tech_stack),
                'sort_order' => $project->sort_order,
                'remove_project_images' => [$image->id],
            ])
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseMissing('project_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($this->storagePath($image->image_path));
    }

    public function test_admin_can_upload_profile_photo_shown_on_home_and_about(): void
    {
        Storage::fake('public');
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.settings.update'), [
                'author_name' => 'Febrian Rezki Hemeto',
                'author_title' => 'Full Stack Web Developer',
                'headline' => 'Web developer profile headline',
                'bio_summary' => 'A short profile summary.',
                'about_narrative' => 'A detailed profile narrative.',
                'availability_status' => 'Open to opportunities',
                'contact_email' => 'febrianhemeto04@gmail.com',
                'contact_phone' => '0822-9058-1860',
                'author_location' => 'Gorontalo',
                'instagram_url' => 'https://instagram.com/example-profile',
                'profile_image' => $this->fakePng('profile.png'),
            ])
            ->assertRedirect();

        $profileImageUrl = Setting::get('profile_image_url');
        $this->assertNotEmpty($profileImageUrl);
        $this->assertStringStartsWith('/storage/profile/', $profileImageUrl);
        $this->assertStringContainsString('profile-photo-1.png', $profileImageUrl);
        $oldProfilePath = $this->storagePath($profileImageUrl);
        $this->get('/')->assertOk()->assertSee($profileImageUrl);
        $this->get('/about')->assertOk()->assertSee($profileImageUrl);

        $this->actingAs($admin)
            ->post(route('admin.settings.update'), [
                'author_name' => 'Febrian Rezki Hemeto',
                'author_title' => 'Full Stack Web Developer',
                'headline' => 'Web developer profile headline',
                'bio_summary' => 'A short profile summary.',
                'about_narrative' => 'A detailed profile narrative.',
                'availability_status' => 'Open to opportunities',
                'contact_email' => 'febrianhemeto04@gmail.com',
                'contact_phone' => '0822-9058-1860',
                'author_location' => 'Gorontalo',
                'instagram_url' => 'https://instagram.com/example-profile',
                'profile_image' => $this->fakePng('profile-new.png'),
            ])
            ->assertRedirect();

        $newProfileUrl = Setting::get('profile_image_url');
        $this->assertNotSame($profileImageUrl, $newProfileUrl);
        Storage::disk('public')->assertMissing($oldProfilePath);
        Storage::disk('public')->assertExists($this->storagePath($newProfileUrl));
    }

    public function test_uploading_new_resume_replaces_old_pdf(): void
    {
        Storage::fake('public');
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();

        $payload = [
            'author_name' => 'Febrian Rezki Hemeto',
            'author_title' => 'Full Stack Web Developer',
            'headline' => 'Web developer profile headline',
            'bio_summary' => 'A short profile summary.',
            'about_narrative' => 'A detailed profile narrative.',
            'availability_status' => 'Open to opportunities',
            'contact_email' => 'febrianhemeto04@gmail.com',
            'contact_phone' => '0822-9058-1860',
            'author_location' => 'Gorontalo',
        ];

        $this->actingAs($admin)
            ->post(route('admin.settings.update'), $payload + [
                'resume_pdf' => UploadedFile::fake()->create('old-resume.pdf', 10, 'application/pdf'),
            ])
            ->assertRedirect();

        $oldResumeUrl = Setting::get('resume_pdf_url');
        $this->assertStringContainsString('resume-1.pdf', $oldResumeUrl);
        $oldResumePath = $this->storagePath($oldResumeUrl);
        Storage::disk('public')->assertExists($oldResumePath);

        $this->post(route('admin.settings.update'), $payload + [
            'resume_pdf' => UploadedFile::fake()->create('new-resume.pdf', 10, 'application/pdf'),
        ])->assertRedirect();

        $newResumeUrl = Setting::get('resume_pdf_url');
        $this->assertNotSame($oldResumeUrl, $newResumeUrl);
        $this->assertStringContainsString('resume-2.pdf', $newResumeUrl);
        Storage::disk('public')->assertMissing($oldResumePath);
        Storage::disk('public')->assertExists($this->storagePath($newResumeUrl));
    }

    public function test_replacing_project_cover_and_deleting_project_removes_old_media(): void
    {
        Storage::fake('public');
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();
        $project = Project::firstOrFail();

        $oldCover = app(\App\Services\MediaUploadService::class)->upload($this->fakePng('old-cover.png'), 'projects');
        $project->update(['featured_image' => $oldCover]);
        $oldCoverPath = $this->storagePath($oldCover);

        $this->actingAs($admin)
            ->put(route('admin.projects.update', $project), [
                'title' => $project->title,
                'slug' => $project->slug,
                'tagline' => $project->tagline,
                'category' => $project->category,
                'problem_statement' => $project->problem_statement,
                'solution_description' => $project->solution_description,
                'tech_stack' => implode(', ', $project->tech_stack),
                'sort_order' => $project->sort_order,
                'featured_image' => $this->fakePng('new-cover.png'),
            ])
            ->assertRedirect(route('admin.projects.index'));

        $project->refresh();
        $this->assertStringContainsString('project-cover-1.png', $project->featured_image);
        Storage::disk('public')->assertMissing($oldCoverPath);
        Storage::disk('public')->assertExists($this->storagePath($project->featured_image));

        $galleryImage = $project->images()->create([
            'image_path' => app(\App\Services\MediaUploadService::class)->upload($this->fakePng('project-gallery.png'), 'projects'),
            'sort_order' => 1,
        ]);
        $coverPath = $this->storagePath($project->featured_image);
        $galleryPath = $this->storagePath($galleryImage->image_path);

        $this->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.projects.index'));

        Storage::disk('public')->assertMissing($coverPath);
        Storage::disk('public')->assertMissing($galleryPath);
    }

    public function test_admin_csrf_expiration_redirects_to_login_with_message(): void
    {
        $request = Request::create('/admin/logout', 'POST');
        $response = app(ExceptionHandler::class)->render($request, new TokenMismatchException());

        $this->assertSame(route('admin.login'), $response->headers->get('Location'));
        $this->assertSame('Sesi admin telah berakhir. Silakan masuk kembali.', $response->getSession()->get('error'));
    }

    public function test_admin_sidebar_stays_sticky_during_page_scroll(): void
    {
        $admin = User::where('email', 'admin@kiki.dev')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('md:sticky md:top-0 md:h-screen', false);
    }

    public function test_instagram_is_configurable_and_shown_in_public_social_links(): void
    {
        Setting::set('instagram_url', 'https://instagram.com/example-profile');

        $this->actingAs(User::where('email', 'admin@kiki.dev')->firstOrFail())
            ->get(route('admin.projects.index'))
            ->assertOk()
            ->assertSee('Kembali ke Dashboard');

        $this->get('/')
            ->assertOk()
            ->assertSee('Instagram')
            ->assertSee('href="https://instagram.com/example-profile"', false)
            ->assertSee('href="mailto:febrianhemeto04@gmail.com"', false);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('LinkedIn')
            ->assertSee('href="https://www.linkedin.com/in/febrian-rezki-hemeto-4a788a287/"', false)
            ->assertSee('febrian-rezki-hemeto-4a788a287')
            ->assertDontSee('Saluran Profesional')
            ->assertDontSee('>Instagram</span>', false)
            ->assertDontSee('GitHub Repositories');
    }

    private function fakePng(string $filename): UploadedFile
    {
        $contents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');

        return UploadedFile::fake()->createWithContent($filename, $contents);
    }

    private function storagePath(?string $url): string
    {
        return substr((string) parse_url((string) $url, PHP_URL_PATH), strlen('/storage/'));
    }
}
