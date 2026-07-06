<header class="border-b border-line bg-surface/80 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-6 py-4">
        <a href="{{ route('home') }}" class="group">
            <span class="block text-[11px] font-medium uppercase tracking-[0.2em] text-ink-muted">Est. 2026</span>
            <span class="font-serif text-2xl font-semibold text-ink group-hover:text-accent transition-colors">
                {{ $siteConfig['name'] }}
            </span>
        </a>

        <nav class="flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'text-accent' : 'text-ink hover:text-accent' }} transition-colors">
                Beranda
            </a>
            <a href="{{ route('services.index') }}"
               class="{{ request()->routeIs('services.index') ? 'text-accent' : 'text-ink hover:text-accent' }} transition-colors">
                Layanan
            </a>
            <a href="{{ route('products.index') }}"
               class="{{ request()->routeIs('products.*') ? 'text-accent' : 'text-ink hover:text-accent' }} transition-colors">
                Produk
            </a>
            <a href="{{ route('booking.create') }}"
               class="{{ request()->routeIs('booking.*') ? 'text-accent' : 'text-ink hover:text-accent' }} transition-colors">
                Booking
            </a>
            <a href="{{ route('cart.index') }}"
               class="{{ request()->routeIs('cart.*') ? 'text-accent' : 'text-ink hover:text-accent' }} relative transition-colors">
                Cart
                @if (\App\Support\Cart::count() > 0)
                    <span class="absolute -right-3 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-accent text-[10px] font-semibold text-white">
                        {{ \App\Support\Cart::count() }}
                    </span>
                @endif
            </a>

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.services.index') }}"
                       class="{{ request()->routeIs('admin.*') ? 'text-accent' : 'text-ink hover:text-accent' }} transition-colors">
                        Kelola Layanan
                    </a>
                @endif

                <div class="flex items-center gap-3 border-l border-line pl-6">
                    @unless (auth()->user()->isAdmin())
                        <a href="{{ route('bookings.mine') }}"
                           class="{{ request()->routeIs('bookings.mine') ? 'text-accent' : 'text-ink-muted hover:text-accent' }} text-xs">
                            Booking Saya
                        </a>
                        <a href="{{ route('account.edit') }}"
                           class="{{ request()->routeIs('account.*') ? 'text-accent' : 'text-ink-muted hover:text-accent' }} text-xs">
                            Akun Saya
                        </a>
                    @endunless
                    <span class="text-ink-muted">Hai, {{ explode(' ', auth()->user()->name)[0] }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-accent px-4 py-2 text-white transition hover:bg-accent-dark">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="rounded-full bg-accent px-4 py-2 text-white transition hover:bg-accent-dark">
                    Login
                </a>
            @endauth
        </nav>
    </div>
</header>
