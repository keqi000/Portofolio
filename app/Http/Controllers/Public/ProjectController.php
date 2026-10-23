<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\SiteSettingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $settings = SiteSettingService::all();
        $selectedCategory = $request->query('category', 'all');

        $query = Project::published()->orderBy('sort_order')->orderByDesc('id');

        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->where('category', $selectedCategory);
        }

        $projects = $query->paginate(9)->withQueryString();

        $categories = Project::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('public.projects.index', compact('settings', 'projects', 'categories', 'selectedCategory'));
    }

    public function show(string $slug): View
    {
        $settings = SiteSettingService::all();
        $project = Project::published()->where('slug', $slug)->firstOrFail();

        // Related projects
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->take(2)
            ->get();

        if ($relatedProjects->isEmpty()) {
            $relatedProjects = Project::published()
                ->where('id', '!=', $project->id)
                ->take(2)
                ->get();
        }

        return view('public.projects.show', compact('settings', 'project', 'relatedProjects'));
    }
}

