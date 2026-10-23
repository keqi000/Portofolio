<?php

namespace App\Models;

use App\Services\MediaUploadService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'image_path',
        'caption',
        'sort_order',
    ];

    public function getImagePathAttribute(?string $value): ?string
    {
        return app(MediaUploadService::class)->publicUrl($value);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
