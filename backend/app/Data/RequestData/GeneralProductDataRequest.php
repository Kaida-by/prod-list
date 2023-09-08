<?php

namespace App\Data\RequestData;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class GeneralProductDataRequest extends Data
{
    #[Required, StringType, Max(255)]
    public string $name;
}
