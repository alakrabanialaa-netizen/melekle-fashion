<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return "الموقع يعمل، يرجى زيارة /run-migrate لإنشاء الجداول.";
});

Route::get('/run-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "تم إنشاء الجداول بنجاح:   
<pre>" . Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return "حدث خطأ أثناء إنشاء الجداول: " . $e->getMessage();
    }
});
