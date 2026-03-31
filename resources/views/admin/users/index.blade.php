@extends('admin.layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">المستخدمون</h1>

        <a href="{{ route('admin.users.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            + إضافة مستخدم
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-right">
            <thead class="bg-gray-100 text-sm">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">الاسم</th>
                    <th class="p-3">الإيميل</th>
                    <th class="p-3">النوع</th>
                    <th class="p-3 text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t">
                    <td class="p-3">{{ $user->id }}</td>
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">
                        @if($user->is_admin)
                            <span class="text-green-600 font-bold">Admin</span>
                        @else
                            <span class="text-gray-600">User</span>
                        @endif
                    </td>
                    <td class="p-3 text-center flex justify-center gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="px-3 py-1 bg-blue-100 text-blue-700 rounded">
                            تعديل
                        </a>

                        <form method="POST"
                              action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-100 text-red-700 rounded">
                                حذف
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>
@endsection
