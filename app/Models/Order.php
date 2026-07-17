<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $order_number
 * @property int|null $user_id
 * @property string $customer_name
 * @property string|null $customer_email
 * @property string|null $customer_phone
 * @property string|null $shipping_address
 * @property string $payment_method
 * @property int $subtotal
 * @property int $total
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'order_number', 'user_id', 'customer_name', 'customer_email',
    'customer_phone', 'shipping_address', 'payment_method',
    'subtotal', 'total', 'status',
])]
class Order extends Model
{
    use HasFactory, Notifiable;

    public const STATUSES = ['pending', 'paid', 'completed', 'cancelled'];

    public const STATUS_LABELS = [
        'pending' => 'Menunggu',
        'paid' => 'Dikonfirmasi',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    // ...casts(), user(), items(), generateOrderNumber() tetap sama seperti sebelumnya...

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }


    /**
     * Order bisa dibuat oleh guest (tidak login), jadi notifikasi email
     * dialamatkan ke customer_email yang diisi saat checkout, bukan ke
     * email akun user (yang belum tentu ada).
     */
    public function routeNotificationForMail(): ?string
    {
        return $this->customer_email;
    }

}
