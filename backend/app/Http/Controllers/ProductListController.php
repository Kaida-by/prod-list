<?php

namespace App\Http\Controllers;

use App\Data\RequestData\ProductListDataRequest;
use App\Data\ResourceData\ProductListDataResource;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\TypeProduct;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductListController extends Controller
{
    public function __construct(protected ProductList $productList) {}

    public function index(): JsonResponse
    {
        $productLists = ProductList::where('user_id', auth()->id())
            ->with('typeProducts.products')
            ->simplePaginate(10);

        return response()->json([
            'data' => ProductListDataResource::collection($productLists),
        ]);
    }

    public function one(int $id): ?JsonResponse
    {
        try {
            $productList = ProductList::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])
                ->with('typeProducts.products.comment')
                ->first();

            return response()->json([
                'success' => true,
                'data' => ProductListDataResource::from($productList)
            ]);
        } catch (Exception $exeption) {
            return response()->json([
                'success' => false,
                'errors' => $exeption->errors(),
            ], 500);
        }
    }

    public function create(ProductListDataRequest $productListDataRequest): ?JsonResponse
    {
        $this->productList->name = $productListDataRequest->name;
        $this->productList->user_id = auth()->id();

        try {
            $this->productList->save();

            return response()->json([
                'success' => true,
                'data' => $this->productList,
            ], 201);
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

    public function update(ProductListDataRequest $productListDataRequest, ProductList $productList): ?JsonResponse
    {
        $userId = auth()->id();

        try {
            $productList->update([
                'name' => $productListDataRequest->name,
                'user_id' => $userId,
            ]);

            foreach ($productListDataRequest->typeProducts as $key => $typeProduct) {
                try {
                    if (array_key_exists($key, (array) $productList->typeProducts)) {
                        $productList->typeProducts[$key]->update([
                            'name' => $typeProduct->name,
                            'user_id' => $userId,
                            'product_list_id' => $productList->id,
                        ]);
                    } else {
                        TypeProduct::create([
                            'name' => $typeProduct->name,
                            'user_id' => $userId,
                            'product_list_id' => $productList->id,
                        ]);
                    }
                } catch (Exception $exception) {
                    dd($exception->getMessage());
                    return response()->json([
                        'success' => false,
                        'errors' => [
                            'name' => [
                                $exception->getMessage()
                            ]
                        ],
                    ]);
                }


//                dd($productList->typeProducts[$key]->products, $typeProduct->products);

                foreach ($typeProduct->products as $keyPr => $product) {
                    if (array_key_exists($keyPr, ))


                    foreach ($productList->typeProducts as $tp) {
                        try {
                            $comment = $product->comment->update([
                                'text' => $product->comment->text,
                                'user_id' => $userId,
                            ]);

                            $product->update([
                                'name' => $product->name,
                                'count' => $product->count,
                                'type_count_id' => $product->type_count_id,
                                'comment_id' => $comment->id,
                                'type_product_id' => $tp->id,
                                'user_id' => $userId,
                            ]);
                        } catch (Exception $exception) {
                            dd($exception->getMessage());
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
            }

            return response()->json([
                'success' => true,
                'data' => $productList,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function delete(ProductList $productList): ?JsonResponse
    {
        try {
            $productList->delete();

            return response()->json([
                'success' => true,
            ], 204);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function deleteTypeProductFromProductList(int $typeProductId): ?JsonResponse
    {
        try {
            TypeProduct::findOrFail($typeProductId)->delete();

            return response()->json([
                'success' => true,
            ], 204);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function deleteProductFromProductList(int $productId): ?JsonResponse
    {
        try {
            Product::findOrFail($productId)->delete();

            return response()->json([
                'success' => true,
            ], 204);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }
}
