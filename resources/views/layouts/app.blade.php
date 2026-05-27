<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/favicon.png?v=2">
    <title>Melekler Group | @yield('title', 'Premium Fashion')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        /* --- Global Styles --- */
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fffaf0; /* متناسق مع الكريمي الناعم لصفحة الأطفال */
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .font-black { font-weight: 900; }

        /* --- Floating Header Styles --- */
        #main-header {
            position: fixed;
            top: 0;       
            left: 0;    
            right: 0;   
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Cairo', sans-serif;
        }

        /* Initial Transparent State */
        .header-transparent {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(6px);
            padding-top: 1.2rem;
            padding-bottom: 1.2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        /* Scrolled Glassy State */
        .header-scrolled {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
        }

        /* Logo Configuration */
        .logo-container { transition: all 0.4s ease; }
        
        /* Nav Links */
        .nav-link { transition: all 0.3s ease; font-weight: 700; position: relative; color: #374151; }
        .nav-link:hover { color: #f43f5e !important; }

        /* Icons */
        .nav-icon { transition: all 0.3s ease; cursor: pointer; color: #374151; }
        .nav-icon:hover { color: #f43f5e !important; transform: translateY(-2px); }

        /* Language Switcher Button */
        .lang-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
        }
        .lang-btn:hover { color: #f43f5e !important; border-color: #f43f5e; transform: translateY(-2px); }

        /* Dropdowns */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }
        .group:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }

        /* Mobile Menu Styles */
        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        #mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-50">

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

            <a href="{{ route('login') }}" class="nav-icon text-xl hidden md:block">
                <i class="far fa-user-circle"></i>
            </a>
        </div>
        
        {{-- 2. Center Side: Logo Image --}}
        <div class="logo-container text-center flex justify-center items-center">
            <a href="{{ route('welcome') }}" class="inline-block">
                <img src="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/favicon.png?v=2" alt="Melekler Logo" class="logo-img h-14 md:h-20 w-auto object-contain transition-all duration-300">
            </a>
        </div>

        {{-- 3. Right Side: Navigation & Cart --}}
        <div class="flex items-center gap-6 justify-end">
            <nav class="hidden lg:flex items-center gap-8 text-sm">
                <a href="{{ route('welcome') }}" class="nav-link">الرئيسية</a>
                
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
<div id="mobile-menu" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl z-50 p-8">
    <button id="close-mobile-menu" class="absolute top-6 left-6 text-2xl text-gray-600">&times;</button>
    <nav class="flex flex-col gap-6 mt-12 font-bold text-gray-800">
        <a href="{{ route('welcome') }}" class="hover:text-orange-500">الرئيسية</a>
        <h3 class="text-gray-400 text-sm mt-4">الأقسام</h3>
        <a href="{{ route('category.boys') }}" class="hover:text-orange-500 pr-4">ملابس أولاد</a>
        <a href="{{ route('category.girls') }}" class="hover:text-orange-500 pr-4">ملابس بنات</a>
        <a href="{{ route('category.babies') }}" class="hover:text-orange-500 pr-4">ملابس رضع</a>
        <hr>
        <a href="{{ route('admin.products.index') }}" class="hover:text-orange-500">كل المنتجات</a>
        <a href="#" class="text-red-500">تخفيضات</a>
        <hr>
        <a href="{{ route('login') }}" class="hover:text-orange-500">تسجيل الدخول</a>
    </nav>
</div>

{{-- مساحة حماية علوية ذكية لمنع صعود المحتوى تحت الهيرو وعرضه بطريقة متناسقة تماماً --}}
<main class="pt-24 md:pt-32 min-h-screen">
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
                            <p class="font-bold text-pink-600">{{ number_format($item['price'], 2) }} ₺</p>
                        </div>
                    </div>
                    
                    <button onclick="window.location.href='{{ url('/cart-remove/'.$id) }}'" class="text-gray-300 hover:text-red-500 transition">
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
                <span class="text-xl font-bold text-pink-600">{{ number_format($total, 2) }} ₺</span>
            </div>
            <a href="{{ route('mycart') }}" class="block w-full bg-pink-600 text-white text-center py-3 rounded-xl hover:bg-pink-700 transition font-bold shadow-md">عرض السلة وتثبيت الطلب</a>
            <a href="{{ route('mycart') }}" class="block w-full mt-3 bg-black text-white text-center py-3 rounded-xl hover:bg-gray-800 transition font-semibold shadow-md">الدفع الآن عبر واتساب</a>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Header Scroll Effect ---
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

    // --- Mini Cart Logic ---
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

    // --- Mobile Menu Logic ---
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    mobileMenuButton.addEventListener('click', () => mobileMenu.classList.add('open'));
    closeMobileMenuButton.addEventListener('click', () => mobileMenu.classList.remove('open'));
});

function addToCart(productId) {
    $.ajax({
        type: "POST",
        url: "/cart/data/store/" + productId,
        dataType: 'json',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if(response.status == 'success') {
                document.getElementById('mini-cart').style.right = "0";
                location.reload();
            }
        },
        error: function(error) {
            console.log(error);
            alert('يرجى المحاولة مجدداً أو مراجعة الكنترولر.');
        }
    });
}
</script>

</body>
</html>
