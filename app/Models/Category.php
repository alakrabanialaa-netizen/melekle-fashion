<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = []; 

    // أضف هذه الدالة هنا لكي يعرف لارافيل كيف يجلب المنتجات الـ 3 الخاصة بكل قسم
    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'category_name');
    }
}
