<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $customer_name
 * @property string $whatsapp
 * @property int|null $service_id
 * @property string $service_name
 * @property \Illuminate\Support\Carbon $booking_date
 * @property \Illuminate\Support\Carbon $booking_time
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Service|null $service
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereBookingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereBookingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereServiceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereWhatsapp($value)
 * @mixin \Eloquent
 */
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

    public function getDisplayPriceAttribute()
    {
        // 1. Jika harga tersimpan langsung di transaksi booking
        if ($this->price) {
            return 'Rp ' . number_format($this->price, 0, ',', '.');
        }

        // 2. Jika mengambil dari relasi service
        if ($this->service) {
            return $this->service->formattedPrice();
        }

        return 'Rp 0';
    }

}
