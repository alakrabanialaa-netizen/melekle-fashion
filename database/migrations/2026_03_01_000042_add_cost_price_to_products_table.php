<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // هذا السطر سيضيف حقل "سعر التكلفة" بعد حقل "سعر البيع"
            $table->decimal('cost_price', 8, 2)->default(0)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // هذا السطر سيحذف الحقل في حال أردنا التراجع عن التغيير
            $table->dropColumn('cost_price');
        });
    }
};
