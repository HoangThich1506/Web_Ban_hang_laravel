<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::latest()->paginate(10);

        return view('backend.categories.index', [
            'items'=>$items,
            'title'=>'Danh mục',
            'routePrefix'=>'admin.categories',
            'columns'=>['id','name','status']
        ]);
    }

    public function create()
    {
        return view('backend.categories.form',[
            'title'=>'Thêm danh mục',
            'formTitle'=>'Tạo danh mục',
            'action'=>route('admin.categories.store'),
            'method'=>'POST',
            'routePrefix'=>'admin.categories',
            'item'=>null,

            'fields'=>[
                'name'=>['label'=>'Tên'],
                'description'=>['label'=>'Mô tả','type'=>'textarea'],
                'status'=>[
                    'label'=>'Trạng thái',
                    'type'=>'select',
                    'options'=>[1=>'Hiển thị',0=>'Ẩn']
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        $data['created_by'] = 1;

        Category::create($data);

        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {
        $item = Category::findOrFail($id);

        return view('backend.categories.form',[
            'title'=>'Sửa',
            'formTitle'=>'Cập nhật',
            'action'=>route('admin.categories.update',$id),
            'method'=>'PUT',
            'routePrefix'=>'admin.categories',
            'item'=>$item,

            'fields'=>[
                'name'=>['label'=>'Tên'],
                'description'=>['label'=>'Mô tả','type'=>'textarea'],
                'status'=>[
                    'label'=>'Trạng thái',
                    'type'=>'select',
                    'options'=>[1=>'Hiển thị',0=>'Ẩn']
                ]
            ]
        ]);
    }

    public function update(Request $request,$id)
    {
        $item = Category::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);

        $item->update($data);

        return redirect()->route('admin.categories.index');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success','Đã vào thùng rác');
    }
    // THÙNG RÁC
    public function trash()
    {
        $items = Category::onlyTrashed()->paginate(10);
        return view('backend.categories.trash', compact('items'),[
            'title'=>'Thùng rác',
            'routePrefix'=>'admin.categories',
            'columns'=>['id','name','description','status']
        ]);
    }

    // KHÔI PHỤC
    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.categories.trash')->with('success','Đã khôi phục');
    }

    // XOÁ VĨNH VIỄN
    public function forceDelete($id)
    {
        Category::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.categories.trash')->with('success','Đã xóa vĩnh viễn');
    }
    public function status($id)
    {
        $item = Category::findOrFail($id);
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();

        return back()->with('success', 'Da cap nhat trang thai danh muc');
    }

    use SoftDeletes;
}
