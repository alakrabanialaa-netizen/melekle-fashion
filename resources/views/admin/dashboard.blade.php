@extends('admin.layouts.app')

@section('page-title', 'لوحة التحكم الاستراتيجية')

@section('content')

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

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-gray-400 text-sm font-bold">إجمالي المبيعات</h3>
            <p class="text-2xl font-black text-gray-800" data-counter-up="{{ $totalSales ?? 0 }}">0</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-gray-400 text-sm font-bold">طلبات الشهر</h3>
            <p class="text-2xl font-black text-gray-800" data-counter-up="{{ $ordersThisMonth ?? 0 }}">0</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-gray-400 text-sm font-bold">إجمالي العملاء</h3>
            <p class="text-2xl font-black text-gray-800" data-counter-up="{{ $totalCustomers ?? 0 }}">0</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-gray-400 text-sm font-bold">صافي الربح</h3>
            <p class="text-2xl font-black text-gray-800" data-counter-up="{{ $netProfit ?? 0 }}">0</p>
        </div>

    </div>

    {{-- Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Chart --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xl font-black text-gray-800 mb-6">نظرة عامة على المبيعات</h3>
            <div id="sales-chart"></div>
        </div>

        {{-- Activities --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-6 border-b border-gray-50">
                <h3 class="text-xl font-black text-gray-800">آخر النشاطات</h3>
            </div>

            <div class="divide-y divide-gray-50">

                @php
                    $activities = $recentActivities ?? collect();
                @endphp

                @forelse($activities as $activity)

                    @if($activity instanceof \App\Models\Order)
                        <div class="flex items-center gap-4 p-4 hover:bg-gray-50/80 transition-colors cursor-pointer activity-item">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-800">
                                    طلب جديد من
                                    <span class="text-indigo-600">
                                        {{ $activity->user->name ?? 'عميل غير مسجل' }}
                                    </span>
                                </p>
                                <span class="text-xs text-gray-400 font-bold">
                                    {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                    @elseif($activity instanceof \App\Models\User)
                        <div class="flex items-center gap-4 p-4 hover:bg-gray-50/80 transition-colors cursor-pointer activity-item">
                            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-800">
                                    انضمام عضو جديد:
                                    <span class="text-indigo-600">{{ $activity->name }}</span>
                                </p>
                                <span class="text-xs text-gray-400 font-bold">
                                    {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endif

                @empty
                    <div class="p-6 text-center text-gray-500">
                        لا توجد نشاطات حديثة.
                    </div>
                @endforelse

            </div>
        </div>

    </div>
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Counter
    document.querySelectorAll('[data-counter-up]').forEach(el => {
        el.innerText = Number(el.getAttribute('data-counter-up')).toLocaleString('ar');
    });

    // Chart
    var options = {
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Cairo, sans-serif'
        },

        series: [{
            name: 'المبيعات',
            data: @json($salesChartData ?? [])
        }],

        xaxis: {
            categories: @json($salesChartLabels ?? [])
        },

        stroke: {
            curve: 'smooth',
            width: 3
        },

        colors: ['#4f46e5'],

        dataLabels: {
            enabled: false
        }
    };

    new ApexCharts(document.querySelector("#sales-chart"), options).render();

});
</script>

@endsection
