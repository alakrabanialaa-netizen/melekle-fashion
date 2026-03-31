@extends('admin.layouts.app')

@section('page-title', 'إضافة مصروف جديد')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">إضافة مصروف جديد</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.expenses.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
        @csrf

        {{-- وصف المصروف --}}
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">وصف المصروف:</label>
            <input type="text" name="description" id="description" value="{{ old('description') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        {{-- قيمة المصروف --}}
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">المبلغ (ليرة تركية):</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        {{-- تاريخ المصروف --}}
        <div class="mb-6">
            <label for="expense_date" class="block text-gray-700 text-sm font-bold mb-2">تاريخ المصروف:</label>
            <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="flex items-center justify-start">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                حفظ المصروف
            </button>
            <a href="{{ route('admin.expenses.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">إلغاء</a>
        </div>
    </form>
</div>
@endsection
