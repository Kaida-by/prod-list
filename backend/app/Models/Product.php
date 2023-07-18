<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $count
 * @property int $count_type_id
 * @property int $comment_id
 * @property int $product_type_id
 * @property int $user_id
 * @method static findOrFail(int $int)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'count',
        'count_type_id',
        'comment_id',
        'product_type_id',
        'user_id',
    ];

    protected $dates = [
        'created_at',
    ];
}
