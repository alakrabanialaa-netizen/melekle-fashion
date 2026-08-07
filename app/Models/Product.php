<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Product extends Model
{
    use HasFactory;

    // تحديد اسم الجدول صراحة في Supabase
    protected $table = 'products';

    protected static function booted()
    {
        static::saving(function ($product) {
            if (!Schema::hasColumn('products', 'sizes')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->text('sizes')->nullable();
                });
            }
            if (!Schema::hasColumn('products', 'ages')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->text('ages')->nullable();
                });
            }
        });
    }

    protected $fillable = [
        'product_code',
        'product_name', // تم التعديل لتطابق Supabase
        'product_slug', // تم التعديل لتطابق Supabase
        'name',
        'price',
        'stock',
        'description',
        'sizes',
        'colors',
        'ages',
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

    // علاقة الصور (مع حماية في حال عدم وجود الجدول)
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    // لضمان جلب اسم المنتج سواء كان العمود اسمه name أو product_name
    public function getNameAttribute()
    {
        return $this->attributes['product_name'] ?? $this->attributes['name'] ?? '';
    }

    public function getRouteKeyName()
    {
        return 'product_slug';
    }
}
