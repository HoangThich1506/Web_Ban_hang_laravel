@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-trash', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten danh muc', 'field' => 'name'],
            ['label' => 'Mo ta', 'field' => 'description'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
