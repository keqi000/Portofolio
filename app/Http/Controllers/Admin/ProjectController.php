<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Services\MediaUploadService;
use App\Services\SortOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(
        protected MediaUploadService $mediaService
    ) {}

    public function index(): View
    {
        $projects = Project::orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(10);
        $categories = ProjectCategory::withCount('projects')->orderBy('sort_order')->get();

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create(): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();
        $projectCount = Project::count();

        return view('admin.projects.create', compact('categories', 'projectCount'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Generate slug if empty
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            // Ensure unique
            $count = Project::where('slug', 'like', $data['slug'] . '%')->count();
            if ($count > 0) {
                $data['slug'] .= '-' . ($count + 1);
            }
        }

        // Process tech stack (comma-separated string to array)
        if (is_string($data['tech_stack'])) {
            $data['tech_stack'] = array_values(array_filter(array_map('trim', explode(',', $data['tech_stack']))));
        }

        // Handle Image Upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->mediaService->upload($request->file('featured_image'), 'projects', 'project-cover');
        }

        $galleryImages = $data['gallery_images'] ?? [];
        unset($data['gallery_images']);

        $data['user_id'] = auth()->id();
        $data['is_featured'] = true;
        $data['is_published'] = true;
        $position = $data['sort_order'] ?? (Project::count() + 1);
        $data['sort_order'] = Project::count() + 1;

        $project = Project::create($data);
        app(SortOrderService::class)->move(
            Project::query()->orderBy('sort_order')->orderBy('id'),
            $project,
            $position
        );

        foreach ($galleryImages as $sortOrder => $image) {
            $project->images()->create([
                'image_path' => $this->mediaService->upload($image, 'projects', 'project-screenshot'),
                'sort_order' => $sortOrder,
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek baru berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();
        $projectCount = Project::count();
        $project->load('images');

        return view('admin.projects.edit', compact('project', 'categories', 'projectCount'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            $count = Project::where('slug', 'like', $data['slug'] . '%')->where('id', '!=', $project->id)->count();
            if ($count > 0) {
                $data['slug'] .= '-' . ($count + 1);
            }
        }

        if (is_string($data['tech_stack'])) {
            $data['tech_stack'] = array_values(array_filter(array_map('trim', explode(',', $data['tech_stack']))));
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->mediaService->replace(
                $project->featured_image,
                $request->file('featured_image'),
                'projects',
                'project-cover'
            );
        }

        foreach ($data['remove_project_images'] ?? [] as $imageId) {
            $image = $project->images()->findOrFail($imageId);
            $this->mediaService->delete($image->image_path);
            $image->delete();
        }

        $galleryImages = $data['gallery_images'] ?? [];
        unset($data['gallery_images'], $data['remove_project_images']);

        $data['is_featured'] = true;
        $data['is_published'] = true;
        $position = $data['sort_order'] ?? $project->sort_order;
        unset($data['sort_order']);

        $project->update($data);
        app(SortOrderService::class)->move(
            Project::query()->orderBy('sort_order')->orderBy('id'),
            $project,
            $position
        );

        $nextSortOrder = (int) $project->images()->max('sort_order') + 1;
        foreach ($galleryImages as $image) {
            $project->images()->create([
                'image_path' => $this->mediaService->upload($image, 'projects', 'project-screenshot'),
                'sort_order' => $nextSortOrder++,
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Data proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->featured_image) {
            $this->mediaService->delete($project->featured_image);
        }

        foreach ($project->images as $image) {
            $this->mediaService->delete($image->image_path);
        }

        $project->delete();
        app(SortOrderService::class)->normalize(Project::query()->orderBy('sort_order')->orderBy('id'));

        return redirect()->route('admin.projects.index')->with('success', 'Proyek telah dihapus.');
    }

    public function updateOrder(Request $request, Project $project, SortOrderService $sortOrderService): RedirectResponse
    {
        $data = $request->validate([
            'sort_order' => ['required', 'integer', 'min:1', 'max:' . Project::count()],
        ]);

        $sortOrderService->move(
            Project::query()->orderBy('sort_order')->orderBy('id'),
            $project,
            (int) $data['sort_order']
        );

        return back()->with('success', 'Urutan proyek Home berhasil diperbarui.');
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:project_categories,name'],
            'sort_order' => ['nullable', 'integer', 'min:1', 'max:' . (ProjectCategory::count() + 1)],
        ]);

        $position = $data['sort_order'] ?? (ProjectCategory::count() + 1);
        $category = ProjectCategory::create([
            'name' => $data['name'],
            'sort_order' => ProjectCategory::count() + 1,
        ]);
        app(SortOrderService::class)->move(
            ProjectCategory::query()->orderBy('sort_order')->orderBy('id'),
            $category,
            $position
        );

        return back()->with('success', 'Kategori proyek berhasil ditambahkan.');
    }

    public function updateCategoryOrder(Request $request, ProjectCategory $category, SortOrderService $sortOrderService): RedirectResponse
    {
        $data = $request->validate([
            'sort_order' => ['required', 'integer', 'min:1', 'max:' . ProjectCategory::count()],
        ]);

        $sortOrderService->move(
            ProjectCategory::query()->orderBy('sort_order')->orderBy('id'),
            $category,
            (int) $data['sort_order']
        );

        return back()->with('success', 'Urutan kategori proyek berhasil diperbarui.');
    }

    public function destroyCategory(ProjectCategory $category): RedirectResponse
    {
        if (Project::where('category', $category->name)->exists()) {
            return back()->with('error', 'Kategori masih digunakan oleh proyek dan tidak dapat dihapus.');
        }

        $category->delete();
        app(SortOrderService::class)->normalize(ProjectCategory::query()->orderBy('sort_order')->orderBy('id'));

        return back()->with('success', 'Kategori proyek berhasil dihapus.');
    }
}
