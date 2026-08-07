<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. إجبار استخدام HTTPS في البيئات غير المحلية (مثل Render)
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // 2. جلب أسعار الصرف وتخزينها بالـ Cache لمدة 60 دقيقة
        $rates = Cache::remember('currency_rates', 3600, function () {
            try {
                // جلب سعر الدولار مقابل الليرة التركية
                $tryResponse = Http::timeout(3)->get('https://open.er-api.com/v6/latest/USD');
                $tryRate = $tryResponse->json()['rates']['TRY'] ?? 33.0;

                // جلب سعر الدولار مقابل الليرة السورية
                $sypResponse = Http::timeout(3)->get('https://api.exchangerate-api.com/v4/latest/USD');
                $sypRate = $sypResponse->json()['rates']['SYP'] ?? 14000.0;

                return [
                    'USD_TRY' => $tryRate,
                    'USD_SYP' => $sypRate,
                ];
            } catch (\Exception $e) {
                return [
                    'USD_TRY' => 33.0,
                    'USD_SYP' => 14000.0,
                ];
            }
        });

        // 3. مشاركة أسعار الصرف مع جميع ملفات Blade تلقائياً
        View::share('rates', $rates);
    }
}
