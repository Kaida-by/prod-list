<?php

namespace App\Http\Controllers;

use App\Data\RequestData\ProductListDataRequest;
use App\Models\GeneralProduct;
use App\Models\GeneralTypeProduct;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\TypeProduct;
use Exception;
use Illuminate\Http\JsonResponse;

class GenerateProductListController extends Controller
{
    public function __construct(
        protected ProductList $productList,
    ) {}

    public function generate(ProductListDataRequest $productListDataRequest): ?JsonResponse
    {
        $userId = auth()->id();
        $this->productList->name = $productListDataRequest->name;
        $this->productList->color = $productListDataRequest->color;
        $this->productList->user_id = $userId;

        try {
            $this->productList->save();
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'name' => [
                        $exception->getMessage()
                    ]
                ],
            ]);
        }

        foreach ($productListDataRequest->typeProducts as $typeProduct) {
            $newTypeProduct = new TypeProduct();
            $newTypeProduct->name = $typeProduct->name;
            $newTypeProduct->color = $typeProduct->color;
            $newTypeProduct->user_id = $userId;
            $newTypeProduct->product_list_id = $this->productList->id;

            $isGeneralTypeProduct = GeneralTypeProduct::where(['name' => $typeProduct->name, 'user_id' => $userId])
                ->first();

            if (!$isGeneralTypeProduct) {
                $newGeneralTypeProduct = new GeneralTypeProduct();
                $newGeneralTypeProduct->name = $typeProduct->name;
                $newGeneralTypeProduct->color = $typeProduct->color;
                $newGeneralTypeProduct->user_id = $userId;
            }

            try {
                $newTypeProduct->save();

                if (!$isGeneralTypeProduct) {
                    $newGeneralTypeProduct->save();
                }
            } catch (Exception $exception) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'name' => [
                            $exception->getMessage()
                        ]
                    ],
                ]);
            }

            foreach ($typeProduct->products as $product) {

                $newProduct = new Product();
                $newProduct->name = $product->name;
                $newProduct->count = $product->count;
                $newProduct->color = $product->color;
                $newProduct->type_count_id = $product->type_count_id;
                $newProduct->type_product_id = $newTypeProduct->id;
                $newProduct->user_id = $userId;
                $newProduct->comment = $product->comment;

                $isGeneralProduct = GeneralProduct::where(['name' => $product->name, 'user_id' => $userId])
                    ->first();

                if (!$isGeneralProduct) {
                    $newGeneralProduct = new GeneralProduct();
                    $newGeneralProduct->name = $product->name;
                    $newGeneralProduct->color = $product->color;
                    $newGeneralProduct->user_id = $userId;
                }

                try {
                    $newProduct->save();

                    if (!$isGeneralProduct) {
                        $newGeneralProduct->save();
                    }
                } catch (Exception $exception) {
                    return response()->json([
                        'success' => false,
                        'errors' => [
                            'name' => [
                                $exception->getMessage()
                            ]
                        ],
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $this->productList,
        ], 201);
    }
}
