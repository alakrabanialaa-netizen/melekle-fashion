<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link class="rounded-full" rel="icon" type="image/png" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/hero-bg.png">
    <title>Melekler Group | @yield('title', 'Premium Fashion')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        /* --- Global Styles --- */
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fffaf0;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .font-black { font-weight: 900; }

        /* --- Floating Header Styles --- */
        #main-header {
            position: fixed;
            top: 1rem;       
            left: 1.5rem;    
            right: 1.5rem;   
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Cairo', sans-serif;
        }

        .header-transparent {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding-top: 1rem;
            padding-bottom: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.03);
        }

        .header-scrolled {
            top: 0.5rem !important;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(244, 63, 94, 0.1);
            box-shadow: 0 10px 30px rgba(244, 63, 94, 0.05);
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
        }

        .nav-link { transition: all 0.3s ease; font-weight: 700; color: #1f2937; position: relative; }
        .nav-link:hover { color: #f43f5e !important; }
        
        .nav-icon { transition: all 0.3s ease; cursor: pointer; color: #1f2937; }
        .nav-icon:hover { color: #f43f5e !important; transform: translateY(-2px); }

        .lang-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            color: #1f2937;
        }
        .lang-btn:hover { color: #f43f5e !important; border-color: #f43f5e; transform: translateY(-2px); }

        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }
        .group:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }

        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        #mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>
<body>

<header id="main-header" class="z-50 header-transparent">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-3 items-center">
        
        {{-- 1. Left Side: Language & User --}}
        <div class="flex items-center gap-4 justify-start">
            <div class="relative group">
                <button class="lang-btn">
                    <i class="fas fa-globe-americas text-sm"></i>
                    <span class="text-xs font-black uppercase">{{ app()->getLocale() }}</span>
                </button>
                <div class="dropdown-menu absolute left-0 mt-2 w-36 bg-white rounded-2xl shadow-2xl py-2 border border-gray-100 overflow-hidden z-[100]">
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇸🇦</span> العربية
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇺🇸</span> English
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇹🇷</span> Türkçe
                    </a>
                </div>
            </div>

            {{-- 🛠️ تم التعديل إلى رابط مباشر آمن بدلاً من الـ route لمنع الانهيار --}}
            <a href="/admin/dashboard" class="nav-icon text-xl hidden md:block" title="لوحة التحكم">
                <i class="fas fa-user-shield"></i>
            </a>
        </div>
        
        {{-- 2. Center Side: Logo Image --}}
        <div class="logo-container text-center flex justify-center items-center">
            <a href="/" class="inline-block">
                <img src="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/hero-bg.png" alt="Melekler Logo" class="logo-img h-12 md:h-16 w-auto object-contain transition-all duration-300">
            </a>
        </div>

        {{-- 3. Right Side: Navigation & Cart --}}
        <div class="flex items-center gap-6 justify-end">
            <nav class="hidden lg:flex items-center gap-8 text-sm">
                <a href="/" class="nav-link">الرئيسية</a>
                
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1.5">
                        <span>الأقسام</span>
                        <i class="fas fa-chevron-down text-[9px] transition-transform group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-4 w-56 bg-white rounded-3xl shadow-2xl py-4 border border-pink-50 overflow-hidden z-[120]">
                        <a href="/category/boys" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👦 ملابس أولاد</a>
                        <a href="/category/girls" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👧 ملابس بنات</a>
                        <a href="/category/babies" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👶 ملابس رضع</a>
                        <a href="/category/mothers" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👩 ملابس نساء</a>
                    </div>
                </div>
            </nav>

            <button id="cart-icon" class="relative nav-icon text-xl">
                <i class="fas fa-shopping-bag"></i>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-pink-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-white font-bold shadow-sm">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </button>

            <button id="mobile-menu-button" class="lg:hidden nav-icon text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

{{-- 📱 Mobile Menu --}}
<div id="mobile-menu" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl z-[150] p-8">
    <button id="close-mobile-menu" class="absolute top-6 left-6 text-2xl text-gray-600">&times;</button>
    <nav class="flex flex-col gap-6 mt-12 font-bold text-gray-800">
        <a href="/" class="hover:text-pink-500">الرئيسية</a>
        <h3 class="text-gray-400 text-sm mt-4">الأقسام</h3>
        <a href="/category/boys" class="hover:text-pink-500 pr-4">ملابس أولاد</a>
        <a href="/category/girls" class="hover:text-pink-500 pr-4">ملابس بنات</a>
        <a href="/category/babies" class="hover:text-pink-500 pr-4">ملابس رضع</a>
        <a href="/category/mothers" class="hover:text-pink-500 pr-4">ملابس نساء</a>
        <hr class="border-gray-100">
        <a href="/shop" class="hover:text-pink-500">كل المنتجات</a>
        <a href="/blog" class="hover:text-pink-500">المدونة</a>
        <hr class="border-gray-100">
        {{-- 🛠️ رابط مباشر آمن للموبايل أيضاً --}}
        <a href="/admin/dashboard" class="hover:text-pink-500 flex items-center gap-2">
            <i class="fas fa-user-shield text-sm"></i> لوحة التحكم
        </a>
    </nav>
</div>

<main class="pt-28 md:pt-36 min-h-screen">
    @yield('content')
</main>

{{-- 🛒 Mini Cart --}}
<div id="mini-cart" class="fixed top-0 right-[-420px] w-[400px] h-screen bg-white shadow-2xl transition-all duration-300 z-[150] flex flex-col">
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
                            <p class="font-bold text-pink-600">{{ number_format($item['price'], 2) }} ₺</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center mt-20">
                <div class="text-6xl mb-4 text-gray-200">🛒</div>
                <p class="text-gray-500">السلة فارغة حالياً</p>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('main-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 30) {
            header.classList.remove('header-transparent');
            header.classList.add('header-scrolled');
        } else {
            header.classList.add('header-transparent');
            header.classList.remove('header-scrolled');
        }
    });

    const miniCart = document.getElementById('mini-cart');
    const cartIcon = document.getElementById('cart-icon');
    
    window.openCart = () => miniCart.style.right = "0";
    window.closeCart = () => miniCart.style.right = "-420px";
    
    if (cartIcon) {
        cartIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            openCart();
        });
    }
    document.addEventListener('click', function(e) {
        if (!miniCart.contains(e.target) && !cartIcon.contains(e.target)) {
            closeCart();
        }
    });

    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    mobileMenuButton.addEventListener('click', () => mobileMenu.classList.add('open'));
    closeMobileMenuButton.addEventListener('click', () => mobileMenu.classList.remove('open'));
});
</script>

</body>
</html>
