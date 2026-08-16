@extends('admin.layouts.app')

@section('page-title', 'لوحة التحكم الاستراتيجية - Melekler')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="p-4 md:p-8 bg-[#faf7f2] min-h-screen dir-rtl">

    {{-- 1. الهيدر العلوي وأزرار الإجراءات السريعة --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8 bg-white p-6 rounded-3xl shadow-sm border border-rose-100/50">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-ping"></span>
                <h1 class="text-2xl md:text-3xl font-black text-gray-800 flex items-center gap-2">
                    <span class="text-rose-500"><i class="fas fa-chart-pie"></i></span> لوحة التحكم الاستراتيجية
                </h1>
            </div>
            <p class="text-gray-500 text-xs md:text-sm font-semibold mt-1">متابعة لحظية لأداء المبيعات والنشاطات في متجر Melekler</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <a href="{{ route('admin.products.create') ?? '#' }}" 
               class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-rose-50 text-rose-600 hover:bg-rose-100 px-4 py-2.5 rounded-xl font-bold text-xs transition-all border border-rose-200">
                <i class="fas fa-plus"></i>
                <span>إضافة منتج</span>
            </a>
            
            <a href="{{ route('admin.orders.index') ?? '#' }}" 
               class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-amber-50 text-amber-700 hover:bg-amber-100 px-4 py-2.5 rounded-xl font-bold text-xs transition-all border border-amber-200">
                <i class="fas fa-boxes-packing"></i>
                <span>الطلبات المعلقة</span>
            </a>

            <a href="{{ url('/') }}" target="_blank"
               class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-gradient-to-r from-rose-500 to-pink-500 text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:from-rose-600 hover:to-pink-600 transition-all shadow-md shadow-rose-500/20">
                <i class="fas fa-external-link-alt"></i>
                <span>المتجر الرئيسي</span>
            </a>
        </div>
    </div>

    {{-- 2. كروت الإحصائيات الأربعة الرئيسية --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- إجمالي المبيعات --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100/60 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-extrabold uppercase tracking-wider mb-1">إجمالي المبيعات</h3>
                    <p class="text-3xl font-black text-gray-800 flex items-baseline gap-1">
                        <span id="counter-sales" data-target="{{ $totalSales ?? 0 }}">0</span>
                        <span class="text-xs font-bold text-gray-400">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-emerald-600 font-bold flex items-center gap-1 bg-emerald-50 px-2.5 py-1 rounded-lg w-fit">
                <i class="fas fa-arrow-trend-up"></i>
                <span>+12.5% مقارنة بالشهر الماضي</span>
            </div>
        </div>

        {{-- طلبات الشهر --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100/60 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-extrabold uppercase tracking-wider mb-1">طلبات الشهر</h3>
                    <p class="text-3xl font-black text-gray-800" id="counter-orders" data-target="{{ $ordersThisMonth ?? 0 }}">0</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-bag-shopping"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-amber-600 font-bold flex items-center gap-1 bg-amber-50 px-2.5 py-1 rounded-lg w-fit">
                <i class="fas fa-spinner fa-spin text-[10px]"></i>
                <span>تحديث مستمر للطلبات</span>
            </div>
        </div>

        {{-- إجمالي العملاء --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100/60 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-extrabold uppercase tracking-wider mb-1">إجمالي العملاء</h3>
                    <p class="text-3xl font-black text-gray-800" id="counter-customers" data-target="{{ $totalCustomers ?? 0 }}">0</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-users-viewfinder"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-indigo-600 font-bold flex items-center gap-1 bg-indigo-50 px-2.5 py-1 rounded-lg w-fit">
                <i class="fas fa-user-check"></i>
                <span>عملاء مسجلون بالمنصة</span>
            </div>
        </div>

        {{-- صافي الربح --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100/60 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-extrabold uppercase tracking-wider mb-1">صافي الربح التقديري</h3>
                    <p class="text-3xl font-black text-emerald-600 flex items-baseline gap-1">
                        <span id="counter-profit" data-target="{{ $netProfit ?? 0 }}">0</span>
                        <span class="text-xs font-bold text-emerald-400">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-rose-500 font-bold flex items-center gap-1 bg-rose-50 px-2.5 py-1 rounded-lg w-fit">
                <i class="fas fa-calculator"></i>
                <span>بعد اقتطاع التكاليف</span>
            </div>
        </div>

    </div>

    {{-- 3. قسم الرسم البياني والنشاطات المباشرة --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- الرسم البياني للتحليلات المال --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-rose-100/60 p-6 flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-6">
                <div>
                    <h3 class="text-lg font-black text-gray-800">تحليلات الأداء المالي</h3>
                    <p class="text-gray-400 text-xs font-bold">مقارنة حركة المبيعات والإيرادات الأسبوعية</p>
                </div>
                <span class="text-xs bg-rose-50 text-rose-500 px-3 py-1 rounded-full font-bold border border-rose-100">
                    <i class="fas fa-sync-alt fa-spin text-[10px] ml-1"></i> مباشر
                </span>
            </div>
            <div id="sales-chart" class="w-full"></div>
        </div>

        {{-- شريط آخر النشاطات والعمليات --}}
        <div class="bg-white rounded-3xl shadow-sm border border-rose-100/60 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 bg-rose-50/30">
                <h3 class="text-lg font-black text-gray-800">آخر النشاطات</h3>
                <p class="text-gray-400 text-xs font-bold mt-0.5">متابعة الطلبات والتسجيلات الجديدة</p>
            </div>

            <div class="divide-y divide-gray-50 overflow-y-auto max-h-[380px]">
                @php
                    $activities = $recentActivities ?? collect();
                @endphp

                @forelse($activities as $activity)
                    @if($activity instanceof \App\Models\Order)
                        <div class="flex items-center gap-4 p-4 hover:bg-rose-50/20 transition-colors group">
                            <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                <i class="fas fa-cart-shopping"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-sm text-gray-800 truncate">
                                    طلب جديد من <span class="text-rose-500 font-extrabold">{{ $activity->user->name ?? 'عميل زائر' }}</span>
                                </p>
                                <span class="text-[11px] text-gray-400 font-bold block mt-0.5">
                                    <i class="far fa-clock ml-0.5"></i> {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <span class="text-xs font-black text-gray-700 bg-gray-100 px-2.5 py-1 rounded-xl shrink-0">
                                {{ number_format($activity->total_price ?? 0, 2) }} ₺
                            </span>
                        </div>

                    @elseif($activity instanceof \App\Models\User)
                        <div class="flex items-center gap-4 p-4 hover:bg-emerald-50/20 transition-colors group">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-sm text-gray-800 truncate">
                                    انضمام عميل جديد: <span class="text-gray-700 font-black">{{ $activity->name }}</span>
                                </p>
                                <span class="text-[11px] text-gray-400 font-bold block mt-0.5">
                                    <i class="far fa-clock ml-0.5"></i> {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="p-8 text-center text-gray-400 font-bold text-sm">
                        <div class="text-3xl mb-2">📥</div>
                        لا توجد نشاطات جديدة مسجلة حتى الآن.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- JS التفاعلي لتشغيل العدادات والرسم البياني --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. أنيميشن العدادات مع تنسيق الفواصل الرقمية
    function animateCounter(id) {
        const el = document.getElementById(id);
        if(!el) return;
        const target = parseFloat(el.getAttribute('data-target')) || 0;
        const duration = 1200; 
        const frameRate = 1000 / 60;
        const totalFrames = Math.round(duration / frameRate);
        let frame = 0;

        const formatter = new Intl.NumberFormat('en-US', {
            maximumFractionDigits: 0
        });

        const counter = setInterval(() => {
            frame++;
            const progress = frame / totalFrames;
            const current = Math.round(target * progress);
            
            el.innerText = formatter.format(current);

            if (frame === totalFrames) {
                el.innerText = formatter.format(target);
                clearInterval(counter);
            }
        }, frameRate);
    }

    animateCounter('counter-sales');
    animateCounter('counter-orders');
    animateCounter('counter-customers');
    animateCounter('counter-profit');

    // 2. إعدادات ApexCharts المحدثة
    var options = {
        chart: {
            type: 'area',
            height: 320,
            toolbar: { show: false },
            fontFamily: 'Tajawal, Cairo, sans-serif',
            sparkline: { enabled: false }
        },
        series: [{
            name: 'المبيعات اليومية',
            data: {!! json_encode($salesChartData ?? [1200, 1900, 3400, 2800, 5100, 4200, 7000]) !!}
        }],
        xaxis: {
            categories: {!! json_encode($salesChartLabels ?? ['الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت', 'الأحد']) !!},
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: {
                    colors: '#9ca3af',
                    fontSize: '12px',
                    fontWeight: 600
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#9ca3af',
                    fontSize: '11px'
                },
                formatter: function (value) {
                    return value.toLocaleString() + ' ₺';
                }
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3.5,
            colors: ['#f43f5e']
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.35,
                opacityTo: 0.0,
                stops: [0, 100],
                colorStops: [
                    { offset: 0, color: "#f43f5e", opacity: 0.35 },
                    { offset: 100, color: "#faf7f2", opacity: 0.0 }
                ]
            }
        },
        colors: ['#f43f5e'],
        grid: {
            borderColor: '#f3f4f6',
            strokeDashArray: 4,
            yaxis: { lines: { show: true } }
        },
        dataLabels: { enabled: false },
        tooltip: {
            theme: 'light',
            y: {
                formatter: function(val) {
                    return val.toLocaleString() + " ₺";
                }
            }
        }
    };

    new ApexCharts(document.querySelector("#sales-chart"), options).render();
});
</script>

@endsection
