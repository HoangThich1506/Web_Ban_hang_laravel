<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $items = Order::latest()->paginate(10);

        return view('backend.orders.index', [
            'items' => $items,
            'title' => 'Don hang',
            'routePrefix' => 'admin.orders',
        ]);
    }

    public function create()
    {
        return view('backend.orders.form', [
            'title' => 'Tao don hang',
            'formTitle' => 'Them don hang moi',
            'action' => route('admin.orders.store'),
            'method' => 'POST',
            'routePrefix' => 'admin.orders',
            'item' => null,
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'note' => 'nullable|string',
            'status' => 'required|integer',
        ]);

        $data['user_id'] = 1;
        $data['created_at'] = now();

        Order::create($data);

        return redirect()->route('admin.orders.index')->with('success', 'Tao don hang thanh cong');
    }

    public function edit($id)
    {
        $item = Order::findOrFail($id);

        return view('backend.orders.form', [
            'title' => 'Cap nhat don hang',
            'formTitle' => 'Chinh sua don hang',
            'action' => route('admin.orders.update', $id),
            'method' => 'PUT',
            'routePrefix' => 'admin.orders',
            'item' => $item,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Order::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'note' => 'nullable|string',
            'status' => 'required|integer',
        ]);

        $data['updated_at'] = now();
        $data['updated_by'] = 1;

        $item->update($data);

        return redirect()->route('admin.orders.index')->with('success', 'Cap nhat don hang thanh cong');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return back()->with('success', 'Da dua vao thung rac');
    }

    public function trash()
    {
        $items = Order::onlyTrashed()->paginate(10);

        return view('backend.orders.trash', [
            'items' => $items,
            'title' => 'Thung rac don hang',
            'routePrefix' => 'admin.orders',
        ]);
    }

    public function restore($id)
    {
        Order::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.orders.trash')->with('success', 'Khoi phuc don hang thanh cong');
    }

    public function forceDelete($id)
    {
        Order::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.orders.trash')->with('success', 'Da xoa vinh vien don hang');
    }

    private function fields(): array
    {
        return [
            'name' => ['label' => 'Ten khach hang'],
            'email' => ['label' => 'Email', 'type' => 'email'],
            'phone' => ['label' => 'So dien thoai'],
            'address' => ['label' => 'Dia chi', 'type' => 'textarea'],
            'note' => ['label' => 'Ghi chu', 'type' => 'textarea'],
            'status' => [
                'label' => 'Trang thai',
                'type' => 'select',
                'options' => [1 => 'Da duyet', 0 => 'Cho xu ly'],
            ],
        ];
    }

    use SoftDeletes;
}
