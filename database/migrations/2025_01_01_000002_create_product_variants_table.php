<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $box) {
            $box->id();
            // ربط العلاقة مع جدول المنتجات الأساسي
            $box->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $box->string('variant_name')->nullable();
            $box->string('variant_value')->nullable();
            $box->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
