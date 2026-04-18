<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $items = Brand::latest()->paginate(10);

        return view('backend.brands.index', [
            'items' => $items,
            'title' => 'Quan ly thuong hieu',
            'routePrefix' => 'admin.brands',
        ]);
    }

    public function create()
    {
        return view('backend.brands.form', [
            'title' => 'Them thuong hieu',
            'formTitle' => 'Tao thuong hieu',
            'action' => route('admin.brands.store'),
            'method' => 'POST',
            'routePrefix' => 'admin.brands',
            'item' => null,
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->makeUniqueSlug($data['name']);
        $data['description'] = $data['description'] ?? '';
        $data['created_by'] = 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/brands'), $filename);
            $data['image'] = $filename;
        }

        Brand::create($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Them thanh cong');
    }

    public function edit($id)
    {
        $item = Brand::findOrFail($id);

        return view('backend.brands.form', [
            'title' => 'Sua thuong hieu',
            'formTitle' => 'Cap nhat thuong hieu',
            'action' => route('admin.brands.update', $id),
            'method' => 'PUT',
            'routePrefix' => 'admin.brands',
            'item' => $item,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Brand::findOrFail($id);
        $data = $this->validateData($request, $item->id);
        $data['slug'] = $this->makeUniqueSlug($data['name'], $item->id);
        $data['description'] = $data['description'] ?? ($item->description ?? '');
        $data['updated_by'] = 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/brands'), $filename);
            $data['image'] = $filename;
        }

        $item->update($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Cap nhat thanh cong');
    }

    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();

        return back()->with('success', 'Da vao thung rac');
    }

    public function trash()
    {
        $items = Brand::onlyTrashed()->paginate(10);

        return view('backend.brands.trash', compact('items'), [
            'title' => 'Thung rac',
            'routePrefix' => 'admin.brands',
        ]);
    }

    public function restore($id)
    {
        Brand::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.brands.trash')->with('success', 'Da khoi phuc');
    }

    public function forceDelete($id)
    {
        Brand::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.brands.trash')->with('success', 'Da xoa vinh vien');
    }

    public function status($id)
    {
        $item = Brand::findOrFail($id);
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();

        return back()->with('success', 'Da cap nhat trang thai thuong hieu');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:1000',
                Rule::unique('brand', 'name')->ignore($ignoreId),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: 'brand';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Brand::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function fields(): array
    {
        return [
            'name' => ['label' => 'Ten thuong hieu'],
            'description' => ['label' => 'Mo ta', 'type' => 'textarea', 'column' => '12'],
            'status' => [
                'label' => 'Trang thai',
                'type' => 'select',
                'options' => [1 => 'Hien thi', 0 => 'An'],
            ],
            'image' => ['label' => 'Hinh anh', 'type' => 'file'],
        ];
    }
}
