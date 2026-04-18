@extends('backend.layouts.admin', ['title' => 'Dashboard'])

@section('content')
    <div class="row g-4">
        @include('backend.partials.stats-card', ['label' => 'San pham', 'value' => $products, 'icon' => 'bi-box-seam', 'hint' => 'Tổng số sản phẩm đang bán', 'bg' => 'rgba(16,185,129,.14)', 'color' => '#047857'])
        @include('backend.partials.stats-card', ['label' => 'Danh muc', 'value' => $categories, 'icon' => 'bi-diagram-3', 'hint' => 'Nhóm sản phẩm hiện có', 'bg' => 'rgba(16,185,129,.14)', 'color' => '#047857'])
        @include('backend.partials.stats-card', ['label' => 'Thuong hieu', 'value' => $brands, 'icon' => 'bi-award', 'hint' => 'Đối tác và nhãn hiệu', 'bg' => 'rgba(59,130,246,.14)', 'color' => '#1d4ed8'])
        @include('backend.partials.stats-card', ['label' => 'Don hang', 'value' => $orders, 'icon' => 'bi-bag-check', 'hint' => 'Số đơn cần theo dõi', 'bg' => 'rgba(239,68,68,.14)', 'color' => '#b91c1c'])
        @include('backend.partials.stats-card', ['label' => 'Thanh vien', 'value' => $users, 'icon' => 'bi-people', 'hint' => 'ài khoản trong hệ thống', 'bg' => 'rgba(14,165,233,.14)', 'color' => '#0369a1'])
        @include('backend.partials.stats-card', ['label' => 'Lien he', 'value' => $contacts, 'icon' => 'bi-chat-dots', 'hint' => 'Tin nhắn từ khách hàng', 'bg' => 'rgba(14,165,233,.14)', 'color' => '#0369a1'])

        @include('backend.partials.stats-card', ['label' => 'Bai viet', 'value' => $posts, 'icon' => 'bi-file-earmark-richtext', 'hint' => 'Nội dung đã đăng', 'bg' => 'rgba(168,85,247,.14)', 'color' => '#7e22ce'])
        @include('backend.partials.stats-card', ['label' => 'Banner', 'value' => $banners, 'icon' => 'bi-image', 'hint' => 'Banner quảng bá đang dùng', 'bg' => 'rgba(249,115,22,.14)', 'color' => '#c2410c'])
    </div>

    <div class="row g-4 mt-1">
        <div class="col-xl-8">
            <div class="admin-card">
                <div class="admin-card__body">
                    <div class="admin-toolbar">
                        <div>
                            <h2 class="admin-toolbar__title">Tổng quan</h2>
                            <p class="admin-toolbar__meta"></p>
                        </div>
                    </div>
                    <div class="admin-detail-grid">
                        <div class="admin-detail-item">
                            <p class="admin-detail-label">Quản trị danh mục</p>
                            <p class="admin-detail-value">sản phẩm, danh mục, thương hiệu, menu, banner, bài viết và chủ đề.</p>
                        </div>
                        <div class="admin-detail-item">
                            <p class="admin-detail-label">Vận hành</p>
                            <p class="admin-detail-value">Đơn hàng, liên hệ và thành viên.</p>
                        </div>
                        <div class="admin-detail-item admin-detail-item--full">
                            <p class="admin-detail-label">Thống kê bổ sung</p>
                            <p class="admin-detail-value">Menu: {{ $menuCount }} | Chủ đề: {{ $topics }} | Bài viết: {{ $posts }} | Liên hệ: {{ $contacts }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="admin-card">
                <div class="admin-card__body">
                    <div class="admin-toolbar">
                        <div>
                            <h2 class="admin-toolbar__title">Lời khuyên sử dụng</h2>
                            <p class="admin-toolbar__meta">Những thao tác nên ưu tiên khi vào admin.</p>
                        </div>
                    </div>
                    <ul class="mb-0 text-secondary ps-3" style="line-height: 1.9;">
                        <li>Cập nhật sản phẩm và tồn kho trước khi xử lý đơn hàng.</li>
                        <li>Kiểm tra liên hệ mới để phản hồi khách hàng nhanh hơn.</li>
                        <li>Duy trì banner, menu và bài viết để Trang web đồng bộ nội dung.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
