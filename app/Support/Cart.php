<?php

namespace App\Support;

use Illuminate\Support\Facades\Session;

/**
 * Port langsung dari includes/cart.php (project PHP native).
 * Semua nama fungsi dipertahankan sebagai method statis supaya gampang
 * dibandingkan dengan kode asli, cuma penyimpanannya lewat Session facade
 * bawaan Laravel (bukan $_SESSION langsung).
 */
class Cart
{
    private const SESSION_KEY = 'cart_items';

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function items(): array
    {
        $rawItems = Session::get(self::SESSION_KEY, []);
        if (! is_array($rawItems)) {
            return [];
        }

        $normalized = [];
        foreach ($rawItems as $key => $item) {
            if (! is_array($item)) {
                continue;
            }

            $quantity = (int) ($item['quantity'] ?? 0);
            $price = (int) ($item['price'] ?? 0);
            $name = trim((string) ($item['name'] ?? ''));

            if ($quantity <= 0 || $price < 0 || $name === '') {
                continue;
            }

            $normalized[(string) $key] = [
                'id' => (int) ($item['id'] ?? 0),
                'name' => $name,
                'category' => trim((string) ($item['category'] ?? 'General')),
                'image' => trim((string) ($item['image'] ?? '')) ?: null,
                'price' => $price,
                'stock' => max(1, (int) ($item['stock'] ?? 99)),
                'quantity' => $quantity,
            ];
        }

        return $normalized;
    }

    /**
     * @param  array<string, array<string, mixed>>  $items
     */
    private static function save(array $items): void
    {
        Session::put(self::SESSION_KEY, $items);
    }

    /**
     * @param  array<string, mixed>  $item
     */
    public static function keyFor(array $item): string
    {
        $id = (int) ($item['id'] ?? 0);
        if ($id > 0) {
            return 'pid_'.$id;
        }

        $fallback = strtolower(trim((string) ($item['name'] ?? 'item')));

        return 'key_'.md5($fallback.'|'.(string) ($item['price'] ?? 0));
    }

    /**
     * @param  array<string, mixed>  $item
     */
    public static function add(array $item, int $quantity = 1): void
    {
        $safeQuantity = max(1, $quantity);
        $key = self::keyFor($item);
        $items = self::items();

        if (! isset($items[$key])) {
            $items[$key] = [
                'id' => (int) ($item['id'] ?? 0),
                'name' => trim((string) ($item['name'] ?? 'Item')),
                'category' => trim((string) ($item['category'] ?? 'General')),
                'image' => trim((string) ($item['image'] ?? '')) ?: null,
                'price' => max(0, (int) ($item['price'] ?? 0)),
                'stock' => max(1, (int) ($item['stock'] ?? 99)),
                'quantity' => 0,
            ];
        }

        $maxStock = max(1, (int) ($items[$key]['stock'] ?? 99));
        $items[$key]['quantity'] = min($maxStock, (int) $items[$key]['quantity'] + $safeQuantity);

        self::save($items);
    }

    public static function updateQuantity(string $key, int $quantity): void
    {
        $items = self::items();
        if (! isset($items[$key])) {
            return;
        }

        if ($quantity <= 0) {
            unset($items[$key]);
            self::save($items);

            return;
        }

        $maxStock = max(1, (int) ($items[$key]['stock'] ?? 99));
        $items[$key]['quantity'] = min($maxStock, $quantity);
        self::save($items);
    }

    public static function remove(string $key): void
    {
        $items = self::items();
        if (! isset($items[$key])) {
            return;
        }

        unset($items[$key]);
        self::save($items);
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public static function count(): int
    {
        $total = 0;
        foreach (self::items() as $item) {
            $total += (int) ($item['quantity'] ?? 0);
        }

        return $total;
    }

    public static function subtotal(): int
    {
        $subtotal = 0;
        foreach (self::items() as $item) {
            $subtotal += (int) $item['price'] * (int) $item['quantity'];
        }

        return $subtotal;
    }
}
