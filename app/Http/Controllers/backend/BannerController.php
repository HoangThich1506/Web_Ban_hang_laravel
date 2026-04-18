<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $items = Banner::latest()->paginate(10);

        return view('backend.banners.index', [
            'items' => $items,
            'title' => 'Banner',
            'routePrefix' => 'admin.banners',
        ]);
    }

    public function create()
    {
        return view('backend.banners.form', [
            'title' => 'Them',
            'formTitle' => 'Tao',
            'action' => route('admin.banners.store'),
            'method' => 'POST',
            'routePrefix' => 'admin.banners',
            'item' => null,
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['created_by'] = 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/banners'), $name);
            $data['image'] = $name;
        }

        Banner::create($data);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Them banner thanh cong');
    }

    public function edit($id)
    {
        $item = Banner::findOrFail($id);

        return view('backend.banners.form', [
            'title' => 'Cap nhat',
            'formTitle' => 'Sua',
            'action' => route('admin.banners.update', $item->id),
            'method' => 'PUT',
            'routePrefix' => 'admin.banners',
            'item' => $item,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Banner::findOrFail($id);
        $data = $this->validateData($request);
        $data['updated_by'] = 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/banners'), $name);
            $data['image'] = $name;
        }

        $item->update($data);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Cap nhat thanh cong');
    }

    public function destroy($id)
    {
        Banner::findOrFail($id)->delete();

        return back()->with('success', 'Da vao thung rac');
    }

    public function trash()
    {
        $items = Banner::onlyTrashed()->paginate(10);

        return view('backend.banners.trash', compact('items'), [
            'title' => 'Thung rac',
            'routePrefix' => 'admin.banners',
        ]);
    }

    public function restore($id)
    {
        Banner::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.banners.trash')->with('success', 'Da khoi phuc');
    }

    public function forceDelete($id)
    {
        Banner::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.banners.trash')->with('success', 'Da xoa vinh vien');
    }

    public function status($id)
    {
        $item = Banner::findOrFail($id);
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();

        return back()->with('success', 'Da cap nhat trang thai banner');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:1000'],
            'link' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'in:slideshow,advertise'],
            'status' => ['required', 'integer', 'in:0,1'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function fields(): array
    {
        return [
            'name' => ['label' => 'Ten'],
            'link' => ['label' => 'Link'],
            'position' => [
                'label' => 'Vi tri',
                'type' => 'select',
                'options' => [
                    'slideshow' => 'Slideshow',
                    'advertise' => 'Advertise',
                ],
            ],
            'description' => ['label' => 'Mo ta', 'type' => 'textarea', 'column' => '12'],
            'image' => ['label' => 'Hinh', 'type' => 'file'],
            'status' => [
                'label' => 'Trang thai',
                'type' => 'select',
                'options' => [1 => 'Hien thi', 0 => 'An'],
            ],
        ];
    }
}
