@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="mb-6 grid grid-cols-4 gap-4">
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Total Pesanan</p>
        <p class="mt-1 text-xl font-semibold text-ink">{{ $totalOrders }}</p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Sudah Dibayar</p>
        <p class="mt-1 text-xl font-semibold text-ink">{{ $paidOrders }}</p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Menunggu</p>
        <p class="mt-1 text-xl font-semibold text-ink">{{ $pendingOrders }}</p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Selesai</p>
        <p class="mt-1 text-xl font-semibold text-ink">{{ $completedOrders }}</p>
    </div>
</div>

<form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4 flex flex-wrap gap-3">
    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nomor order / nama pelanggan..."
           class="flex-1 rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
    <select name="status" onchange="this.form.submit()"
            class="rounded-lg border border-line bg-white px-3 py-2 text-sm">
        <option value="" @selected($filterStatus === '')>Semua Status</option>
        <option value="pending" @selected($filterStatus === 'pending')>Pending</option>
        <option value="paid" @selected($filterStatus === 'paid')>Paid</option>
        <option value="cancelled" @selected($filterStatus === 'cancelled')>Cancelled</option>
    </select>
    <button type="submit" class="rounded-lg bg-accent px-4 py-2 text-sm font-medium text-white hover:bg-accent-dark">Cari</button>
</form>

<div class="overflow-hidden rounded-xl border border-line bg-surface">
    <table class="w-full text-left text-sm">
        <thead class="bg-surface-light text-xs uppercase tracking-wide text-ink-muted">
            <tr>
                <th class="px-4 py-3">Order</th>
                <th class="px-4 py-3">Pelanggan</th>
                <th class="px-4 py-3">Item</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-line">
            @forelse ($orders as $order)
                <tr>
                    <td class="px-4 py-3">
                        <p class="font-medium text-ink">{{ $order->order_number }}</p>
                        <p class="text-xs text-ink-muted">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-ink">{{ $order->customer_name }}</p>
                        <p class="text-xs text-ink-muted">{{ $order->customer_phone }}</p>
                    </td>
                    <td class="px-4 py-3 text-xs text-ink-muted">
                        {{ $order->items->pluck('product_name')->implode(', ') }}
                    </td>
                    <td class="px-4 py-3 text-ink-muted">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                            @csrf
                            @method('PATCH')
                            <!-- Filter di atas tabel -->
                            <select name="status" onchange="this.form.submit()"
                                    class="rounded-lg border border-line bg-white px-3 py-2 text-sm">
                                <option value="" @selected($filterStatus === '')>Semua Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected($filterStatus === $status)>
                                        {{ \App\Models\Order::STATUS_LABELS[$status] }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                              onsubmit="return confirm('Hapus order {{ $order->order_number }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-ink-muted">Belum ada pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
