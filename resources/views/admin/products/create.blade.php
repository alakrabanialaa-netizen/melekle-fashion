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

    {{-- تم تصحيح وسم الفورم هنا --}}
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-lg space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">

            {{-- 1. المعلومات الأساسية --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-8">
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">اسم المنتج</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                </div>

                <div>
                    <label for="category" class="block text-sm font-bold text-gray-700 mb-2">القسم</label>
                    <select name="category" id="category" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                        <option value="">-- اختر القسم --</option>
                        <option value="girls" {{ old('category') == 'girls' ? 'selected' : '' }}>بنات</option>
                        <option value="boys" {{ old('category') == 'boys' ? 'selected' : '' }}>أولاد</option>
                        <option value="babies" {{ old('category') == 'babies' ? 'selected' : '' }}>رضع</option>
                        <option value="mothers" {{ old('category') == 'mothers' ? 'selected' : '' }}>أمهات</option>
                    </select>
                </div>
            </div>

            {{-- 2. الأسعار --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b pb-8">
                <div>
                    <label for="original_price" class="block text-sm font-bold text-gray-700 mb-2">السعر الأصلي</label>
                    <input type="number" name="original_price" id="original_price" value="{{ old('original_price') }}" step="0.01" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 mb-2">السعر النهائي</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label for="cost_price" class="block text-sm font-bold text-gray-700 mb-2">سعر التكلفة</label>
                    <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" step="0.01" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
            </div>

            {{-- 3. الشارة والمخزون --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-8">
                <div>
                    <label for="badge_text" class="block text-sm font-bold text-gray-700 mb-2">نص الشارة</label>
                    <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text') }}" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">الكمية</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
            </div>

            {{-- 4. الوصف والملفات --}}
            <div class="space-y-6 border-b pb-8">
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">شرح المنتج</label>
                    <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">صور المنتج (تعدد الصور متاح)</label>
                    <input type="file" name="images[]" multiple required accept="image/*" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label for="video" class="block text-sm font-bold text-gray-700 mb-2">فيديو المنتج (اختياري)</label>
                    <input type="file" name="video" id="video" accept="video/mp4,video/webm" class="w-full border rounded-lg p-2 bg-gray-50">
                </div>
            </div>

            {{-- 5. الأزرار --}}
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
