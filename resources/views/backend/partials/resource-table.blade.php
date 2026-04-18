@php
    $title = $title ?? 'Danh sach';
    $items = $items ?? collect();
    $columns = $columns ?? [];
    $routePrefix = $routePrefix ?? '';
    $showCreate = $showCreate ?? true;
    $showTrash = $showTrash ?? true;
    $showShow = $showShow ?? false;
    $emptyText = $emptyText ?? 'Chua co du lieu.';
@endphp

<div class="admin-card">
    <div class="admin-card__body">
        <div class="admin-toolbar">
            <div>
                <h2 class="admin-toolbar__title">{{ $title }}</h2>
                <p class="admin-toolbar__meta">Quan ly du lieu trong bang va thao tac nhanh ngay tai day.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                @if ($routePrefix)
                    <button type="button" class="btn btn-soft-danger" data-bulk-delete data-route-prefix="{{ $routePrefix }}">
                        <i class="bi bi-trash me-1"></i> Xoa muc da chon
                    </button>
                @endif
                @if ($showTrash && $routePrefix)
                    <a href="{{ route($routePrefix . '.trash') }}" class="btn btn-soft-secondary">
                        <i class="bi bi-trash3 me-1"></i> Thung rac
                    </a>
                @endif
                @if ($showCreate && $routePrefix)
                    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-soft-primary">
                        <i class="bi bi-plus-circle me-1"></i> Them moi
                    </a>
                @endif
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
                        <th style="min-width: 180px;">Thao tac</th>
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
                                    $field = $column['field'] ?? null;
                                    $value = $field ? data_get($item, $field) : null;
                                @endphp
                                <td>
                                    @if ($type === 'image')
                                        @if ($value)
                                            <img src="{{ asset(($column['path'] ?? 'images') . '/' . $value) }}" alt="{{ $item->name ?? 'image' }}" class="admin-thumb">
                                        @else
                                            <span class="text-secondary">No image</span>
                                        @endif
                                    @elseif ($type === 'status')
                                        <span class="admin-badge {{ (int) $value === 1 ? 'admin-badge--success' : 'admin-badge--muted' }}">
                                            {{ (int) $value === 1 ? 'Hien thi' : 'An' }}
                                        </span>
                                    @elseif ($type === 'price')
                                        {{ is_numeric($value) ? number_format((float) $value, 0, ',', '.') . ' d' : '-' }}
                                    @elseif ($type === 'multiline')
                                        <div style="max-width: 340px;" class="text-wrap">{{ $value ?: '-' }}</div>
                                    @else
                                        {{ $value !== null && $value !== '' ? $value : '-' }}
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                <div class="admin-actions">
                                    @if ($showShow && $routePrefix)
                                        <a href="{{ route($routePrefix . '.show', $item->id) }}" class="btn btn-soft-secondary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endif
                                    @if ($routePrefix)
                                        <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route($routePrefix . '.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Chuyen vao thung rac?')" class="btn btn-soft-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}" class="admin-empty">{{ $emptyText }}</td>
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
        const bulkDeleteButton = card.querySelector('[data-bulk-delete]');

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

        if (bulkDeleteButton) {
            bulkDeleteButton.addEventListener('click', async () => {
                const ids = selectedIds();

                if (ids.length === 0) {
                    alert('Vui long chon it nhat mot muc.');
                    return;
                }

                if (!confirm(`Chuyen ${ids.length} muc vao thung rac?`)) {
                    return;
                }

                bulkDeleteButton.disabled = true;

                try {
                    for (const id of ids) {
                        const response = await fetch(`${window.location.origin}${window.location.pathname.replace(/\/$/, '')}/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                            },
                            body: new URLSearchParams({
                                _method: 'DELETE',
                            }),
                        });

                        if (!response.ok) {
                            throw new Error(`Khong the xoa muc co ID ${id}`);
                        }
                    }

                    window.location.reload();
                } catch (error) {
                    alert(error.message || 'Co loi xay ra khi xoa du lieu.');
                } finally {
                    bulkDeleteButton.disabled = false;
                }
            });
        }
    })();
</script>
