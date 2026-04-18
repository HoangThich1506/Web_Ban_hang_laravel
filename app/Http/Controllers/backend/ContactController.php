<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $items = Contact::latest()->paginate(10);

        return view('backend.contacts.index', [
            'items' => $items,
            'title' => 'Lien he',
            'routePrefix' => 'admin.contacts',
        ]);
    }

    public function create()
    {
        return view('backend.contacts.form', [
            'title' => 'Them lien he',
            'formTitle' => 'Tao lien he moi',
            'action' => route('admin.contacts.store'),
            'method' => 'POST',
            'item' => null,
            'routePrefix' => 'admin.contacts',
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'title' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'status' => 'required|integer',
        ]);

        $data['replay_id'] = 0;
        $data['created_at'] = now();

        Contact::create($data);

        return redirect()->route('admin.contacts.index')->with('success', 'Tao lien he thanh cong');
    }

    public function edit($id)
    {
        $item = Contact::findOrFail($id);

        return view('backend.contacts.form', [
            'title' => 'Cap nhat lien he',
            'formTitle' => 'Chinh sua lien he',
            'action' => route('admin.contacts.update', $id),
            'method' => 'PUT',
            'item' => $item,
            'routePrefix' => 'admin.contacts',
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Contact::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'title' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'status' => 'required|integer',
        ]);

        $data['updated_at'] = now();
        $data['updated_by'] = 1;

        $item->update($data);

        return redirect()->route('admin.contacts.index')->with('success', 'Cap nhat lien he thanh cong');
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();

        return back()->with('success', 'Da dua vao thung rac');
    }

    public function trash()
    {
        $items = Contact::onlyTrashed()->paginate(10);

        return view('backend.contacts.trash', [
            'items' => $items,
            'title' => 'Thung rac lien he',
            'routePrefix' => 'admin.contacts',
        ]);
    }

    public function restore($id)
    {
        Contact::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.contacts.trash')->with('success', 'Khoi phuc lien he thanh cong');
    }

    public function forceDelete($id)
    {
        Contact::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.contacts.trash')->with('success', 'Da xoa vinh vien lien he');
    }

    private function fields(): array
    {
        return [
            'name' => ['label' => 'Ten nguoi gui'],
            'email' => ['label' => 'Email', 'type' => 'email'],
            'phone' => ['label' => 'So dien thoai'],
            'title' => ['label' => 'Tieu de', 'column' => '12'],
            'content' => ['label' => 'Noi dung', 'type' => 'textarea'],
            'status' => [
                'label' => 'Trang thai',
                'type' => 'select',
                'options' => [1 => 'Da xu ly', 0 => 'Cho xu ly'],
            ],
        ];
    }
}
