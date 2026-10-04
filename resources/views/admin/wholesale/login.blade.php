@extends('layouts.app')

@section('content')
<div dir="rtl" class="min-h-[70vh] flex items-center justify-center bg-stone-50 px-4 py-16">
    <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-xl border border-amber-100">
        <div class="text-center mb-8">
            <div class="mx-auto mb-4 grid h-16 w-16 place-items-center rounded-2xl bg-zinc-950 text-amber-300 text-2xl">♜</div>
            <p class="text-xs font-black tracking-[.2em] text-amber-700">MELEKLER BUSINESS</p>
            <h1 class="mt-2 text-3xl font-black text-zinc-900">دخول تجار الجملة</h1>
            <p class="mt-3 text-sm text-zinc-500">أدخل الكود الخاص بك للوصول إلى المواد المخصصة للتجار.</p>
        </div>

        @if(session('error')) <div class="mb-4 rounded-xl bg-red-50 p-3 text-sm font-bold text-red-700">{{ session('error') }}</div> @endif
        @if(session('status')) <div class="mb-4 rounded-xl bg-emerald-50 p-3 text-sm font-bold text-emerald-700">{{ session('status') }}</div> @endif
        @error('code') <div class="mb-4 rounded-xl bg-red-50 p-3 text-sm font-bold text-red-700">{{ $message }}</div> @enderror

        <form method="POST" action="{{ route('wholesale.login.submit') }}" class="space-y-5">
            @csrf
            <div>
                <label for="code" class="mb-2 block text-sm font-black text-zinc-800">كود التاجر</label>
                <input id="code" name="code" value="{{ old('code') }}" required autofocus autocomplete="one-time-code"
                       class="w-full rounded-2xl border border-zinc-200 px-4 py-4 text-center text-xl font-black tracking-[.18em] outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
                       placeholder="أدخل الكود" dir="ltr">
            </div>
            <button class="w-full rounded-2xl bg-zinc-950 px-5 py-4 font-black text-white transition hover:bg-amber-600 hover:text-zinc-950">متابعة إلى مواد التجار ←</button>
        </form>
        <p class="mt-6 text-center text-xs text-zinc-400">الكود يُمنح من إدارة المتجر فقط.</p>
    </div>
</div>
@endsection
