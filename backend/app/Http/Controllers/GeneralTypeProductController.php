<?php

namespace App\Http\Controllers;

use App\Data\RequestData\GeneralTypeProductDataRequest;
use App\Data\ResourceData\GeneralTypeProductDataResource;
use App\Models\GeneralTypeProduct;
use Exception;
use Illuminate\Http\JsonResponse;

class GeneralTypeProductController extends Controller
{
    public function __construct(
        protected GeneralTypeProduct $generalTypeProduct,
    ) {}

    public function getAllTypeProducts()
    {
        $generalProducts = GeneralTypeProduct::where('user_id', auth()->id())
            ->simplePaginate(10);

        return response()->json([
            'data' => GeneralTypeProductDataResource::collection($generalProducts),
        ]);
    }

    public function one(int $id): ?JsonResponse
    {
        try {
            $typeProduct = GeneralTypeProduct::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->first();

            return response()->json([
                'success' => true,
                'data' => GeneralTypeProductDataRequest::from($typeProduct)
            ]);
        } catch (Exception $exeption) {
            return response()->json([
                'success' => false,
                'errors' => $exeption->errors(),
            ], 500);
        }
    }

    public function create(GeneralTypeProductDataRequest $generalTypeProductDataRequest): ?JsonResponse
    {
        $this->generalTypeProduct->name = $generalTypeProductDataRequest->name;
        $this->generalTypeProduct->user_id = auth()->id();

        try {
            $this->generalTypeProduct->save();

            return response()->json([
                'success' => true,
                'data' => $this->generalTypeProduct,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function update(GeneralTypeProductDataRequest $generalTypeProductDataRequest, GeneralTypeProduct $generalTypeProduct): ?JsonResponse
    {
        try {
            $generalTypeProduct->update([
                'name' => $generalTypeProductDataRequest->name,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->generalTypeProduct,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function delete(GeneralTypeProduct $generalTypeProduct): ?JsonResponse
    {
        try {
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
