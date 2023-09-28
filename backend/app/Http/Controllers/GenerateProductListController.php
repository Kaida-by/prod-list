<?php

namespace App\Http\Controllers;

use App\Data\RequestData\ProductListDataRequest;
use App\Models\Comment;
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
            $newTypeProduct->user_id = $userId;
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

                if ($product->comment->text) {
                    $comment = new Comment();
                    $comment->text = $product->comment->text;
                    $comment->user_id = $userId;

                    try {
                        $comment->save();
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
                } else {
                    $comment = null;
                }

                $newProduct = new Product();
                $newProduct->name = $product->name;
                $newProduct->count = $product->count;
                $newProduct->type_count_id = $product->type_count_id;
                $newProduct->comment_id = $comment?->id;
                $newProduct->type_product_id = $newTypeProduct->id;
                $newProduct->user_id = $userId;

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
