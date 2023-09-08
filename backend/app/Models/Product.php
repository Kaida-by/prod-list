<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int $count
 * @property int $type_count_id
 * @property int $comment_id
 * @property int $type_product_id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read TypeCount|null typeCount
 * @property-read TypeProduct|null typeProduct
 * @method static findOrFail(int $int)
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'count',
        'type_count_id',
        'comment_id',
        'type_product_id',
        'user_id',
    ];

    protected $dates = [
        'created_at',
    ];

    public function typeCount(): HasOne
    {
        return $this->hasOne(TypeCount::class, 'id', 'type_count_id');
    }

    public function typeProduct(): HasOne
    {
        return $this->hasOne(TypeProduct::class, 'id', 'type_product_id');
    }
}
