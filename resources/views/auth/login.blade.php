<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- 🌐 إضافة اللوغو في نافذة غوغل (Favicon) --}}
    <link rel="icon" type="image/png" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/hero-bg.png">
    
    <title>تسجيل الدخول - Melekler Fashion</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fffaf0;
            /* 1. تأثير التكستشر القماشي الفخم للخلفية */
            background-image: 
                linear-gradient(rgba(244, 63, 94, 0.01) 1.5px, transparent 1.5px),
                linear-gradient(90deg, rgba(244, 63, 94, 0.01) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }
        
        .login-container {
            animation: popIn 0.6s cubic-bezier(.4,0,.2,1);
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* أنيميشن الشريط الإخباري المتحرك بسلاسة */
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .marquee-content {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 20s linear infinite;
        }

        /* أنيميشن لطيف للأطفال بجانب الكرت */
        @keyframes gentleBounce {
            0%, 100% { transform: translateY(0) scaleX(1); }
            50% { transform: translateY(-8px) scaleX(0.98); }
        }
        .dancing-kid {
            animation: gentleBounce 3s ease-in-out infinite;
        }

        /* أنيميشن زر الباب المطور */
        .btn-scene {
            position: absolute;
            opacity: 0;
            transition: 0.4s;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            width: 40px;
            height: 35px;
        }

        .btn-door {
            width: 18px;
            height: 26px;
            background: #fff;
            border-radius: 3px 3px 0 0;
            transform-origin: right;
            transition: 0.5s;
        }

        .btn-person {
            position: absolute;
            bottom: 0;
            right: 50px;
            width: 8px;
            height: 20px;
            opacity: 0;
            transition: 0.6s cubic-bezier(0.4,0,0.2,1);
        }

        .btn-person::before {
            content: '';
            position: absolute;
            top: 0;
            width: 6px;
            height: 6px;
            background: #f43f5e;
            border-radius: 50%;
            left: 1px;
        }

        .btn-person::after {
            content: '';
            position: absolute;
            top: 6px;
            width: 4px;
            height: 12px;
            background: #db2777;
            border-radius: 2px;
            left: 2px;
        }

        .login-btn.active .btn-text {
            transform: translateY(-40px);
            opacity: 0;
        }

        .login-btn.active .btn-scene {
            opacity: 1;
        }

        .login-btn.active .btn-door {
            transform: rotateY(-100deg);
            background: #eee;
        }

        .login-btn.active .btn-person {
            right: 24px;
            opacity: 1;
            transform: scale(0.85);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden bg-[#fffaf0]">

    {{-- 2. الشريط الإخباري المتحرك (Ticker) في أعلى الصفحة --}}
    <div class="absolute top-0 left-0 w-full bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 text-white text-xs font-bold py-2 overflow-hidden shadow-sm z-30">
        <div class="marquee-content flex gap-12 items-center">
            <span>✨ أهلاً بك في Melekler Fashion - تشكيلة الصيف الجديدة وصلت الآن! 🛍️</span>
            <span>🚚 شحن مجاني للطلبات فوق 500 ₺ داخل كافة الولايات 🇹🇷</span>
            <span>🎀 جودة ممتازة وخامات قطنية 100% تناسب عائلتك 👦👧</span>
            <span>🔥 سجل دخولك الآن واستمتع بخصم 10% على أول طلب لك!</span>
        </div>
    </div>

    {{-- الدوائر الجمالية في الخلفية --}}
    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-pink-200/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-amber-100/40 rounded-full blur-3xl pointer-events-none"></div>

    {{-- الحاوية الرئيسية التي تجمع الكرت مع عناصر الأطفال التفاعلية --}}
    <div class="relative max-w-[460px] w-full mt-8 z-10">
        
        {{-- 3. الولد والبنت فاشن أنيميشن (يتحركون بلطافة حول كرت الدخول) --}}
        <div class="dancing-kid absolute -top-16 -right-12 text-5xl select-none filter drop-shadow-md hidden sm:block" title="أزياء أولاد">👦🏻🎒</div>
        <div class="dancing-kid absolute -bottom-10 -left-14 text-5xl select-none filter drop-shadow-md hidden sm:block" style="animation-delay: 1.5s;" title="أزياء بنات">👧🏻👗</div>

        {{-- كرت تسجيل الدخول المتناسق مع التكستشر --}}
        <div class="login-container bg-white/80 backdrop-blur-md rounded-[32px] border border-pink-100/60 shadow-[0_32px_80px_rgba(244,63,94,0.06)] p-8 md:p-10 w-full transition-all duration-300 hover:shadow-[0_32px_85px_rgba(244,63,94,0.09)]">
            
            {{-- الهيدر مع شعار الهوية البصرية --}}
            <div class="text-center mb-8">
                <div class="inline-block mb-3 transition-transform duration-500 hover:scale-105">
                    <img src="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/hero-bg.png" alt="Melekler Logo" class="h-20 w-auto object-contain mx-auto">
                </div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">مرحباً بك مجدداً</h1>
                <p class="text-gray-400 text-sm mt-1 font-medium">سجل دخولك إلى Melekler Fashion</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- حقل البريد الإلكتروني --}}
                <div class="space-y-2 group">
                    <label class="block font-bold text-gray-700 text-sm transition-colors duration-300 group-focus-within:text-pink-500">البريد الإلكتروني</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-400 group-focus-within:text-pink-500 transition-colors">
                            <i class="far fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pr-11 pl-4 py-3.5 bg-white/50 border-2 border-gray-100 rounded-2xl text-sm focus:outline-none focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-400/10 transition-all duration-300 placeholder-gray-300 font-medium text-gray-700"
                               placeholder="example@domain.com">
                    </div>
                    @error('email') <div class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</div> @enderror
                </div>

                {{-- حقل كلمة المرور --}}
                <div class="space-y-2 group">
                    <label class="block font-bold text-gray-700 text-sm transition-colors duration-300 group-focus-within:text-pink-500">كلمة المرور</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-400 group-focus-within:text-pink-500 transition-colors">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required
                               class="w-full pr-11 pl-4 py-3.5 bg-white/50 border-2 border-gray-100 rounded-2xl text-sm focus:outline-none focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-400/10 transition-all duration-300 placeholder-gray-300 text-gray-700"
                               placeholder="••••••••">
                    </div>
                    @error('password') <div class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</div> @enderror
                </div>

                {{-- تذكرني ونست كود المرور (جماليات إضافية) --}}
                <div class="flex items-center justify-between text-xs font-bold text-gray-500 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-pink-500 focus:ring-pink-400 border-gray-200 accent-pink-500">
                        <span>تذكرني دائماً</span>
                    </label>
                    <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">نسيت كلمة المرور؟</a>
                </div>

                {{-- زر تسجيل الدخول التفاعلي --}}
                <button type="submit" class="login-btn relative overflow-hidden w-full h-14 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold rounded-2xl shadow-lg shadow-pink-500/20 hover:shadow-pink-500/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center mt-6 cursor-pointer" id="authBtn">
                    <span class="btn-text text-base">تسجيل الدخول</span>
                    <div class="btn-scene">
                        <div class="btn-person"></div>
                        <div class="btn-door"></div>
                    </div>
                </button>
            </form>

            {{-- روابط الإنشاء --}}
            <div class="text-center mt-8 text-sm text-gray-500 font-bold">
                ليس لديك حساب بعد؟ 
                <a href="{{ route('register') }}" class="text-pink-500 hover:text-rose-600 transition-colors duration-200 underline decoration-2 underline-offset-4 mr-1">
                    إنشاء حساب جديد
                </a>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('authBtn').classList.add('active');
        });
    </script>

</body>
</html>
