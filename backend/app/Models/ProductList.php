<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read Collection | TypeProduct|null $typeProduct
 * @property-read Collection | Product|null $product
 * @method static findOrFail(int $int)
 */
class ProductList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $dates = [
        'created_at',
    ];

    public function typeProduct()
    {
        return $this->hasMany(TypeProduct::class, 'product_list_id');
    }
}
