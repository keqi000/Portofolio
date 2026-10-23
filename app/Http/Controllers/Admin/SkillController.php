<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillRequest;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Services\SortOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $categories = SkillCategory::with(['skills' => function ($q) {
            $q->orderBy('sort_order');
        }])->orderBy('sort_order')->get();

        return view('admin.skills.index', compact('categories'));
    }

    public function storeSkill(StoreSkillRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? ((int) Skill::where('category_id', $data['category_id'])->max('sort_order') + 1);

        Skill::create($data);

        return back()->with('success', 'Keahlian baru berhasil ditambahkan.');
    }

    public function updateSkill(Request $request, Skill $skill): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:skill_categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'proficiency_level' => ['required', 'in:production,learning'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $skill->update($data);

        return back()->with('success', 'Data keahlian berhasil diperbarui.');
    }

    public function destroySkill(Skill $skill): RedirectResponse
    {
        $skill->delete();
        return back()->with('success', 'Keahlian telah dihapus.');
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:1', 'max:' . (SkillCategory::count() + 1)],
        ]);

        $position = $data['sort_order'] ?? (SkillCategory::count() + 1);
        $data['slug'] = Str::slug($data['name']);
        $data['sort_order'] = SkillCategory::count() + 1;

        $category = SkillCategory::create($data);
        app(SortOrderService::class)->move(
            SkillCategory::query()->orderBy('sort_order')->orderBy('id'),
            $category,
            $position
        );

        return back()->with('success', 'Kategori baru berhasil dibuat.');
    }

    public function updateCategoryOrder(Request $request, SkillCategory $category, SortOrderService $sortOrderService): RedirectResponse
    {
        $data = $request->validate([
            'sort_order' => ['required', 'integer', 'min:1', 'max:' . SkillCategory::count()],
        ]);

        $sortOrderService->move(
            SkillCategory::query()->orderBy('sort_order')->orderBy('id'),
            $category,
            (int) $data['sort_order']
        );

        return back()->with('success', 'Urutan kategori keahlian berhasil diperbarui.');
    }

    public function destroyCategory(SkillCategory $category): RedirectResponse
    {
        $category->delete();
        app(SortOrderService::class)->normalize(SkillCategory::query()->orderBy('sort_order')->orderBy('id'));
        return back()->with('success', 'Kategori dan seluruh keahlian di dalamnya telah dihapus.');
    }
}
