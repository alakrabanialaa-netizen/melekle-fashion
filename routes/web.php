<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return "الموقع يعمل، يرجى زيارة /run-migrate لإنشاء الجداول من الصفر.";
});

Route::get('/run-migrate', function () {
    try {
        // هذا الأمر يمسح كل شيء ويبدأ من جديد بالترتيب الصحيح
        Artisan::call('migrate:fresh', ['--force' => true]);
        return "تم مسح قاعدة البيانات وإنشاء الجداول بالترتيب الصحيح بنجاح:   
<pre>" . Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return "حدث خطأ أثناء إنشاء الجداول: " . $e->getMessage();
    }
});
