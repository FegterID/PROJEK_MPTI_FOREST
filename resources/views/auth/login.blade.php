@extends('layouts.app')

@section('content')
<div class="grid min-h-screen lg:grid-cols-2">
    <div class="relative hidden overflow-hidden bg-ink lg:flex lg:items-center lg:justify-center">
        <div class="absolute inset-0 bg-gradient-to-br from-accent-dark via-ink to-ink opacity-90"></div>
        <p class="relative z-10 max-w-xs px-10 text-center font-serif text-3xl font-medium leading-snug text-white">
            Where beauty finds<br>
            <em>its quiet rhythm.</em>
        </p>
    </div>

    <div class="relative flex items-center justify-center px-6 py-16">
        <a href="{{ route('home') }}"
           class="absolute right-6 top-6 text-2xl leading-none text-ink-muted transition hover:text-accent"
           aria-label="Kembali ke beranda">&times;</a>

        <div class="w-full max-w-sm">
            <p class="font-serif text-lg font-semibold text-ink">{{ $siteConfig['name'] }}</p>
            <h1 class="mt-2 font-serif text-3xl font-semibold text-ink">Welcome Back</h1>
            <p class="mt-1 text-xs font-medium uppercase tracking-wider text-ink-muted">
                Login required to book or purchase
            </p>

            @if ($errors->any())
                <div class="mt-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label for="login_id" class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">
                        Email / Username
                    </label>
                    <input type="text" id="login_id" name="login_id" value="{{ old('login_id') }}" required
                           placeholder="name@example.com"
                           class="mt-2 w-full rounded-lg border border-line bg-white px-4 py-2.5 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required placeholder="........"
                           class="mt-2 w-full rounded-lg border border-line bg-white px-4 py-2.5 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-accent py-3 text-sm font-medium text-white transition hover:bg-accent-dark">
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-ink-muted">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-accent hover:underline">Register</a>
            </p>

            <p class="mt-8 text-center text-xs text-ink-muted">&copy; {{ date('Y') }} {{ $siteConfig['name'] }}. All rights reserved.</p>
        </div>
    </div>
</div>
@endsection
