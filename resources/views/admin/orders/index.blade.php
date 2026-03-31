@extends('admin.layouts.app')

@section('page-title', 'الطلبات')

@section('content')
<div class="space-y-6">

    {{-- العنوان --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-black text-gray-800">إدارة الطلبات</h1>
    </div>

    {{-- الجدول --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-right">
            <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">المستخدم</th>
                    <th class="px-6 py-4">الإجمالي</th>
                    <th class="px-6 py-4">الحالة</th>
                    <th class="px-6 py-4 text-center">إجراءات</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-bold">{{ $order->id }}</td>

                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">
                            {{ $order->user->name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $order->created_at->format('Y-m-d H:i') }}
                        </div>
                    </td>

                    <td class="px-6 py-4 font-bold text-indigo-600">
                        {{ number_format($order->total, 2) }} ر.س
                    </td>

                    <td class="px-6 py-4">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'processing' => 'bg-blue-100 text-blue-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp

                        <span class="px-3 py-1 text-xs font-bold rounded-full
                            {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="inline-flex items-center gap-1 px-4 py-2 text-sm font-bold
                                  bg-indigo-600 text-white rounded-lg
                                  hover:bg-indigo-700 transition">
                            <i class="fas fa-eye"></i>
                            عرض
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-4 text-gray-300"></i>
                        <p class="font-bold text-lg">لا توجد طلبات حتى الآن</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

</div>
@endsection
