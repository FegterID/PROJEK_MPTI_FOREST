<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Contoh data booking biar dashboard admin & my-bookings nggak kosong
 * pas pertama kali di-seed. Aman dihapus/disesuaikan.
 */
class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('role', 'customer')->first();
        $services = Service::inRandomOrder()->limit(3)->get();

        if (! $customer || $services->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'confirmed', 'completed'];

        foreach ($services as $index => $service) {
            Booking::updateOrCreate(
                [
                    'user_id' => $customer->id,
                    'service_id' => $service->id,
                    'booking_date' => now()->addDays($index + 1)->toDateString(),
                ],
                [
                    'customer_name' => $customer->name,
                    'whatsapp' => $customer->username,
                    'service_name' => $service->name,
                    'booking_time' => Booking::TIME_SLOTS[$index] ?? '09:00',
                    'status' => $statuses[$index] ?? 'pending',
                ]
            );
        }
    }
}
