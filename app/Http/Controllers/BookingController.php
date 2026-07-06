<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Halaman form booking. Port dari pages/booking.php.
     * Tetap route publik, tapi kalau belum login akan ditampilkan
     * ajakan login (sama seperti versi asli), bukan redirect paksa.
     */
    public function create(Request $request): View
    {
        return view('booking.create', [
            'services' => Service::orderBy('id')->get(['id', 'name']),
            'selectedService' => trim((string) $request->query('service', '')),
            'timeSlots' => Booking::TIME_SLOTS,
        ]);
    }

    /**
     * Setara api/booking.php.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:25'],
            'service' => ['required', 'string'],
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'in:'.implode(',', Booking::TIME_SLOTS)],
        ]);

        $bookingDateTime = \DateTime::createFromFormat('Y-m-d H:i', $validated['date'].' '.$validated['time']);
        if ($bookingDateTime === false || $bookingDateTime < new \DateTime()) {
            return redirect()->route('booking.create')->withErrors([
                'date' => 'Tanggal/jam booking tidak valid atau sudah lewat.',
            ]);
        }

        $conflict = Booking::where('booking_date', $validated['date'])
            ->where('booking_time', $validated['time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($conflict) {
            return redirect()->route('booking.create')->withErrors([
                'time' => 'Slot waktu tersebut sudah terisi. Silakan pilih slot lain.',
            ]);
        }

        $service = Service::where('name', $validated['service'])->first();

        Booking::create([
            'user_id' => Auth::id(),
            'customer_name' => $validated['name'],
            'whatsapp' => $validated['phone'],
            'service_id' => $service?->id,
            'service_name' => $validated['service'],
            'booking_date' => $validated['date'],
            'booking_time' => $validated['time'],
            'status' => 'pending',
        ]);

        return redirect()->route('booking.create')->with('success', 'Reservasi berhasil dikirim. Tim kami akan konfirmasi via WhatsApp.');
    }

    /**
     * Setara api/booking-slots.php — dipanggil via fetch() dari form booking.
     */
    public function slots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        $date = $validated['date'];

        $bookedSlots = Booking::where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(fn (Booking $booking) => $booking->booking_time->format('H:i'))
            ->unique()
            ->values();

        if ($date === now()->toDateString()) {
            $now = now()->format('H:i');
            $bookedSlots = $bookedSlots->merge(
                collect(Booking::TIME_SLOTS)->filter(fn ($slot) => $slot <= $now)
            )->unique()->values();
        }

        return response()->json([
            'ok' => true,
            'date' => $date,
            'slots' => Booking::TIME_SLOTS,
            'booked' => $bookedSlots,
        ]);
    }
}
