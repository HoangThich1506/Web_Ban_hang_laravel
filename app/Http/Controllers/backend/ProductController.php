<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('backend.products.index', [
            'items' => $products,
            'title' => 'Danh sách sản phẩm',
            'routePrefix' => 'admin.products',
        ]);
    }

    // ================= CREATE =================
    public function create()
    {
        return view('backend.products.form', [
            'title' => 'Thêm sản phẩm',
            'formTitle' => 'Tạo sản phẩm',
            'action' => route('admin.products.store'),
            'method' => 'POST',
            'routePrefix' => 'admin.products',
            'item' => null,

            'fields' => [
                'name' => ['label' => 'Tên sản phẩm'],

                'category_id' => [
                    'label'=>'Danh mục',
                    'type'=>'select',
                    'parent_id'=>'parent_id',
                    'options'=>Category::pluck('name','id')
                ],

                'brand_id' => [
                    'label'=>'Thương hiệu',
                    'type'=>'select',
                    'options'=>Brand::pluck('name','id')
                ],

                'price_buy' => ['label' => 'Giá nhập', 'type' => 'number'],
                'price_sale' => ['label' => 'Giá bán', 'type' => 'number'],

                'qty' => ['label'=>'Số lượng','type'=>'number'],
                'detail' => ['label'=>'Chi tiết','type'=>'textarea'],

                'description' => ['label' => 'Mô tả', 'type' => 'textarea'],

                'status' => [
                    'label' => 'Trạng thái',
                    'type' => 'select',
                    'options' => [1 => 'Hiển thị', 0 => 'Ẩn']
                ],

                'image' => ['label' => 'Hình ảnh', 'type' => 'file']
            ],
        ]);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price_buy' => 'required|numeric',
            'price_sale' => 'nullable|numeric',
            'qty' => 'required|numeric',
            'detail' => 'required',
            'image' => 'required|image',
        ]);

        $data = $request->all();

        $data['slug'] = Str::slug($data['name']);
        $data['created_by'] = 1;
        $data['status'] = $data['status'] ?? 1;

        // upload ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công');
    }
    // ================= SHOW =================
    public function show($id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);

        return view('backend.products.detail', compact('product'));
    }
    // ================= EDIT =================
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('backend.products.form', [
            'title' => 'Sửa sản phẩm',
            'formTitle' => 'Cập nhật sản phẩm',
            'action' => route('admin.products.update',$id),
            'method' => 'PUT',
            'routePrefix' => 'admin.products',
            'item' => $product,

            'fields' => [
                'name' => ['label' => 'Tên sản phẩm'],

                'category_id' => [
                    'label'=>'Danh mục',
                    'type'=>'select',
                    'options'=>Category::pluck('name','id')
                ],

                'brand_id' => [
                    'label'=>'Thương hiệu',
                    'type'=>'select',
                    'options'=>Brand::pluck('name','id')
                ],

                'price_buy' => ['label'=>'Giá nhập','type'=>'number'],
                'price_sale' => ['label'=>'Giá bán','type'=>'number'],

                'qty' => ['label'=>'Số lượng','type'=>'number'],
                'detail' => ['label'=>'Chi tiết','type'=>'textarea'],

                'description' => ['label'=>'Mô tả','type'=>'textarea'],

                'status' => [
                    'label'=>'Trạng thái',
                    'type'=>'select',
                    'options'=>[1=>'Hiển thị',0=>'Ẩn']
                ],

                'image' => ['label'=>'Hình ảnh','type'=>'file']
            ],
        ]);
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('images/products/'.$product->image))) {
                unlink(public_path('images/products/'.$product->image));
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);

            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success','Cập nhật thành công');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success','Đã vào thùng rác');
    }

    // ================= TRASH =================
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(10);

        return view('backend.products.trash', [
            'items'=>$products,
            'title'=>'Thùng rác',
            'routePrefix'=>'admin.products',
            'columns'=>['id','name','price_buy','qty','status','image']
        ]);
    }

    // ================= RESTORE =================
    public function restore($id)
    {
        Product::withTrashed()->findOrFail($id)->restore();
        return back()->with('success','Khôi phục thành công');
    }

    // ================= FORCE DELETE =================
    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if ($product->image && file_exists(public_path('images/products/'.$product->image))) {
            unlink(public_path('images/products/'.$product->image));
        }

        $product->forceDelete();

        return back()->with('success','Xóa vĩnh viễn');
    }
    public function status($id)
    {
        $product = Product::findOrFail($id);
        $product->status = $product->status == 1 ? 0 : 1;
        $product->save();

        return back()->with('success', 'Da cap nhat trang thai san pham');
    }
}
