<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read Collection | TypeProduct|null $typeProducts
 * @property-read Collection | Product|null $products
 * @method static findOrFail(int $int)
 */
class ProductList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'user_id',
    ];

    protected $dates = [
        'created_at',
    ];

    public function typeProducts(): HasMany
    {
        return $this->hasMany(TypeProduct::class, 'product_list_id');
    }
}
