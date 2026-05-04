<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Product extends Model
{
    use HasFactory;

    /**
     * هذا الكود سيقوم بفحص قاعدة البيانات وإضافة الأعمدة الناقصة تلقائياً
     * بمجرد محاولة حفظ أو إنشاء منتج جديد.
     */
    protected static function booted()
    {
        static::saving(function ($product) {
            // التحقق من وجود عمود المقاسات
            if (!Schema::hasColumn('products', 'sizes')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->text('sizes')->nullable();
                });
            }
            // التحقق من وجود عمود الأعمار
            if (!Schema::hasColumn('products', 'ages')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->text('ages')->nullable();
                });
            }
        });
    }

    protected $fillable = [
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

    // علاقة صور المنتج
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // علاقة المتغيرات
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
