<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Services\SiteSettingService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $settings = SiteSettingService::all();
        $featuredProjects = Project::published()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $coreSkills = Skill::production()
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('public.home', compact('settings', 'featuredProjects', 'coreSkills'));
    }
}
