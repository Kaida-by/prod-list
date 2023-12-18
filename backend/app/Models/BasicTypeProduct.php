<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $created_at
 * @property string $updated_at
 * @method static get()
 */
class BasicTypeProduct extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(BasicProduct::class, 'type_product_id');
    }
}
