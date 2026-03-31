<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory; // من الجيد إضافتها

    protected $fillable = [
        'customer_name',
        'phone',
        'total_price', // ❗ انتبه: تأكد من أن هذا هو اسم الحقل الصحيح
        'status',
        'user_id' // ❗ انتبه: تأكد من وجود هذا الحقل
    ];

    /**
     * علاقة لجلب عناصر هذا الطلب
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * علاقة لجلب المستخدم صاحب الطلب
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
