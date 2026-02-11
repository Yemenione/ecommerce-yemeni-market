<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price_eur',
        'sku',
        'stock',
        'images',
        'is_featured',
    ];

    protected $translatable = ['name', 'description'];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
    ];
}
