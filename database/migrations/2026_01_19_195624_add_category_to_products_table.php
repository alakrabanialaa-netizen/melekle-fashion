<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إضافة القسم الرئيسي والفرعي إلى جدول المنتجات.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'main_category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('main_category', 50)
                    ->nullable()
                    ->index();
            });
        }

        if (!Schema::hasColumn('products', 'sub_category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('sub_category', 50)
                    ->nullable()
                    ->index();
            });
        }
    }

    /**
     * حذف العمودين عند التراجع عن Migration.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'sub_category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('sub_category');
            });
        }

        if (Schema::hasColumn('products', 'main_category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('main_category');
            });
        }
    }
};
