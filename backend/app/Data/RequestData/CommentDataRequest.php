<?php

namespace App\Data\RequestData;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CommentDataRequest extends Data
{
    #[Required, StringType, Max(255)]
    public string $text;
}
