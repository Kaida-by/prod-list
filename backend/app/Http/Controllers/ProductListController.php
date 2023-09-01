<?php

namespace App\Http\Controllers;

use App\Models\ProductList;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductListController extends Controller
{
    public function __construct(protected ProductList $productList) {}

    public function index(): JsonResponse
    {
        $productLists = ProductList::where('user_id', auth()->id())
            ->simplePaginate(10);
        dd($productLists);
        return response()->json([
            'data' => ProductList::all()
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
                'data' => $productList
            ]);
        } catch (Exception $exeption) {
            return response()->json([
                'success' => false,
                'errors' => $exeption->errors(),
            ], 500);
        }
    }

    public function create(Request $request): ?JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 500);
        }

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
                'errors' => [
                    'name' => [
                        $exception->getMessage()
                    ]
                ],
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
