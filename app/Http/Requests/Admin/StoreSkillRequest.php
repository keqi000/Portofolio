<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:skill_categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'proficiency_level' => ['required', 'in:production,learning'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}

