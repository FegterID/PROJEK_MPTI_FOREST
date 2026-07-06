<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteConfig['name'] }} @hasSection('title')&mdash; @yield('title')@endif</title>
    <meta name="description" content="Salon kecantikan dengan layanan hair styling, treatment, dan perawatan kuku.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|cormorant-garamond:500,600i,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg text-ink antialiased">

    @unless(Request::routeIs(['login', 'register']))
        @include('partials.navbar')
    @endunless

    <main>
        @if (session('success'))
            <div class="mx-auto mt-6 max-w-5xl rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    @unless(Request::routeIs(['login', 'register']))
        @include('partials.footer')
    @endunless

</body>
</html>
