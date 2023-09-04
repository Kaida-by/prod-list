<?php

namespace App\Data\RequestData;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class TypeProductDataRequest extends Data
{
    #[Required, StringType, Max(255)]
    public string $name;
    #[Required, IntegerType, Max(999999999)]
    public int $product_list_id;
}
