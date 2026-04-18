<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $items = Menu::with('parent')->latest()->paginate(10);

        return view('backend.menus.index', [
            'items' => $items,
            'title' => 'Menu',
            'routePrefix' => 'admin.menus',
        ]);
    }

    public function create()
    {
        return view('backend.menus.form', [
            'title' => 'Them',
            'formTitle' => 'Tao menu',
            'action' => route('admin.menus.store'),
            'method' => 'POST',
            'routePrefix' => 'admin.menus',
            'item' => null,
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['created_by'] = 1;

        Menu::create($data);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Them menu thanh cong');
    }

    public function destroy($id)
    {
        Menu::findOrFail($id)->delete();

        return back()->with('success', 'Da vao thung rac');
    }

    public function edit($id)
    {
        $item = Menu::findOrFail($id);

        return view('backend.menus.form', [
            'title' => 'Cap nhat',
            'formTitle' => 'Chinh sua menu',
            'action' => route('admin.menus.update', $item->id),
            'method' => 'PUT',
            'routePrefix' => 'admin.menus',
            'item' => $item,
            'fields' => $this->fields($item->id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Menu::findOrFail($id);
        $data = $this->validateData($request, $item->id);
        $data['updated_by'] = 1;

        $item->update($data);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Cap nhat thanh cong');
    }

    public function trash()
    {
        $items = Menu::with('parent')->onlyTrashed()->paginate(10);

        return view('backend.menus.trash', compact('items'), [
            'title' => 'Thung rac',
            'routePrefix' => 'admin.menus',
        ]);
    }

    public function restore($id)
    {
        Menu::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.menus.trash');
    }

    public function forceDelete($id)
    {
        Menu::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.menus.trash');
    }

    public function status($id)
    {
        $item = Menu::findOrFail($id);
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();

        return back()->with('success', 'Da cap nhat trang thai menu');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'integer', 'in:0,1'],
        ]);

        $parentId = (int) ($data['parent_id'] ?? 0);

        if ($ignoreId !== null && $parentId === $ignoreId) {
            return back()
                ->withErrors(['parent_id' => 'Menu cha khong hop le.'])
                ->withInput()
                ->throwResponse();
        }

        if ($parentId > 0 && ! Menu::where('id', $parentId)->exists()) {
            return back()
                ->withErrors(['parent_id' => 'Menu cha khong ton tai.'])
                ->withInput()
                ->throwResponse();
        }

        $data['parent_id'] = $parentId;

        return $data;
    }

    private function fields(?int $ignoreId = null): array
    {
        $parentOptions = [0 => 'Khong co menu cha'] + Menu::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        return [
            'name' => ['label' => 'Ten'],
            'link' => ['label' => 'Link'],
            'parent_id' => [
                'label' => 'Id cha',
                'type' => 'select',
                'options' => $parentOptions,
            ],
            'status' => [
                'label' => 'Trang thai',
                'type' => 'select',
                'options' => [1 => 'Hien thi', 0 => 'An'],
            ],
        ];
    }
}
