<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'tagline' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::exists('project_categories', 'name')],
            'problem_statement' => ['required', 'string'],
            'solution_description' => ['required', 'string'],
            'tech_stack' => ['required', 'string'],
            'live_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'remove_project_images' => ['nullable', 'array'],
            'remove_project_images.*' => [
                'integer',
                Rule::exists('project_images', 'id')->where('project_id', $projectId),
            ],
            'sort_order' => ['nullable', 'integer', 'min:1', 'max:' . Project::count()],
        ];
    }
}
