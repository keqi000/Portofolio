<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use App\Services\MediaUploadService;
use App\Services\SiteSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        protected MediaUploadService $mediaService
    ) {}

    public function index(): View
    {
        $settings = SiteSettingService::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $fields = [
            'author_name',
            'author_title',
            'headline',
            'bio_summary',
            'about_narrative',
            'availability_status',
            'contact_email',
            'contact_phone',
            'author_location',
            'github_url',
            'linkedin_url',
            'instagram_url',
        ];

        foreach ($fields as $field) {
            Setting::set($field, $request->input($field));
        }

        if ($request->hasFile('profile_image')) {
            Setting::set(
                'profile_image_url',
                $this->mediaService->replace(
                    Setting::get('profile_image_url'),
                    $request->file('profile_image'),
                    'profile',
                    'profile-photo'
                )
            );
        } elseif ($request->boolean('remove_profile_image')) {
            $this->mediaService->delete(Setting::get('profile_image_url'));
            Setting::set('profile_image_url', null);
        }

        if ($request->hasFile('resume_pdf')) {
            $resumeUrl = $this->mediaService->replace(
                Setting::get('resume_pdf_url'),
                $request->file('resume_pdf'),
                'documents',
                'resume'
            );
            Setting::set('resume_pdf_url', $resumeUrl);
        }

        return back()->with('success', 'Pengaturan situs dan profil berhasil disimpan.');
    }
}
