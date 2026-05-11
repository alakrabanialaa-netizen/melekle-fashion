<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return "الموقع يعمل، يرجى زيارة /run-migrate لإنشاء الجداول من الصفر.";
});

Route::get('/run-migrate', function () {
    try {
        // 1. مسح الكاش لضمان قراءة إعدادات السيرفر الجديدة
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        // 2. تصفير القاعدة وبناء الجداول بالترتيب الصحيح
        // ملاحظة: تم استخدام migrate:fresh لضمان حذف أي جداول قديمة مسببة للمشاكل
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed'  => true // سيقوم بتعبئة البيانات الأساسية إذا كان لديك Seeders
        ]);
        
        return "تم تصفير قاعدة البيانات وبناء الجداول بنجاح! <pre>" . Artisan::output() . "</pre>";
        
    } catch (\Exception $e) {
        // في حال فشل migrate:fresh، سنحاول التشغيل العادي كخيار احتياطي
        try {
            Artisan::call('migrate', ['--force' => true]);
            return "تم تنفيذ الميجريشن العادي بنجاح بعد فشل Fresh: <pre>" . Artisan::output() . "</pre>";
        } catch (\Exception $secondError) {
            return "حدث خطأ حرج: " . $e->getMessage();
        }
    }
});
