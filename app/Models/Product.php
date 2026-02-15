<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'base_price', // Renamed from price_eur
        'sku',
        'stock', // Base stock if no variants, or total stock? Usually base stock.
        'images', // JSON for simple products? Or use relationship for complex?
        'detail_images',
        'lifestyle_images',
        'is_featured',
        'is_active',
        'is_flash_sale',
        'sold_count',
        'material',
        'care_instructions',
        'dimensions',
        'tax_id',
    ];

    protected $translatable = ['name', 'description', 'material', 'care_instructions'];

    protected $casts = [
        'images' => 'array',
        'detail_images' => 'array',
        'lifestyle_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_flash_sale' => 'boolean',
        'base_price' => 'decimal:2',
        'sold_count' => 'integer',
        'tax_id' => 'integer',
    ];

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function flashSales(): HasMany
    {
        return $this->hasMany(FlashSale::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->getTranslation('name', 'en') ?? $product->getTranslation('name', array_key_first($product->getTranslations('name'))));
            }
        });
        
        static::updating(function ($product) {
            if (empty($product->slug)) {
                 $product->slug = \Illuminate\Support\Str::slug($product->getTranslation('name', 'en') ?? $product->getTranslation('name', array_key_first($product->getTranslations('name'))));
            }
        });
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
