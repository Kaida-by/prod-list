<?php

namespace App\Data\ResourceData;

use App\Models\GeneralProduct;
use Spatie\LaravelData\Data;

class GeneralProductDataResource extends Data
{
    public function __construct(
       public int $id,
       public string $name,
       public int $user_id,
       public string $created_at,
       public string $updated_at,
    ) {}

    public static function fromModel(GeneralProduct $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            user_id: $product->user_id,
            created_at: $product->created_at,
            updated_at: $product->updated_at,
        );
    }
}