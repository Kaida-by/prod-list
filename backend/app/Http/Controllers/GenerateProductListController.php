<?php

namespace App\Http\Controllers;

use App\Data\RequestData\ProductListDataRequest;
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
        $this->productList->name = $productListDataRequest->name;
        $this->productList->user_id = auth()->id();

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
//        for ($i = 0, $iMax = count($productListDataRequest->typeProducts); $i < $iMax; $i++) {
//            $this->typeProduct->name = $productListDataRequest->typeProducts[$i]->name;
//            $this->typeProduct->user_id = auth()->id();
//        }

        foreach ($productListDataRequest->typeProducts as $typeProduct) {
            $newTypeProduct = new TypeProduct();
            $newTypeProduct->name = $typeProduct->name;
            $newTypeProduct->user_id = auth()->id();
            $newTypeProduct->product_list_id = $this->productList->id;

            try {
                $newTypeProduct->save();
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
                $newProduct->type_count_id = $product->type_count_id;
                $newProduct->comment_id = $product->comment_id;
                $newProduct->type_product_id = $newTypeProduct->id;
                $newProduct->user_id = auth()->id();

                try {
                    $newProduct->save();
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

//        try {
//            $this->productList->save();
//
//            return response()->json([
//                'success' => true,
//                'data' => $this->productList,
//            ], 201);
//        } catch (Exception $exception) {
//            return response()->json([
//                'success' => false,
//                'errors' => [
//                    'name' => [
//                        $exception->getMessage()
//                    ]
//                ],
//            ]);
//        }
    }
}
