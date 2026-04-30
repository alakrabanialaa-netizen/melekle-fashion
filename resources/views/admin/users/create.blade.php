@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6 text-center">إضافة مستخدم جديد</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <!-- عرض رسالة نجاح -->
@if (session('success'))
    <div style="background-color: #d1fae5; border-right: 4px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: right;">
        {{ session('success') }}
    </div>
@endif

<!-- عرض رسالة خطأ النظام -->
@if (session('error'))
    <div style="background-color: #fee2e2; border-right: 4px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: right;">
        {{ session('error') }}
    </div>
@endif
        
        {{-- الاسم --}}
        <div class="mb-4">
            <label class="block mb-1 font-bold">الاسم</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        {{-- الإيميل --}}
        <div class="mb-4">
            <label class="block mb-1 font-bold">الإيميل</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        {{-- كلمة المرور --}}
        <div class="mb-4">
            <label class="block mb-1 font-bold">كلمة المرور</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        {{-- هل أدمن --}}
        <div class="mb-6 flex items-center gap-2">
            <input type="checkbox" name="is_admin" value="1" id="is_admin">
            <label for="is_admin" class="font-bold">أدمن</label>
        </div>

        {{-- أزرار --}}
        <div class="flex gap-3">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                حفظ
            </button>

            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                رجوع
            </a>
        </div>

    </form>
</div>
@endsection
