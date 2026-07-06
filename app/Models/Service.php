<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
