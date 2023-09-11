<?php

namespace App\Http\Controllers;

use App\Data\RequestData\ProductListDataRequest;
use App\Data\ResourceData\ProductListDataResource;
use App\Models\ProductList;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductListController extends Controller
{
    public function __construct(protected ProductList $productList) {}

    public function index(): JsonResponse
    {
        $productLists = ProductList::where('user_id', auth()->id())
            ->with('typeProduct.products')
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
            ])->first();

            return response()->json([
                'success' => true,
                'data' => ProductListDataRequest::from($productList)
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
        try {
            $productList->update([
                'name' => $productListDataRequest->name,
                'user_id' => auth()->id(),
            ]);

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
}
