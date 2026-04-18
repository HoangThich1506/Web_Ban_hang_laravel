@extends('backend.layouts.admin', ['title' => $title])

@section('content')
    @include('backend.partials.resource-form', compact('formTitle', 'action', 'method', 'routePrefix', 'item', 'fields'))
@endsection
