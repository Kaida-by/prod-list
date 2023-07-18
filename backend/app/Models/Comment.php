<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $text
 * @property mixed $user_id
 * @method static findOrFail(int $int)
 */
class Comment extends Model
{
    use HasFactory;
}
