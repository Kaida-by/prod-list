<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property int|null $type_product_id
 * @property string $created_at
 * @property string $updated_at
 * @method static get()
 */
class BasicProduct extends Model
{
    protected $fillable = [
        'name',
        'type_product_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function typeProduct(): HasOne
    {
        return $this->hasOne(BasicTypeProduct::class, 'id', 'type_product_id');
    }
}
