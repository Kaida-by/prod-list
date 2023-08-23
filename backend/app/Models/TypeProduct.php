<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $user_id
 * @property int $product_list_id
 * @method static findOrFail(int $int)
 */
class TypeProduct extends Model
{
    use HasFactory;
}
