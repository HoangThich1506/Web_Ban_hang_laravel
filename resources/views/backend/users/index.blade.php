@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-table', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ho ten', 'field' => 'name'],
            ['label' => 'Ten dang nhap', 'field' => 'username'],
            ['label' => 'Email', 'field' => 'email'],
            ['label' => 'So dien thoai', 'field' => 'phone'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
