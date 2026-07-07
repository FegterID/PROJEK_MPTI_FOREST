<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin &mdash; {{ $siteConfig['name'] }} @hasSection('title')&mdash; @yield('title')@endif</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|cormorant-garamond:600,700"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-bg text-ink antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 shrink-0 border-r border-line bg-surface">
            <div class="border-b border-line px-6 py-5">
                <p class="font-serif text-lg font-semibold text-ink">{{ $siteConfig['name'] }}</p>
                <p class="text-xs uppercase tracking-wide text-ink-muted">Admin Panel</p>
            </div>

            @php
                $adminNav = [
                    ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'available' => true],
                    ['label' => 'Booking', 'route' => 'admin.bookings.index', 'available' => true],
                    ['label' => 'Pesanan', 'route' => 'admin.orders.index', 'available' => true],
                    ['label' => 'Produk', 'route' => 'admin.products.index', 'available' => true],
                    ['label' => 'Layanan', 'route' => 'admin.services.index', 'available' => true],
                ];
            @endphp

            <nav class="space-y-1 px-3 py-4 text-sm">
                @foreach ($adminNav as $item)
                    @if ($item['available'])
                        <a href="{{ route($item['route']) }}"
                            class="block rounded-lg px-3 py-2 font-medium transition {{ request()->routeIs($item['route']) ? 'bg-accent text-white' : 'text-ink hover:bg-surface-light' }}">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="flex items-center justify-between rounded-lg px-3 py-2 text-ink-muted/60">
                            {{ $item['label'] }}
                            <span
                                class="rounded-full border border-line px-2 py-0.5 text-[10px] uppercase tracking-wide">Segera</span>
                        </span>
                    @endif
                @endforeach
            </nav>

            <div class="mt-auto border-t border-line px-3 py-4">
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-lg px-3 py-2 text-left text-sm text-ink-muted hover:bg-surface-light">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <header class="border-b border-line bg-surface px-8 py-5">
                <h1 class="font-serif text-xl font-semibold text-ink">@yield('title')</h1>
            </header>

            <main class="p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>