<?php

namespace App\Data\RequestData;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class GeneralProductDataRequest extends Data
{
    #[Required, StringType, Max(255)]
    public string $name;
    #[Required, StringType, Max(255)]
    public string $color;
    #[Nullable, IntegerType]
    public ?int $type_product_id;
}
