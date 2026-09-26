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

    .marquee-footer { position: fixed; bottom: 0; left: 0; width: 100%; background-color: #111827; color: white; z-index: 60; overflow: hidden; padding: 12px 0; }
    .marquee-inner-wrap { display: flex; width: fit-content; animation: marquee 30s linear infinite; }
    .marquee-content { display: flex; align-items: center; white-space: nowrap; }
    .marquee-content span { font-size: 0.85rem; opacity: 0.9; margin: 0 2rem; }

    @media (max-width: 768px) {
        .hero-swiper { height: 60vh; border-radius: 0 0 30px 30px; }
    }
</style>


{{-- ✨ PREMIUM CATEGORY CIRCLES (تظهر مباشرة تحت النافر) --}}
<style>
    .category-strip {
        position: relative;
        z-index: 20;
        padding: 22px 16px 24px;
        background:
            radial-gradient(circle at 12% 0%, rgba(244,63,94,.09), transparent 30%),
            radial-gradient(circle at 88% 100%, rgba(245,158,11,.10), transparent 28%),
            #fffaf0;
        border-bottom: 1px solid rgba(31,41,55,.07);
    }
    .category-panel {
        max-width: 1220px;
        margin: 0 auto;
        padding: 18px 20px 20px;
        border: 1px solid rgba(255,255,255,.95);
        border-radius: 30px;
        background: rgba(255,255,255,.74);
        box-shadow: 0 18px 45px rgba(31,41,55,.08), inset 0 1px 0 rgba(255,255,255,.9);
        backdrop-filter: blur(14px);
    }
    .category-heading {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin: 0 0 17px;
        color: #1f2937;
        font-size: .82rem;
        font-weight: 900;
        letter-spacing: .08em;
    }
    .category-heading::before,
    .category-heading::after {
        content: '';
        width: min(110px, 15vw);
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(244,63,94,.35));
    }
    .category-heading::after { transform: rotate(180deg); }
    .category-scroll {
        display: flex;
        align-items: flex-start;
        justify-content: space-evenly;
        gap: 16px;
        overflow-x: auto;
        scrollbar-width: none;
        padding: 5px 4px 3px;
    }
    .category-scroll::-webkit-scrollbar { display: none; }
    .category-item {
        position: relative;
        flex: 0 0 104px;
        color: #374151;
        text-align: center;
        text-decoration: none;
        transition: transform .35s cubic-bezier(.16,1,.3,1), color .25s ease;
    }
    .category-item:hover { transform: translateY(-7px); color: var(--brand-pink); }
    .category-orbit {
        position: relative;
        width: 82px;
        height: 82px;
        padding: 3px;
        margin: 0 auto 9px;
        border-radius: 50%;
        background: conic-gradient(from 210deg, #f59e0b, #f43f5e, #a855f7, #f59e0b);
        box-shadow: 0 8px 20px rgba(244,63,94,.16);
        transition: transform .35s ease, box-shadow .35s ease;
    }
    .category-orbit::before {
        content: '';
        position: absolute;
        inset: -5px;
        border: 1px solid rgba(244,63,94,.18);
        border-radius: inherit;
        transform: scale(.92);
        transition: transform .35s ease, border-color .35s ease;
    }
    .category-item:hover .category-orbit {
        transform: scale(1.07) rotate(5deg);
        box-shadow: 0 14px 28px rgba(244,63,94,.28);
    }
    .category-item:hover .category-orbit::before {
        transform: scale(1.08);
        border-color: rgba(244,63,94,.45);
    }
    .category-icon {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        border: 4px solid #fffaf0;
        border-radius: inherit;
        background: linear-gradient(145deg, #ffffff, #fff5f4);
        color: var(--brand-pink);
        font-size: 27px;
        box-shadow: inset 0 0 0 1px rgba(31,41,55,.04);
    }
    .category-name {
        display: block;
        font-size: .78rem;
        font-weight: 900;
        line-height: 1.4;
        white-space: nowrap;
    }
    .category-note {
        display: block;
        margin-top: 3px;
        color: #9ca3af;
        font-size: .58rem;
        font-weight: 700;
    }
    .category-item::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: -8px;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--brand-pink);
        opacity: 0;
        transform: translateX(-50%) scale(.4);
        transition: opacity .25s ease, transform .25s ease;
    }
    .category-item:hover::after { opacity: 1; transform: translateX(-50%) scale(1); }
    @media (max-width: 768px) {
        .category-strip { padding: 14px 9px 17px; }
        .category-panel { padding: 16px 8px 17px; border-radius: 24px; }
        .category-heading { margin-bottom: 14px; font-size: .73rem; }
        .category-scroll { justify-content: flex-start; gap: 18px; padding-inline: 8px; }
        .category-item { flex-basis: 82px; }
        .category-orbit { width: 68px; height: 68px; }
        .category-icon { font-size: 23px; border-width: 3px; }
        .category-note { display: none; }
    }
</style>

<style>
    /* Instagram-style story circles: fixed, perfectly round and never compressed */
    .category-strip .category-scroll {
        align-items: flex-start !important;
        justify-content: center !important;
        flex-wrap: nowrap !important;
    }
    .category-strip .category-item {
        flex: 0 0 104px !important;
        width: 104px !important;
        min-width: 104px !important;
    }
    .category-strip .category-orbit {
        display: block !important;
        width: 84px !important;
        min-width: 84px !important;
        height: 84px !important;
        min-height: 84px !important;
        aspect-ratio: 1 / 1 !important;
        padding: 3px !important;
        margin: 0 auto 10px !important;
        border-radius: 50% !important;
        background: conic-gradient(from 220deg, #f7b731, #f43f5e 38%, #c026d3 68%, #f7b731) !important;
        box-shadow: 0 0 0 2px #fff, 0 7px 20px rgba(244,63,94,.22) !important;
    }
    .category-strip .category-orbit::before {
        inset: -5px !important;
        width: auto !important;
        height: auto !important;
        border-radius: 50% !important;
        border: 1px solid rgba(244,63,94,.28) !important;
    }
    .category-strip .category-icon {
        display: flex !important;
        width: 100% !important;
        height: 100% !important;
        min-height: 0 !important;
        border-radius: 50% !important;
        border: 4px solid #fffaf0 !important;
        background: linear-gradient(145deg, #fff, #fff1f4) !important;
        font-size: 27px !important;
    }
    .category-strip .category-name { font-size: .8rem !important; }
    @media (max-width: 768px) {
        .category-strip .category-scroll {
            justify-content: flex-start !important;
            overflow-x: auto !important;
            padding: 6px 8px 8px !important;
        }
        .category-strip .category-item { width: 82px !important; min-width: 82px !important; flex-basis: 82px !important; }
        .category-strip .category-orbit { width: 70px !important; min-width: 70px !important; height: 70px !important; min-height: 70px !important; }
        .category-strip .category-icon { font-size: 23px !important; }
    }
    .hero-offer-card {
        position: absolute;
        z-index: 12;
        left: clamp(24px, 6vw, 92px);
        bottom: 118px;
        display: flex;
        align-items: center;
        gap: 12px;
        max-width: 245px;
        padding: 12px 16px;
        border: 1px solid rgba(255,255,255,.32);
        border-radius: 18px;
        background: rgba(17,24,39,.38);
        box-shadow: 0 14px 30px rgba(0,0,0,.16);
        color: #fff;
        backdrop-filter: blur(12px);
    }
    .hero-offer-icon {
        display: grid;
        place-items: center;
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f59e0b, #f43f5e);
        font-size: 17px;
    }
    .hero-offer-card strong { display: block; font-size: .8rem; }
    .hero-offer-card span { display: block; margin-top: 2px; color: rgba(255,255,255,.76); font-size: .68rem; }
    @media (max-width: 768px) {
        .hero-offer-card { left: 18px; bottom: 112px; max-width: 205px; padding: 10px 12px; }
        .hero-offer-icon { width: 32px; height: 32px; flex-basis: 32px; font-size: 14px; }
    }
</style>

<section class="category-strip" dir="rtl" aria-label="تصفح الأقسام">
    <div class="category-panel">
        <h2 class="category-heading">تسوّقي حسب القسم</h2>
        <div class="category-scroll">
            <a href="{{ Route::has('category.boys') ? route('category.boys') : '/category/boys' }}" class="category-item">
                <span class="category-orbit"><span class="category-icon"><i class="fas fa-crown"></i></span></span>
                <span class="category-name">أولاد</span><span class="category-note">ستايل مميز</span>
            </a>
            <a href="{{ Route::has('category.girls') ? route('category.girls') : '/category/girls' }}" class="category-item">
                <span class="category-orbit"><span class="category-icon"><i class="fas fa-gem"></i></span></span>
                <span class="category-name">بنات</span><span class="category-note">أناقة ناعمة</span>
            </a>
            <a href="{{ Route::has('category.babies') ? route('category.babies') : '/category/babies' }}" class="category-item">
                <span class="category-orbit"><span class="category-icon"><i class="fas fa-baby"></i></span></span>
                <span class="category-name">بيبي</span><span class="category-note">راحة وحب</span>
            </a>
            <a href="{{ Route::has('category.women') ? route('category.women') : '/category/women' }}" class="category-item">
                <span class="category-orbit"><span class="category-icon"><i class="fas fa-person-dress"></i></span></span>
                <span class="category-name">نسائي</span><span class="category-note">إطلالتكِ</span>
            </a>
            <a href="#shop" class="category-item">
                <span class="category-orbit"><span class="category-icon"><i class="fas fa-sparkles"></i></span></span>
                <span class="category-name">وصل حديثاً</span><span class="category-note">كوني أولاً</span>
            </a>
            <a href="#shop" class="category-item">
                <span class="category-orbit"><span class="category-icon"><i class="fas fa-fire"></i></span></span>
                <span class="category-name">الأكثر طلباً</span><span class="category-note">اختياراتنا</span>
            </a>
        </div>
    </div>
</section>

{{-- 🚀 HERO IMAGE SECTION (FULLSCREEN LUXURY STYLE) --}}
<div class="relative w-full h-screen min-h-[600px] overflow-hidden bg-gray-900 flex items-center">

    {{-- 🖼️ Background Image with Subtle Zoom Effect --}}
    <div class="absolute inset-0 z-0">
        <img 
            src="https://files.manuscdn.com/user_upload_by_module/session_file/310519663166720664/MkdnFgIRAmlobtLe.png" 
            alt="Melekler Fashion Hero" 
            class="w-full h-full object-cover object-center scale-105 animate-subtle-zoom"
        >
        {{-- Overlays for Text Readability --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black/45 via-black/20 to-transparent rtl:bg-gradient-to-l"></div>
        <div class="absolute inset-0 bg-black/5"></div>
    </div>

    {{-- 📝 Main Content Container --}}
    <div class="relative z-10 max-w-screen-xl mx-auto px-6 w-full pt-16">
        <div class="max-w-2xl text-right">
            
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 border border-white/20 backdrop-blur-md rounded-full mb-6">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                <span class="text-white text-xs font-bold tracking-widest uppercase">NEW COLLECTION 2026</span>
            </div>

            {{-- Title --}}
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white leading-tight mb-6 tracking-tight">
                عالم من <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-pink-500">الأناقة</span> لصغيرك ✨
            </h1>

            {{-- Subtitle --}}
            <p class="text-gray-200 text-lg md:text-xl font-light leading-relaxed mb-10 max-w-xl">
                اكتشفي أحدث صيحات الموضة التركية المصممة بعناية وفخامة تمنح طفلك إطلالة استثنائية وراحة مطلقة.
            </p>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-4 items-center">
                <a href="#shop" class="group relative px-8 py-4 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl shadow-xl shadow-rose-500/30 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-3">
                    <span>تسوقي المجموعة</span>
                    <span class="group-hover:translate-x-[-4px] transition-transform rtl:group-hover:translate-x-[4px]">←</span>
                </a>
                
                <a href="#collection" class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-2xl border border-white/20 backdrop-blur-md transition-all duration-300">
                    استكشفي الأقسام
                </a>
            </div>

        </div>
    </div>

    {{-- ✨ Premium Service Card --}}
    <div class="hero-offer-card">
        <span class="hero-offer-icon"><i class="fas fa-truck-fast"></i></span>
        <div>
            <strong>توصيل سريع لباب بيتك</strong>
            <span>شحن مجاني للطلبات فوق 1000 ₺</span>
        </div>
    </div>

    {{-- 🌟 Bottom Quick Info Strip --}}
    <div class="absolute bottom-0 inset-x-0 z-10 bg-gradient-to-t from-black/80 to-transparent pt-10 pb-6">
        <div class="max-w-screen-xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-4 text-white/80 text-xs md:text-sm border-t border-white/10 pt-4">
            <div class="flex items-center gap-3">
                <span class="text-xl">✨</span>
                <span>تصاميم تركية حصرية</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xl">🚚</span>
                <span>توصيل سريع ومضمون</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xl">🧵</span>
                <span>أقمشة قطنية 100%</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xl">💎</span>
                <span>جودة عالية وأسعار منافسة</span>
            </div>
        </div>
    </div>

</div>

{{-- Animate CSS for Hero Image --}}
<style>
    @keyframes subtleZoom {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .animate-subtle-zoom {
        animation: subtleZoom 20s infinite alternate ease-in-out;
    }
</style>


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

{{-- 🗓️ LUXURY EVENT & CALENDAR SECTION --}}
<section class="mt-16 py-20 text-white relative bg-gradient-to-br from-rose-500 via-rose-600 to-pink-600 overflow-hidden select-none">
    
    {{-- 🎨 Decorative Top Pattern --}}
    <div class="absolute top-0 inset-x-0 h-4 bg-[radial-gradient(circle_at_bottom,_transparent_60%,_#ffffff_65%)] bg-[length:16px_16px] opacity-20"></div>

    <div class="max-w-6xl mx-auto px-6 flex flex-col lg:flex-row gap-12 items-center justify-between relative z-10">
        
        {{-- 📝 Event Info Card (Right Side in RTL) --}}
        <div class="lg:w-1/2 space-y-6 text-right w-full">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/20 border border-white/30 text-xs font-bold tracking-wider uppercase backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                <span>فعالية خاصة قادمة</span>
            </div>

            <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-tight text-white">
                عرض ربيع <span class="text-amber-300">2026</span> الأكبر ✨
            </h2>

            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 md:p-8 border border-white/20 shadow-2xl relative overflow-hidden group">
                <div class="flex flex-wrap gap-4 text-xs md:text-sm mb-6 font-bold text-rose-100 items-center justify-start">
                    <span class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl border border-white/10">📅 17 أبريل 2026</span>
                    <span class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl border border-white/10">⏰ 09:00 صباحاً</span>
                    <span class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl border border-white/10">📍 اسطنبول</span>
                </div>

                <p class="mb-8 leading-relaxed text-white/90 text-sm md:text-base font-light">
                    انضموا إلينا في إطلاق التشكيلة الجديدة لربيع 2026! خصومات حصرية، هدايا مميزة للأطفال، وأنشطة تفاعلية لا تُنسى طوال اليوم.
                </p>

                {{-- ⏳ Live Countdown Timer --}}
                <div class="grid grid-cols-4 gap-2 text-center mb-8 bg-black/20 p-3 rounded-2xl border border-white/10">
                    <div>
                        <span class="block text-xl md:text-2xl font-black text-amber-300" id="days">00</span>
                        <span class="text-[10px] text-rose-200">يوم</span>
                    </div>
                    <div>
                        <span class="block text-xl md:text-2xl font-black text-amber-300" id="hours">00</span>
                        <span class="text-[10px] text-rose-200">ساعة</span>
                    </div>
                    <div>
                        <span class="block text-xl md:text-2xl font-black text-amber-300" id="minutes">00</span>
                        <span class="text-[10px] text-rose-200">دقيقة</span>
                    </div>
                    <div>
                        <span class="block text-xl md:text-2xl font-black text-amber-300" id="seconds">00</span>
                        <span class="text-[10px] text-rose-200">ثانية</span>
                    </div>
                </div>

                <a href="#register" class="inline-flex items-center gap-2 bg-white text-rose-600 font-extrabold px-8 py-3.5 rounded-2xl hover:bg-amber-400 hover:text-gray-900 transition-all shadow-lg hover:shadow-xl text-sm transform hover:-translate-y-0.5">
                    <span>احجزي مقعدك الآن</span>
                    <span>←</span>
                </a>
            </div>
        </div>

        {{-- 📅 Visual Calendar (Left Side in RTL) --}}
        <div class="lg:w-1/2 flex flex-col items-center w-full">
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 md:p-8 border border-white/20 w-full max-w-md shadow-2xl">
                
                {{-- Month Header --}}
                <div class="flex justify-between items-center mb-6 border-b border-white/15 pb-4">
                    <span class="text-sm font-bold text-rose-200">2026</span>
                    <h3 class="text-2xl font-black text-white tracking-wider">أبريل / April</h3>
                    <span class="text-amber-300 text-lg">✨</span>
                </div>
                
                {{-- Calendar Grid --}}
                <div dir="ltr" class="w-full">
                    {{-- Days of Week --}}
                    <div class="grid grid-cols-7 text-center font-black text-xs md:text-sm mb-4 opacity-80 text-rose-100">
                        <span>S</span><span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                    </div>

                    {{-- Days Grid --}}
                    <div class="grid grid-cols-7 gap-y-2 text-center text-xs md:text-sm">
                        {{-- Offset for April 2026 starting on Wednesday (3 empty slots) --}}
                        <div></div><div></div><div></div>

                        @for ($d = 1; $d <= 30; $d++)
                            <div class="flex items-center justify-center">
                                <div class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-full font-bold transition-all duration-300 {{ $d == 17 ? 'bg-amber-400 text-gray-900 shadow-lg shadow-amber-400/50 scale-110 ring-4 ring-amber-400/30 font-black' : 'hover:bg-white/10 text-white' }}">
                                    {{ $d }}
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Calendar Footer Note --}}
                <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-rose-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-400 inline-block"></span>
                        <span>يوم الفعالية</span>
                    </div>
                    <span class="opacity-75">معرض اسطنبول الدولي</span>
                </div>

            </div>
        </div>

    </div>
</section>

{{-- ⏱️ Countdown Timer Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventDate = new Date("April 17, 2026 09:00:00").getTime();

        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = eventDate - now;

            if (distance < 0) {
                clearInterval(timer);
                return;
            }

            document.getElementById("days").innerText = Math.floor(distance / (1000 * 60 * 60 * 24));
            document.getElementById("hours").innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById("minutes").innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById("seconds").innerText = Math.floor((distance % (1000 * 60)) / 1000);
        }, 1000);
    });
</script>

    {{-- Products Infinite Ticker Section --}}
<section class="py-20 bg-gray-50/50 overflow-hidden" id="shop">
    <div class="max-w-screen-xl mx-auto px-6">

        {{-- شريط العناوين والبحث العلوي --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="text-right w-full md:w-auto">
                <span class="lux-badge block mb-2">JUST ARRIVED</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 leading-tight">قطعنا <span class="lux-gradient">الجديدة</span> الساحرة ✨</h2>
            </div>
            <div class="filter-bar w-full md:w-auto">
                <div class="filter-group flex w-full">
                    <input type="text" class="filter-input" placeholder="ابحث عن قطعة...">
                    <button class="apply-button">بحث</button>
                </div>
            </div>
        </div>

        {{-- مصفوفة الأقسام الثابتة --}}
        @php
            $static_categories = [
                [
                    'name' => 'ملابس الأولاد', 
                    'route' => 'category.boys', 
                    'keywords' => ['%ولد%', '%ولادي%', '%boy%', '%boys%']
                ],
                [
                    'name' => 'ملابس البنات', 
                    'route' => 'category.girls', 
                    'keywords' => ['%بنات%', '%بناتي%', '%girl%', '%girls%']
                ],
                [
                    'name' => 'ملابس الرضع', 
                    'route' => 'category.babies', 
                    'keywords' => ['%رضع%', '%طفل%', '%أطفال%', '%اطفال%', '%baby%', '%babies%']
                ],
                [
                    'name' => 'ملابس الأمهات', 
                    'route' => 'category.women', 
                    'keywords' => ['%أمهات%', '%نساء%', '%نسائي%', '%mother%', '%women%']
                ]
            ];
        @endphp

        @foreach($static_categories as $cat)
            @php
                $cat_products = \App\Models\Product::where(function($query) use ($cat) {
                                                    foreach($cat['keywords'] as $keyword) {
                                                        $query->orWhere('category', 'like', $keyword);
                                                    }
                                               })
                                               ->where('status', 1)
                                               ->with('images')
                                               ->latest()
                                               ->take(12)
                                               ->get();
            @endphp
            @if($cat_products->count() > 0)
                {{-- رأس القسم --}}
                <div class="flex justify-between items-end mb-6 border-b pb-4 border-gray-200 {{ !$loop->first ? 'mt-16' : '' }}">
                    <div class="text-right">
                        <h3 class="text-2xl md:text-3xl font-black text-gray-800">{{ $cat['name'] }}</h3>
                    </div>
                    <div>
                        <a href="{{ Route::has($cat['route']) ? route($cat['route']) : '/category/'.explode('.', $cat['route'])[1] }}" class="apply-button text-xs md:text-sm inline-block px-4 py-2 rounded-xl transition-all">عرض الكل &larr;</a>
                    </div>
                </div>

                {{-- شريط المنتجات المتحرك (Carousel / Ticker) --}}
                <div class="relative w-full overflow-x-auto pb-4 pt-2 no-scrollbar scroll-smooth flex gap-6 snap-x snap-mandatory">
                    @foreach($cat_products as $product)
                        @php
                            $prodImg = $product->images->first() ? $product->images->first()->image : ($product->product_thambnail ?? 'https://via.placeholder.com/400x600');
                        @endphp
                        <div class="product-card-ty group flex-shrink-0 w-[240px] sm:w-[270px] md:w-[290px] snap-start bg-white rounded-2xl p-3 border border-gray-100 shadow-sm hover:shadow-md transition">
                            
                            {{-- غلاف الصورة الرئيسي --}}
                            <div class="ty-image-wrapper relative overflow-hidden rounded-xl bg-gray-100 h-[300px]">
                                
                                {{-- نسبة الخصم إن وجد --}}
                                @if($product->original_price > $product->price)
                                    <div class="ty-badge absolute top-3 right-3 z-20 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-md">
                                        خصم {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                    </div>
                                @endif

                                {{-- زر المفضلة مفصول تماماً أعلى اليسار --}}
                                <button class="ty-wishlist-btn absolute top-3 left-3 z-20 w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:text-rose-500 transition shadow-sm">
                                    <i class="far fa-heart text-sm"></i>
                                </button>

                                {{-- صورة المنتج --}}
                                <a href="{{ route('products.show', [$product->id, $product->product_slug ?? 'item']) }}" class="block w-full h-full">
                                    <img loading="lazy" src="{{ $prodImg }}" class="ty-main-image w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $product->name }}">
                                </a>
                            </div>

                            {{-- تفاصيل المنتج والأسعار --}}
                            <div class="ty-info-wrapper mt-3 text-right">
                                <a href="{{ route('products.show', [$product->id, $product->product_slug ?? 'item']) }}" class="hover:text-rose-500 transition-colors">
                                    <h3 class="ty-title text-gray-800 font-bold text-sm line-clamp-1">{{ $product->name }}</h3>
                                </a>
                                <div class="ty-price-wrapper mt-1 flex items-center justify-end gap-2">
                                    @if($product->original_price)
                                        <span class="text-xs text-gray-400 line-through">{{ number_format($product->original_price, 2) }} ₺</span>
                                    @endif
                                    <span class="ty-final-price font-black text-rose-600 text-base">{{ number_format($product->price, 2) }} ₺</span>
                                </div>

                                {{-- صف الأزرار السفلي: تجربة AI + أضف للسلة --}}
                                <div class="mt-3 flex items-center gap-2">
                                    {{-- زر تجربة الذكاء الاصطناعي --}}
                                    <button type="button" onclick="openFittingRoom('{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ $prodImg }}')" class="w-1/2 bg-gray-900 hover:bg-black text-white font-bold py-2 px-2 rounded-xl text-xs flex items-center justify-center gap-1 transition shadow-sm">
                                        <span>✨</span>
                                        <span>تجربة AI</span>
                                    </button>

                                    {{-- زر السلة --}}
                                    <form action="{{ url('cart-add/'.$product->id) }}" method="POST" class="w-1/2">
                                        @csrf
                                        <input type="hidden" name="size" value="Free Size">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-2 rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-1">
                                            <span>🛍️</span>
                                            <span>أضف للسلة</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach

    </div>
</section>

{{-- Fitting Room Modal (نافذة التجربة الافتراضية) --}}
<div id="fittingRoomModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-gray-900 text-white w-full max-w-md rounded-3xl p-6 relative shadow-2xl border border-gray-800 text-center">
        <button onclick="closeFittingRoom()" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl font-bold">&times;</button>
        <div class="mb-4">
            <span class="text-xs text-rose-400 font-bold uppercase tracking-widest">Fitting Room</span>
            <h3 id="fittingProductName" class="text-lg font-bold mt-1 text-gray-200">غرفة التجربة الافتراضية</h3>
        </div>
        <div class="relative w-full h-80 bg-gray-800 rounded-2xl overflow-hidden flex items-center justify-center border border-gray-700">
            <img id="fittingProductImg" src="" class="max-h-full object-contain" alt="Selected Product">
            <div id="fittingLoader" class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center p-4">
                <div class="w-10 h-10 border-4 border-rose-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                <p class="text-sm text-gray-300">جاري قياس وتلبيس القطعة على المانيكان...</p>
            </div>
        </div>
        <button onclick="closeFittingRoom()" class="w-full mt-5 bg-rose-500 hover:bg-rose-600 font-bold py-3 rounded-xl transition">إغلاق</button>
    </div>
</div>

<script>
function openFittingRoom(id, name, img) {
    document.getElementById('fittingProductName').innerText = name;
    document.getElementById('fittingProductImg').src = img;
    document.getElementById('fittingRoomModal').classList.remove('hidden');
    
    // إخفاء مؤشر التحميل بعد ثانيتين لإظهار النتيجة
    const loader = document.getElementById('fittingLoader');
    loader.classList.remove('hidden');
    setTimeout(() => {
        loader.classList.add('hidden');
    }, 1500);
}

function closeFittingRoom() {
    document.getElementById('fittingRoomModal').classList.add('hidden');
}
</script>
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
                
                {{-- تم التعديل: تغليف زر العرض المميز داخل فورم لمنع توقف الرابط أو الجافا سكريبت --}}
                <form action="{{ url('cart-add/premium-set') }}" method="POST" class="w-full add-to-cart-form">
                    @csrf
                    <input type="hidden" name="size" value="Free Size">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full py-4 mt-4 bg-gradient-to-r from-amber-500 to-rose-500 text-white rounded-2xl font-black text-base md:text-lg shadow-lg hover:shadow-xl transition-all duration-300">شراء الإطلالة كاملة الآن — 420.00 ₺</button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ==================== الـ FOOTER المنظم والموحد ==================== --}}

{{-- 🔀 SMART CURRENCY CONVERTER SECTION --}}
<section class="py-12 bg-gradient-to-r from-gray-900 via-rose-950 to-gray-900 text-white relative overflow-hidden my-12 border-y border-rose-500/20">
    {{-- خلفية جمالية ضوئية --}}
    <div class="absolute -top-24 -left-24 w-72 h-72 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-bold tracking-wider uppercase mb-4 backdrop-blur-md text-amber-300">
            <span>🔱 حاسبة أسعار التسوق الحية</span>
        </div>

        <h3 class="text-2xl md:text-4xl font-black text-white mb-2">
            حاسبة العملات <span class="lux-gradient">الذكية</span> ✨
        </h3>
        <p class="text-gray-300 text-xs md:text-sm mb-8 font-light">
            اعرف تكلفة مشترياتك بعملتك المفضلة وبأسعار الصرف الحية لحظة بلحظة.
        </p>

        {{-- بطاقة الحاسبة --}}
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 md:p-8 border border-white/20 shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                
                {{-- المبلغ بالليرة التركية --}}
                <div class="text-right">
                    <label class="block text-xs font-bold text-gray-300 mb-2">المبلغ بالليرة التركية (₺):</label>
                    <div class="relative">
                        <input type="number" id="tryAmount" value="1000" min="1" class="w-full bg-black/40 border border-white/20 rounded-2xl py-3 px-4 text-white font-bold text-lg focus:outline-none focus:border-rose-400 transition" placeholder="أدخل المبلغ...">
                        <span class="absolute left-4 top-3.5 text-gray-400 font-bold">₺</span>
                    </div>
                </div>

                {{-- اختيار العملة المراد التحويل إليها --}}
                <div class="text-right">
                    <label class="block text-xs font-bold text-gray-300 mb-2">تحويل إلى:</label>
                    <select id="targetCurrency" class="w-full bg-black/40 border border-white/20 rounded-2xl py-3 px-4 text-white font-bold text-lg focus:outline-none focus:border-rose-400 transition cursor-pointer">
                        <option value="USD" selected>💵 دولار أمريكي ($)</option>
                        <option value="EUR">💶 يورو (€)</option>
                        <option value="SAR">🇸🇦 ريال سعودي (SAR)</option>
                        <option value="AED">🇦🇪 درهم إماراتي (AED)</option>
                        <option value="JOD">🇯🇴 دينار أردني (JOD)</option>
                        <option value="KWD">🇰🇼 دينار كويتي (KWD)</option>
                    </select>
                </div>

                {{-- النتيجة --}}
                <div class="text-right md:text-center bg-rose-500/20 border border-rose-500/30 p-4 rounded-2xl">
                    <span class="block text-xs font-bold text-rose-200 mb-1">المبلغ المقابل تقريباً:</span>
                    <span class="text-2xl md:text-3xl font-black text-amber-300" id="convertedResult">0.00 $</span>
                </div>

            </div>

            {{-- شريط ملخص أسعار الصرف --}}
            <div class="mt-6 pt-4 border-t border-white/10 flex flex-wrap justify-between items-center text-xs text-gray-300 gap-2">
                <div class="flex items-center gap-4">
                    <span>💲 1 USD = <strong class="text-white" id="rateUSD">--</strong> TRY</span>
                    <span>💶 1 EUR = <strong class="text-white" id="rateEUR">--</strong> TRY</span>
                    <span>🇸🇦 1 SAR = <strong class="text-white" id="rateSAR">--</strong> TRY</span>
                </div>
                <span class="text-gray-400 text-[10px]" id="lastUpdate">🔄 جاري تحديث الأسعار...</span>
            </div>
        </div>

    </div>
</section>

{{-- ⚙️ SCRIPT FOR LIVE CURRENCY CONVERSION --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiUrl = "https://open.er-api.com/v6/latest/TRY";
    let exchangeRates = {};

    const tryInput = document.getElementById('tryAmount');
    const targetSelect = document.getElementById('targetCurrency');
    const convertedResult = document.getElementById('convertedResult');
    const lastUpdateSpan = document.getElementById('lastUpdate');

    const currencySymbols = {
        USD: '$',
        EUR: '€',
        SAR: 'ر.س',
        AED: 'د.إ',
        JOD: 'د.أ',
        KWD: 'د.ك'
    };

    async function fetchRates() {
        try {
            const response = await fetch(apiUrl);
            const data = await response.json();
            
            if(data.result === "success") {
                exchangeRates = data.rates;

                document.getElementById('rateUSD').innerText = (1 / exchangeRates.USD).toFixed(2);
                document.getElementById('rateEUR').innerText = (1 / exchangeRates.EUR).toFixed(2);
                document.getElementById('rateSAR').innerText = (1 / exchangeRates.SAR).toFixed(2);

                const now = new Date();
                lastUpdateSpan.innerText = `تحديث مباشر: ${now.getHours()}:${now.getMinutes() < 10 ? '0' : ''}${now.getMinutes()}`;

                calculateConversion();
            }
        } catch (error) {
            console.error("خطأ في جلب أسعار العملات:", error);
            lastUpdateSpan.innerText = "تعذر تحديث الأسعار التلقائي";
        }
    }

    function calculateConversion() {
        const amount = parseFloat(tryInput.value) || 0;
        const targetCurrency = targetSelect.value;
        const symbol = currencySymbols[targetCurrency] || targetCurrency;

        if (exchangeRates[targetCurrency]) {
            const converted = amount * exchangeRates[targetCurrency];
            convertedResult.innerText = `${converted.toFixed(2)} ${symbol}`;
        }
    }

    if (tryInput && targetSelect) {
        tryInput.addEventListener('input', calculateConversion);
        targetSelect.addEventListener('change', function() {
            localStorage.setItem('preferred_currency', targetSelect.value);
            calculateConversion();
        });
    }

    const savedCurrency = localStorage.getItem('preferred_currency');
    if (savedCurrency && targetSelect.querySelector(`option[value="${savedCurrency}"]`)) {
        targetSelect.value = savedCurrency;
    }

    fetchRates();
});
</script>

<footer class="bg-gradient-to-b from-gray-900 to-black text-gray-300 pt-20 pb-10">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-12 mb-16">
            <div>
                <h4 class="text-2xl font-black text-white mb-4 tracking-wide">MELEKLER GROUP</h4>
                <p class="text-gray-400 leading-relaxed">متجرك الموثوق لأزياء الأطفال والنساء بتصاميم عصرية جودة عالية.</p>
                <div class="flex gap-4 mt-6 text-xl">
                    <a href="https://www.instagram.com/meleklerkids/" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/MELEKLERKIDSTR" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-facebook"></i></a>
                    <a href="https://api.whatsapp.com/message/CL67ADRC7PMFO1" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div>
                <h5 class="font-bold text-white mb-5 text-lg">التسوق</h5>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="#" class="hover:text-white transition">وصل حديثاً</a></li>
                    <li><a href="{{ Route::has('category.boys') ? route('category.boys') : '/category/boys' }}" class="hover:text-white transition">ملابس أطفال</a></li>
                    <li><a href="{{ Route::has('category.women') ? route('category.women') : '/category/women' }}" class="hover:text-white transition">ملابس نساء</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold text-white mb-5 text-lg">خدمة العملاء</h5>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="{{ Route::has('contact') ? route('contact') : '/contact' }}" class="hover:text-white transition">اتصل بنا</a></li>
                    <li><a href="/refund-policy" class="hover:text-white transition">سياسة الإرجاع</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold text-white mb-5 text-lg">اشترك في العروض</h5>
                <form action="#" method="POST" class="flex">
                    @csrf
                    {{-- تم إزالة readonly ليتاح للمستخدم الكتابة --}}
                    <input type="email" name="email" placeholder="بريدك الإلكتروني" class="w-full px-4 py-3 rounded-l-xl bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-orange-500 transition" required>
                    <button type="submit" class="px-5 bg-orange-500 rounded-r-xl hover:bg-orange-600 text-white font-bold transition">اشتراك</button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">© 2026 Melekler Fashion — جميع الحقوق محفوظة</p>
            <p class="text-gray-600 text-xs">CREATED BY ALAA ALAKRABANI</p>
        </div>
    </div>
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
    // تشغيل السلايدر فقط إذا كان موجوداً فعلياً في الصفحة
    if (document.querySelector('.hero-swiper')) {
        const heroSwiper = new Swiper('.hero-swiper', {
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
        });
    }

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

    function addToCart(productId) {
        fetch(`/cart-add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: 1, size: 'Free Size' })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (typeof openCart === 'function') {
                openCart();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof openCart === 'function') openCart(); 
        });
    }

</script>

@endsection
