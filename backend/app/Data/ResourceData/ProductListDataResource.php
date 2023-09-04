<?php

namespace App\Data\ResourceData;

use App\Models\ProductList;
use Spatie\LaravelData\Data;

class ProductListDataResource extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public int $user_id,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromModel(ProductList $productList): self
    {
        return new self(
            id: $productList->id,
            name: $productList->name,
            user_id: $productList->user_id,
            created_at: $productList->created_at,
            updated_at: $productList->updated_at,
        );
    }
}
