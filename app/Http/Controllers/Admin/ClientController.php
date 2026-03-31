<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // عرض العملاء والموردين
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    // صفحة الإضافة
    public function create()
    {
        return view('admin.clients.create');
    }

    // حفظ
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string',
            'email'   => 'nullable|email',
            'country' => 'nullable|string',
            'city'    => 'nullable|string',
            'address' => 'nullable|string',
            'type'    => 'required|in:customer,supplier',
        ]);

        Client::create($data);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'تمت الإضافة بنجاح');
    }
}
