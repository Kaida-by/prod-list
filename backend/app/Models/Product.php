<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $count
 * @property int $type_count_id
 * @property int $comment_id
 * @property int $type_product_id
 * @property int $user_id
 * @method static findOrFail(int $int)
 */
class Product extends Model
{
    use HasFactory;

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
}
