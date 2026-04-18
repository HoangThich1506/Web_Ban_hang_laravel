@extends('backend.layouts.admin', ['title' => $title])

@php $fields['image']['path'] = 'images/brands'; @endphp

@section('content')
    @include('backend.partials.resource-form', compact('formTitle', 'action', 'method', 'routePrefix', 'item', 'fields'))
@endsection
