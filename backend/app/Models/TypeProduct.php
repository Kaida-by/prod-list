<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $user_id
 * @property int $product_list_id
 * @property string $created_at
 * @property string $updated_at
 * @method static findOrFail(int $int)
 */
class TypeProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'color',
        'user_id',
        'product_list_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'type_product_id');
    }
}
