<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'author_name' => ['required', 'string', 'max:150'],
            'author_title' => ['required', 'string', 'max:200'],
            'headline' => ['required', 'string', 'max:255'],
            'bio_summary' => ['required', 'string', 'max:500'],
            'about_narrative' => ['required', 'string'],
            'availability_status' => ['required', 'string', 'max:150'],
            'contact_email' => ['required', 'email', 'max:150'],
            'contact_phone' => ['required', 'string', 'max:30'],
            'author_location' => ['required', 'string', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'remove_profile_image' => ['nullable', 'boolean'],
            'resume_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // Max 5MB PDF
        ];
    }
}
