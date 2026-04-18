<!DOCTYPE html>
<html lang="vi">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    
    <style>
        body {
            margin:0;
            font-family: Arial;
            background:#121212;
            color:#fff;
        }
        .container-fluid {
            padding:20px;
        }
    </style>
</head>

<body>
<div class="bg-gray-800 border-b border-gray-700">
    <div class="flex space-x-2 px-4">

        <!-- TAB ITEM -->
        <a href="{{ route('admin.product.index') }}"
           class="px-4 py-3 text-sm font-medium
           {{ request()->routeIs('admin.product.index') ? 'bg-gray-900 text-blue-400 border-b-2 border-blue-500' : 'text-gray-300 hover:bg-gray-700' }}">
            📦 Sản phẩm
        </a>

        <a href="{{ route('admin.product.create') }}"
           class="px-4 py-3 text-sm font-medium
           {{ request()->routeIs('admin.product.create') ? 'bg-gray-900 text-green-400 border-b-2 border-green-500' : 'text-gray-300 hover:bg-gray-700' }}">
            ➕ Thêm sản phẩm
        </a>

        <a href="{{ route('admin.product.trash') }}"
           class="px-4 py-3 text-sm font-medium
           {{ request()->routeIs('admin.product.trash') ? 'bg-gray-900 text-red-400 border-b-2 border-red-500' : 'text-gray-300 hover:bg-gray-700' }}">
            🗑️ Thùng rác
        </a>

    </div>
</div>
    @yield('content')

</body>
</html>