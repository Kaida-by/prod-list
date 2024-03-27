<?php

namespace App\Http\Controllers;

use App\Data\RequestData\GeneralProductDataRequest;
use App\Data\ResourceData\GeneralProductDataResource;
use App\Models\GeneralProduct;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GeneralProductController extends Controller
{
    public function __construct(
        protected GeneralProduct $generalProduct,
    ) {}

    public function getAllProducts()
    {
        $generalProducts = GeneralProduct::where('user_id', auth()->id())
            ->simplePaginate(240);

        return response()->json([
            'data' => GeneralProductDataResource::collection($generalProducts),
        ]);
    }

    public function getAllProductsByName(?string $name)
    {
        $queryForBasic = DB::table('basic_products')
            ->select(
                'basic_products.id',
                'basic_products.name',
                'basic_products.type_product_id',
                'basic_products.created_at',
                'basic_products.updated_at',
            );

        if ($name) {
            $queryForBasic = $queryForBasic
                ->leftJoin(
                'basic_type_products',
                'basic_products.type_product_id',
                '=',
                'basic_type_products.id'
                )
                ->where('basic_type_products.name', $name);

            $basicProducts = $queryForBasic->get();

            $generalBasicQuery = DB::table('general_products')
                ->select(
                'general_products.id',
                    'general_products.name',
                    'general_products.type_product_id',
                    'general_products.user_id',
                    'general_products.created_at',
                    'general_products.updated_at'
                )->where(
                'general_products.user_id', auth()->id()
                )->leftJoin(
                'basic_type_products',
                'general_products.type_product_id',
                '=',
                'basic_type_products.id'
                )
                ->where('basic_type_products.name', $name);
            $generalBasicProducts = $generalBasicQuery->get()->toArray();

            $basicProducts = $basicProducts->concat($generalBasicProducts);
        } else {
            $basicProducts = [];
        }

        if (count($basicProducts) === 0) {
            $query = DB::table('general_products')->select(
                'general_products.id',
                'general_products.name',
                'general_products.color',
                'general_products.type_product_id',
                'general_products.user_id',
                'general_products.created_at',
                'general_products.updated_at'
            )->where('general_products.user_id', auth()->id());

            if ($name) {
                $query = $query->leftJoin
                (
                    'general_type_products',
                    'general_products.type_product_id',
                    '=',
                    'general_type_products.id'
                )
                    ->where('general_type_products.name', $name);

                $finallyProducts = $query->get();
            } else {
                $finallyProducts = [];
            }
        } else {
            $finallyProducts = $basicProducts;
        }

        return response()->json([
            'data' => GeneralProductDataResource::collection($finallyProducts),
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
        $this->generalProduct->color = $generalProductDataRequest->color;
        $this->generalProduct->type_product_id = $generalProductDataRequest->type_product_id;
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
                'color' => $generalProductDataRequest->color,
                'type_product_id' => $generalProductDataRequest->type_product_id,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $generalProduct,
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
