<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $user_id
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
}
