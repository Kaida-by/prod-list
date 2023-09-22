<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @method static findOrFail(int $int)
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'user_id',
    ];
}
