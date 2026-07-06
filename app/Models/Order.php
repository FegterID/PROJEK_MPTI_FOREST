<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'order_number', 'user_id', 'customer_name', 'customer_email',
    'customer_phone', 'shipping_address', 'payment_method',
    'subtotal', 'total', 'status',
])]
class Order extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'total' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Setara logic penomoran order di pages/cart.php lama: SBB-0001, SBB-0002, dst.
     */
    public static function generateOrderNumber(): string
    {
        $count = static::count();

        return 'SBB-'.str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
    }
}
