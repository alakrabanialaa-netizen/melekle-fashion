@extends('admin.layouts.app')

@section('page-title', 'تعديل المنتج: ' . $product->name)

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

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-lg space-y-8">
        @csrf
        @method('PUT')

        {{-- ================================================== --}}
        {{-- 1. المعلومات الأساسية (في عمودين) --}}
        {{-- ================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-8">
            {{-- اسم المنتج --}}
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">اسم المنتج</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>

            {{-- القسم (Category) --}}
            <div>
                <label for="category" class="block text-sm font-bold text-gray-700 mb-2">القسم</label>
                <select name="category" id="category" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                    <option value="">-- اختر القسم --</option>
                    {{-- يتم اختيار القسم الحالي للمنتج تلقائياً --}}
                    <option value="girls" @if(old('category', $product->category) == 'girls') selected @endif>بنات</option>
                    <option value="boys" @if(old('category', $product->category) == 'boys') selected @endif>أولاد</option>
                    <option value="babies" @if(old('category', $product->category) == 'babies') selected @endif>رضع</option>
                    <option value="mothers" @if(old('category', $product->category) == 'mothers') selected @endif>نسائي</option>
                </select>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- 2. الأسعار والمخزون (في ثلاثة أعمدة) --}}
        {{-- ================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b pb-8">
            {{-- ✅ السعر الأصلي (قبل الخصم) --}}
            <div>
                <label for="original_price" class="block text-sm font-bold text-gray-700 mb-2">السعر الأصلي (قبل الخصم)</label>
                <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $product->original_price) }}" step="0.01" class="w-full px-4 py-2 border rounded-lg" placeholder="مثال: 150">
                <p class="text-xs text-gray-500 mt-1">اتركه فارغاً إذا لم يكن هناك خصم.</p>
            </div>

            {{-- السعر النهائي (بعد الخصم) --}}
            <div>
                <label for="price" class="block text-sm font-bold text-gray-700 mb-2">السعر النهائي (بعد الخصم)</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- سعر التكلفة --}}
            <div>
                <label for="cost_price" class="block text-sm font-bold text-gray-700 mb-2">سعر التكلفة</label>
                <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price', $product->cost_price) }}" step="0.01" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- 3. الشارة والمخزون --}}
        {{-- ================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-8">
            {{-- ✅ نص الشارة (Badge) --}}
            <div>
                <label for="badge_text" class="block text-sm font-bold text-gray-700 mb-2">نص الشارة (اختياري)</label>
                <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text', $product->badge_text) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="مثال: شحن مجاني, الأكثر مبيعاً">
                <p class="text-xs text-gray-500 mt-1">اتركه فارغاً لحساب الخصم تلقائياً.</p>
            </div>

            {{-- المخزون --}}
            <div>
                <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">الكمية في المخزون</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- 4. المقاسات والألوان --}}
        {{-- ================================================== --}}
        {{-- (يمكنك إضافة هذه الحقول هنا بنفس الطريقة إذا أردت) --}}
        
        {{-- ================================================== --}}
        {{-- 5. الوصف والصور --}}
        {{-- ================================================== --}}
        <div class="space-y-6 border-b pb-8">
            {{-- وصف المنتج --}}
            <div>
                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">شرح المنتج</label>
                <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- صور المنتج --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">إضافة صور جديدة (اختياري)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border rounded-lg p-2">
                <p class="text-xs text-gray-500 mt-2">
                    الصور الحالية للمنتج (يمكنك حذفها من صفحة عرض كل المنتجات لاحقاً).
                </p>
                <div class="flex gap-4 mt-4">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/'.$image->image) }}" class="w-24 h-24 object-cover rounded-lg">
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- 6. أزرار الحفظ والإلغاء --}}
        {{-- ================================================== --}}
        <div class="flex items-center gap-4">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                حفظ التعديلات
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-8 py-3 rounded-lg border font-bold text-gray-600 hover:bg-gray-100 transition">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
