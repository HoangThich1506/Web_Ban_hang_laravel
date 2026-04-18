<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $items = User::latest()->paginate(10);

        return view('backend.users.index', [
            'items' => $items,
            'title' => 'Thanh vien',
            'routePrefix' => 'admin.users',
        ]);
    }

    public function create()
    {
        return view('backend.users.form', [
            'title' => 'Them thanh vien',
            'formTitle' => 'Tao tai khoan moi',
            'action' => route('admin.users.store'),
            'method' => 'POST',
            'routePrefix' => 'admin.users',
            'item' => null,
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'email' => 'required|email|max:255|unique:user,email',
            'phone' => 'required|string|max:255|unique:user,phone',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
            'status' => 'required|integer',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['roles'] = 'user';
        $data['created_by'] = 1;
        $data['created_at'] = now();

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Tao thanh vien thanh cong');
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);

        return view('backend.users.form', [
            'title' => 'Cap nhat thanh vien',
            'formTitle' => 'Chinh sua tai khoan',
            'action' => route('admin.users.update', $id),
            'method' => 'PUT',
            'routePrefix' => 'admin.users',
            'item' => $item,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username,' . $id,
            'email' => 'required|email|max:255|unique:user,email,' . $id,
            'phone' => 'required|string|max:255|unique:user,phone,' . $id,
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'status' => 'required|integer',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['updated_by'] = 1;
        $data['updated_at'] = now();

        $item->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cap nhat thanh vien thanh cong');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Da dua vao thung rac');
    }

    public function trash()
    {
        $items = User::onlyTrashed()->paginate(10);

        return view('backend.users.trash', [
            'items' => $items,
            'title' => 'Thung rac thanh vien',
            'routePrefix' => 'admin.users',
        ]);
    }

    public function restore($id)
    {
        User::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.users.trash')->with('success', 'Khoi phuc thanh vien thanh cong');
    }

    public function forceDelete($id)
    {
        User::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.users.trash')->with('success', 'Da xoa vinh vien thanh vien');
    }

    private function fields(): array
    {
        return [
            'name' => ['label' => 'Ho ten'],
            'username' => ['label' => 'Ten dang nhap'],
            'email' => ['label' => 'Email', 'type' => 'email'],
            'phone' => ['label' => 'So dien thoai'],
            'address' => ['label' => 'Dia chi'],
            'password' => ['label' => 'Mat khau', 'type' => 'password'],
            'status' => [
                'label' => 'Trang thai',
                'type' => 'select',
                'options' => [1 => 'Hoat dong', 0 => 'Khoa'],
            ],
        ];
    }

    use SoftDeletes;
}
