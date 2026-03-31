@extends('layouts.app')

@section('content')
<main class="bg-[#fdfdfd] min-h-screen">
    
    {{-- 🌸 Header Section --}}
    <div class="container mx-auto px-4 pt-16 pb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-3 animate-fade-in">قسم الأمهات</h1>
        <div class="w-20 h-1 bg-orange-500 mx-auto mb-4 rounded-full"></div>
        <p class="text-gray-500 text-lg">أحدث التصاميم لصغيرتك الأنيقة ولأجلكِ أنتِ</p>
    </div>

    {{-- 📦 Product Grid Section --}}
    <div class="container mx-auto px-4 pb-24">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-8">
                @foreach($products as $product)
                    <div class="product-card-ty group">
                        <!-- رابط المنتج مع الصورة -->
                        <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden ty-image-wrapper">
                            <!-- شارة الخصم (اختياري) -->
                            @if($product->original_price > $product->price)
                                <span class="absolute top-2 right-2 z-10 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded">خصم %{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}</span>
                            @endif

                            <img src="{{ $product->images->first() ? asset('storage/'.$product->images->first()->image) : 'https://via.placeholder.com/400x600' }}" 
                                 class="ty-main-image" 
                                 alt="{{ $product->name }}">
                            
                            <!-- زر أضف للسلة يظهر عند الحوم (على الكمبيوتر ) -->
                            <div class="absolute inset-x-0 bottom-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-gradient-to-t from-black/50 to-transparent hidden md:block">
                                <button class="w-full bg-white text-gray-900 font-bold py-2 rounded-lg text-sm hover:bg-orange-500 hover:text-white transition-colors">
                                    أضف إلى السلة
                                </button>
                            </div>
                        </a>

                        <!-- معلومات المنتج -->
                        <div class="ty-info-wrapper">
                            <h3 class="ty-title mb-2">{{ $product->name }}</h3>
                            
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex flex-col">
                                    @if($product->original_price)
                                        <span class="ty-original-price text-xs text-gray-400 line-through">{{ number_format($product->original_price, 2) }} ₺</span>
                                    @endif
                                    <span class="ty-final-price text-orange-500 font-black text-lg">{{ number_format($product->price, 2) }} ₺</span>
                                </div>
                                <!-- أيقونة سلة صغيرة للجوال -->
                                <button class="md:hidden w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                    <i class="fas fa-shopping-cart text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- 🏜️ Empty State --}}
            <div class="text-center py-32 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <div class="text-6xl mb-6">🛍️</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">لا توجد منتجات حالياً</h3>
                <p class="text-gray-500 mb-8">نحن نعمل على إضافة تشكيلة جديدة قريباً، ابقوا بالقرب!</p>
                <a href="{{ url('/') }}" class="inline-block px-10 py-3 bg-gray-900 text-white font-bold rounded-full hover:bg-orange-500 transition-all">
                    العودة للرئيسية
                </a>
            </div>
        @endif
    </div>

    {{-- 🔻 Luxury Footer --}}
    <footer class="bg-gradient-to-b from-gray-900 to-black text-gray-300 pt-20 pb-10">
        <div class="max-w-screen-xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <!-- Logo & Social -->
                <div>
                    <h4 class="text-2xl font-black text-white mb-4 tracking-wide">MELEKLER GROUP</h4>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        متجرك الموثوق لأزياء الأطفال والنساء بتصاميم عصرية وجودة عالية تمنحك تجربة تسوق مميزة.
                    </p>
                    <div class="flex gap-4 mt-6 text-xl">
                        <a href="https://www.instagram.com/meleklerkids/" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.facebook.com/MELEKLERKIDSTR" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-facebook"></i></a>
                        <a href="https://api.whatsapp.com/message/CL67ADRC7PMFO1" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Shop Links -->
                <div>
                    <h5 class="font-bold text-white mb-5 text-lg">التسوق</h5>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">وصل حديثاً</a></li>
                        <li><a href="{{ route('category.boys' ) }}" class="hover:text-white transition">ملابس أطفال</a></li>
                        <li><a href="{{ route('category.mothers') }}" class="hover:text-white transition">ملابس نساء</a></li>
                        <li><a href="#" class="hover:text-white transition">التخفيضات</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div>
                    <h5 class="font-bold text-white mb-5 text-lg">خدمة العملاء</h5>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">اتصل بنا</a></li>
                        <li><a href="#" class="hover:text-white transition">الأسئلة الشائعة</a></li>
                        <li><a href="#" class="hover:text-white transition">سياسة الإرجاع</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h5 class="font-bold text-white mb-5 text-lg">اشترك في العروض</h5>
                    <p class="text-gray-400 mb-4 text-xs">احصل على أحدث الخصومات مباشرة إلى بريدك.</p>
                    <div class="flex">
                        <input type="email" placeholder="بريدك الإلكتروني" class="w-full px-4 py-2 rounded-r-xl bg-gray-800 border border-gray-700 text-white text-sm focus:outline-none">
                        <button class="px-5 bg-orange-500 text-white rounded-l-xl hover:bg-orange-600 transition font-bold text-sm">اشترك</button>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs">
                <p class="text-gray-500">© 2026 Melekler Fashion — جميع الحقوق محفوظة</p>
                <p class="text-gray-600">CREATED BY ALAA ALAKRABANI</p>
            </div>
        </div>
    </footer>
</main>

{{-- 🎨 Stylesheet --}}
<style>
    .product-card-ty {
        background: white;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
    }

    .product-card-ty:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #f97316;
    }

    .ty-image-wrapper {
        aspect-ratio: 2/3; /* النسبة الذهبية لصور Trendyol */
        background: #f9fafb;
    }

    .ty-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card-ty:hover .ty-main-image {
        transform: scale(1.08);
    }

    .ty-info-wrapper {
        padding: 15px;
        text-align: right;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .ty-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        line-height: 1.4;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.8s ease-out both; }
</style>
@endsection