@php
    $item = $item ?? null;
    $fields = $fields ?? [];
@endphp

<div class="admin-card">
    <div class="admin-card__body">
        <div class="admin-toolbar">
            <div>
                <h2 class="admin-toolbar__title">{{ $formTitle ?? 'Cap nhat du lieu' }}</h2>
                <p class="admin-toolbar__meta">Nhap day du thong tin de luu vao he thong.</p>
            </div>
            <a href="{{ route($routePrefix . '.index') }}" class="btn btn-soft-secondary">
                <i class="bi bi-arrow-left me-1"></i> Quay lai
            </a>
        </div>

        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(($method ?? 'POST') !== 'POST')
                @method($method)
            @endif

            <div class="row g-4">
                @foreach ($fields as $name => $field)
                    @php
                        $type = $field['type'] ?? 'text';
                        $value = old($name, $item?->{$name});
                        $columnClass = $field['column'] ?? ($type === 'textarea' ? '12' : '6');
                        $placeholder = $field['placeholder'] ?? '';
                    @endphp
                    <div class="col-md-{{ $columnClass }}">
                        <label class="form-label">{{ $field['label'] }}</label>

                        @if ($type === 'textarea')
                            <textarea name="{{ $name }}" rows="{{ $field['rows'] ?? 5 }}" class="form-control" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
                        @elseif ($type === 'select')
                            <select name="{{ $name }}" class="form-select">
                                @foreach ($field['options'] as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" {{ (string) $value === (string) $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif ($type === 'file')
                            <input type="file" name="{{ $name }}" class="form-control" onchange="previewAdminImage(event, '{{ $name }}')">
                            <div class="mt-3">
                                @php
                                    $previewPath = $field['path'] ?? 'images/products';
                                    $hasPreview = !empty($item?->{$name});
                                @endphp
                                <img id="preview_{{ $name }}" src="{{ $hasPreview ? asset($previewPath . '/' . $item->{$name}) : '' }}" alt="preview" class="admin-thumb" style="{{ $hasPreview ? '' : 'display:none;' }}">
                            </div>
                        @else
                            <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" class="form-control" placeholder="{{ $placeholder }}">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="d-flex gap-2 mt-4 flex-wrap">
                <button type="submit" class="btn btn-soft-primary"><i class="bi bi-floppy me-1"></i> Luu du lieu</button>
                <a href="{{ route($routePrefix . '.index') }}" class="btn btn-soft-secondary">Huy</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewAdminImage(event, name) {
        const file = event.target.files && event.target.files[0];
        const target = document.getElementById('preview_' + name);
        if (!file || !target) return;
        target.src = URL.createObjectURL(file);
        target.style.display = 'block';
    }
</script>
