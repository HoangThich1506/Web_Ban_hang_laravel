@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-trash', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten banner', 'field' => 'name'],
            ['label' => 'Hinh anh', 'field' => 'image', 'type' => 'image', 'path' => 'images/banners'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
