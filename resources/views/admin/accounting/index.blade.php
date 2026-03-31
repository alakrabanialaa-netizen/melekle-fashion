@extends('admin.layouts.app')

@section('page-title', 'المحاسبة')

@section('content')

{{-- تنبيه عن المخزون المنخفض --}}
@if(isset($lowStock) && $lowStock->count() > 0)
<div class="bg-red-200 text-red-800 p-4 rounded mb-4">
<strong>تنبيه:</strong> بعض المنتجات لديها مخزون منخفض!
<ul>
    @foreach($lowStock as $item)
<li>{{ $item->product->name ?? 'منتج مجهول' }} ({{ $item->quantity }} قطعة متبقية)</li>
    @endforeach
</ul>
</div>
@endif

<div class="container mx-auto p-6">

<h1 class="text-3xl font-bold mb-6">لوحة المعلومات المحاسبية</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

{{-- بطاقة رأس المال --}}
<div class="bg-yellow-100 p-6 rounded-lg shadow">
<h2 class="text-lg font-semibold mb-2">رأس المال</h2>
<p class="text-2xl font-bold text-yellow-700">
        {{ number_format($capital ?? 0, 2) }} ليرة تركية
</p>
</div>

{{-- بطاقة قيمة المخزون --}}
<div class="bg-gray-100 p-6 rounded-lg shadow">
<h2 class="text-lg font-semibold mb-2">قيمة المخزون الحالية</h2>
<p class="text-2xl font-bold text-gray-600">
        {{ number_format($inventoryValue ?? 0, 2) }} ليرة تركية
</p>
</div>

{{-- بطاقة إجمالي المبيعات --}}
<div class="bg-green-100 p-6 rounded-lg shadow">
<h2 class="text-lg font-semibold mb-2">إجمالي المبيعات</h2>
<p class="text-2xl font-bold text-green-600">
        {{ number_format($totalSales ?? 0, 2) }} ليرة تركية
</p>
</div>

{{-- بطاقة إجمالي المصاريف --}}
<div class="bg-red-100 p-6 rounded-lg shadow">
<h2 class="text-lg font-semibold mb-2">إجمالي المصاريف</h2>
<p class="text-2xl font-bold text-red-600">
        {{ number_format($totalExpenses ?? 0, 2) }} ليرة تركية
</p>
</div>

{{-- قسم الرسم البياني --}}
<div class="mt-8 bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">ملخص المبيعات الشهري ({{ date('Y') }})</h2>
    <div>
        <canvas id="salesChart"></canvas>
    </div>
</div>

{{-- بطاقة إجمالي الأرباح --}}
<div class="bg-blue-100 p-6 rounded-lg shadow">
<h2 class="text-lg font-semibold mb-2">إجمالي الأرباح (قبل المصاريف)</h2>
<p class="text-2xl font-bold text-blue-600">
        {{ number_format($totalProfit ?? 0, 2) }} ليرة تركية
</p>
</div>



{{-- بطاقة صافي الربح --}}
<div class="bg-purple-100 p-6 rounded-lg shadow">
<h2 class="text-lg font-semibold mb-2">صافي الربح</h2>
<p class="text-2xl font-bold text-purple-600">
        {{ number_format($net ?? 0, 2) }} ليرة تركية
</p>
</div>

</div>

</div>

{{-- =============================================== --}}
{{-- قسم إدارة المصاريف --}}
{{-- =============================================== --}}
<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- العمود الأول: نموذج إضافة مصروف --}}
    <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">إضافة مصروف جديد</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <strong>الرجاء إصلاح الأخطاء التالية:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.expenses.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                <input type="text" name="description" id="description" value="{{ old('description') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">المبلغ (ليرة تركية)</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="expense_date" class="block text-sm font-medium text-gray-700">التاريخ</label>
                <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    حفظ المصروف
                </button>
            </div>
        </form>
    </div>

    {{-- العمود الثاني: جدول آخر المصاريف --}}
    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">آخر المصاريف المسجلة</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-3 text-right text-sm font-semibold text-gray-600">الوصف</th>
                        <th class="py-2 px-3 text-right text-sm font-semibold text-gray-600">المبلغ</th>
                        <th class="py-2 px-3 text-right text-sm font-semibold text-gray-600">التاريخ</th>
                        <th class="py-2 px-3 text-center text-sm font-semibold text-gray-600">إجراءات</th>

                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($recentExpenses as $expense)
                        <tr class="border-t">
                            <td class="py-3 px-3 text-sm">{{ $expense->description }}</td>
                            <td class="py-3 px-3 text-sm text-red-600 font-medium">{{ number_format($expense->amount, 2) }} ₺</td>
                            <td class="py-3 px-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') }}</td>
                            <td class="py-3 px-3 text-sm text-center">
    <div class="flex item-center justify-center">
        {{-- زر التعديل --}}
        <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="w-6 mr-2 transform hover:text-purple-500 hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
        </a>
        {{-- زر الحذف --}}
        <form action="{{ route('admin.expenses.destroy', $expense->id ) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المصروف؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-6 mr-2 transform hover:text-red-500 hover:scale-110 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </form>
    </div>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-10 text-gray-500">
                                لم يتم تسجيل أي مصاريف بعد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts') {{-- أو استخدم @section('scripts') --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    const salesChart = new Chart(ctx, {
        type: 'bar', // يمكنك تغييره إلى 'line' لعرض مخطط خطي
        data: {
            labels: @json($chartLabels), // جلب أسماء الشهور من الـ Controller
            datasets: [{
                label: 'إجمالي المبيعات (ليرة تركية)',
                data: @json($chartData), // جلب بيانات المبيعات من الـ Controller
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // تنسيق الأرقام على المحور Y
                        callback: function(value, index, values) {
                            return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(value);
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush


@endsection
