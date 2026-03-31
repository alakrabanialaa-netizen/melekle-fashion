<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melekler Fashion | لوحة التحكم</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Cairo', sans-serif; }
        .sidebar-item-active {
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            border-left: 4px solid #4f46e5;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-xl hidden lg:flex flex-col sticky top-0 h-screen">
        <div class="p-8 text-center border-b">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-600 text-white rounded-xl mb-3">
                <i class="fas fa-crown text-xl"></i>
            </div>
            <h2 class="text-xl font-black text-gray-800">
                Melekler <span class="text-indigo-600">Admin</span>
            </h2>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <!-- الرئيسية -->
            <p class="text-xs font-bold text-gray-400 uppercase px-4 mb-2 tracking-widest">
                الرئيسية
            </p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
               {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                <i class="fas fa-th-large text-lg"></i>
                <span class="font-bold">لوحة التحكم</span>
            </a>

            <!-- إدارة المتجر -->
            <p class="text-xs font-bold text-gray-400 uppercase px-4 mt-6 mb-2 tracking-widest">
                إدارة المتجر
            </p>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
               {{ request()->routeIs('admin.products.*') ? 'sidebar-item-active' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                <i class="fas fa-box-open text-lg"></i>
                <span class="font-bold">المنتجات</span>
            </a>

<a href="{{ route('admin.orders.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:text-indigo-600 hover:bg-gray-50">
    <i class="fas fa-shopping-bag text-lg"></i>
    <span class="font-bold">الطلبات</span>
</a>

  <a href="{{ route('admin.clients.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl
          text-gray-500 hover:text-indigo-600 hover:bg-gray-50">
    <i class="fas fa-users text-lg"></i>
    <span class="font-bold">العملاء والموردين</span>
</a>

            <!-- النظام -->
            <p class="text-xs font-bold text-gray-400 uppercase px-4 mt-6 mb-2 tracking-widest">
                النظام
            </p>

        <a href="{{ route('admin.users.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:text-indigo-600 hover:bg-gray-50">
    <i class="fas fa-users-cog text-lg"></i>
    <span class="font-bold">المستخدمون</span>
</a>


            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:text-indigo-600 hover:bg-gray-50">
                <i class="fas fa-gear text-lg"></i>
                <span class="font-bold">الإعدادات</span>
            </a>

            <a href="{{ route('admin.accounting.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:text-indigo-600 hover:bg-gray-50">
                <i class="fas fa-file-invoice-dollar text-lg"></i>
                <span class="font-bold">المحاسبة</span>
            </a>

        </nav>

        <!-- User -->
        <div class="p-6 border-t bg-gray-50">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                     class="w-10 h-10 rounded-lg" alt="">
                <div>
                    <h4 class="text-sm font-bold">{{ auth()->user()->name }}</h4>
                    <span class="text-xs text-green-500">مدير النظام</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 text-white py-2 rounded-xl font-bold hover:bg-red-600">
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col overflow-hidden">

        <!-- Header -->
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8">
            <h1 class="text-xl font-bold text-gray-800">
                @yield('page-title', 'لوحة التحكم')
            </h1>
        </header>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>

    </main>

</div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@stack('scripts')
</body>
</html>
