@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-trash', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten san pham', 'field' => 'name'],
            ['label' => 'Gia nhap', 'field' => 'price_buy'],
            ['label' => 'So luong', 'field' => 'qty'],
            ['label' => 'Hinh anh', 'field' => 'image', 'type' => 'image', 'path' => 'images/products'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
