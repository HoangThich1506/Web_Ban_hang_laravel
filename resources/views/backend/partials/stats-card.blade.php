<div class="col-md-6 col-xl-3">
    <div class="admin-card h-100">
        <div class="admin-card__body">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <p class="text-uppercase small fw-semibold text-secondary mb-2">{{ $label }}</p>
                    <h3 class="display-6 fw-bold mb-1">{{ $value }}</h3>
                    @if (!empty($hint))
                        <p class="text-secondary mb-0">{{ $hint }}</p>
                    @endif
                </div>
                <div class="rounded-4 d-grid place-items-center p-3" style="background: {{ $bg ?? 'rgba(245,158,11,.14)' }}; color: {{ $color ?? '#92400e' }};">
                    <i class="bi {{ $icon }}"></i>
                </div>
            </div>
        </div>
    </div>
</div>
