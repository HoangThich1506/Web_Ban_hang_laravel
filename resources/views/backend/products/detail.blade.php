@extends('backend.layouts.admin', ['title' => 'Chi tiet san pham'])

@section('content')
    @include('backend.partials.resource-detail', [
        'title' => 'Chi tiet san pham',
        'backUrl' => route('admin.products.index'),
        'details' => [
            ['label' => 'ID', 'value' => $product->id],
            ['label' => 'Ten san pham', 'value' => $product->name],
            ['label' => 'Gia nhap', 'value' => $product->price_buy, 'type' => 'price'],
            ['label' => 'Gia ban', 'value' => $product->price_sale, 'type' => 'price'],
            ['label' => 'Danh muc', 'value' => $product->category->name ?? '-'],
            ['label' => 'Thuong hieu', 'value' => $product->brand->name ?? '-'],
            ['label' => 'Trang thai', 'value' => $product->status, 'type' => 'status'],
            ['label' => 'Hinh anh', 'value' => $product->image, 'type' => 'image', 'path' => 'images/products'],
            ['label' => 'Chi tiet', 'value' => $product->detail, 'full' => true],
            ['label' => 'Mo ta', 'value' => $product->description, 'full' => true],
        ],
    ])
@endsection
