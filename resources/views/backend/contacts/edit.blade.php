@extends('backend.layouts.admin', ['title' => $title])

@section('content')

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- FIX: không dùng $method nữa --}}
    @method('PUT')

    <div class="row">
        @foreach($fields as $name => $field)
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    {{ $field['label'] ?? ucfirst($name) }}
                </label>

                {{-- TEXTAREA --}}
                @if(($field['type'] ?? '') === 'textarea')
                    <textarea name="{{ $name }}" class="form-control">{{ old($name, $item->$name ?? '') }}</textarea>

                {{-- SELECT --}}
                @elseif(($field['type'] ?? '') === 'select')
                    <select name="{{ $name }}" class="form-control">
                        @foreach($field['options'] ?? [] as $k => $v)
                            <option value="{{ $k }}"
                                {{ old($name, $item->$name ?? '') == $k ? 'selected' : '' }}>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>

                {{-- FILE --}}
                @elseif(($field['type'] ?? '') === 'file')
                    <input type="file" name="{{ $name }}" class="form-control">

                {{-- DEFAULT INPUT --}}
                @else
                    <input type="{{ $field['type'] ?? 'text' }}"
                           name="{{ $name }}"
                           value="{{ old($name, $item->$name ?? '') }}"
                           class="form-control">
                @endif
            </div>
        @endforeach
    </div>

    <button class="btn btn-success">Lưu</button>
</form>

@endsection