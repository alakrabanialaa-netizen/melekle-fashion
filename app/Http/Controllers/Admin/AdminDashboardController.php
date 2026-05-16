<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // تصفير البيانات مؤقتاً لمنع الانهيار وقراءة الجداول المفقودة
        $totalSales = 0;
        $ordersThisMonth = 0;
        $totalCustomers = 0;
        $netProfit = 0;

        $salesChartLabels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $salesChartData = [0, 0, 0, 0, 0, 0, 0];
        $recentActivities = collect([]);

        // إرسال البيانات الصفرية لكي تفتح الـ Blade بسلام
        return view('admin.dashboard', [
            'totalSales' => $totalSales,
            'ordersThisMonth' => $ordersThisMonth,
            'totalCustomers' => $totalCustomers,
            'netProfit' => $netProfit,
            'salesChartLabels' => $salesChartLabels,
            'salesChartData' => $salesChartData,
            'recentActivities' => $recentActivities,
        ]);
    }
}
