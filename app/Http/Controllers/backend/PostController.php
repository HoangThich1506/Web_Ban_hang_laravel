<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $items = Post::latest()->paginate(10);

        return view('backend.posts.index', [
            'items' => $items,
            'title' => 'Bai viet',
            'routePrefix' => 'admin.posts',
        ]);
    }

    public function create()
    {
        return view('backend.posts.form', [
            'title' => 'Them bai viet',
            'formTitle' => 'Tao bai viet moi',
            'action' => route('admin.posts.store'),
            'method' => 'POST',
            'routePrefix' => 'admin.posts',
            'item' => null,
            'fields' => [
                'title' => ['label' => 'Tieu de'],
                'detail' => ['label' => 'Chi tiet', 'type' => 'textarea'],
                'image' => ['label' => 'Hinh anh', 'type' => 'file'],
                'status' => [
                    'label' => 'Trang thai',
                    'type' => 'select',
                    'options' => [1 => 'Hien thi', 0 => 'An'],
                ],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/posts'), $name);
            $data['image'] = $name;
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Them bai viet thanh cong');
    }

    public function edit($id)
    {
        $item = Post::findOrFail($id);

        return view('backend.posts.form', [
            'title' => 'Cap nhat bai viet',
            'formTitle' => 'Chinh sua bai viet',
            'action' => route('admin.posts.update', $id),
            'method' => 'PUT',
            'routePrefix' => 'admin.posts',
            'item' => $item,
            'fields' => [
                'title' => ['label' => 'Tieu de'],
                'detail' => ['label' => 'Chi tiet', 'type' => 'textarea'],
                'image' => ['label' => 'Hinh anh', 'type' => 'file'],
                'status' => [
                    'label' => 'Trang thai',
                    'type' => 'select',
                    'options' => [1 => 'Hien thi', 0 => 'An'],
                ],
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Post::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/posts'), $name);
            $data['image'] = $name;
        }

        $item->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Cap nhat bai viet thanh cong');
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return back()->with('success', 'Da dua vao thung rac');
    }

    public function trash()
    {
        $items = Post::onlyTrashed()->paginate(10);

        return view('backend.posts.trash', [
            'items' => $items,
            'title' => 'Thung rac bai viet',
            'routePrefix' => 'admin.posts',
        ]);
    }

    public function restore($id)
    {
        Post::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.posts.trash')->with('success', 'Khoi phuc bai viet thanh cong');
    }

    public function forceDelete($id)
    {
        Post::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.posts.trash')->with('success', 'Da xoa vinh vien bai viet');
    }

    public function status($id)
    {
        $item = Post::findOrFail($id);
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();

        return back()->with('success', 'Da cap nhat trang thai bai viet');
    }

    use SoftDeletes;
}
