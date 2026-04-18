@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-table', [
        'title' => $title,
        'items' => $items,
        'routePrefix' => $routePrefix,
        'columns' => [
            ['label' => 'ID', 'field' => 'id'],
            ['label' => 'Ten chu de', 'field' => 'name'],
            ['label' => 'Trang thai', 'field' => 'status', 'type' => 'status'],
        ],
    ])
@endsection
