<?php

namespace App\Http\Controllers;

use App\Data\RequestData\GeneralProductDataRequest;
use App\Data\ResourceData\GeneralProductDataResource;
use App\Models\GeneralProduct;
use Exception;
use Illuminate\Http\JsonResponse;

class GeneralProductController extends Controller
{
    public function __construct(
        protected GeneralProduct $generalProduct,
    ) {}

    public function getAllProducts()
    {
        $generalProducts = GeneralProduct::where('user_id', auth()->id())
            ->simplePaginate(10);

        return response()->json([
            'data' => GeneralProductDataResource::collection($generalProducts),
        ]);
    }

    public function one(int $id): ?JsonResponse
    {
        try {
            $product = GeneralProduct::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->first();

            return response()->json([
                'success' => true,
                'data' => GeneralProductDataRequest::from($product)
            ]);
        } catch (Exception $exeption) {
            return response()->json([
                'success' => false,
                'errors' => $exeption->errors(),
            ], 500);
        }
    }

    public function create(GeneralProductDataRequest $generalProductDataRequest): ?JsonResponse
    {
        $this->generalProduct->name = $generalProductDataRequest->name;
        $this->generalProduct->user_id = auth()->id();

        try {
            $this->generalProduct->save();

            return response()->json([
                'success' => true,
                'data' => $this->generalProduct,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function update(GeneralProductDataRequest $generalProductDataRequest, GeneralProduct $generalProduct): ?JsonResponse
    {
        try {
            $generalProduct->update([
                'name' => $generalProductDataRequest->name,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->generalProduct,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function delete(GeneralProduct $generalProduct): ?JsonResponse
    {
        try {
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
