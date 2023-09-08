<?php

namespace App\Http\Controllers;

use App\Data\RequestData\TypeProductDataRequest;
use App\Data\ResourceData\TypeProductDataResource;
use App\Models\GeneralTypeProduct;
use App\Models\Product;
use App\Models\TypeProduct;
use Exception;
use Illuminate\Http\JsonResponse;

class TypeProductController extends Controller
{
    public function __construct(
        protected TypeProduct $typeProduct,
        protected GeneralTypeProduct $generalTypeProduct,
        protected Product $product,
    ) {}

    public function index(): JsonResponse
    {
        $typeProducts = TypeProduct::where('user_id', auth()->id())
            ->simplePaginate(10);

        return response()->json([
            'data' => TypeProductDataResource::collection($typeProducts),
        ]);
    }

    public function one(int $id): ?JsonResponse
    {
        try {
            $typeProduct = TypeProduct::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->first();

            return response()->json([
                'success' => true,
                'data' => TypeProductDataRequest::from($typeProduct)
            ]);
        } catch (Exception $exeption) {
            return response()->json([
                'success' => false,
                'errors' => $exeption->errors(),
            ], 500);
        }
    }

    public function create(TypeProductDataRequest $typeProductDataRequest): ?JsonResponse
    {
        $this->typeProduct->name = $typeProductDataRequest->name;
        $this->typeProduct->user_id = auth()->id();
        $this->typeProduct->product_list_id = $typeProductDataRequest->product_list_id;

        try {
            $this->typeProduct->save();
            $this->generalTypeProduct->firstOrCreate([
                'name' => $typeProductDataRequest->name,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->typeProduct,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function update(TypeProductDataRequest $typeProductDataRequest, TypeProduct $typeProduct): ?JsonResponse
    {
        try {
            $generalTypeProduct = $this->generalTypeProduct->where([
                'user_id' => $typeProduct->user_id,
                'name' => $typeProduct->name,
            ])->first();

            $typeProduct->update([
                'name' => $typeProductDataRequest->name,
                'user_id' => auth()->id(),
                'product_list_id' => $typeProductDataRequest->product_list_id,
            ]);

            $generalTypeProduct->update([
                'name' => $typeProductDataRequest->name,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->typeProduct,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function delete(TypeProduct $typeProduct): ?JsonResponse
    {
        try {
            $generalTypeProduct = $this->generalTypeProduct->where([
                'user_id' => $typeProduct->user_id,
                'name' => $typeProduct->name
            ])->first();
            $typeProduct->forceDelete();
            $generalTypeProduct->delete();

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
