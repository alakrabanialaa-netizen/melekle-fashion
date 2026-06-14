@extends('admin.layouts.app')

@section('page-title', 'المحاسبة الاحترافية')

@section('content')

@if(isset($lowStock) && $lowStock->count() > 0)
<div class="bg-red-200 text-red-800 p-4 rounded mb-6 shadow-sm">
    <strong>تنبيه المخزون:</strong> بعض المنتجات أوشكت على النفاد!
    <ul class="list-disc list-inside mt-1">
        @foreach($lowStock as $item)
        <li>{{ $item->name ?? 'منتج مجهول' }} (متبقي {{ $item->stock }} قطع)</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-2">لوحة الإدارة المحاسبية والقيود</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 shadow-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- بطاقات العرض الرئيسية --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl shadow-sm border border-yellow-200">
            <h2 class="text-sm font-semibold text-yellow-800 uppercase tracking-wider mb-1">إجمالي رأس المال المتوفر</h2>
            <p class="text-3xl font-extrabold text-yellow-700">{{ number_format($capital ?? 0, 2) }} ₺</p>
        </div>

        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">قيمة المخزون الحالية (الكمية × التكلفة)</h2>
            <p class="text-3xl font-extrabold text-gray-700">{{ number_format($inventoryValue ?? 0, 2) }} ₺</p>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-sm border border-green-200">
            <h2 class="text-sm font-semibold text-green-800 uppercase tracking-wider mb-1">إجمالي المبيعات المستلمة</h2>
            <p class="text-3xl font-extrabold text-green-700">{{ number_format($totalSales ?? 0, 2) }} ₺</p>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow-sm border border-red-200">
            <h2 class="text-sm font-semibold text-red-800 uppercase tracking-wider mb-1">إجمالي المصاريف التشغيلية</h2>
            <p class="text-3xl font-extrabold text-red-700">{{ number_format($totalExpenses ?? 0, 2) }} ₺</p>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-sm border border-blue-200">
            <h2 class="text-sm font-semibold text-blue-800 uppercase tracking-wider mb-1">مجمل الأرباح (قبل المصاريف)</h2>
            <p class="text-3xl font-extrabold text-blue-700">{{ number_format($totalProfit ?? 0, 2) }} ₺</p>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-sm border border-purple-200">
            <h2 class="text-sm font-semibold text-purple-800 uppercase tracking-wider mb-1">صافي الأرباح الدورية</h2>
            <p class="text-3xl font-extrabold text-purple-700">{{ number_format($net ?? 0, 2) }} ₺</p>
        </div>
    </div>

    {{-- قسم الرسم البياني --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-700">ملخص الأداء المالي والبياني ({{ date('Y') }})</h2>
        <div style="position: relative; height:280px; width:100%;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- نظام إدخال وإدارة القيود --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- قسم إدارة المصاريف --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold mb-4 text-red-700 border-b pb-2">📋 إدارة حركات المصاريف</h2>
            
            <form action="{{ url('/admin/expenses') }}" method="POST" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-600">البيان / الوصف</label>
                    <input type="text" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600">المبلغ (₺)</label>
                    <input type="number" name="amount" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-red-700 shadow-sm">إدراج مصروف</button>
                </div>
            </form>

            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="text-gray-500 border-b">
                        <th class="pb-2">البيان</th>
                        <th class="pb-2">المبلغ</th>
                        <th class="pb-2 text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentExpenses as $exp)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3">{{ $exp->description }}</td>
                        <td class="py-3 text-red-600 font-bold">{{ number_format($exp->amount, 2) }} ₺</td>
                        <td class="py-3 text-center">
                            <form action="{{ url('/admin/expenses/'.$exp->id) }}" method="POST" onsubmit="return confirm('حذف هذا القيد؟')">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-600 text-xs">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-4 text-gray-400">لا توجد مصاريف مسجلة حركياً.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- قسم إدارة رأس المال والشركاء --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold mb-4 text-yellow-700 border-b pb-2">💰 قيود رأس المال والتمويل</h2>
            
            <form action="{{ url('/admin/accounting/capital') }}" method="POST" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                @csrf
                <input type="hidden" name="transaction_date" value="{{ date('Y-m-d') }}">
                <div>
                    <label class="block text-xs font-medium text-gray-600">نوع الحركة / الشريك</label>
                    <input type="text" name="description" placeholder="مثال: ضخ رأس مال" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600">المبلغ (₺) <span class="text-gray-400">(- للسحب)</span></label>
                    <input type="number" name="amount" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-yellow-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-yellow-700 shadow-sm">تعديل رأس المال</button>
                </div>
            </form>

            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="text-gray-500 border-b">
                        <th class="pb-2">الحركة</th>
                        <th class="pb-2">المبلغ</th>
                        <th class="pb-2 text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($capitalTransactions as $cap)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3">{{ $cap->description }}</td>
                        <td class="py-3 {{ $cap->amount > 0 ? 'text-green-600' : 'text-red-500' }} font-bold">
                            {{ number_format($cap->amount, 2) }} ₺
                        </td>
                        <td class="py-3 text-center">
                            <form action="{{ url('/admin/accounting/capital/'.$cap->id) }}" method="POST" onsubmit="return confirm('حذف هذا القيد المالي؟')">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-600 text-xs">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-4 text-gray-400">لم يتم إدراج قيود رأس مال بعد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: JSON.parse('{!! json_encode($chartLabels) !!}'), 
            datasets: [{
                label: 'المبيعات الشهرية الفعلية (₺)',
                data: JSON.parse('{!! json_encode($chartData) !!}'), 
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endpush

@endsection
