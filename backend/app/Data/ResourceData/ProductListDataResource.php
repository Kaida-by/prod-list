<?php

namespace App\Data\ResourceData;

use App\Models\Product;
use App\Models\ProductList;
use App\Models\TypeProduct;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class ProductListDataResource extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public Collection $typeProduct,
        public Collection $product,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromModel(ProductList $productList): self
    {
        return new self(
            id: $productList->id,
            name: $productList->name,
            typeProduct: $productList->typeProduct,
            product: $productList->product,
            created_at: $productList->created_at,
            updated_at: $productList->updated_at,
        );
    }
}
