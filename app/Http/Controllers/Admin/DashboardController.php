<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $unreadMessagesCount = Message::where('is_read', false)->where('is_archived', false)->count();
        $totalProjectsCount = Project::count();
        $publishedProjectsCount = Project::where('is_published', true)->count();
        $totalSkillsCount = Skill::count();

        $recentMessages = Message::orderByDesc('created_at')->take(5)->get();
        $recentProjects = Project::orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard.index', compact(
            'unreadMessagesCount',
            'totalProjectsCount',
            'publishedProjectsCount',
            'totalSkillsCount',
            'recentMessages',
            'recentProjects'
        ));
    }
}

