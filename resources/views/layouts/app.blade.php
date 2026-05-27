@extends('layouts.app')

@section('content')

{{-- 🎨 1. MASTER STYLESHEET & FONTS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Fredoka:wght@400;600;700&display=swap');

    /* --- الهوية البصرية والألوان الموحدة --- */
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
        padding-bottom: 60px; /* مساحة الفوتر المتحرك */
    }

    h1, h2, h3, h4, h5, h6, .font-bold { font-weight: 700; }
    .font-black { font-weight: 900; }

    /* --- تأثيرات الحركة والأنيميشن --- */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .scroll-reveal.visible { opacity: 1; transform: translateY(0); }

    @keyframes gradientMove { 0% { background-position: 0% } 100% { background-position: 200% } }
    @keyframes marquee { from { transform: translateX(0%); } to { transform: translateX(-50%); } }
    @keyframes float-huge { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-12px) scale(1.02); } }
    @keyframes blob {
        0%, 100% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }

    /* --- قسم الـ Hero والـ Badges الفاخرة --- */
    .hero-spotted-container {
        border: 12px solid white;
        border-radius: 50px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .hero-curved-container {
        border-radius: 38px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
    }
    .btn-rounded {
        padding: 12px 32px;
        border-radius: 999px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .btn-rounded:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(244, 63, 94, 0.3);
    }
    .lux-badge { letter-spacing: 0.2em; font-size: 13px; font-weight: 600; color: var(--brand-amber); }
    .lux-gradient {
        background: linear-gradient(90deg, var(--brand-amber), var(--brand-pink), var(--brand-amber));
        background-size: 200% 100%; -webkit-background-clip: text; color: transparent;
        animation: gradientMove 6s linear infinite;
    }

    /* --- كروت المنتجات الذكية السائلة --- */
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
    .ty-wishlist-btn:hover { color: var(--brand-pink); transform: scale(1.15); }
    .ty-info-wrapper { padding: 12px 4px 4px; text-align: right; }
    .ty-title { font-size: 0.9rem; font-weight: 600; color: #374151; line-height: 1.4; }
    .ty-price-wrapper { display: flex; align-items: center; gap: 8px; flex-direction: row-reverse; justify-content: flex-start; margin-top: 6px; }
    .ty-final-price { font-size: 1.1rem; font-weight: 700; color: var(--brand-pink); }
    .ty-original-price { font-size: 0.85rem; color: #9ca3af; text-decoration: line-through; }

    /* --- شريط التصفية والبحث الذكي --- */
    .filter-bar {
        display: flex; align-items: center; background-color: #ffffff;
        border-radius: 16px; padding: 6px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid #e5e7eb;
    }
    .filter-group { position: relative; display: flex; align-items: center; flex-grow: 1; }
    .filter-input { width: 100%; border: none; padding: 12px 44px 12px 16px; font-weight: 600; color: #374151; }
    .filter-input:focus { outline: none; }
    .apply-button {
        background-color: var(--brand-pink); color: white; font-weight: 700;
        padding: 12px 24px; border-radius: 12px; transition: all 0.2s ease;
    }
    .apply-button:hover { background-color: var(--brand-pink-hover); transform: scale(1.02); }

    /* --- سلايدر التقييمات اللانهائي --- */
    .reviews-slider { position: relative; overflow: hidden; width: 100%; padding: 10px 0; }
    .reviews-track { display: flex; width: max-content; animation: scrollReviews 35s linear infinite; gap: 24px; }
    .reviews-slider:hover .reviews-track { animation-play-state: paused; }
    @keyframes scrollReviews { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    .review-card {
        min-width: 310px; max-width: 310px; background: white; padding: 24px;
        border-radius: 24px; text-align: center; border: 1px solid #f3f4f6;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02); transition: transform 0.3s;
    }
    .review-card:hover { transform: translateY(-6px); }
    .review-img { width: 75px; height: 75px; border-radius: 50%; margin: 0 auto 12px; object-fit: cover; }
    .stars { color: #fbbf24; font-size: 16px; }

    /* --- الفوتر الإعلاني المتحرك --- */
    .marquee-footer {
        position: fixed; bottom: 0; left: 0; width: 100%;
        background-color: #111827; color: white; z-index: 60;
        overflow: hidden; padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.1);
    }
    .marquee-inner-wrap { display: flex; width: fit-content; animation: marquee 30s linear infinite; }
    .marquee-footer:hover .marquee-inner-wrap { animation-play-state: paused; }
    .marquee-content { display: flex; align-items: center; white-space: nowrap; }
    .marquee-content span { font-size: 0.85rem; opacity: 0.9; margin: 0 2rem; }
    .marquee-content i { margin: 0 1rem; }

    /* --- الشاشات الصغيرة والموبايل --- */
    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; gap: 8px; padding: 12px; }
        .filter-input { padding: 10px 40px 10px 12px; }
        .apply-button { width: 100%; text-align: center; }
        .hero-spotted-container { border-radius: 32px; padding: 16px; }
    }
</style>

{{-- 🚀 2. HTML CONTENT CONTENT START --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-6">
    
    {{-- 🔥 قسم الهيرو الاحترافي بالخلفية الجديدة من Supabase والـ Curved Box الداخلي --}}
    <div class="hero-spotted-container p-4 md:p-8" 
         style="background-image: url('https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/hero-bg.png'); background-repeat: no-repeat; background-size: cover; background-position: center;"> 
        
        <div class="hero-curved-container flex flex-col md:flex-row-reverse items-center p-8 md:p-16 gap-10">
            
            {{-- الطرف الأيسر: الصورة المدوّرة مع تأثيرات البلور للأطفال --}}
            <div class="w-full md:w-1/2 flex justify-center relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-amber-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob" style="animation-delay: 2s;"></div>
                
                <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&q=80&w=600" 
                     alt="Kids Premium" 
                     class="rounded-full w-64 h-64 md:w-80 md:h-80 object-cover border-8 border-white shadow-lg relative z-10">
            </div>

            {{-- الطرف الأيمن: النصوص الترحيبية الموزونة --}}
            <div class="w-full md:w-1/2 text-center md:text-right flex flex-col justify-center">
                <span class="lux-badge block mb-2">WELCOME TO MELEKLER KIDS</span>
                <h1 class="text-3xl md:text-5xl font-black text-gray-900 leading-tight mb-4">
                    FOR YOUR BEBE <br>
                    عالم من الأناقة <span class="lux-gradient">لطفلكِ الصغير</span> ✨
                </h1>
                <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-8">
                    متجر مختص لبيع ملابس الأطفال المريحة والحديثة التي تناسب كشخة وأناقة طفلكِ في كل الأوقات والمناسبات.
                </p>
                <div class="flex justify-center md:justify-start">
                    <a href="#shop" class="btn-rounded bg-pink-500 text-white shadow-lg">
                        تسوقي الأحدث الآن 🛍️
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- 🔎 3. شريط التصفية والبحث الذكي --}}
    <div class="my-12">
        <form action="#" method="GET" class="filter-bar">
            <div class="filter-group">
                <i class="fas fa-search absolute right-4 text-gray-400"></i>
                <input type="text" name="search" placeholder="ابحثي عن فستان، تيشيرت، أو طقم أطفال..." class="filter-input text-right" dir="rtl">
            </div>
            <button type="submit" class="apply-button">ابحث الآن</button>
        </form>
    </div>

    {{-- 🛍️ 4. شبكة المنتجات (Interactive Product Grid) --}}
    <div id="shop" class="my-12">
        <h2 class="text-2xl md:text-3xl font-black text-right mb-8 text-gray-800">✨ وصل حديثاً (أحدث الموديلات)</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            {{-- الكارت الأول --}}
            <div class="product-card-ty">
                <div class="ty-image-wrapper">
                    <span class="ty-badge">جديد</span>
                    <button class="ty-wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="https://images.unsplash.com/photo-1519457431-44ccd64a579b?q=80&w=500" alt="Product" class="ty-main-image">
                    <div class="ty-glass-overlay">
                        <button class="w-full bg-pink-500 text-white py-2 rounded-xl font-bold text-sm shadow mb-2"><i class="fas fa-shopping-cart ml-1"></i> أضف للسلة</button>
                        <button class="w-full bg-gray-900 text-white py-2 rounded-xl font-bold text-sm shadow">التفاصيل</button>
                    </div>
                </div>
                <div class="ty-info-wrapper">
                    <h3 class="ty-title">فستان دانتيل أبيض بناتي ناعم</h3>
                    <div class="ty-price-wrapper">
                        <span class="ty-final-price">349 ₺</span>
                        <span class="ty-original-price">499 ₺</span>
                    </div>
                </div>
            </div>

            {{-- الكارت الثاني --}}
            <div class="product-card-ty">
                <div class="ty-image-wrapper">
                    <span class="ty-badge bg-amber-500">الأكثر مبيعاً</span>
                    <button class="ty-wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?q=80&w=500" alt="Product" class="ty-main-image">
                    <div class="ty-glass-overlay">
                        <button class="w-full bg-pink-500 text-white py-2 rounded-xl font-bold text-sm shadow mb-2"><i class="fas fa-shopping-cart ml-1"></i> أضف للسلة</button>
                        <button class="w-full bg-gray-900 text-white py-2 rounded-xl font-bold text-sm shadow">التفاصيل</button>
                    </div>
                </div>
                <div class="ty-info-wrapper">
                    <h3 class="ty-title">تيشيرت ولادي كاجوال قطن 100%</h3>
                    <div class="ty-price-wrapper">
                        <span class="ty-final-price">189 ₺</span>
                    </div>
                </div>
            </div>

            {{-- الكارت الثالث --}}
            <div class="product-card-ty">
                <div class="ty-image-wrapper">
                    <button class="ty-wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="https://images.unsplash.com/photo-1622290319146-7b63df48a635?q=80&w=500" alt="Product" class="ty-main-image">
                    <div class="ty-glass-overlay">
                        <button class="w-full bg-pink-500 text-white py-2 rounded-xl font-bold text-sm shadow mb-2"><i class="fas fa-shopping-cart ml-1"></i> أضف للسلة</button>
                        <button class="w-full bg-gray-900 text-white py-2 rounded-xl font-bold text-sm shadow">التفاصيل</button>
                    </div>
                </div>
                <div class="ty-info-wrapper">
                    <h3 class="ty-title">طقم بيبى رضع شتوي متكامل</h3>
                    <div class="ty-price-wrapper">
                        <span class="ty-final-price">420 ₺</span>
                        <span class="ty-original-price">550 ₺</span>
                    </div>
                </div>
            </div>

            {{-- الكارت الرابع --}}
            <div class="product-card-ty">
                <div class="ty-image-wrapper">
                    <span class="ty-badge">خصم</span>
                    <button class="ty-wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=500" alt="Product" class="ty-main-image">
                    <div class="ty-glass-overlay">
                        <button class="w-full bg-pink-500 text-white py-2 rounded-xl font-bold text-sm shadow mb-2"><i class="fas fa-shopping-cart ml-1"></i> أضف للسلة</button>
                        <button class="w-full bg-gray-900 text-white py-2 rounded-xl font-bold text-sm shadow">التفاصيل</button>
                    </div>
                </div>
                <div class="ty-info-wrapper">
                    <h3 class="ty-title">فستان مخملي للأمومة والنساء</h3>
                    <div class="ty-price-wrapper">
                        <span class="ty-final-price">599 ₺</span>
                        <span class="ty-original-price">750 ₺</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🥰 5. شريط تقييمات العملاء اللانهائي المتحرك --}}
    <div class="my-16">
        <h2 class="text-2xl md:text-3xl font-black text-center mb-8 text-gray-800">💭 ماذا قالوا عن Melekler Kids؟</h2>
        <div class="reviews-slider">
            <div class="reviews-track" dir="rtl">
                {{-- التقييم 1 --}}
                <div class="review-card">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150" alt="User" class="review-img">
                    <div class="stars mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <h4 class="font-bold text-gray-800 text-sm mb-1">أم أحمد - جدة</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">"الخامات تجنن وناعمة جداً على بشرة بنتي، التوصيل كان سريع والتعامل راقي جداً."</p>
                </div>
                {{-- التقييم 2 --}}
                <div class="review-card">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150" alt="User" class="review-img">
                    <div class="stars mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <h4 class="font-bold text-gray-800 text-sm mb-1">أبو لارا - دبي</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">"كشخة الملابس وجودة التقفيل فوق الممتازة، والمقاسات دقيقة جداً ومطابقة للموقع."</p>
                </div>
                {{-- التقييم 3 --}}
                <div class="review-card">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=150" alt="User" class="review-img">
                    <div class="stars mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>
                    <h4 class="font-bold text-gray-800 text-sm mb-1">سارة م. - الرياض</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">"الموديلات حصرية وغير مكررة بالسوق، بنتي طلعت كأنها ملاك ببراند مِلكلر!"</p>
                </div>
                {{-- تكرار الكروت لضمان سلاسة حركة السلايدر اللانهائية --}}
                <div class="review-card">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150" alt="User" class="review-img">
                    <div class="stars mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <h4 class="font-bold text-gray-800 text-sm mb-1">أم أحمد - جدة</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">"الخامات تجنن وناعمة جداً على بشرة بنتي، التوصيل كان سريع والتعامل راقي جدا."</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- 📢 6. الفوتر الإعلاني السائل والمتحرك الثابت بالأسفل (Marquee Footer) --}}
<footer class="marquee-footer">
    <div class="marquee-inner-wrap">
        <div class="marquee-content">
            <span><i class="fas fa-truck-moving text-pink-500 ml-2"></i> شحن مجاني وسريع للطلبات فوق 1000 ₺</span>
            <span><i class="fas fa-percentage text-amber-500 ml-2"></i> خصم خاص 10% على أول طلب كود: FIRST10</span>
            <span><i class="fas fa-ribbon text-pink-500 ml-2"></i> جودة تركية فاخرة ومضمونة 100%</span>
            <span><i class="fas fa-star text-amber-500 ml-2"></i> دعم فني متكامل عبر الواتساب على مدار الساعة</span>
        </div>
        <div class="marquee-content">
            <span><i class="fas fa-truck-moving text-pink-500 ml-2"></i> شحن مجاني وسريع للطلبات فوق 1000 ₺</span>
            <span><i class="fas fa-percentage text-amber-500 ml-2"></i> خصم خاص 10% على أول طلب كود: FIRST10</span>
            <span><i class="fas fa-ribbon text-pink-500 ml-2"></i> جودة تركية فاخرة ومضمونة 100%</span>
            <span><i class="fas fa-star text-amber-500 ml-2"></i> دعم فني متكامل عبر الواتساب على مدار الساعة</span>
        </div>
    </div>
</footer>

@endsection
