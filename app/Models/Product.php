<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $category
 * @property string $name
 * @property string $description
 * @property string|null $image
 * @property int $price
 * @property int $stock
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|Product active()
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereCategory($value)
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereDescription($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereImage($value)
 * @method static Builder<static>|Product whereIsActive($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product wherePrice($value)
 * @method static Builder<static>|Product whereStock($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['category', 'name', 'description', 'image', 'price', 'stock', 'is_active'])]
class Product extends Model
{
    use HasFactory;

    public const CATEGORIES = ['Hair Care', 'Face Care', 'Nail Care', 'Body Care'];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function inStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Harga dalam Rupiah, dipakai di cart/checkout.
     */
    public function formattedPrice(): string
    {
        return 'Rp '.number_format($this->price, 0, ',', '.');
    }

    /**
     * Port dari tampilan "$" di pages/products.php & product-detail.php lama
     * (price dibagi 1000, format 2 desimal). Dipertahankan biar visualnya sama.
     */
    public function displayPrice(): string
    {
        return '$'.number_format($this->price / 1000, 2);
    }

    public function sku(): string
    {
        return 'SEPTYAA-'.str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * URL gambar produk. Kalau belum upload gambar, return null supaya
     * view bisa jatuh ke placeholder gradient (dipertahankan dari desain awal).
     */
    public function imageUrl(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
