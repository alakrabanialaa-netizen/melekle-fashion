@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6 text-center">تعديل المستخدم</h1>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        {{-- الاسم --}}
        <div class="mb-4">
            <label class="block mb-1 font-bold">الاسم</label>
            <input type="text" name="name"
                   value="{{ $user->name }}"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        {{-- الإيميل --}}
        <div class="mb-4">
            <label class="block mb-1 font-bold">الإيميل</label>
            <input type="email" name="email"
                   value="{{ $user->email }}"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        {{-- كلمة المرور (اختياري) --}}
        <div class="mb-4">
            <label class="block mb-1 font-bold">كلمة المرور (اختياري)</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2"
                   placeholder="اتركها فارغة إن لم ترد التغيير">
        </div>

        {{-- أدمن --}}
        <div class="mb-6 flex items-center gap-2">
            <input type="checkbox" name="is_admin" value="1"
                   id="is_admin"
                   {{ $user->is_admin ? 'checked' : '' }}>
            <label for="is_admin" class="font-bold">أدمن</label>
        </div>

        {{-- أزرار --}}
        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                تحديث
            </button>

            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                رجوع
            </a>
        </div>

    </form>
</div>
@endsection
