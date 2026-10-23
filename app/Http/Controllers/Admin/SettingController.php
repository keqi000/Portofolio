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
            'github_url',
            'linkedin_url',
        ];

        foreach ($fields as $field) {
            Setting::set($field, $request->input($field));
        }

        // Handle Resume Upload
        if ($request->hasFile('resume_pdf')) {
            $oldResume = Setting::get('resume_pdf_url');
            if ($oldResume) {
                $this->mediaService->delete($oldResume);
            }
            $resumeUrl = $this->mediaService->upload($request->file('resume_pdf'), 'documents');
            Setting::set('resume_pdf_url', $resumeUrl);
        }

        return back()->with('success', 'Pengaturan situs dan profil berhasil disimpan.');
    }
}

