@extends('layouts.admin')

@section('title', 'Booking List')

@section('content')
<div class="mb-6 grid grid-cols-3 gap-4">
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Menunggu</p>
        <p class="mt-1 text-xl font-semibold text-ink">{{ $totalPending }}</p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Selesai</p>
        <p class="mt-1 text-xl font-semibold text-ink">{{ $totalCompleted }}</p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Dibatalkan</p>
        <p class="mt-1 text-xl font-semibold text-ink">{{ $totalCancelled }}</p>
    </div>
</div>

<div class="mb-4 flex flex-wrap gap-2">
    <a href="{{ route('admin.bookings.index') }}"
       class="rounded-full px-3 py-1.5 text-xs font-medium {{ $filterStatus === '' ? 'bg-accent text-white' : 'border border-line text-ink hover:border-accent' }}">
        Semua
    </a>
    @foreach ($statuses as $status)
        <a href="{{ route('admin.bookings.index', ['status' => $status]) }}"
           class="rounded-full px-3 py-1.5 text-xs font-medium {{ $filterStatus === $status ? 'bg-accent text-white' : 'border border-line text-ink hover:border-accent' }}">
            {{ \App\Models\Booking::STATUS_LABELS[$status] }}
        </a>
    @endforeach
</div>

<div class="overflow-hidden rounded-xl border border-line bg-surface">
    <table class="w-full text-left text-sm">
        <thead class="bg-surface-light text-xs uppercase tracking-wide text-ink-muted">
            <tr>
                <th class="px-4 py-3">Pelanggan</th>
                <th class="px-4 py-3">Layanan</th>
                <th class="px-4 py-3">Jadwal</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-line">
            @forelse ($bookings as $booking)
                <tr>
                    <td class="px-4 py-3">
                        <p class="font-medium text-ink">{{ $booking->customer_name }}</p>
                        <p class="text-xs text-ink-muted">{{ $booking->whatsapp }}</p>
                    </td>
                    <td class="px-4 py-3 text-ink-muted">{{ $booking->service_name }}</td>
                    <td class="px-4 py-3 text-ink-muted">
                        {{ $booking->booking_date->format('d M Y') }}<br>
                        <span class="text-xs">{{ $booking->booking_time->format('H:i') }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="rounded-lg border border-line bg-white px-2 py-1.5 text-xs">
                                @foreach (\App\Models\Booking::STATUSES as $status)
                                    <option value="{{ $status }}" @selected($booking->status === $status)>
                                        {{ \App\Models\Booking::STATUS_LABELS[$status] }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                              onsubmit="return confirm('Hapus booking #{{ $booking->id }}?');">
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
                    <td colspan="5" class="px-4 py-10 text-center text-ink-muted">Belum ada booking.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $bookings->links() }}
</div>
@endsection
