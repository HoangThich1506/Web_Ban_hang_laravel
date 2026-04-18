@extends('backend.layouts.admin', ['title' => $title])

@section('content')
<div class="card">
    <div class="card-header bg-white py-3"><strong>{{ $title }} - chi tiết</strong></div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($fields as $name => $field)
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100 bg-light">
                        <div class="text-muted small mb-1">{{ $field['label'] }}</div>
                        @php $value = $item->{$name}; @endphp
                        @if(str_contains($name, 'image') && $value)
                            <img src="{{ $value }}" class="img-fluid rounded" alt="preview">
                        @else
                            <div class="fw-semibold">{{ $value ?: '—' }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-warning">Chỉnh sửa</a>
            <a href="{{ route($routePrefix . '.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
