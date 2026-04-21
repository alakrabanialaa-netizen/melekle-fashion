@extends('admin.layouts.app')

@section('page-title', 'لوحة التحكم الاستراتيجية')

@section('content')

{{-- ApexCharts.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="p-6 bg-gray-50 min-h-screen">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-black text-gray-800">
            لوحة التحكم الاستراتيجية
        </h1>

      <a href="{{ url('/') }}" target="_blank"
   class="group flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm
          hover:bg-indigo-700 transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5">
    <i class="fas fa-globe transition-transform group-hover:-translate-x-1"></i>
    <span>اذهب إلى الموقع</span>
</a>
    </div>
    
    {{-- Animated Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- إجمالي المبيعات --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 text-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
                <div class="text-right">
                    <span class="text-green-500 text-xs font-black bg-green-50 px-2 py-1 rounded-lg">+12.5%</span>
                </div>
            </div>
            <h3 class="text-gray-400 text-sm font-bold">إجمالي المبيعات</h3>
            <div class="flex items-baseline gap-1">
<p class="text-2xl font-black text-gray-800" data-counter-up="{{ $totalSales ?? 0 }}">0</p>
                <span class="text-gray-400 text-xs font-bold">ليرة</span>
            </div>
        </div>

        {{-- الطلبات --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-shopping-basket text-2xl"></i>
                </div>
                <span class="text-blue-500 text-xs font-black bg-blue-50 px-2 py-1 rounded-lg">+5%</span>
            </div>
            <h3 class="text-gray-400 text-sm font-bold">طلبات الشهر</h3>
<p class="text-2xl font-black text-gray-800" data-counter-up="{{ $ordersThisMonth ?? 0 }}">0</p>
        </div>

        {{-- المستخدمين --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <span class="text-purple-500 text-xs font-black bg-purple-50 px-2 py-1 rounded-lg">+20 جديد</span>
            </div>
            <h3 class="text-gray-400 text-sm font-bold">إجمالي العملاء</h3>
<p class="text-2xl font-black text-gray-800" data-counter-up="{{ $totalCustomers ?? 0 }}">0</p>
        </div>

        {{-- الأرباح --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <span class="text-orange-500 text-xs font-black bg-orange-50 px-2 py-1 rounded-lg">+8%</span>
            </div>
            <h3 class="text-gray-400 text-sm font-bold">صافي الربح</h3>
            <div class="flex items-baseline gap-1">
<p class="text-2xl font-black text-gray-800" data-counter-up="{{ $netProfit ?? 0 }}">0</p>
                <span class="text-gray-400 text-xs font-bold">ليرة</span>
            </div>
        </div>
    </div>

    {{-- Charts and Recent Activities Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Sales Chart --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xl font-black text-gray-800 mb-1">نظرة عامة على المبيعات</h3>
            <p class="text-sm text-gray-400 mb-6">أداء المبيعات خلال آخر 7 أيام</p>
            <div id="sales-chart"></div>
        </div>

        {{-- Recent Activities --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                <div>
                    <h3 class="text-xl font-black text-gray-800">آخر النشاطات</h3>
                    <p class="text-sm text-gray-400 mt-1">تحديث حي</p>
                </div>
            </div>
            <div class="divide-y divide-gray-50">
    @if(isset($recentActivities))
    @foreach($recentActivities as $activity)
        {{-- عرض البيانات --}}
    @endforeach
@endif
        @if($activity instanceof \App\Models\Order)
            {{-- عرض نشاط "طلب جديد" --}}
            <div class="flex items-center gap-4 p-4 hover:bg-gray-50/80 transition-colors cursor-pointer activity-item">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-shopping-bag"></i></div>
                <div>
                    <p class="font-bold text-sm text-gray-800">
                        طلب جديد من <span class="text-indigo-600">{{ $activity->user->name ?? 'عميل غير مسجل' }}</span>
                    </p>
                    <span class="text-xs text-gray-400 font-bold">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @elseif($activity instanceof \App\Models\User)
            {{-- عرض نشاط "عضو جديد" --}}
            <div class="flex items-center gap-4 p-4 hover:bg-gray-50/80 transition-colors cursor-pointer activity-item">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center"><i class="fas fa-user-plus"></i></div>
                <div>
                    <p class="font-bold text-sm text-gray-800">
                        انضمام عضو جديد: <span class="text-indigo-600">{{ $activity->name }}</span>
                    </p>
                    <span class="text-xs text-gray-400 font-bold">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @endif
    @empty
        <div class="p-6 text-center text-gray-500">
            لا توجد نشاطات حديثة.
        </div>
    @endforelse
</div>

        

<style>
    .activity-item {
        opacity: 0;
        transform: translateX(20px);
        animation: slideIn 0.5s forwards;
    }
    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Counter-Up Animation
    const counters = document.querySelectorAll('[data-counter-up]');
    const speed = 200; // The lower the slower

    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-counter-up');
        const count = +counter.innerText;
        const inc = target / speed;

        if (count < target) {
            counter.innerText = Math.ceil(count + inc);
            setTimeout(() => animateCounter(counter), 10);
        } else {
            counter.innerText = target.toLocaleString('ar');
        }
    };
    counters.forEach(animateCounter);

    // 2. Staggered Animation for Activity List
    const activityItems = document.querySelectorAll('.activity-item');
    activityItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.15}s`;
    });

    // 3. ApexCharts - Sales Chart
    var options = {
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Cairo, sans-serif',
        },
        series: [{
            name: 'المبيعات',
            data: [1200, 1800, 1500, 2500, 2200, 3200, 2800]
        }],
        xaxis: {
            categories: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
            labels: { style: { fontWeight: 700 } }
        },
        yaxis: {
            labels: {
                formatter: (value) => { return value.toLocaleString('ar') + ' ليرة' },
                style: { fontWeight: 700 }
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 3,
        },
        colors: ['#4f46e5'], // Indigo
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2,
                stops: [0, 90, 100]
            }
        },
        tooltip: {
            x: { show: false },
            y: {
                formatter: (value) => { return value.toLocaleString('ar') + ' ليرة' },
            },
            marker: { show: true },
        },
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 4
        }
    };

    var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
    chart.render();
});
</script>
@endsection
