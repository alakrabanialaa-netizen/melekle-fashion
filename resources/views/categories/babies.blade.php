@extends('layouts.app')

@section('content')
<main class="container mx-auto px-4 py-12">
    
    {{-- عنوان الصفحة --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-black">قسم البنات</h1>
        <p class="text-gray-500 mt-2">أحدث التصاميم لصغيرتك الأنيقة</p>
    </div>

    {{-- شبكة عرض المنتجات --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                {{-- هنا يمكنك لصق كود كرت المنتج الذي تفضله --}}
                {{-- مثال: استخدام كرت Trendyol --}}
                <div class="product-card-ty">
                    <a href="{{ route("products.show", $product) }}">

                        <div class="ty-image-wrapper">
                            <img src="{{ $product->images->first() ? asset('storage/'.$product->images->first()->image) : 'https://via.placeholder.com/300' }}" class="ty-main-image" alt="{{ $product->name }}">
                        </div>
                    </a>
                    <div class="ty-info-wrapper">
                        <h3 class="ty-title">{{ $product->name }}</h3>
                        <div class="ty-price-wrapper">
                            @if($product->original_price )
                                <span class="ty-original-price">{{ number_format($product->original_price, 2) }} ₺</span>
                            @endif
                            <span class="ty-final-price">{{ number_format($product->price, 2) }} ₺</span>
                        </div>
                    </div>
                    <button class="ty-add-to-cart">أضف إلى السلة</button>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">لا توجد منتجات في هذا القسم حالياً.</p>
        </div>
    @endif
    {{-- 🔻 Luxury Footer --}}
<footer class="bg-gradient-to-b from-gray-900 to-black text-gray-300 pt-20 pb-10">

    <div class="max-w-screen-xl mx-auto px-6">

        <div class="grid md:grid-cols-4 gap-12 mb-16">

            <!-- Logo -->
            <div>
                <h4 class="text-2xl font-black text-white mb-4 tracking-wide">
                    MELEKLER GROUP
                </h4>

                <p class="text-gray-400 leading-relaxed">
                    متجرك الموثوق لأزياء الأطفال والنساء بتصاميم عصرية
                    وجودة عالية تمنحك تجربة تسوق مميزة.
                </p>

                <div class="flex gap-4 mt-6 text-xl">
                    <a href="https://www.instagram.com/meleklerkids/" target="_blank" rel="noopener noreferrer" class="hover:text-orange-500 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/MELEKLERKIDSTR" target="_blank" rel="noopener noreferrer" class="hover:text-orange-500 transition">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://api.whatsapp.com/message/CL67ADRC7PMFO1?autoload=1&app_absent=0" target="_blank" rel="noopener noreferrer" class="hover:text-orange-500 transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>


            <!-- Shop -->
            <div>
                <h5 class="font-bold text-white mb-5 text-lg">
                    التسوق
                </h5>

                <ul class="space-y-3 text-gray-400">

                    <li>
                        <a href="#" class="hover:text-white transition">
                            وصل حديثاً
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('category.boys') }}" class="hover:text-white transition">
                            ملابس أطفال
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('category.mothers') }}" class="hover:text-white transition">
                            ملابس نساء
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-white transition">
                            التخفيضات
                        </a>
                    </li>

                </ul>
            </div>


            <!-- Support -->
            <div>
                <h5 class="font-bold text-white mb-5 text-lg">
                    خدمة العملاء
                </h5>

                <ul class="space-y-3 text-gray-400">

                    <li><a href="#" class="hover:text-white transition">اتصل بنا</a></li>
                    <li><a href="#" class="hover:text-white transition">الأسئلة الشائعة</a></li>
                    <li><a href="#" class="hover:text-white transition">سياسة الإرجاع</a></li>
                    <li><a href="#" class="hover:text-white transition">سياسة الخصوصية</a></li>

                </ul>
            </div>


            <!-- Newsletter -->
         <div>
    <h5 class="font-bold text-white mb-5 text-lg">
        اشترك في العروض
    </h5>
    <p class="text-gray-400 mb-4 text-sm">
        احصل على أحدث الخصومات والعروض الحصرية مباشرة إلى بريدك.
    </p>
    <a href="mailto:meleklerkids@gmail.com?subject=اشتراك%20جديد&body=أود%20الاشتراك%20في%20العروض%20الخاصة."
       class="flex">
        <input type="email"
               placeholder="بريدك الإلكتروني"
               class="w-full px-4 py-3 rounded-l-xl bg-gray-800 border border-gray-700 text-white focus:outline-none"
               readonly> <!-- جعل الحقل للقراءة فقط لأنه لن يرسل البيانات مباشرة -->
        <button class="px-5 bg-orange-500 rounded-r-xl hover:bg-orange-600 transition">
            اشتراك
        </button>
    </a>
</div>
</div>



        <!-- Bottom -->
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">

            <p class="text-gray-500 text-sm">
                © 2026 Melekler Fashion — جميع الحقوق محفوظة
            </p>

            <p class="text-gray-600 text-xs">
                CREATED BY ALAA ALAKRABANI
            </p>

        </div>

    </div>

</footer>
</main>
@endsection
