@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-trash', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten', 'field' => 'name'],
            ['label' => 'Email', 'field' => 'email'],
            ['label' => 'So dien thoai', 'field' => 'phone'],
            ['label' => 'Tieu de', 'field' => 'title'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
