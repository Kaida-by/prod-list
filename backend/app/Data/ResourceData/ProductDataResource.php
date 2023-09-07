<?php

namespace App\Data\ResourceData;

use App\Models\Product;
use App\Models\TypeCount;
use App\Models\TypeProduct;
use Spatie\LaravelData\Data;

class ProductDataResource extends Data
{
    public function __construct(
       public int $id,
       public string $name,
       public int $count,
       public ?int $comment_id,
       public int $type_count_id,
       public int $type_product_id,
       public int $user_id,
       public string $created_at,
       public string $updated_at,
       public TypeCount $typeCount,
       public TypeProduct $typeProduct,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            count: $product->count,
            comment_id: $product->comment_id,
            type_count_id: $product->type_count_id,
            type_product_id: $product->type_product_id,
            user_id: $product->user_id,
            created_at: $product->created_at,
            updated_at: $product->updated_at,
            typeCount: $product->typeCount,
            typeProduct: $product->typeProduct,
        );
    }
}
