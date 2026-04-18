<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mr.Hoang Store')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-100">
    <div class="site-shell">
        <x-header />

        @if (session('success') || session('error'))
            <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="rounded-3xl border border-emerald-400/30 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mt-3 rounded-3xl border border-rose-400/30 bg-rose-400/10 px-5 py-4 text-sm text-rose-200">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <main>
            @yield('content')
        </main>

        <x-footer />
    </div>
</body>
</html>
