<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Services\MediaUploadService;
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

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
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
            $data['featured_image'] = $this->mediaService->upload($request->file('featured_image'), 'projects');
        }

        $data['user_id'] = auth()->id();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek baru berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
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
            // Delete old file if exists
            $this->mediaService->delete($project->featured_image);
            $data['featured_image'] = $this->mediaService->upload($request->file('featured_image'), 'projects');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? $project->sort_order;

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Data proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->featured_image) {
            $this->mediaService->delete($project->featured_image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek telah dihapus.');
    }

    public function togglePublish(Project $project): RedirectResponse
    {
        $project->update(['is_published' => !$project->is_published]);
        return back()->with('success', 'Status publikasi proyek berhasil diubah.');
    }
}

