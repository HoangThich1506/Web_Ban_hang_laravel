@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-table', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten thuong hieu', 'field' => 'name'],
            ['label' => 'Hinh anh', 'field' => 'image', 'type' => 'image', 'path' => 'images/brands'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
