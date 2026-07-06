@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<section class="mx-auto max-w-6xl px-6 py-12">
    <p class="text-xs text-ink-muted">DESKTOP - CHECKOUT</p>
    <h1 class="mt-2 font-serif text-3xl font-semibold text-ink">Complete Your Order</h1>
    <p class="mt-1 text-sm text-ink-muted">Review your selection and finalize your purchase.</p>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_340px]">
        <div class="space-y-8">
            {{-- Item keranjang --}}
            <section class="rounded-xl border border-line bg-surface p-6">
                <h2 class="font-serif text-lg font-semibold text-ink">Your Selection</h2>

                @if (count($cartItems) === 0)
                    <div class="mt-6 rounded-lg border border-dashed border-line p-8 text-center text-ink-muted">
                        <p>Keranjang kamu masih kosong.</p>
                        <a href="{{ route('products.index') }}" class="mt-2 inline-block font-medium text-accent hover:underline">Lihat Produk</a>
                    </div>
                @else
                    <div class="mt-4 divide-y divide-line">
                        @foreach ($cartItems as $itemKey => $item)
                            <div class="flex flex-wrap items-center justify-between gap-4 py-4">
                                <div class="flex items-center gap-4">
                                    @if (! empty($item['image']))
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-14 w-14 shrink-0 rounded-lg object-cover">
                                    @else
                                        <div class="h-14 w-14 shrink-0 rounded-lg bg-gradient-to-br from-accent/20 to-surface-light"></div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-ink">{{ $item['name'] }}</p>
                                        <p class="text-xs text-ink-muted">{{ $item['category'] }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <form method="POST" action="{{ route('cart.update', $itemKey) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="text-xs text-ink-muted">Qty</label>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}"
                                               class="w-16 rounded-lg border border-line bg-white px-2 py-1.5 text-sm">
                                        <button type="submit" class="rounded-lg border border-line px-3 py-1.5 text-xs font-medium hover:border-accent hover:text-accent">
                                            Update
                                        </button>
                                    </form>

                                    <p class="w-28 text-right text-sm font-semibold text-ink">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </p>

                                    <form method="POST" action="{{ route('cart.remove', $itemKey) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- Info pelanggan (read-only, sesuai versi asli) --}}
            <section class="rounded-xl border border-line bg-surface p-6">
                <h2 class="font-serif text-lg font-semibold text-ink">Customer Information</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-ink-muted">Full Name</p>
                        <p class="mt-1 text-sm text-ink">{{ $customerName }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-ink-muted">Phone Number</p>
                        <p class="mt-1 text-sm text-ink">{{ $customerPhone }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-ink-muted">Email</p>
                        <p class="mt-1 text-sm text-ink">{{ $customerEmail }}</p>
                    </div>
                </div>
                @guest
                    <p class="mt-3 text-xs text-ink-muted">
                        <a href="{{ route('login') }}" class="text-accent hover:underline">Login</a> untuk memakai data akun kamu saat checkout.
                    </p>
                @endguest
            </section>

            <section class="rounded-xl border border-line bg-surface p-6">
                <h2 class="font-serif text-lg font-semibold text-ink">Shipping Address</h2>
                <p class="mt-3 whitespace-pre-line text-sm text-ink-muted">{{ $customerAddress }}</p>
            </section>
        </div>

        {{-- Ringkasan & checkout --}}
        <aside class="h-fit rounded-xl border border-line bg-surface p-6">
            <h2 class="font-serif text-lg font-semibold text-ink">Summary</h2>
            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between text-ink-muted">
                    <span>Subtotal</span>
                    <strong class="text-ink">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>
                <div class="flex justify-between text-ink-muted">
                    <span>Shipping</span>
                    <strong class="text-ink">Free</strong>
                </div>
                <div class="flex justify-between border-t border-line pt-2 text-base font-semibold text-ink">
                    <span>Total</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('cart.checkout') }}" class="mt-6">
                @csrf
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Payment Method</label>
                <div class="mt-2 space-y-2 text-sm">
                    <label class="flex items-center gap-2 rounded-lg border border-line px-3 py-2">
                        <input type="radio" name="payment_method" value="bank_transfer" checked>
                        Bank Transfer
                    </label>
                    <label class="flex items-center gap-2 rounded-lg border border-line px-3 py-2">
                        <input type="radio" name="payment_method" value="cod">
                        Cash on Delivery
                    </label>
                    <label class="flex items-center gap-2 rounded-lg border border-line px-3 py-2">
                        <input type="radio" name="payment_method" value="ewallet">
                        E-Wallet
                    </label>
                </div>

                <button type="submit" @if(count($cartItems) === 0) disabled @endif
                        class="mt-6 w-full rounded-full bg-accent py-3 text-sm font-medium text-white transition hover:bg-accent-dark disabled:cursor-not-allowed disabled:bg-ink-muted/40">
                    Place Order
                </button>
            </form>

            <p class="mt-4 text-center text-xs text-ink-muted">Encrypted, secure transaction</p>
        </aside>
    </div>
</section>
@endsection
