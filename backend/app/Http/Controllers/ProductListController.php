<?php

namespace App\Http\Controllers;

use App\Models\ProductList;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function __construct(protected ProductList $productList) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => ProductList::all()
        ]);
    }

    public function create(Request $request): ?JsonResponse
    {
        $this->productList->name = $request['name'];
        $this->productList->user_id = $request['user_id'];

        try {
            $this->productList->save();

            return response()->json([
                'success' => true,
                'data' => $this->productList,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage(),
            ]);
        }
    }

    public function update(Request $request, ProductList $productList): ?JsonResponse
    {
        try {
            $productList->update([
                'name' => $request['name'],
                'user_id' => $request['user_id'],
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->productList,
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
