<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Port dari pages/admin/orders.php. Filter search (order number /
     * nama pelanggan) + status dipertahankan; filter metode pembayaran
     * disederhanakan (bisa ditambah lagi kalau perlu).
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $filterStatus = trim((string) $request->query('status', ''));

        $orders = Order::query()
            ->with('items')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%");
                });
            })
            ->when($filterStatus !== '', fn ($q) => $q->where('status', $filterStatus))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'search' => $search,
            'filterStatus' => $filterStatus,
            'totalOrders' => Order::count(),
            'paidOrders' => Order::where('status', 'paid')->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
