@extends('admin.layouts.app')

@section('page-title', 'تعديل المصروف')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">تعديل المصروف</h1>

    <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
        @csrf
        @method('PUT') {{-- مهم جداً لعملية التحديث --}}

        {{-- وصف المصروف --}}
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">الوصف:</label>
            <input type="text" name="description" id="description" value="{{ old('description', $expense->description) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        {{-- قيمة المصروف --}}
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">المبلغ (ليرة تركية):</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        {{-- تاريخ المصروف --}}
        <div class="mb-6">
            <label for="expense_date" class="block text-gray-700 text-sm font-bold mb-2">التاريخ:</label>
            <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', $expense->expense_date) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="flex items-center justify-start">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                حفظ التعديلات
            </button>
            <a href="{{ route('admin.accounting.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">إلغاء</a>
        </div>
    </form>
</div>
@endsection
