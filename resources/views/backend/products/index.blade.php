@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-table', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'showShow' => true,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten san pham', 'field' => 'name'],
            ['label' => 'Gia nhap', 'field' => 'price_buy', 'type' => 'price'],
            ['label' => 'Gia ban', 'field' => 'price_sale', 'type' => 'price'],
            ['label' => 'So luong', 'field' => 'qty'],
            ['label' => 'Hinh anh', 'field' => 'image', 'type' => 'image', 'path' => 'images/products'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
