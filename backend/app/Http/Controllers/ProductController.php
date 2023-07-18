<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected Product $product) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Product::all()
        ]);
    }

    public function create(Request $request): ?JsonResponse
    {
        $this->product->name = $request['name'];
        $this->product->count = $request['count'];
        $this->product->count_type_id = $request['count_type_id'];
        $this->product->comment_id = $request['comment_id'];
        $this->product->product_type_id = $request['product_type_id'];
        $this->product->user_id = $request['user_id'];

        try {
            $this->product->save();

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

    public function update(Request $request, Product $product): ?JsonResponse
    {
        try {
            $product->update([
                'name' => $request['name'],
                'count' => $request['count'],
                'count_type_id' => $request['count_type_id'],
                'comment_id' => $request['comment_id'],
                'product_type_id' => $request['product_type_id'],
                'user_id' => $request['user_id'],
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
             $product->delete();

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
