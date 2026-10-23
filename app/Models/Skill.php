<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'proficiency_level',
        'icon_svg',
        'sort_order',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'category_id');
    }

    public function scopeProduction($query)
    {
        return $query->where('proficiency_level', 'production');
    }

    public function scopeLearning($query)
    {
        return $query->where('proficiency_level', 'learning');
    }
}

