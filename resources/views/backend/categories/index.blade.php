@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-table', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten danh muc', 'field' => 'name'],
            ['label' => 'Mo ta', 'field' => 'description', 'type' => 'multiline'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
