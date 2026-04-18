@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-table', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Khach hang', 'field' => 'name'],
            ['label' => 'Email', 'field' => 'email'],
            ['label' => 'So dien thoai', 'field' => 'phone'],
            ['label' => 'Dia chi', 'field' => 'address', 'type' => 'multiline'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
