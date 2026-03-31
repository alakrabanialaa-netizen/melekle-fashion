<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
   public function variant()
{
    return $this->belongsTo(ProductVariant::class, 'product_variant_id');
}
}
