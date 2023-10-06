<?php

namespace App\Http\Controllers;

use App\Data\RequestData\ProductDataRequest;
use App\Data\ResourceData\ProductDataResource;
use App\Models\GeneralProduct;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected Product $product,
        protected GeneralProduct $generalProduct,
    ) {}

    public function index(): JsonResponse
    {
        $products = Product::where('user_id', auth()->id())
            ->simplePaginate(10);

        return response()->json([
            'data' => ProductDataResource::collection($products),
        ]);
    }

    public function one(int $id): ?JsonResponse
    {
        try {
            $product = Product::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->first();

            return response()->json([
                'success' => true,
                'data' => ProductDataRequest::from($product)
            ]);
        } catch (Exception $exeption) {
            return response()->json([
                'success' => false,
                'errors' => $exeption->errors(),
            ], 500);
        }
    }

    public function create(ProductDataRequest $productDataRequest): ?JsonResponse
    {
        $this->product->name = $productDataRequest->name;
        $this->product->count = $productDataRequest->count;
        $this->product->type_count_id = $productDataRequest->type_count_id;
        $this->product->type_product_id = $productDataRequest->type_product_id;
        $this->product->user_id = auth()->id();
        $this->product->comment = $productDataRequest->comment;

        try {
            $this->product->save();
            $this->generalProduct->firstOrCreate([
                'name' => $productDataRequest->name,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->product,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function update(ProductDataRequest $productDataRequest, Product $product): ?JsonResponse
    {
        try {
            $generalProduct = $this->generalProduct->where([
                'user_id' => $product->user_id,
                'name' => $product->name,
            ])->first();

            $product->update([
                'name' => $productDataRequest->name,
                'count' => $productDataRequest->count,
                'type_count_id' => $productDataRequest->type_count_id,
                'type_product_id' => $productDataRequest->type_product_id,
                'user_id' => auth()->id(),
                'comment' => $productDataRequest->comment,
            ]);

            $generalProduct->update([
                'name' => $productDataRequest->name,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->product,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function delete(Product $product): ?JsonResponse
    {
        try {
            $generalProduct = $this->generalProduct->where([
                'user_id' => $product->user_id,
                'name' => $product->name
            ])->first();
            $product->forceDelete();
            $generalProduct->delete();

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
