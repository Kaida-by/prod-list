<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $product_list_id
 * @property string $created_at
 * @property string $updated_at
 * @method static findOrFail(int $int)
 */
class TypeProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'product_list_id',
    ];
}
