<?php

namespace App\Data\RequestData;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class TypeProductDataRequest extends Data
{
    #[Required, StringType, Max(255)]
    public string $name;
    #[Required, StringType, Max(255)]
    public string $color;
    #[DataCollectionOf(ProductDataRequest::class)]
    public DataCollection $products;
}
