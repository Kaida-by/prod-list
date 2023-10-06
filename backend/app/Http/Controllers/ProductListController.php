<?php

namespace App\Http\Controllers;

use App\Data\RequestData\ProductListDataRequest;
use App\Data\ResourceData\ProductListDataResource;
use App\Models\GeneralProduct;
use App\Models\GeneralTypeProduct;
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
                ->with('typeProducts.products')
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
                    if (array_key_exists($key, $productList->typeProducts->toArray())) {
                        $productList->typeProducts[$key]->update([
                            'name' => $typeProduct->name,
                            'user_id' => $userId,
                            'product_list_id' => $productList->id,
                        ]);
                    } else {
                        $tp = TypeProduct::create([
                            'name' => $typeProduct->name,
                            'user_id' => $userId,
                            'product_list_id' => $productList->id,
                        ]);

                        $isGeneralTypeProduct = GeneralTypeProduct::where(['name' => $typeProduct->name, 'user_id' => $userId])
                            ->first();

                        if (!$isGeneralTypeProduct) {
                            GeneralTypeProduct::create([
                                'name' => $typeProduct->name,
                                'user_id' => $userId,
                            ]);
                        }

                        $productList->typeProducts->add($tp);
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

                foreach ($typeProduct->products as $keyPr => $product) {
                    try {
                        if (array_key_exists($key, $productList->typeProducts->toArray()) &&
                            array_key_exists($keyPr, $productList->typeProducts[$key]->products->toArray())) {

                            $productList->typeProducts[$key]->products[$keyPr]->update([
                                'name' => $product->name,
                                'count' => $product->count,
                                'type_count_id' => $product->type_count_id,
                                'type_product_id' => $productList->typeProducts[$key]->id,
                                'user_id' => $userId,
                                'comment' => $product->comment,
                            ]);
                        } else {
                            $isGeneralProduct = GeneralProduct::where(['name' => $product->name, 'user_id' => $userId])
                                ->first();
                            Product::create([
                                'name' => $product->name,
                                'count' => $product->count,
                                'type_count_id' => $product->type_count_id,
                                'type_product_id' => $productList->typeProducts[$key]->id,
                                'user_id' => $userId,
                                'comment' => $product->comment,
                            ]);

                            if (!$isGeneralProduct) {
                                GeneralProduct::create([
                                    'name' => $product->name,
                                    'user_id' => $userId,
                                ]);
                            }

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
