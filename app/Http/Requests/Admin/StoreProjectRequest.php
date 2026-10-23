<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'tagline' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::exists('project_categories', 'name')],
            'problem_statement' => ['required', 'string'],
            'solution_description' => ['required', 'string'],
            'tech_stack' => ['required', 'string'], // Comma-separated string converted in controller
            'live_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:1', 'max:' . (Project::count() + 1)],
        ];
    }
}
