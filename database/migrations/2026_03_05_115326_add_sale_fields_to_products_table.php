<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // هذا الكود يضيف الأعمدة الجديدة إلى جدول products
        Schema::table('products', function (Blueprint $table) {
            // حقل السعر الأصلي قبل الخصم، يضاف بعد حقل 'price'
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
            
            // حقل نص الشارة، يضاف بعد حقل 'original_price'
            $table->string('badge_text')->nullable()->after('original_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // هذا الكود يحذف الأعمدة في حال التراجع عن الـ migration
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('original_price');
            $table->dropColumn('badge_text');
        });
    }
};
