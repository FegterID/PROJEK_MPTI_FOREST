<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'customer_name', 'whatsapp', 'service_id', 'service_name',
    'booking_date', 'booking_time', 'status', 'notes',
])]
class Booking extends Model
{
    use HasFactory;

    public const TIME_SLOTS = [
        '09:00', '10:00', '11:00', '12:00', '13:00',
        '14:00', '15:00', '16:00', '17:00', '18:00',
    ];

    public const STATUSES = ['pending', 'confirmed', 'completed', 'cancelled'];

    public const STATUS_LABELS = [
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'booking_time' => 'datetime:H:i',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Setara link WhatsApp di pages/my-bookings.php lama.
     */
    public function whatsappLink(): string
    {
        $text = rawurlencode("Halo, saya ingin tanya booking #{$this->id} untuk layanan {$this->service_name}.");
        $base = config('site.whatsapp');

        return $base.(str_contains($base, '?') ? '&' : '?')."text={$text}";
    }
}
