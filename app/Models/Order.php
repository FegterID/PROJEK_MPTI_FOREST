<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

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

    /**
     * Relasi ke OrderItem (Satu Order memiliki banyak Item)
     */
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
    public static function generateOrderNumber(): string
    {
        $count = static::count();

        return 'SBB-'.str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
    }
}
