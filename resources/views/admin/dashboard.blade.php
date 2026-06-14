@extends('admin.layouts.app')

@section('page-title', 'لوحة التحكم الاستراتيجية - Melekler')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="p-6 bg-[#fffaf0] min-h-screen">

    {{-- الهيدر العلوي --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 flex items-center gap-2">
                <span class="text-pink-500">📊</span> لوحة التحكم الاستراتيجية
            </h1>
            <p class="text-gray-400 text-xs font-bold mt-1">متابعة أداء متجر Melekler Fashion المباشر</p>
        </div>

        <a href="{{ url('/') }}" target="_blank"
           class="group flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white px-5 py-3 rounded-2xl font-bold text-sm hover:from-pink-600 hover:to-rose-600 transition-all shadow-md shadow-pink-500/10 hover:shadow-xl hover:-translate-y-0.5">
            <i class="fas fa-globe transition-transform group-hover:-translate-x-1"></i>
            <span>عرض المتجر الرئيسي</span>
        </a>
    </div>

    {{-- كروت الإحصائيات الاستراتيجية المحدثة بالكامل تماشياً مع الهوية --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white p-6 rounded-[24px] shadow-[0_10px_30px_rgba(244,63,94,0.02)] border border-pink-100/40 relative overflow-hidden group hover:border-pink-200 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold tracking-wider uppercase mb-1">إجمالي المبيعات</h3>
                    <p class="text-3xl font-black text-gray-800 flex items-center gap-1">
                        <span id="counter-sales" data-target="{{ $totalSales ?? 0 }}">0</span>
                        <span class="text-sm font-bold text-gray-400">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-500 flex items-center justify-center text-lg shadow-sm">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-green-500 font-bold flex items-center gap-1">
                <i class="fas fa-arrow-trend-up"></i> <span>+12.5% مبيعات متزايدة</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] shadow-[0_10px_30px_rgba(244,63,94,0.02)] border border-pink-100/40 relative overflow-hidden group hover:border-pink-200 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold tracking-wider uppercase mb-1">طلبات الشهر</h3>
                    <p class="text-3xl font-black text-gray-800" id="counter-orders" data-target="{{ $ordersThisMonth ?? 0 }}">0</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg shadow-sm">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-amber-500 font-bold flex items-center gap-1">
                <i class="fas fa-clock"></i> <span>قيد المعالجة والتجهيز</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] shadow-[0_10px_30px_rgba(244,63,94,0.02)] border border-pink-100/40 relative overflow-hidden group hover:border-pink-200 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold tracking-wider uppercase mb-1">إجمالي العملاء</h3>
                    <p class="text-3xl font-black text-gray-800" id="counter-customers" data-target="{{ $totalCustomers ?? 0 }}">0</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-lg shadow-sm">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-purple-500 font-bold flex items-center gap-1">
                <i class="fas fa-user-check"></i> <span>حسابات نشطة ومسجلة</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] shadow-[0_10px_30px_rgba(244,63,94,0.02)] border border-pink-100/40 relative overflow-hidden group hover:border-pink-200 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold tracking-wider uppercase mb-1">صافي الربح</h3>
                    <p class="text-3xl font-black text-rose-500 flex items-center gap-1">
                        <span id="counter-profit" data-target="{{ $netProfit ?? 0 }}">0</span>
                        <span class="text-sm font-bold text-rose-400">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg shadow-sm">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-rose-400 font-bold flex items-center gap-1">
                <i class="fas fa-heart"></i> <span>بعد اقتطاع المصاريف</span>
            </div>
        </div>

    </div>

    {{-- قسم الرسوم البيانية والنشاطات المباشرة --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- الرسم البياني للمبيعات (Chart) بتصميم وردي متدرج ناعم --}}
        <div class="lg:col-span-2 bg-white rounded-[28px] shadow-[0_10px_30px_rgba(244,63,94,0.01)] border border-pink-50/60 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-black text-gray-800">تحليلات الأداء المالي</h3>
                    <p class="text-gray-400 text-xs font-bold">مقارنة مبيعات المتجر الأسبوعية</p>
                </div>
                <span class="text-xs bg-pink-50 text-pink-500 px-3 py-1.5 rounded-full font-bold">محدث فورياً</span>
            </div>
            <div id="sales-chart"></div>
        </div>

        {{-- شريط آخر النشاطات والعمليات على الموقع --}}
        <div class="bg-white rounded-[28px] shadow-[0_10px_30px_rgba(244,63,94,0.01)] border border-pink-50/60 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-50 bg-gradient-to-r from-white to-pink-50/20">
                <h3 class="text-lg font-black text-gray-800">آخر العمليات</h3>
                <p class="text-gray-400 text-xs font-bold mt-0.5">مراقبة الطلبات والاشتراكات الجديدة</p>
            </div>

            <div class="divide-y divide-gray-50 overflow-y-auto max-h-[340px]">
                @php
                    $activities = $recentActivities ?? collect();
                @endphp

                @forelse($activities as $activity)
                    @if($activity instanceof \App\Models\Order)
                        <div class="flex items-center gap-4 p-4 hover:bg-pink-50/10 transition-colors cursor-pointer group">
                            <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-500 flex items-center justify-center transition-transform group-hover:scale-110">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-sm text-gray-800">
                                    طلب جديد من 
                                    <span class="text-pink-500">{{ $activity->user->name ?? 'عميل زائر' }}</span>
                                </p>
                                <span class="text-[11px] text-gray-400 font-bold block mt-0.5">
                                    <i class="far fa-clock ml-0.5"></i> {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <span class="text-xs font-black text-gray-700 bg-gray-50 px-2.5 py-1 rounded-lg">
                                {{ number_format($activity->total_price, 2) }} ₺
                            </span>
                        </div>

                    @elseif($activity instanceof \App\Models\User)
                        <div class="flex items-center gap-4 p-4 hover:bg-pink-50/10 transition-colors cursor-pointer group">
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-500 flex items-center justify-center transition-transform group-hover:scale-110">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-800">
                                    انضم عميل جديد: 
                                    <span class="text-gray-600 font-black">{{ $activity->name }}</span>
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
                        لا توجد نشاطات مسجلة اليوم.
                    </div>
                @endempty
            </div>
        </div>

    </div>
</div>

{{-- JS التفاعلي لتشغيل العدادات والرسم البياني --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. أنيميشن العدادات التصاعدية الذكي (Counter Up Animation)
    function animateCounter(id) {
        const el = document.getElementById(id);
        if(!el) return;
        const target = parseFloat(el.getAttribute('data-target'));
        const speed = 200; 
        const increment = target / speed;
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                el.innerText = Math.ceil(current).toLocaleString('ar');
                setTimeout(updateCounter, 1);
            } else {
                el.innerText = target.toLocaleString('ar');
            }
        };
        updateCounter();
    }

    animateCounter('counter-sales');
    animateCounter('counter-orders');
    animateCounter('counter-customers');
    animateCounter('counter-profit');

    // 2. إعدادات الـ ApexCharts
var options = {
    chart: {
        type: 'area',
        height: 320,
        toolbar: { show: false },
        fontFamily: 'Cairo, sans-serif',
        sparkline: { enabled: false }
    },
    series: [{
        name: 'المبيعات الحالية',
        // تعديل السطر 215 إلى json_encode لتفادي خطأ الـ Blade ParseError 👇
        data: {!! json_encode($salesChartData ?? [1200, 1900, 3400, 2800, 5100, 4200, 7000]) !!}
    }],
    xaxis: {
        // تعديل السطر 220 أيضاً لضمان عدم تكرار الخطأ مع النصوص 👇
        categories: {!! json_encode($salesChartLabels ?? ['الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت', 'الأحد']) !!},
        axisBorder: { show: false },
        axisTicks: { show: false }
    },
    stroke: {
        curve: 'smooth',
        width: 3,
        colors: ['#f43f5e']
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.45,
            opacityTo: 0.02,
            stops: [0, 100],
            colorStops: [
                { offset: 0, color: "#f43f5e", opacity: 0.4 },
                { offset: 100, color: "#fffaf0", opacity: 0.02 }
            ]
        }
    },
    colors: ['#f43f5e'],
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 4,
        yaxis: { lines: { show: true } }
    },
    dataLabels: { enabled: false }
};

new ApexCharts(document.querySelector("#sales-chart"), options).render();
</script>

@endsection
