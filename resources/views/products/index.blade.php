@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-16 text-center">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Skincare Collection</p>
        <h1 class="mt-3 font-serif text-3xl font-semibold text-ink sm:text-4xl">Produk Perawatan Premium</h1>
        <p class="mx-auto mt-4 max-w-xl text-sm text-ink-muted">
            Dipilih untuk melengkapi rutinitas perawatan harian Anda.
        </p>
    </section>

    <section class="mx-auto max-w-6xl px-6 pb-20">
        @if ($productsByCategory->isEmpty())
            <div class="rounded-xl border border-line bg-surface p-10 text-center text-ink-muted">
                Belum ada produk tersedia saat ini.
            </div>
        @else
            @foreach ($productsByCategory as $category => $products)
                <div class="mb-14">
                    <h2 class="mb-5 font-serif text-xl font-semibold text-ink">{{ $category }}</h2>

                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $product)
                            <div
                                class="flex flex-col justify-between rounded-xl border border-line bg-surface p-5 transition hover:border-accent">
                                <div>
                                    @if ($product->imageUrl())
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                                            class="mb-3 h-40 w-full rounded-lg object-cover">
                                    @else
                                        <div class="mb-3 h-40 w-full rounded-lg bg-gradient-to-br from-accent/20 to-surface-light"></div>
                                    @endif
                                    <span class="text-[11px] font-medium uppercase tracking-wide text-accent">
                                        {{ $product->inStock() ? 'IN STOCK' : 'SOLD OUT' }}
                                    </span>
                                    <h3 class="mt-2 font-serif text-lg font-semibold text-ink">
                                        <a href="{{ route('products.show', $product) }}"
                                            class="hover:text-accent">{{ $product->name }}</a>
                                    </h3>
                                    <p class="mt-2 text-sm text-ink-muted">
                                        {{ \Illuminate\Support\Str::limit($product->description, 90) }}
                                    </p>
                                </div>

                                <div class="mt-5 flex items-center justify-between border-t border-line pt-4">
                                    <p class="font-semibold text-ink">{{ $product->displayPrice() }}</p>

                                    <div class="flex gap-2">
                                        <a href="{{ route('products.show', $product) }}"
                                            class="rounded-full border border-line px-3 py-1.5 text-xs font-medium text-ink hover:border-accent hover:text-accent">
                                            Detail
                                        </a>

                                        @if ($product->inStock())
                                            <form method="POST" action="{{ route('cart.add') }}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="name" value="{{ $product->name }}">
                                                <input type="hidden" name="category" value="{{ $product->category }}">
                                                <input type="hidden" name="image" value="{{ $product->imageUrl() }}">
                                                <input type="hidden" name="price" value="{{ $product->price }}">
                                                <input type="hidden" name="stock" value="{{ $product->stock }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="rounded-full bg-accent px-3 py-1.5 text-xs font-medium text-white hover:bg-accent-dark">
                                                    + Keranjang
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </section>
@endsection