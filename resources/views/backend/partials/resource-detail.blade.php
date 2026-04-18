@php
    $title = $title ?? 'Chi tiet';
    $details = $details ?? [];
@endphp

<div class="admin-card">
    <div class="admin-card__body">
        <div class="admin-toolbar">
            <div>
                <h2 class="admin-toolbar__title">{{ $title }}</h2>
                <p class="admin-toolbar__meta">Thong tin day du cua ban ghi dang duoc quan ly.</p>
            </div>
            <a href="{{ $backUrl }}" class="btn btn-soft-secondary">
                <i class="bi bi-arrow-left me-1"></i> Quay lai
            </a>
        </div>

        <div class="admin-detail-grid">
            @foreach ($details as $detail)
                <div class="admin-detail-item {{ !empty($detail['full']) ? 'admin-detail-item--full' : '' }}">
                    <p class="admin-detail-label">{{ $detail['label'] }}</p>
                    @if (($detail['type'] ?? 'text') === 'image')
                        @if (!empty($detail['value']))
                            <img src="{{ asset($detail['path'] . '/' . $detail['value']) }}" alt="detail image" class="admin-thumb" style="width: 140px; height: 140px;">
                        @else
                            <p class="admin-detail-value">No image</p>
                        @endif
                    @elseif (($detail['type'] ?? 'text') === 'status')
                        <span class="admin-badge {{ (int) $detail['value'] === 1 ? 'admin-badge--success' : 'admin-badge--muted' }}">
                            {{ (int) $detail['value'] === 1 ? 'Hien thi' : 'An' }}
                        </span>
                    @elseif (($detail['type'] ?? 'text') === 'price')
                        <p class="admin-detail-value">{{ number_format((float) $detail['value'], 0, ',', '.') }} d</p>
                    @else
                        <p class="admin-detail-value">{{ $detail['value'] ?: '-' }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
