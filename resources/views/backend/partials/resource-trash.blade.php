@php
    $title = $title ?? 'Thung rac';
    $items = $items ?? collect();
    $columns = $columns ?? [];
    $routePrefix = $routePrefix ?? '';
@endphp

<div class="admin-card">
    <div class="admin-card__body">
        <div class="admin-toolbar">
            <div>
                <h2 class="admin-toolbar__title">{{ $title }}</h2>
                <p class="admin-toolbar__meta">Khoi phuc du lieu da xoa mem hoac xoa vinh vien neu can.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                @if ($routePrefix)
                    <button type="button" class="btn btn-success" data-bulk-restore>
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Khoi phuc da chon
                    </button>
                    <button type="button" class="btn btn-soft-danger" data-bulk-force-delete>
                        <i class="bi bi-x-octagon me-1"></i> Xoa vinh vien da chon
                    </button>
                @endif
                <a href="{{ route($routePrefix . '.index') }}" class="btn btn-soft-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lai danh sach
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 56px;">
                            <input type="checkbox" class="form-check-input" data-check-all>
                        </th>
                        @foreach ($columns as $column)
                            <th>{{ $column['label'] }}</th>
                        @endforeach
                        <th style="min-width: 220px;">Thao tac</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" value="{{ $item->id }}" data-item-checkbox>
                            </td>
                            @foreach ($columns as $column)
                                @php
                                    $type = $column['type'] ?? 'text';
                                    $value = data_get($item, $column['field']);
                                @endphp
                                <td>
                                    @if ($type === 'image')
                                        @if ($value)
                                            <img src="{{ asset(($column['path'] ?? 'images') . '/' . $value) }}" alt="thumb" class="admin-thumb">
                                        @else
                                            <span class="text-secondary">No image</span>
                                        @endif
                                    @elseif ($type === 'status')
                                        <span class="admin-badge {{ (int) $value === 1 ? 'admin-badge--success' : 'admin-badge--muted' }}">
                                            {{ (int) $value === 1 ? 'Hien thi' : 'An' }}
                                        </span>
                                    @else
                                        {{ $value !== null && $value !== '' ? $value : '-' }}
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                <div class="admin-actions">
                                    <form action="{{ route($routePrefix . '.restore', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Khoi phuc
                                        </button>
                                    </form>
                                    <form action="{{ route($routePrefix . '.forceDelete', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Xoa vinh vien muc nay?')" class="btn btn-soft-danger btn-sm">
                                            <i class="bi bi-x-octagon me-1"></i> Xoa vinh vien
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}" class="admin-empty">Thung rac dang trong.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($items, 'links'))
            <div class="mt-4 d-flex justify-content-end">
                {{ $items->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<script>
    (() => {
        const card = document.currentScript.previousElementSibling;
        if (!card) return;

        const checkAll = card.querySelector('[data-check-all]');
        const checkboxes = Array.from(card.querySelectorAll('[data-item-checkbox]'));
        const bulkRestoreButton = card.querySelector('[data-bulk-restore]');
        const bulkForceDeleteButton = card.querySelector('[data-bulk-force-delete]');

        const selectedIds = () => checkboxes.filter((checkbox) => checkbox.checked).map((checkbox) => checkbox.value);

        if (checkAll) {
            checkAll.addEventListener('change', () => {
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = checkAll.checked;
                });
            });
        }

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                if (!checkAll) return;
                checkAll.checked = checkboxes.length > 0 && checkboxes.every((item) => item.checked);
            });
        });

        const sendBulkRequest = async (ids, action, method) => {
            for (const id of ids) {
                const response = await fetch(`${window.location.origin}${window.location.pathname.replace(/\/trash\/?$/, '')}/${id}/${action}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                    },
                    body: new URLSearchParams(method === 'DELETE' ? { _method: 'DELETE' } : {}),
                });

                if (!response.ok) {
                    throw new Error(`Khong the thuc hien thao tac voi ID ${id}`);
                }
            }
        };

        if (bulkRestoreButton) {
            bulkRestoreButton.addEventListener('click', async () => {
                const ids = selectedIds();

                if (ids.length === 0) {
                    alert('Vui long chon it nhat mot muc.');
                    return;
                }

                bulkRestoreButton.disabled = true;

                try {
                    await sendBulkRequest(ids, 'restore', 'POST');
                    window.location.reload();
                } catch (error) {
                    alert(error.message || 'Co loi xay ra khi khoi phuc du lieu.');
                } finally {
                    bulkRestoreButton.disabled = false;
                }
            });
        }

        if (bulkForceDeleteButton) {
            bulkForceDeleteButton.addEventListener('click', async () => {
                const ids = selectedIds();

                if (ids.length === 0) {
                    alert('Vui long chon it nhat mot muc.');
                    return;
                }

                if (!confirm(`Xoa vinh vien ${ids.length} muc da chon?`)) {
                    return;
                }

                bulkForceDeleteButton.disabled = true;

                try {
                    await sendBulkRequest(ids, 'force-delete', 'DELETE');
                    window.location.reload();
                } catch (error) {
                    alert(error.message || 'Co loi xay ra khi xoa vinh vien du lieu.');
                } finally {
                    bulkForceDeleteButton.disabled = false;
                }
            });
        }
    })();
</script>
