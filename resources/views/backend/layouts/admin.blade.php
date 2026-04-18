<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --admin-bg:#0f172a; --admin-panel:rgba(15,23,42,.82); --admin-card:#fff; --admin-accent:#f59e0b; --admin-accent-soft:rgba(245,158,11,.14); --admin-text:#0f172a; --admin-muted:#64748b; --admin-border:#e2e8f0; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; font-family:"Segoe UI", Arial, sans-serif; color:var(--admin-text); background:radial-gradient(circle at top left, rgba(245,158,11,.18), transparent 24%), radial-gradient(circle at bottom right, rgba(59,130,246,.18), transparent 20%), linear-gradient(180deg, #0b1120 0%, #111827 100%); }
        .admin-shell { display:flex; min-height:100vh; }
        .admin-sidebar { width:290px; padding:28px 18px; background:var(--admin-panel); backdrop-filter:blur(18px); color:#fff; position:sticky; top:0; align-self:flex-start; min-height:100vh; border-right:1px solid rgba(255,255,255,.08); }
        .admin-brand { display:flex; align-items:center; gap:14px; padding:16px 14px 22px; margin-bottom:22px; border-bottom:1px solid rgba(255,255,255,.08); }
        .admin-brand__logo { width:46px; height:46px; display:grid; place-items:center; border-radius:16px; background:linear-gradient(135deg, #fbbf24, #fb7185); color:#111827; font-weight:800; }
        .admin-brand__title { margin:0; font-size:1.15rem; font-weight:700; }
        .admin-brand__subtitle { margin:3px 0 0; font-size:.78rem; color:rgba(255,255,255,.58); letter-spacing:.08em; text-transform:uppercase; }
        .admin-section-label { margin:16px 12px 10px; font-size:.74rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.15em; }
        .menu-link { display:flex; align-items:center; gap:12px; color:rgba(255,255,255,.78); text-decoration:none; padding:12px 14px; border-radius:16px; margin-bottom:8px; transition:all .2s ease; }
        .menu-link:hover, .menu-link.active { color:#fff; background:linear-gradient(135deg, rgba(245,158,11,.22), rgba(59,130,246,.18)); transform:translateX(2px); }
        .menu-link i { font-size:1rem; width:18px; }
        .admin-content { flex:1; padding:28px; }
        .admin-topbar { background:rgba(255,255,255,.9); border:1px solid rgba(255,255,255,.68); box-shadow:0 20px 45px rgba(15,23,42,.14); border-radius:28px; padding:20px 24px; margin-bottom:22px; display:flex; justify-content:space-between; align-items:center; gap:18px; }
        .admin-page-title { margin:0; font-size:1.75rem; font-weight:800; }
        .admin-page-subtitle { margin:5px 0 0; color:var(--admin-muted); }
        .admin-chip { display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:999px; background:var(--admin-accent-soft); color:#92400e; font-weight:600; }
        .admin-card, .card { border:1px solid rgba(255,255,255,.68); border-radius:26px; background:rgba(255,255,255,.92); box-shadow:0 18px 40px rgba(15,23,42,.12); overflow:hidden; }
        .admin-card__body { padding:24px; }
        .admin-toolbar { display:flex; justify-content:space-between; align-items:center; gap:14px; flex-wrap:wrap; margin-bottom:18px; }
        .admin-toolbar__title { margin:0; font-size:1.1rem; font-weight:700; }
        .admin-toolbar__meta { margin:4px 0 0; color:var(--admin-muted); font-size:.92rem; }
        .admin-table { width:100%; margin:0; border-collapse:separate; border-spacing:0; }
        .admin-table thead th { padding:14px 16px; border-bottom:1px solid var(--admin-border); color:var(--admin-muted); font-size:.82rem; text-transform:uppercase; letter-spacing:.08em; background:#f8fafc; }
        .admin-table tbody td { padding:16px; border-bottom:1px solid #eef2f7; vertical-align:middle; }
        .admin-table tbody tr:hover { background:rgba(248,250,252,.8); }
        .admin-thumb { width:64px; height:64px; object-fit:cover; border-radius:16px; border:1px solid var(--admin-border); background:#fff; }
        .admin-badge { display:inline-flex; align-items:center; border-radius:999px; padding:7px 12px; font-size:.82rem; font-weight:700; }
        .admin-badge--success { background:rgba(16,185,129,.12); color:#047857; }
        .admin-badge--muted { background:rgba(100,116,139,.12); color:#475569; }
        .admin-actions { display:flex; gap:8px; flex-wrap:wrap; }
        .btn { border-radius:14px; padding:.62rem .95rem; font-weight:600; }
        .btn-soft-primary { color:#92400e; background:rgba(245,158,11,.12); border:1px solid rgba(245,158,11,.16); }
        .btn-soft-primary:hover { background:rgba(245,158,11,.2); color:#78350f; }
        .btn-soft-secondary { color:#334155; background:#edf2f7; border:1px solid #dbe4ee; }
        .btn-soft-secondary:hover { background:#e2e8f0; color:#0f172a; }
        .btn-soft-danger { color:#b91c1c; background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.14); }
        .btn-soft-danger:hover { background:rgba(239,68,68,.18); color:#991b1b; }
        .form-control, .form-select { border-radius:16px; padding:.85rem 1rem; border-color:#dbe4ee; box-shadow:none; }
        .form-control:focus, .form-select:focus { border-color:rgba(245,158,11,.58); box-shadow:0 0 0 .2rem rgba(245,158,11,.12); }
        .form-label { font-weight:700; color:#334155; margin-bottom:.55rem; }
        .admin-empty { padding:42px 18px; text-align:center; color:var(--admin-muted); }
        .admin-detail-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:18px; }
        .admin-detail-item { padding:18px; border-radius:20px; background:#f8fafc; border:1px solid #e2e8f0; }
        .admin-detail-item--full { grid-column:1 / -1; }
        .admin-detail-label { margin:0 0 6px; font-size:.8rem; text-transform:uppercase; letter-spacing:.08em; color:var(--admin-muted); }
        .admin-detail-value { margin:0; font-size:1rem; font-weight:600; color:#0f172a; word-break:break-word; }
        .pagination { --bs-pagination-border-radius:14px; --bs-pagination-color:#334155; --bs-pagination-bg:#fff; --bs-pagination-border-color:#dbe4ee; --bs-pagination-hover-color:#78350f; --bs-pagination-hover-bg:rgba(245,158,11,.12); --bs-pagination-hover-border-color:rgba(245,158,11,.18); --bs-pagination-focus-color:#78350f; --bs-pagination-focus-bg:rgba(245,158,11,.12); --bs-pagination-focus-box-shadow:0 0 0 .2rem rgba(245,158,11,.12); --bs-pagination-active-color:#78350f; --bs-pagination-active-bg:rgba(245,158,11,.18); --bs-pagination-active-border-color:rgba(245,158,11,.24); --bs-pagination-disabled-color:#94a3b8; --bs-pagination-disabled-bg:#f8fafc; --bs-pagination-disabled-border-color:#e2e8f0; gap:8px; }
        .pagination .page-link { border-radius:14px; font-weight:600; padding:.7rem .95rem; border-left-width:1px; }
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link { border-radius:14px; }
        @media (max-width: 991.98px) { .admin-shell{flex-direction:column;} .admin-sidebar{width:100%; min-height:auto; position:static;} .admin-content{padding:18px;} .admin-topbar{flex-direction:column; align-items:flex-start;} .admin-detail-grid{grid-template-columns:1fr;} }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <div class="admin-brand__logo">MH</div>
                <div>
                    <p class="admin-brand__title">Mr.Hoang Admin</p>
                    <p class="admin-brand__subtitle">Control Center</p>
                </div>
            </div>
            <div class="admin-section-label">Quan tri noi dung</div>
            <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
            <a class="menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam"></i><span>San pham</span></a>
            <a class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-diagram-3"></i><span>Danh muc</span></a>
            <a class="menu-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}"><i class="bi bi-award"></i><span>Thuong hieu</span></a>
            <a class="menu-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}"><i class="bi bi-image"></i><span>Banner</span></a>
            <a class="menu-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}"><i class="bi bi-file-earmark-richtext"></i><span>Bai viet</span></a>
            <a class="menu-link {{ request()->routeIs('admin.topics.*') ? 'active' : '' }}" href="{{ route('admin.topics.index') }}"><i class="bi bi-tags"></i><span>Chu de</span></a>
            <a class="menu-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}"><i class="bi bi-menu-button-wide"></i><span>Menu</span></a>
            <div class="admin-section-label">Van hanh</div>
            <a class="menu-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="bi bi-bag-check"></i><span>Don hang</span></a>
            <a class="menu-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}"><i class="bi bi-chat-dots"></i><span>Lien he</span></a>
            <a class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i><span>Thanh vien</span></a>
        </aside>
        <main class="admin-content">
            <div class="admin-topbar">
                <div>
                    <h1 class="admin-page-title">{{ $title ?? 'Admin Panel' }}</h1>
                    <p class="admin-page-subtitle">Quan ly du lieu, cap nhat noi dung va theo doi tinh trang he thong.</p>
                </div>
                <a href="{{ route('site.home') }}" class="admin-chip text-decoration-none">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Quay ve trang chu</span>
                </a>
            </div>
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-4">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
