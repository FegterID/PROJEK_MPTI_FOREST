<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingInvoiceMail;
use App\Notifications\BookingStatusNotification;

class BookingController extends Controller
{
    /**
     * Port dari pages/admin/bookings.php. Filter tanggal/layanan
     * disederhanakan jadi filter status saja + pagination bawaan Laravel.
     */
    public function index(Request $request): View
    {
        $filterStatus = trim((string) $request->query('status', ''));

        $bookings = Booking::query()
            ->when($filterStatus !== '', fn($q) => $q->where('status', $filterStatus))
            ->orderByDesc('booking_date')
            ->orderByDesc('booking_time')
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'filterStatus' => $filterStatus,
            'statuses' => Booking::STATUSES,
            'totalPending' => Booking::where('status', 'pending')->count(),
            'totalCompleted' => Booking::where('status', 'completed')->count(),
            'totalCancelled' => Booking::where('status', 'cancelled')->count(),
        ]);
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', Booking::STATUSES)],
        ]);

        $booking->update(['status' => $validated['status']]);

        if ($booking->wasChanged('status')) { // [BARU] cuma kirim kalau status beneran berubah
            $booking->user?->notify(new BookingStatusNotification($booking));
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Status booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
