<?php

namespace App\Data\ResourceData;

use App\Models\TypeProduct;
use Spatie\LaravelData\Data;

class TypeProductDataResource extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public int $user_id,
        public int $product_list_id,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromModel(TypeProduct $typeProduct): self
    {
        return new self(
            id: $typeProduct->id,
            name: $typeProduct->name,
            user_id: $typeProduct->user_id,
            product_list_id: $typeProduct->product_list_id,
            created_at: $typeProduct->created_at,
            updated_at: $typeProduct->updated_at,
        );
    }
}
