<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $category
 * @property string $category_name
 * @property string $name
 * @property string $description
 * @property string|null $image
 * @property int $duration
 * @property int|null $price
 * @property string|null $price_range
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service wherePriceRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['category', 'category_name', 'name', 'description', 'image', 'duration', 'price', 'price_range'])]
class Service extends Model
{
    use HasFactory;

    public const CATEGORIES = ['hair', 'face', 'nail'];

    public const CATEGORY_LABELS = [
        'hair' => 'PERAWATAN RAMBUT',
        'face' => 'PERAWATAN WAJAH',
        'nail' => 'PERAWATAN KUKU',
    ];

    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'price' => 'integer',
        ];
    }

    /**
     * Setara formatServicePrice() di pages/services.php lama.
     */
    public function formattedPrice(): string
    {
        $priceRange = trim((string) $this->price_range);

        if ($priceRange !== '') {
            return preg_match('/^\d+$/', $priceRange) === 1
                ? 'Rp '.number_format((int) $priceRange, 0, ',', '.')
                : 'Rp '.$priceRange;
        }

        if ((int) $this->price > 0) {
            return 'Rp '.number_format((int) $this->price, 0, ',', '.');
        }

        return 'Hubungi kami';
    }

    public function imageUrl(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
