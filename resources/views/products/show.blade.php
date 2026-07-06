@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-12">
        <p class="text-xs text-ink-muted">
            <a href="{{ route('home') }}" class="hover:text-accent">Home</a> /
            <a href="{{ route('products.index') }}" class="hover:text-accent">Products</a> /
            {{ strtoupper($product->category) }}
        </p>

        <div class="mt-6 grid gap-10 lg:grid-cols-2">
            @if ($product->imageUrl())
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                    class="aspect-square w-full rounded-2xl border border-line object-cover">
            @else
                <div
                    class="aspect-square rounded-2xl border border-line bg-gradient-to-br from-accent/20 via-surface to-surface-light">
                </div>
            @endif

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-accent">{{ $product->category }}</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-ink">{{ $product->name }}</h1>
                <p class="mt-3 text-2xl font-semibold text-ink">{{ $product->displayPrice() }}</p>

                <form method="POST" action="{{ route('cart.add') }}" class="mt-6 space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="category" value="{{ $product->category }}">
                    <input type="hidden" name="image" value="{{ $product->imageUrl() }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="stock" value="{{ $product->stock }}">

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                            class="mt-2 w-24 rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                    </div>

                    @if ($product->inStock())
                        <button type="submit"
                            class="rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition hover:bg-accent-dark">
                            Add To Cart
                        </button>
                    @else
                        <button type="button" disabled
                            class="cursor-not-allowed rounded-full bg-ink-muted/40 px-6 py-3 text-sm font-medium text-white">
                            Out of Stock
                        </button>
                    @endif
                </form>

                <div class="mt-6 space-y-1 border-t border-line pt-4 text-sm text-ink-muted">
                    <p>
                        <strong class="text-ink">Availability:</strong>
                        <span class="{{ $product->inStock() ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $product->inStock() ? "In Stock ({$product->stock} items)" : 'Out of Stock' }}
                        </span>
                    </p>
                    <p><strong class="text-ink">SKU:</strong> {{ $product->sku() }}</p>
                </div>
            </div>
        </div>

        <div class="mt-14 max-w-3xl">
            <h2 class="font-serif text-xl font-semibold text-ink">The Essence of {{ $product->name }}</h2>
            <p class="mt-3 text-sm leading-relaxed text-ink-muted">{{ $product->description }}</p>

            <div class="mt-6">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-ink">Product Benefits</h3>
                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-ink-muted">
                    <li>Premium quality ingredients for best results</li>
                    <li>Dermatologically tested and safe for all skin types</li>
                    <li>Long-lasting formula with visible results</li>
                </ul>
            </div>
        </div>
    </section>
@endsection