<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'image',
        'pre_title',
        'headline',
        'subheadline',
        'cta_text',
        'cta_url',
        'video_url',
        'is_active',
        'sort_order',
    ];

    protected $translatable = ['headline', 'subheadline', 'pre_title', 'cta_text'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
