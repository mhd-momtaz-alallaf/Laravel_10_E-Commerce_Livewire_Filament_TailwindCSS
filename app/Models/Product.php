<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale',
    ];

    protected $casts = [
        'images'=> 'array' // because we use json type for the images in the migration.
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class); // one category => many products.
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class); // one brand => many products.
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class); // one product => many orderItems.
    }
}
