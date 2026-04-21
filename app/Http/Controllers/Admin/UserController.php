<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 📋 عرض المستخدمين
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // ➕ صفحة إضافة مستخدم
    public function create()
    {
        return view('admin.users.create');
    }

    // 💾 حفظ مستخدم جديد
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'type'     => 'required|in:admin,client,supplier',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->type === 'admin' ? 1 : 0,
            'type'     => $request->type,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    // ✏️ صفحة التعديل
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 🔄 تحديث المستخدم
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'type'  => 'required|in:admin,client,supplier',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'is_admin' => $request->type === 'admin' ? 1 : 0,
            'type'     => $request->type,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    // 🗑️ حذف مستخدم
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم');
    }
}
