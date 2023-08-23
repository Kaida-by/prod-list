<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $text
 * @property int $user_id
 * @method static findOrFail(int $int)
 */
class Comment extends Model
{
    use HasFactory;
}
