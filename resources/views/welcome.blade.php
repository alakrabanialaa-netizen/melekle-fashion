@extends('layouts.app')

@section('content')
{{-- 🎨 MASTER STYLESHEET --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Fredoka:wght@400;600;700&display=swap');

    :root {
        --brand-pink: #f43f5e;
        --brand-pink-hover: #e11d48;
        --brand-amber: #f59e0b;
        --soft-cream: #fffaf0;
        --text-dark: #1f2937;
    }

    body { 
        font-family: 'Cairo', 'Fredoka', sans-serif; 
        background-color: var(--soft-cream); 
        color: var(--text-dark);
        overflow-x: hidden;
        padding-bottom: 60px;
    }

    h1, h2, h3, h4, h5, h6, .font-bold { font-weight: 700; }
    .font-black { font-weight: 900; }

    .hero-swiper {
        width: 100%;
        height: 75vh;
        min-height: 500px;
        border-radius: 0 0 50px 50px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }
    .swiper-slide {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: cover;
        background-position: center;
    }
    .slide-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to left, rgba(255, 250, 240, 0.1), rgba(255, 250, 240, 0.7));
    }
    .slide-content {
        position: relative;
        z-index: 10;
        max-width: 800px;
        text-align: right;
        padding: 0 2rem;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .swiper-slide-active .slide-content {
        opacity: 1;
        transform: translateY(0);
    }
    .hero-title {
        font-size: clamp(2rem, 5vw, 4rem);
        line-height: 1.2;
        margin-bottom: 1.5rem;
        color: var(--text-dark);
    }
    .hero-btn {
        display: inline-block;
        padding: 0.8rem 2.2rem;
        background-color: var(--brand-pink);
        color: white;
        border-radius: 15px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .swiper-pagination-bullet-active {
        background: var(--brand-pink) !important;
        width: 25px !important;
        border-radius: 5px !important;
    }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .scroll-reveal.visible { opacity: 1; transform: translateY(0); }
    @keyframes gradientMove { 0% { background-position: 0% } 100% { background-position: 200% } }
    @keyframes marquee { from { transform: translateX(0%); } to { transform: translateX(-50%); } }

    .lux-badge { letter-spacing: 0.2em; font-size: 13px; font-weight: 600; color: var(--brand-amber); }
    .lux-gradient {
        background: linear-gradient(90deg, var(--brand-amber), var(--brand-pink), var(--brand-amber));
        background-size: 200% 100%; -webkit-background-clip: text; color: transparent;
        animation: gradientMove 6s linear infinite;
    }

    .product-card-ty {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 24px;
        padding: 12px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .product-card-ty:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(244, 63, 94, 0.06);
        border-color: rgba(244, 63, 94, 0.15);
    }
    .ty-image-wrapper {
        width: 100%;
        aspect-ratio: 1 / 1;
        position: relative;
        background: #fdfdfd;
        overflow: hidden;
        border-radius: 18px;
    }
    .ty-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 18px;
        transition: transform 0.3s ease-out;
    }
    .ty-glass-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(255, 255, 255, 0.95) 45%, rgba(255, 255, 255, 0.3));
        backdrop-filter: blur(4px);
        opacity: 0;
        transform: translateY(100%);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 10;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 16px;
    }
    .product-card-ty:hover .ty-glass-overlay { opacity: 1; transform: translateY(0); }
    .ty-badge {
        position: absolute; top: 12px; left: 12px; background-color: var(--brand-pink);
        color: white; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; border-radius: 30px; z-index: 20;
    }
    .ty-wishlist-btn {
        position: absolute; top: 12px; right: 12px; width: 36px; height: 36px;
        border-radius: 50%; background-color: white; color: #6b7280;
        display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: all 0.2s ease; z-index: 20;
    }
    .ty-info-wrapper { padding: 12px 4px 4px; text-align: right; }
    .ty-title { font-size: 0.9rem; font-weight: 600; color: #374151; line-height: 1.4; }
    .ty-price-wrapper { display: flex; align-items: center; gap: 8px; flex-direction: row-reverse; justify-content: flex-start; margin-top: 6px; }
    .ty-final-price { font-size: 1.1rem; font-weight: 700; color: var(--brand-pink); }
    .ty-original-price { font-size: 0.85rem; color: #9ca3af; text-decoration: line-through; }

    .filter-bar {
        display: flex; align-items: center; background-color: #ffffff;
        border-radius: 16px; padding: 6px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid #e5e7eb;
    }
    .filter-input { width: 100%; border: none; padding: 12px 16px; font-weight: 600; color: #374151; }
    .apply-button { background-color: var(--brand-pink); color: white; font-weight: 700; padding: 12px 24px; border-radius: 12px; transition: all 0.2s ease; }

    /* --- إصلاح كود التقويم لضمان عدم تداخل التواريخ --- */
    .calendar-grid { 
        display: grid !important; 
        grid-template-cols: repeat(7, minmax(0, 1fr)) !important; 
        gap: 8px !important; 
        width: 100% !important; 
        direction: ltr !important; /* يضمن الترتيب السليم لخانة الأيام */
    }
    .calendar-day { 
        aspect-ratio: 1/1; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 0.85rem; 
        font-weight: 700; 
        border-radius: 50%; 
        transition: all 0.2s ease; 
        cursor: pointer; 
    }
    .calendar-day.active { 
        background-color: var(--brand-amber); 
        color: var(--text-dark); 
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4); 
    }

    .marquee-footer { position: fixed; bottom: 0; left: 0; width: 100%; background-color: #111827; color: white; z-index: 60; overflow: hidden; padding: 12px 0; }
    .marquee-inner-wrap { display: flex; width: fit-content; animation: marquee 30s linear infinite; }
    .marquee-content { display: flex; align-items: center; white-space: nowrap; }
    .marquee-content span { font-size: 0.85rem; opacity: 0.9; margin: 0 2rem; }

    @media (max-width: 768px) {
        .hero-swiper { height: 60vh; border-radius: 0 0 30px 30px; }
    }
</style>

{{-- 🚀 HERO SLIDER --}}
<div class="swiper hero-swiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide" style="background-image: url('https://files.manuscdn.com/user_upload_by_module/session_file/310519663166720664/MkdnFgIRAmlobtLe.png')">
            <div class="slide-overlay"></div>
            <div class="max-w-7xl mx-auto w-full px-6">
                <div class="slide-content">
                    <span class="lux-badge">NEW COLLECTION 2026</span>
                    <h1 class="hero-title font-black">عالم من <span class="text-rose-500">الأناقة</span> لصغيرك</h1>
                    <p class="hero-subtitle mb-8 text-gray-600">اكتشفي تشكيلتنا الجديدة من ملابس الأطفال المصنوعة بحب وعناية فائقة.</p>
                    <a href="#shop" class="hero-btn">تسوقي الآن 🛍️</a>
                </div>
            </div>
        </div>
        <div class="swiper-slide" style="background-image: url('https://files.manuscdn.com/user_upload_by_module/session_file/310519663166720664/tVwHaWhOrDBbxEvW.png')">
            <div class="slide-overlay"></div>
            <div class="max-w-7xl mx-auto w-full px-6">
                <div class="slide-content">
                    <span class="lux-badge">ARTISTIC TEXTURES</span>
                    <h1 class="hero-title font-black">تصاميم <span class="text-amber-500">عصرية</span> بلمسة فنية</h1>
                    <p class="hero-subtitle mb-8 text-gray-600">نمزج بين الراحة والجمال في كل قطعة، لنمنح أطفالك إطلالة فريدة.</p>
                    <a href="#collection" class="hero-btn">اكتشفي المزيد ✨</a>
                </div>
            </div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>

{{-- Features Section --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-12 py-20 text-center select-none max-w-7xl mx-auto px-6">
    <div class="group cursor-pointer">
        <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-2 border-dashed border-emerald-200 group-hover:rotate-12 transition-all duration-300 transform group-hover:scale-105">
            <span class="text-4xl">🍼</span>
        </div>
        <h3 class="font-black text-emerald-500 text-xl mb-3">About Product</h3>
        <p class="text-gray-400 text-sm px-6 leading-relaxed">ملابس خاصة صنعت بعناية فائقة لحديثي الولادة.</p>
    </div>
    <div class="group cursor-pointer">
        <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-2 border-dashed border-rose-200 group-hover:-rotate-12 transition-all duration-300 transform group-hover:scale-105">
            <span class="text-4xl">🧷</span>
        </div>
        <h3 class="font-black text-rose-500 text-xl mb-3">Our Experience</h3>
        <p class="text-gray-400 text-sm px-6 leading-relaxed">صنعت كل قطعة بحب وشغف مخصص لطفلكِ.</p>
    </div>
    <div class="group cursor-pointer">
        <div class="w-24 h-24 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-2 border-dashed border-sky-200 group-hover:rotate-12 transition-all duration-300 transform group-hover:scale-105">
            <span class="text-4xl">🪄</span>
        </div>
        <h3 class="font-black text-sky-500 text-xl mb-3">Big Fun for Kids!</h3>
        <p class="text-gray-400 text-sm px-6 leading-relaxed">مع كل قطعة من متجرنا ستحصل على هدية مميزة مخصصة.</p>
    </div>
</div>

{{-- Event & Calendar --}}
<div class="mt-16 py-20 text-white select-none relative" style="background-color: #f43f5e;">
    <div class="absolute top-0 left-0 right-0 h-4 bg-[radial-gradient(circle_at_bottom,_transparent_60%,_#fffaf0_65%)] bg-[length:16px_16px]"></div>
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row gap-12 items-center justify-between">
        <div class="md:w-1/2 space-y-6 text-right w-full order-2 md:order-1">
            <h2 class="text-3xl md:text-4xl font-black tracking-wide leading-tight text-white">April's Upcoming Event</h2>
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 md:p-8 border border-white/25 shadow-xl text-right">
                <div class="flex gap-4 text-xs md:text-sm mb-4 font-bold opacity-95 flex-row-reverse justify-start">
                    <span>📅 17.04.2026</span><span>⏰ 09:00 AM</span><span>📍 اسطنبول</span>
                </div>
                <p class="mb-6 leading-relaxed text-white/90 text-sm md:text-base">انضموا إلينا في فعاليتنا القادمة لربيع 2026، حيث سنقوم بالعديد من الأنشطة التفاعلية.</p>
                <div class="text-left"><a href="#" class="inline-block bg-white text-rose-500 font-bold px-6 py-3 rounded-2xl hover:bg-rose-50 transition-all shadow-md text-sm">معرفة المزيد</a></div>
            </div>
        </div>
        <div class="md:w-1/2 flex flex-col items-center w-full order-1 md:order-2">
            {{-- تم تعديل الحاوية هنا لضمان خلفية كرتونية بيضاء شفافة بحدود واضحة --}}
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20 w-full max-w-sm shadow-xl">
                <h3 class="text-xl font-black mb-6 text-center text-white">April 2026</h3>
                
                {{-- هيكل التقويم المقاوم لأي تداخل --}}
                <div style="direction: ltr; w-full">
                    <div style="display: flex; justify-content: space-between; text-align: center; font-weight: bold; margin-bottom: 12px; opacity: 0.9; color: white;">
                        <span style="width: 14%;">S</span><span style="width: 14%;">M</span><span style="width: 14%;">T</span><span style="width: 14%;">W</span><span style="width: 14%;">T</span><span style="width: 14%;">F</span><span style="width: 14%;">S</span>
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px 0;">
                        @for ($d = 1; $d <= 30; $d++)
                            <div style="width: 14%; display: flex; justify-content: center; align-items: center; margin-bottom: 4px;">
                                <div class="{{ $d == 17 ? 'active' : '' }}" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; font-size: 0.85rem; {{ $d == 17 ? 'background-color: #f59e0b; color: #1f2937; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4);' : 'color: white;' }}">
                                    {{ $d }}
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Products Grid Organized by Categories --}}
<section class="py-24" id="shop">
    <div class="max-w-screen-xl mx-auto px-6">
        
        {{-- شريط البحث الرئيسي في أعلى المتجر --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="text-right w-full md:w-auto">
                <span class="lux-badge block mb-2">COLLECTIONS</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">تشكيلاتنا <span class="lux-gradient">الساحرة</span> ✨</h2>
            </div>
            <div class="filter-bar w-full md:w-auto">
                <div class="filter-group flex w-full">
                    <input type="text" class="filter-input" placeholder="ابحث عن قطعة...">
                    <button class="apply-button">بحث</button>
                </div>
            </div>
        </div>

        {{-- حلقة التكرار الرئيسية على الأقسام --}}
        @forelse($categories as $category)
            {{-- لا نعرض القسم إلا إذا كان يحتوي على منتجات مضافة ومفعلة --}}
            @if($category->products->count() > 0)
                
                {{-- رأس القسم: يحتوي على اسم القسم وزر "عرض الكل" --}}
                <div class="flex justify-between items-end mb-8 border-b pb-4 border-gray-100 mt-12">
                    <div class="text-right">
                        <h3 class="text-2xl md:text-3xl font-black text-gray-800">{{ $category->category_name }}</h3>
                    </div>
                    <div>
                        {{-- الزر ينقل المستخدم لصفحة القسم الكاملة المربوطة بالـ ID --}}
                        <a href="{{ route('categories.show', $category->id) }}" class="apply-button text-xs md:text-sm inline-block px-4 py-2 rounded-xl transition-all">
                            عرض كل قطع {{ $category->category_name }} &larr;
                        </a>
                    </div>
                </div>

                {{-- شبكة عرض المنتجات (ستعرض 3 منتجات فقط تلقائياً بناءً على كود الـ Controller) --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-10 mb-12">
                    @foreach($category->products as $product)
                        <div class="product-card-ty group">
                            <div class="ty-image-wrapper">
                                @if($product->original_price > $product->price)
                                    <div class="ty-badge">خصم {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%</div>
                                @endif
                                <button class="ty-wishlist-btn"><i class="far fa-heart"></i></button>
                                
                                <a href="{{ route('product.show', $product->id) }}" class="block w-full h-full">
                                    <img loading="lazy" src="{{ $product->images->first() ? $product->images->first()->image : 'https://images.unsplash.com/photo-1515488042361-404e9250afef?q=80&w=400&auto=format&fit=crop' }}" class="ty-main-image group-hover:scale-105" alt="{{ $product->name }}">
                                </a>
                                
                                <div class="ty-glass-overlay">
                                    <button type="button" onclick="addToCart('{{ $product->id }}')" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 text-xs md:text-sm">
                                        <span>🛍️</span><span>أضف إلى السلة</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="ty-info-wrapper mt-3">
                                <a href="{{ route('product.show', $product->id) }}" class="hover:text-rose-500 transition-colors">
                                    <h3 class="ty-title text-gray-800 line-clamp-1 text-right">{{ $product->name }}</h3>
                                </a>
                                <div class="ty-price-wrapper mt-2">
                                    <span class="ty-final-price">{{ number_format($product->price, 2) }} ₺</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @endif
        @empty
            {{-- حالة عدم وجود أي أقسام أو منتجات بالموقع بالكامل --}}
            <div class="col-span-full text-center py-24 bg-white rounded-3xl border border-dashed border-gray-200 shadow-sm">
                <p class="text-gray-400 font-bold text-lg">لا توجد قطع أو أقسام معروضة حالياً!</p>
            </div>
        @endforelse

    </div>
</section>

{{-- Premium Section --}}
<section class="relative py-24 overflow-hidden bg-transparent select-none">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative group cursor-pointer overflow-hidden rounded-3xl shadow-md border-4 border-white">
                <img src="https://static.aljamila.com/styles/1100x732_scale/public/2018/12/20/2393901-1727507459.jpg" alt="Kids Premium Fashion" class="w-full h-[550px] object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/15 to-transparent"></div>
                <div class="absolute bottom-8 right-8 left-8 text-right text-white space-y-2">
                    <span class="inline-block bg-amber-500 text-white px-3 py-1 rounded-full text-xs font-bold tracking-wider">كشخة العيد ✨</span>
                    <h3 class="text-2xl md:text-3xl font-black leading-tight">أناقة أطفالكِ تبدأ من التفاصيل الصغيرة</h3>
                </div>
            </div>
            <div class="space-y-8 text-right">
                <div><span class="lux-badge block mb-2">MATCHING SET</span><h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">إطلالة كاملة <span class="lux-gradient">بضغطة واحدة</span> 🪄</h2></div>
                <button onclick="addToCart('premium-set')" class="w-full py-4 mt-4 bg-gradient-to-r from-amber-500 to-rose-500 text-white rounded-2xl font-black text-base md:text-lg shadow-lg hover:shadow-xl transition-all duration-300">شراء الإطلالة كاملة الآن — 420.00 ₺</button>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-gradient-to-b from-gray-900 to-black text-gray-300 pt-20 pb-10">
    <div class="max-w-screen-xl mx-auto px-6 text-center"><p class="text-gray-500 text-sm">© 2026 Melekler Fashion — جميع الحقوق محفوظة</p></div>
</footer>

<div class="marquee-footer">
    <div class="marquee-inner-wrap">
        <div class="marquee-content">
            <span>شحن مجاني للطلبات فوق 1000 ₺</span><i class="fas fa-star"></i>
            <span>خصم 10% على أول طلب</span><i class="fas fa-star"></i>
            <span>أحدث صيحات الموضة للأطفال 2026</span><i class="fas fa-star"></i>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
    });

    function reveal() {
        var reveals = document.querySelectorAll(".scroll-reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            if (elementTop < windowHeight - 150) reveals[i].classList.add("visible");
        }
    }
    window.addEventListener("scroll", reveal);
    reveal();

    // دالة محسنة لإرسال المنتج وفتح السلة بشكل فوري ومباشر
    function addToCart(productId) {
        // نرسل طلب الـ Ajax إلى مسار السلة الخاص بك لـ Laravel لكي يسجل المنتج فعلياً
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            // بعد نجاح الإضافة، نقوم بفتح نافذة السلة الجانبية لرؤية التحديث
            openCart();
            // إذا كان لديك دالة لتحديث العداد العلوي للسلة يمكنك استدعاؤها هنا (مثل updateCartCount())
        })
        .catch(error => {
            console.error('Error:', error);
            // حل بديل في حال لم يكن الـ Ajax مجهز بالخلفية لكي تفتح السلة على الأقل
            openCart(); 
        });
    }

    function openCart() {
        if (typeof window.parent.openCart === 'function') {
            window.parent.openCart();
        } else if (document.getElementById('mini-cart')) {
            document.getElementById('mini-cart').style.right = "0";
        }
    }
</script>
@endsection
