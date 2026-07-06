<footer class="mt-24 border-t border-line bg-surface">
    <div class="mx-auto grid max-w-6xl gap-8 px-6 py-12 sm:grid-cols-3">
        <div>
            <p class="font-serif text-xl font-semibold text-ink">{{ $siteConfig['name'] }}</p>
            <p class="mt-2 text-sm text-ink-muted">{{ $siteConfig['address'] }}</p>
        </div>
        <div class="text-sm text-ink-muted">
            <p class="font-medium text-ink">Kontak</p>
            <p class="mt-2">{{ $siteConfig['phone'] }}</p>
            <a href="{{ $siteConfig['whatsapp'] }}" class="mt-1 block hover:text-accent">WhatsApp</a>
            <a href="{{ $siteConfig['instagram'] }}" class="mt-1 block hover:text-accent">Instagram</a>
        </div>
        <div class="text-sm text-ink-muted sm:text-right">
            <p>&copy; {{ date('Y') }} {{ $siteConfig['name'] }}.</p>
            <p>All rights reserved.</p>
        </div>
    </div>
</footer>
