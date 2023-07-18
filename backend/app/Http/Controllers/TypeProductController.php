<?php

namespace App\Http\Controllers;

use App\Models\TypeProduct;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeProductController extends Controller
{
    public function __construct(protected TypeProduct $typeProduct) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => TypeProduct::all()
        ]);
    }

    public function create(Request $request): ?JsonResponse
    {
        $this->typeProduct->name = $request['name'];
        $this->typeProduct->user_id = $request['user_id'];
        $this->typeProduct->product_list_id = $request['product_list_id'];

        try {
            $this->typeProduct->save();

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

    public function update(Request $request, TypeProduct $typeProduct): ?JsonResponse
    {
        try {
            $typeProduct->update([
                'name' => $request['name'],
                'user_id' => $request['user_id'],
                'product_list_id' => $request['product_list_id'],
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
             $typeProduct->delete();

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
