<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'sizes',
        'colors',
        'slug',
        'cost_price',
        'original_price',
        'badge_text',
        'category',
        'video',
        'image',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'ages' => 'array',
];
  

    // علاقة صور المنتج
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // علاقة المتغيرات (إذا عندك)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // استخدام slug للروت بدلاً من id
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
