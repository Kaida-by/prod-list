<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $name
 * @property mixed $user_id
 * @property mixed $product_list_id
 * @method static findOrFail(int $int)
 */
class TypeProduct extends Model
{
    use HasFactory;
}
