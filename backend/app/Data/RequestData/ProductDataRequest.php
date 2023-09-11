<?php

namespace App\Data\RequestData;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class ProductDataRequest extends Data
{
    #[Required, StringType, Max(255)]
    public string $name;
    #[Required, IntegerType, Max(999999999)]
    public int $count;
    #[Required, IntegerType, Max(999999999)]
    public int $type_count_id;
    #[Nullable, IntegerType, Max(999999999)]
    public ?int $comment_id;
}
