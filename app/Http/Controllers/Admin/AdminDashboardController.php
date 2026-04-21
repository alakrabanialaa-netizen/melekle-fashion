<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Expense;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // =========================
        // 1. البطاقات الرئيسية
        // =========================
        $totalSales = Order::where('status', 'completed')->sum('total_price');

        $ordersThisMonth = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $totalCustomers = User::count();

        $costOfGoodsSold = 0;
        $completedOrders = Order::with('items.product')
            ->where('status', 'completed')
            ->get();

        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $costOfGoodsSold += ($item->qty * $item->product->cost_price);
                }
            }
        }

        $grossProfit = $totalSales - $costOfGoodsSold;
        $totalExpenses = Expense::sum('amount');
        $netProfit = $grossProfit - $totalExpenses;

        // =========================
        // 2. بيانات الرسم البياني
        // =========================
        $salesChartData = [];
        $salesChartLabels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $salesChartLabels[] = $date->format('D');

            $dailySales = Order::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_price');

            $salesChartData[] = $dailySales;
        }

        // =========================
        // 3. آخر النشاطات
        // =========================
        $recentOrders = Order::with('user')->latest()->take(3)->get();
        $recentUsers = User::latest()->take(2)->get();

        $recentActivities = $recentOrders
            ->concat($recentUsers)
            ->sortByDesc('created_at');

        // =========================
        // 4. إرسال البيانات للواجهة
        // =========================
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
