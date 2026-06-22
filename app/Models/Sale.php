<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // ✅ السماح بحفظ حقول المبيعات تلقائياً لإنهاء الخطأ
    protected $fillable = [
        'total_amount',
        'total_profit',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
