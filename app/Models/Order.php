<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 💡 أضف هذا السطر وتأكد هل اسم الجدول في قاعدة البيانات عندك 'orders' أم شيء آخر
    protected $table = 'orders'; 

    protected $fillable = [
        'customer_name',
        'phone',
        'total_price',
        'status',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
