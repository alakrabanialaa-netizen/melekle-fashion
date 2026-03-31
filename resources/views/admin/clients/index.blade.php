@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-black">العملاء والموردين</h1>

        <a href="{{ route('admin.clients.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-xl font-bold">
            + إضافة جديد
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <table class="w-full text-right">
            <thead class="bg-gray-50 text-sm">
                <tr>
                    <th class="p-4">الاسم</th>
                    <th class="p-4">الهاتف</th>
                    <th class="p-4">البلد</th>
                    <th class="p-4">النوع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4 font-bold">{{ $client->name }}</td>
                    <td class="p-4">{{ $client->phone }}</td>
                    <td class="p-4">{{ $client->country }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $client->type == 'customer' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $client->type == 'customer' ? 'عميل' : 'مورد' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $clients->links() }}

</div>
@endsection
