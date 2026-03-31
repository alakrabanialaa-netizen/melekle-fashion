<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل عملية الترحيل (إضافة العمود)
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // إضافة عمود الفيديو بعد حقل الوصف (description)
            // جعلناه nullable لكي لا يسبب مشاكل للمنتجات القديمة التي ليس لها فيديو
            $table->string('video')->nullable()->after('description');
        });
    }

    /**
     * التراجع عن عملية الترحيل (حذف العمود)
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('video');
        });
    }
};
