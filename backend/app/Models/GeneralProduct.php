<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @method static findOrFail(int $int)
 */
class GeneralProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'user_id',
    ];

    protected $dates = [
        'created_at',
    ];
}
