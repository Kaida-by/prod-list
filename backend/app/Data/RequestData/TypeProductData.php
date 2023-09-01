<?php

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class TypeProductData extends Data
{
    #[Required, StringType, Max(255)]
    public string $name;
}
