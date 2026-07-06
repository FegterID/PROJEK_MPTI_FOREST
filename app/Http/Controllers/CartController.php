<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Support\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Halaman cart/checkout. Port dari bagian GET pages/cart.php.
     * Cart & checkout tetap bisa diakses guest (tidak wajib login),
     * sama seperti project asli — index.php cuma requireLogin() untuk
     * my-bookings & my-account, bukan cart.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('cart.index', [
            'cartItems' => Cart::items(),
            'subtotal' => Cart::subtotal(),
            'customerName' => $user->name ?? 'Nama Pelanggan',
            'customerPhone' => $user->username ?? config('site.phone'),
            'customerEmail' => $user->email ?? 'email@example.com',
            'customerAddress' => $user->address ?: config('site.address'),
        ]);
    }

    /**
     * Setara cart_action=add.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'category' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        Cart::add([
            'id' => $validated['product_id'],
            'name' => $validated['name'],
            'category' => $validated['category'] ?? 'General',
            'image' => $validated['image'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'] ?? 99,
        ], $validated['quantity'] ?? 1);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Setara cart_action=update.
     */
    public function update(Request $request, string $itemKey): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer'],
        ]);

        Cart::updateQuantity($itemKey, $validated['quantity']);

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    /**
     * Setara cart_action=remove.
     */
    public function destroy(string $itemKey): RedirectResponse
    {
        Cart::remove($itemKey);

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    /**
     * Setara cart_action=place_order. Simpan ke orders + order_items,
     * lalu kosongkan cart.
     */
    public function checkout(Request $request): RedirectResponse
    {
        $cartItems = Cart::items();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->withErrors([
                'cart' => 'Keranjang masih kosong. Tambahkan produk terlebih dahulu.',
            ]);
        }

        $user = Auth::user();
        $subtotal = Cart::subtotal();

        DB::transaction(function () use ($cartItems, $user, $subtotal, $request) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user?->id,
                'customer_name' => $user->name ?? 'Guest',
                'customer_email' => $user->email ?? null,
                'customer_phone' => $user->username ?? null,
                'shipping_address' => $user->address ?? config('site.address'),
                'payment_method' => $request->input('payment_method', 'bank_transfer'),
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'] > 0 ? $item['id'] : null,
                    'product_name' => $item['name'],
                    'product_category' => $item['category'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }
        });

        Cart::clear();

        return redirect()->route('cart.index')->with('success', 'Pesanan berhasil diproses. Tim kami akan menghubungi Anda segera.');
    }
}
