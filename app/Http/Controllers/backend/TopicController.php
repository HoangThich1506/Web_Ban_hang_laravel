<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicController extends Controller
{
    public function index()
    {
        $items = Topic::latest()->paginate(10);

        return view('backend.topics.index',[
            'items'=>$items,
            'title'=>'Chủ đề',
            'routePrefix'=>'admin.topics',
            'columns'=>['id','name','status']
        ]);
    }

    public function create()
    {
        return view('backend.topics.form',[
            'title'=>'Thêm',
            'formTitle'=>'Tạo chủ đề',
            'action'=>route('admin.topics.store'),
            'method'=>'POST',
            'routePrefix'=>'admin.topics',
            'item'=>null,

            'fields'=>[
                'name'=>['label'=>'Tên'],
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

        Topic::create($data);

        return redirect()->route('admin.topics.index');
    }
    public function edit($id)
    {
        $item = Topic::findOrFail($id);

        return view('backend.topics.form',[
            'title'=>'Sửa',
            'formTitle'=>'Cập nhật chủ đề',
            'action'=>route('admin.topics.update',$id),
            'method'=>'PUT',
            'routePrefix'=>'admin.topics',
            'item'=>$item,

            'fields'=>[
                'name'=>['label'=>'Tên'],
                'status'=>[
                    'label'=>'Trạng thái',
                    'type'=>'select',
                    'options'=>[1=>'Hiển thị',0=>'Ẩn']
                ]
            ]
        ]);
    }
    public function update(Request $request, $id)
    {
        $item = Topic::findOrFail($id);

        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);

        $item->update($data);

        return redirect()->route('admin.topics.index');
    }
    // ================= DELETE =================
    public function destroy($id)
    {
        Topic::findOrFail($id)->delete();
        return back()->with('success','Đã vào thùng rác');
    }
    // THÙNG RÁC
    public function trash()
    {
        $items = Topic::onlyTrashed()->paginate(10);
        return view('backend.topics.trash', compact('items'),[
            'title'=>'Thùng rác',
            'routePrefix'=>'admin.topics',
            'columns'=>['id','name','status']
        ]);
    }

    // KHÔI PHỤC
    public function restore($id)
    {
        Topic::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.topics.trash')->with('success','Đã khôi phục');
    }

    // XOÁ VĨNH VIỄN
    public function forceDelete($id)
    {
        Topic::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.topics.trash')->with('success','Đã xóa vĩnh viễn');
    }
    public function status($id)
    {
        $item = Topic::findOrFail($id);
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();

        return back()->with('success', 'Da cap nhat trang thai chu de');
    }

    use SoftDeletes;
}
