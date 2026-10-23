<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use App\Services\SiteSettingService;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function __invoke(): View
    {
        $settings = SiteSettingService::all();
        $categories = SkillCategory::with(['skills' => function ($query) {
            $query->orderBy('sort_order');
        }])->orderBy('sort_order')->get();

        return view('public.skills', compact('settings', 'categories'));
    }
}

