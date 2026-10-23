<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
            'category' => ['required', 'string', 'max:100'],
            'problem_statement' => ['required', 'string'],
            'solution_description' => ['required', 'string'],
            'tech_stack' => ['required', 'string'], // Comma-separated string converted in controller
            'live_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}

