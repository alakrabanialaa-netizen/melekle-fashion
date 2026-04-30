@extends('admin.layouts.app')

@section('page-title', 'إضافة منتج جديد')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- رسائل الأخطاء --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6" role="alert">
            <p class="font-bold">الرجاء إصلاح الأخطاء التالية:</p>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-lg space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">

            {{-- 1. المعلومات الأساسية --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-8">
                <div>
                    <label for="product_name" class="block text-sm font-bold text-gray-700 mb-2">اسم المنتج</label>
                    <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                </div>

                <div>
                    <label for="product_category" class="block text-sm font-bold text-gray-700 mb-2">القسم</label>
                    <select name="product_category" id="product_category" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                        <option value="">-- اختر القسم --</option>
                        <option value="girls" {{ old('product_category') == 'girls' ? 'selected' : '' }}>بنات</option>
                        <option value="boys" {{ old('product_category') == 'boys' ? 'selected' : '' }}>أولاد</option>
                        <option value="babies" {{ old('product_category') == 'babies' ? 'selected' : '' }}>رضع</option>
                        <option value="mothers" {{ old('product_category') == 'mothers' ? 'selected' : '' }}>أمهات</option>
                    </select>
                </div>
            </div>

            {{-- 2. الأسعار والمخزون --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-8">
                <div>
                    <label for="product_price" class="block text-sm font-bold text-gray-700 mb-2">السعر النهائي</label>
                    <input type="number" name="product_price" id="product_price" value="{{ old('product_price') }}" step="0.01" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label for="product_stock" class="block text-sm font-bold text-gray-700 mb-2">الكمية في المخزون</label>
                    <input type="number" name="product_stock" id="product_stock" value="{{ old('product_stock') }}" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>

            {{-- 3. الوصف والملفات --}}
            <div class="space-y-6 border-b pb-8">
                <div>
                    <label for="product_description" class="block text-sm font-bold text-gray-700 mb-2">شرح المنتج</label>
                    <textarea name="product_description" id="product_description" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('product_description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">صور المنتج</label>
                    <input type="file" name="images[]" multiple required accept="image/*" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label for="video" class="block text-sm font-bold text-gray-700 mb-2">فيديو المنتج (اختياري)</label>
                    <input type="file" name="video" id="video" accept="video/mp4,video/webm" class="w-full border rounded-lg p-2 bg-gray-50">
                </div>
            </div>

            {{-- 4. الأزرار --}}
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                    حفظ المنتج
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-8 py-3 rounded-lg border font-bold text-gray-600 hover:bg-gray-100 transition">
                    إلغاء
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
