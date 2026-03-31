@extends('admin.layouts.app')

@section('content')

<h1 class="text-xl font-bold mb-4">طلب #{{ $order->id }}</h1>

<p>العميل: {{ $order->user->name }}</p>
<p>الإجمالي: {{ $order->total }}</p>

<form method="POST" action="{{ route('admin.orders.update', $order) }}">
    @csrf
    @method('PUT')

    <select name="status">
        <option value="pending">Pending</option>
        <option value="paid">Paid</option>
        <option value="shipped">Shipped</option>
    </select>

    <button>تحديث الحالة</button>
</form>

<hr>

<h3 class="mt-4 font-bold">المنتجات</h3>

<ul>
@foreach($order->items as $item)
    <li>
        {{ $item->product->name }} × {{ $item->quantity }}
        ({{ $item->price }})
    </li>
@endforeach
</ul>

@endsection
