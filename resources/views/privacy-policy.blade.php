@extends('layouts.app')

@section('content')

<div class="bg-white text-gray-900 py-24">

    <div class="max-w-4xl mx-auto px-6">

        <!-- TITLE -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-black mb-4">سياسة الاستبدال والاسترجاع</h1>
            <p class="text-gray-500">رضاكم هو أولويتنا، تعرف على شروط استرجاع المنتجات</p>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 leading-relaxed text-lg">

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🕒 الفترة الزمنية</h2>
                <p class="text-gray-600">
                    يمكنك طلب استبدال أو استرجاع المنتج خلال **7 أيام** من تاريخ استلام الطلب، بشرط أن يكون المنتج بحالته الأصلية.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">📦 شروط الاسترجاع</h2>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>يجب أن يكون المنتج غير مستخدم وفي تغليفه الأصلي.</li>
                    <li>يجب إرفاق فاتورة الشراء أو رقم الطلب.</li>
                    <li>المنتجات التي تم التلاعب بها أو إزالة ملصقاتها الأصلية لا يمكن استرجاعها.</li>
                </ul>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">💰 آلية استرداد الأموال</h2>
                <p class="text-gray-600">
                    عند قبول طلب الاسترجاع، سيتم تحويل المبلغ إلى حسابك البنكي أو وسيلة الدفع الأصلية خلال **5 إلى 10 أيام عمل** بعد فحص المنتج.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🚚 رسوم الشحن</h2>
                <p class="text-gray-600">
                    في حال كان المنتج تالفاً أو به خطأ من طرفنا، نتحمل كامل تكاليف الشحن. أما في حال رغبة العميل بالتبديل دون وجود عيب، يتحمل العميل تكاليف الشحن ذهاباً وإياباً.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🚫 منتجات لا يمكن استرجاعها</h2>
                <p class="text-gray-600">
                    لأسباب صحية، لا يمكن استبدال أو استرجاع الملابس الداخلية، أو المنتجات التي تم تصنيعها بناءً على طلب خاص بمواصفات محددة.
                </p>
            </div>

        </div>

        <!-- CONTACT -->
        <div class="mt-16 text-center">
            <p class="text-gray-500 mb-4">
                هل لديك استفسار بخصوص عملية الاسترجاع؟
            </p>
            <a href="{{ route('contact') }}"
               class="inline-block px-8 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition">
                ابدأ طلب استرجاع
            </a>
        </div>

    </div>

</div>

@endsection
