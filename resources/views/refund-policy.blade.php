@extends('layouts.app')

@section('content')

<div class="bg-white text-gray-900 py-24">

    <div class="max-w-4xl mx-auto px-6">

        <!-- TITLE -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-black mb-4">سياسة الإرجاع</h1>
            <p class="text-gray-500">نهدف لتقديم أفضل تجربة تسوق لعملائنا</p>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 leading-relaxed text-lg">

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">📦 شروط الإرجاع</h2>
                <p class="text-gray-600">
                    يمكن إرجاع المنتجات خلال 14 يوم من تاريخ الاستلام بشرط أن تكون بحالتها الأصلية
                    وغير مستخدمة، مع وجود التغليف الأصلي.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🔄 الاستبدال</h2>
                <p class="text-gray-600">
                    يمكن استبدال المنتج في حال وجود عيب مصنعي أو في حال اختيار مقاس غير مناسب.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">💰 استرداد الأموال</h2>
                <p class="text-gray-600">
                    يتم استرداد المبلغ خلال 5-7 أيام عمل بعد استلام المنتج وفحصه.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🚚 رسوم الشحن</h2>
                <p class="text-gray-600">
                    يتحمل العميل رسوم الشحن في حال الإرجاع إلا إذا كان هناك خطأ من طرفنا.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">❌ حالات لا يمكن إرجاعها</h2>
                <ul class="list-disc pr-6 text-gray-600 space-y-2">
                    <li>المنتجات المستخدمة</li>
                    <li>المنتجات بدون تغليف</li>
                    <li>المنتجات المخفضة (حسب العرض)</li>
                </ul>
            </div>

        </div>

        <!-- CONTACT -->
        <div class="mt-16 text-center">
            <p class="text-gray-500 mb-4">
                لأي استفسار بخصوص الإرجاع
            </p>
            <a href="{{ route('contact') }}"
               class="inline-block px-8 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition">
                تواصل معنا
            </a>
        </div>

    </div>

</div>

@endsection