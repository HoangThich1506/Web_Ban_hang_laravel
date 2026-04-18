@extends('backend.layouts.admin', ['title' => $title])

@php $fields['image']['path'] = 'images/posts'; @endphp

@section('content')
    @include('backend.partials.resource-form', compact('formTitle', 'action', 'method', 'routePrefix', 'item', 'fields'))
@endsection
