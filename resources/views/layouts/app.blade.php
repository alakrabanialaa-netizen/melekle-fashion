<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <meta charset="UTF-8">
    <title>Melekler Fashion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">

   <style>
    /* --- Global Styles --- */
    body {
        font-family: 'Cairo', sans-serif;
        background-color: #f9fafb; /* gray-50 */
        /* ✅ الخطوة 1: إضافة مساحة حول الجسم ليتنفس الهيدر العائم */
        padding-top: 1rem; /* ما يعادل 16px */
        padding-left: 1.5rem; /* ما يعادل 24px */
        padding-right: 1.5rem; /* ما يعادل 24px */
    }
    .font-black { font-weight: 900; }

    /* --- Floating Header Styles (التصميم الجديد) --- */
    #main-header {
        position: fixed; /* ✅ الخطوة 2: تثبيت الهيدر في الشاشة */
        top: 1rem;       /* ✅ الخطوة 3: إبعاده عن الحافة العلوية (16px) */
        left: 1.5rem;    /* ✅ الخطوة 4: إبعاده عن الحافة اليمنى (24px) */
        right: 1.5rem;   /* ✅ الخطوة 5: إبعاده عن الحافة اليسرى (24px) */
        
        /* --- اللمسات العصرية --- */
        background-color: rgba(255, 255, 255, 0.7); /* خلفية زجاجية شفافة */
        backdrop-filter: blur(12px);                /* تأثير ضبابي للخلفية (Frosty Glass) */
        border: 1px solid rgba(255, 255, 255, 0.9);  /* حدود بيضاء شبه شفافة */
        border-radius: 1rem;                        /* ✅ الخطوة 6: حواف دائرية جداً (Pill Shape) */
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1); /* ظل ناعم وعميق لإعطاء إحساس بالعوم */
        
        /* --- تأثيرات الحركة --- */
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* حركة أكثر سلاسة */
    }

    /* عند التمرير، يمكننا زيادة شفافية الخلفية قليلاً (اختياري) */
    #main-header.scrolled {
        background-color: rgba(255, 255, 255, 0.85);
    }

    /* تعديل لون النصوص والأيقونات لتكون داكنة دائماً على الخلفية الفاتحة */
    #main-header #logo,
    #main-header .nav-link,
    #main-header .nav-icon {
        color: #1f2937; /* gray-800 */
    }

    .nav-link { transition: color 0.2s ease; }
    .nav-link:hover { color: #f97316; } /* Orange-500 */

    /* --- Dropdown Menu Styles (قائمة الأقسام) --- */
    .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border-radius: 0.75rem; /* حواف دائرية للقائمة المنسدلة أيضاً */
    }
    .group:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .dropdown-item {
        transition: background-color 0.2s ease, padding-right 0.2s ease;
    }
    .dropdown-item:hover {
        background-color: #f3f4f6; /* gray-100 */
        padding-right: 1.25rem; /* 20px */
        color: #f97316;
    }

    /* --- Mobile Menu Styles --- */
    #mobile-menu {
        transform: translateX(100%);
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    #mobile-menu.open {
        transform: translateX(0);
    }
     @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Fredoka:wght@400;600;700&display=swap');
    
    #main-header {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Cairo', 'Fredoka', sans-serif;
    }

    /* Initial Transparent State */
    .header-transparent {
        background: transparent;
        padding-top: 2rem;
    }

    /* Scrolled Glassy State */
    .header-scrolled {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    /* Logo Styling */
    .logo-container {
        transition: all 0.4s ease;
    }
    
    .header-transparent .logo-container {
        background: white;
        padding: 15px 30px;
        border-radius: 0 0 40px 40px; /* Playful curved bottom */
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        margin-top: -2rem;
    }

    .header-scrolled .logo-container {
        background: transparent;
        padding: 0;
        box-shadow: none;
        margin-top: 0;
    }

    .header-transparent .logo-text { color: #f89494; } /* Soft Pink */
    .header-scrolled .logo-text { color: #333; }

    /* Nav Links */
    .nav-link {
        position: relative;
        transition: all 0.3s ease;
    }

    .header-transparent .nav-link { color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }
    .header-scrolled .nav-link { color: #5d5d5d; }

    .nav-link::after {
        content: "";
        position: absolute;
        bottom: -5px;
        left: 50%;
        width: 0;
        height: 3px;
        background: #f89494;
        border-radius: 10px;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .nav-link:hover::after { width: 80%; }
    .nav-link:hover { color: #f89494 !important; transform: translateY(-2px); }

    /* Icons */
    .nav-icon {
        transition: all 0.3s ease;
    }
    .header-transparent .nav-icon { color: white; }
    .header-scrolled .nav-icon { color: #333; }
    .nav-icon:hover { color: #f89494 !important; transform: scale(1.1); }

    /* Dropdown */
    .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    .group:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);

    }

    /* تأكد من استدعاء مكتبة FontAwesome في ملف الـ Layout الرئيسي */
    #main-header {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Cairo', sans-serif;
    }

    .header-transparent { background: transparent; padding-top: 1.5rem; }
    .header-scrolled {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
    }

    /* Logo Center Logic */
    .logo-container { transition: all 0.4s ease; }
    .header-transparent .logo-text { color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
    .header-scrolled .logo-text { color: #333; }

    /* Nav Links */
    .nav-link { transition: all 0.3s ease; font-weight: 700; }
    .header-transparent .nav-link { color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }
    .header-scrolled .nav-link { color: #555; }
    .nav-link:hover { color: #f89494 !important; }

    /* Icons */
    .nav-icon { transition: all 0.3s ease; cursor: pointer; }
    .header-transparent .nav-icon { color: white; }
    .header-scrolled .nav-icon { color: #333; }
    .nav-icon:hover { color: #f89494 !important; transform: translateY(-2px); }

    /* Language Switcher Button */
    .lang-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.3s ease;
    }
    .header-transparent .lang-btn { background: transparent; color: white; border-color: rgba(255,255,255,0.3); }
    .header-scrolled .lang-btn { background: transparent; color: #333; border-color: #e5e7eb; }
    .lang-btn:hover { color: #f89494 !important; border-color: #f89494; transform: translateY(-2px); }

    /* Dropdowns */
    .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    .group:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
</style>



<header id="main-header" class="fixed top-0 left-0 right-0 z-50 header-transparent">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-3 items-center">
        
          {{-- 1. Left Side: Language & User --}}
        <div class="flex items-center gap-4 justify-start">
            {{-- 🌍 Language Switcher --}}
            <div class="relative group">
                <button class="lang-btn">
                    <i class="fas fa-globe-americas text-sm"></i>
                    <span class="text-xs font-black uppercase">{{ app()->getLocale() }}</span>
                </button>
                <div class="dropdown-menu absolute left-0 mt-2 w-36 bg-white rounded-2xl shadow-2xl py-2 border border-gray-100 overflow-hidden z-[100]">
                    <a href="{{ url('lang/ar') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇸🇦</span> العربية
                    </a>
                    <a href="{{ url('lang/en') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇺🇸</span> English
                    </a>
                    <a href="{{ url('lang/tr') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇹🇷</span> Türkçe
                    </a>
                </div>
            </div>

            {{-- User Icon --}}
            <a href="{{ route('login') }}" class="nav-icon text-xl hidden md:block">
                <i class="far fa-user-circle"></i>
            </a>
        </div>

        {{-- 2. Center Side: Logo --}}
        <div class="logo-container text-center">
            <a href="{{ route('welcome') }}" class="logo-text text-3xl font-black tracking-tighter inline-block">
                MELEKLER
            </a>
            <div class="text-[9px] font-bold tracking-[0.4em] uppercase opacity-60 logo-subtext hidden md:block">
                Luxury Kids Store
            </div>
        </div>

        {{-- 3. Right Side: Navigation & Cart --}}
        <div class="flex items-center gap-6 justify-end">
            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-8 text-sm">
                <a href="{{ route('welcome') }}" class="nav-link">الرئيسية</a>
                
                {{-- Categories Dropdown --}}
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1.5">
                        <span>الأقسام</span>
                        <i class="fas fa-chevron-down text-[9px] transition-transform group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-4 w-56 bg-white rounded-3xl shadow-2xl py-4 border border-pink-50 overflow-hidden">
                        <a href="{{ route('category.boys') }}" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👦 ملابس أولاد</a>
                        <a href="{{ route('category.girls') }}" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👧 ملابس بنات</a>
                        <a href="{{ route('category.babies') }}" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👶 ملابس رضع</a>
                        <a href="{{ route('category.mothers') }}" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👩 ملابس نساء</a>
                    </div>
                </div>
            </nav>

            {{-- Cart Icon --}}
            <button id="cart-icon" onclick="openCart()" class="relative nav-icon text-xl">
                <i class="fas fa-shopping-bag"></i>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-pink-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-white font-bold shadow-sm">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </button>

            {{-- Mobile Burger --}}
            <button id="mobile-menu-button" class="lg:hidden nav-icon text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>

    </div>
</header>
</head>
<body class="bg-gray-50">



{{-- 📱 Mobile Menu --}}
<div id="mobile-menu" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl z-50 p-8">
    <button id="close-mobile-menu" class="absolute top-6 left-6 text-2xl text-gray-600">&times;</button>
    <nav class="flex flex-col gap-6 mt-12 font-bold text-gray-800">
        <a href="{{ route('welcome') }}" class="hover:text-orange-500">الرئيسية</a>
        <h3 class="text-gray-400 text-sm mt-4">الأقسام</h3>
        <a href="#" class="hover:text-orange-500 pr-4">ملابس أولاد</a>
        <a href="#" class="hover:text-orange-500 pr-4">ملابس بنات</a>
        <a href="#" class="hover:text-orange-500 pr-4">ملابس رضع</a>
        <hr>
        <a href="{{ route('products.index') }}" class="hover:text-orange-500">كل المنتجات</a>
        <a href="#" class="text-red-500">تخفيضات</a>
        <hr>
        <a href="{{ route('login') }}" class="hover:text-orange-500">تسجيل الدخول</a>
    </nav>
</div>

<main class="pt-28 min-h-screen">

    @yield('content')
</main>

{{-- 🛒 Mini Cart --}}
<div id="mini-cart" class="fixed top-0 right-[-420px] w-[400px] h-screen bg-white shadow-2xl transition-all duration-300 z-50 flex flex-col">
    <div class="p-6 border-b flex justify-between items-center">
        <h2 class="text-xl font-bold">🛒 سلة المشتريات</h2>
        <button onclick="closeCart()" class="text-2xl hover:text-red-500 transition">&times;</button>
    </div>

    <div class="flex-1 p-6 overflow-y-auto">
        @php $cart = session('cart', []); $total = 0; @endphp
        
        @if(count($cart) > 0)
            @foreach($cart as $id => $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <div class="flex gap-4 border-b py-4 items-center">
                    <img src="{{ $item['image'] ? asset('storage/'.$item['image']) : asset('images/default.png') }}" 
                         alt="{{ $item['name'] }}" 
                         class="w-16 h-16 object-cover rounded shadow-sm">
                    
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">{{ $item['name'] }}</h4>
                        @if(isset($item['size']))
                            <p class="text-xs text-gray-400">المقاس: {{ $item['size'] }}</p>
                        @endif
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-sm text-gray-600">الكمية: {{ $item['quantity'] }}</p>
                            <p class="font-bold text-indigo-600">{{ number_format($item['price'], 2) }} ₺</p>
                        </div>
                    </div>
                    
                    {{-- زر اختياري لحذف المنتج --}}
                    <button onclick="removeFromCart('{{ $id }}')" class="text-gray-300 hover:text-red-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            @endforeach
        @else
            <div class="text-center mt-20">
                <div class="text-6xl mb-4 text-gray-200">🛒</div>
                <p class="text-gray-500">السلة فارغة حالياً</p>
            </div>
        @endif
    </div>

    @if(count($cart) > 0)
        <div class="p-6 border-t bg-gray-50">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-600 font-medium">المجموع الكلي:</span>
                <span class="text-xl font-bold text-indigo-700">{{ number_format($total, 2) }} ₺</span>
            </div>
            <a href="{{ route('cart.index') }}" class="block w-full bg-indigo-600 text-white text-center py-3 rounded-lg hover:bg-indigo-700 transition font-semibold shadow-md">عرض السلة</a>
            <a href="{{ route('checkout.index') }}" class="block w-full mt-3 bg-black text-white text-center py-3 rounded-lg hover:bg-gray-800 transition font-semibold shadow-md">الدفع الآن</a>
        </div>
    @endif
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Header Scroll Effect ---
    const header = document.getElementById('main-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // --- Mini Cart Logic ---
    const miniCart = document.getElementById('mini-cart');
    const cartIcon = document.getElementById('cart-icon');
    window.openCart = () => miniCart.style.right = "0";
    window.closeCart = () => miniCart.style.right = "-420px";
    if (cartIcon) {
        cartIcon.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent the document click from closing it immediately
            openCart();
        });
    }
    document.addEventListener('click', function(e) {
        if (!miniCart.contains(e.target) && !cartIcon.contains(e.target)) {
            closeCart();
        }
    });

    // --- Mobile Menu Logic ---
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    mobileMenuButton.addEventListener('click', () => mobileMenu.classList.add('open'));
    closeMobileMenuButton.addEventListener('click', () => mobileMenu.classList.remove('open'));
});



     // Header Scroll Logic
    const header = document.getElementById('main-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 60) {
            header.classList.remove('header-transparent');
            header.classList.add('header-scrolled');
        } else {
            header.classList.add('header-transparent');
            header.classList.remove('header-scrolled');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
