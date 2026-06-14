@extends('admin.layouts.app')

@section('page-title', 'النظام المحاسبي المتكامل')

@section('content')
<div class="container mx-auto p-6 space-y-8 bg-gray-50 min-h-screen">
    
    {{-- الهيدر الرئيسي --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 border-gray-200">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">الدفتر المالي والجرد العام</h1>
            <p class="text-sm text-gray-500 mt-1">الإدارة المالية الشاملة لمستودعات ومبيعات Melekler Fashion</p>
        </div>
        <div class="mt-4 md:mt-0 bg-white shadow-sm rounded-xl px-4 py-2 border text-sm font-medium text-gray-700">
            📅 السنة المالية: <span class="text-indigo-600 font-bold">{{ date('Y') }}</span>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border-r-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-xs font-medium animate-pulse">
            ✨ {{ session('success') }}
        </div>
    @endif

    {{-- ================= قسم 1: جرد وتحليل المستودع الفعلي ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6">
        <div class="flex items-center gap-3 border-b pb-4 mb-6">
            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">تقرير جرد وتقييم المستودع الفعلي</h2>
                <p class="text-xs text-gray-400">محسوب حركياً بناءً على (الكميات المتوفرة الحالية × أسعار التكلفة والبيع)</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                <span class="text-xs font-semibold text-gray-400 block mb-1">إجمالي القطع في المستودع</span>
                <span class="text-2xl font-black text-gray-800 font-mono">{{ number_format($totalStockPieces ?? 0) }}</span> <span class="text-xs text-gray-500">قطعة</span>
            </div>
            <div class="bg-amber-50/60 rounded-xl p-5 border border-amber-100">
                <span class="text-xs font-semibold text-amber-700 block mb-1">قيمة المخزون الإجمالية (سعر التكلفة)</span>
                <span class="text-2xl font-black text-amber-700 font-mono">{{ number_format($inventoryCostValue ?? 0, 2) }}</span> <span class="text-xs text-amber-600">₺</span>
            </div>
            <div class="bg-emerald-50/60 rounded-xl p-5 border border-emerald-100">
                <span class="text-xs font-semibold text-emerald-700 block mb-1">قيمة المخزون المتوقعة (سعر البيع)</span>
                <span class="text-2xl font-black text-emerald-700 font-mono">{{ number_format($inventorySaleValue ?? 0, 2) }}</span> <span class="text-xs text-emerald-600">₺</span>
            </div>
            <div class="bg-indigo-50/60 rounded-xl p-5 border border-indigo-100">
                <span class="text-xs font-semibold text-indigo-700 block mb-1">الأرباح الكامنة داخل المستودع</span>
                <span class="text-2xl font-black text-indigo-700 font-mono">{{ number_format($expectedInventoryProfit ?? 0, 2) }}</span> <span class="text-xs text-indigo-600">₺</span>
            </div>
        </div>
    </div>

    {{-- ================= قسم 2: لوحة الأداء المالي والتدفقات ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- المؤشرات المالية الستة --}}
        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
                <h3 class="text-xs font-bold text-gray-400 uppercase">رأس المال الفعلي المدرج</h3>
                <p class="text-2xl font-black text-slate-800 mt-2 font-mono">{{ number_format($capital ?? 0, 2) }} ₺</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
                <h3 class="text-xs font-bold text-gray-400 uppercase">إجمالي المبيعات المحققة</h3>
                <p class="text-2xl font-black text-emerald-600 mt-2 font-mono">{{ number_format($totalSales ?? 0, 2) }} ₺</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
                <h3 class="text-xs font-bold text-gray-400 uppercase">إجمالي المصاريف التشغيلية</h3>
                <p class="text-2xl font-black text-red-600 mt-2 font-mono">{{ number_format($totalExpenses ?? 0, 2) }} ₺</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
                <h3 class="text-xs font-bold text-gray-400 uppercase">صافي الأرباح الدورية الفعلي</h3>
                <p class="text-2xl font-black {{ $net >= 0 ? 'text-indigo-600' : 'text-rose-600' }} mt-2 font-mono">
                    {{ number_format($net ?? 0, 2) }} ₺
                </p>
            </div>
        </div>

        {{-- الرسم البياني الصغير الذكي --}}
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs flex flex-col justify-between">
            <h3 class="text-xs font-bold text-gray-700 border-b pb-2">📈 حركة المبيعات الشهرية</h3>
            <div class="h-32 w-full mt-2">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ================= قسم 3: دفتر القيود المزدوجة اليومية ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- حركات رأس المال والشركاء --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">🪙 قيود التمويل ورأس المال</h3>
                <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-md font-mono">إجمالي: {{ number_format($capital, 2) }} ₺</span>
            </div>
            
            <form action="{{ url('/admin/accounting/capital') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-gray-50 p-3 rounded-xl mb-4">
                @csrf
                <input type="hidden" name="transaction_date" value="{{ date('Y-m-d') }}">
                <input type="text" name="description" placeholder="البيان (مثال: دفعة شريك)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <input type="number" name="amount" step="0.01" placeholder="المبلغ (+ أو -)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <button type="submit" class="bg-slate-800 text-white font-bold rounded-lg text-xs py-2 hover:bg-slate-900 transition-all">إدراج قيد</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b pb-2"><th class="pb-2">البيان المالي</th><th class="pb-2">القيمة</th><th class="pb-2 text-center">إجراء</th></tr>
                    </thead>
                    <tbody>
                        @forelse($capitalTransactions as $cap)
                        <tr class="border-b hover:bg-gray-50/80 transition-colors">
                            <td class="py-2.5 font-medium text-gray-700">{{ $cap->description }}</td>
                            <td class="py-2.5 font-bold font-mono {{ $cap->amount >= 0 ? 'text-emerald-600' : 'text-rose-500' }}">{{ number_format($cap->amount, 2) }} ₺</td>
                            <td class="py-2.5 text-center">
                                <form action="{{ url('/admin/accounting/capital/'.$cap->id) }}" method="POST" onsubmit="return confirm('تأكيد حذف القيد التمويلي؟')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-300 hover:text-rose-600 transition-colors">✕</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-4 text-gray-400">لا توجد قيود رأس مال مسجلة.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- حركات المصاريف التشغيلية --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">🧾 قيود المصاريف التشغيلية</h3>
                <span class="text-xs text-rose-600 bg-rose-50 px-2 py-1 rounded-md font-mono">إجمالي: {{ number_format($totalExpenses, 2) }} ₺</span>
            </div>

            <form action="{{ url('/admin/expenses') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-gray-50 p-3 rounded-xl mb-4">
                @csrf
                <input type="hidden" name="expense_date" value="{{ date('Y-m-d') }}">
                <input type="text" name="description" placeholder="الوصف (مثال: شحن / إيجار)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <input type="number" name="amount" step="0.01" placeholder="المبلغ (₺)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <button type="submit" class="bg-rose-600 text-white font-bold rounded-lg text-xs py-2 hover:bg-rose-700 transition-all">إدراج مصروف</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b pb-2"><th class="pb-2">نوع المصروف</th><th class="pb-2">المبلغ</th><th class="pb-2 text-center">إجراء</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentExpenses as $exp)
                        <tr class="border-b hover:bg-gray-50/80 transition-colors">
                            <td class="py-2.5 font-medium text-gray-700">{{ $exp->description }}</td>
                            <td class="py-2.5 font-bold font-mono text-rose-600">{{ number_format($exp->amount, 2) }} ₺</td>
                            <td class="py-2.5 text-center">
                                <form action="{{ url('/admin/expenses/'.$exp->id) }}" method="POST" onsubmit="return confirm('تأكيد حذف قيد المصروف؟')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-300 hover:text-rose-600 transition-colors">✕</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-4 text-gray-400">لا توجد مصاريف تشغيلية حالية.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('{!! json_encode($chartLabels) !!}'), 
            datasets: [{
                label: 'الأداء المالي (₺)',
                data: JSON.parse('{!! json_encode($chartData) !!}'), 
                backgroundColor: 'rgba(79, 70, 229, 0.05)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 2,
                pointRadius: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { x: { display: false }, y: { display: false } },
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endpush
@endsection
