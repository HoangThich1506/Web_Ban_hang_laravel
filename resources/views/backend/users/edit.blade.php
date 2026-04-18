@extends('backend.layouts.admin', ['title' => $title])

@section('content')
<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method!='POST') @method($method) @endif

    <div class="row">
        @foreach($fields as $name=>$field)
        <div class="col-md-6 mb-3">
            <label>{{ $field['label'] }}</label>

            @if(($field['type'] ?? '')=='textarea')
                <textarea name="{{ $name }}" class="form-control">{{ old($name,$item->$name ?? '') }}</textarea>

            @elseif(($field['type'] ?? '')=='select')
                <select name="{{ $name }}" class="form-control">
                    @foreach($field['options'] as $k=>$v)
                        <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                </select>

            @elseif(($field['type'] ?? '')=='file')
                <input type="file" name="{{ $name }}" class="form-control">

            @else
                <input type="{{ $field['type'] ?? 'text' }}" name="{{ $name }}"
                       value="{{ old($name,$item->$name ?? '') }}" class="form-control">
            @endif
        </div>
        @endforeach
    </div>

    <button class="btn btn-success">Lưu</button>
</form>
@endsection