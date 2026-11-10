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
        'product_name',
        'product_slug',
        'name',
        'price',
        'stock',
        'status',
        'description',
        'sizes',
        'colors',
        'color',
        'ages',
        'slug',
        'cost_price',
        'original_price',
        'badge_text',
        'category',

        // التصنيف الرئيسي والفرعي الجديد
        'main_category',
        'sub_category',

        'video',
        'image',
        'track_inventory',
        'is_wholesale',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'ages' => 'array',
        'track_inventory' => 'boolean',
        'is_wholesale' => 'boolean',
    ];

    // علاقة الصور
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // علاقة المتغيرات
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    // جلب اسم المنتج سواء كان العمود اسمه name أو product_name
    public function getNameAttribute()
    {
        return $this->attributes['product_name']
            ?? $this->attributes['name']
            ?? '';
    }

    public function getRouteKeyName()
    {
        return 'product_slug';
    }
}
