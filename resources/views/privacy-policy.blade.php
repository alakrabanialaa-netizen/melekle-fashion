@extends('layouts.app')

@section('content')

<div class="bg-white text-gray-900 py-24">

    <div class="max-w-4xl mx-auto px-6">

        <!-- TITLE -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-black mb-4">سياسة الخصوصية</h1>
            <p class="text-gray-500">نحن نحترم خصوصيتك ونحمي بياناتك</p>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 leading-relaxed text-lg">

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🔐 جمع المعلومات</h2>
                <p class="text-gray-600">
                    نقوم بجمع المعلومات التي تقدمها عند التسجيل أو الشراء مثل الاسم، البريد الإلكتروني، ورقم الهاتف.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">📊 استخدام المعلومات</h2>
                <p class="text-gray-600">
                    نستخدم بياناتك لتحسين خدماتنا، معالجة الطلبات، والتواصل معك بخصوص الطلبات والعروض.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🔒 حماية البيانات</h2>
                <p class="text-gray-600">
                    نلتزم بحماية بياناتك باستخدام أحدث وسائل الأمان ولا نقوم بمشاركتها مع أي طرف ثالث دون إذنك.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">🍪 ملفات تعريف الارتباط</h2>
                <p class="text-gray-600">
                    نستخدم ملفات الكوكيز لتحسين تجربة المستخدم وتحليل الأداء داخل الموقع.
                </p>
            </div>

            <!-- SECTION -->
            <div>
                <h2 class="text-2xl font-bold mb-3">⚖️ حقوق المستخدم</h2>
                <p class="text-gray-600">
                    يمكنك طلب تعديل أو حذف بياناتك في أي وقت من خلال التواصل معنا.
                </p>
            </div>

        </div>

        <!-- CONTACT -->
        <div class="mt-16 text-center">
            <p class="text-gray-500 mb-4">
                لأي استفسار حول الخصوصية
            </p>
            <a href="{{ route('contact') }}"
               class="inline-block px-8 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition">
                تواصل معنا
            </a>
        </div>

    </div>

</div>

@endsection