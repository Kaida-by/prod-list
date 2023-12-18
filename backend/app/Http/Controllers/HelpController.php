<?php

namespace App\Http\Controllers;

use App\Models\BasicProduct;
use App\Models\BasicTypeProduct;
use App\Models\TypeCount;
use Exception;
use Illuminate\Http\JsonResponse;

class HelpController extends Controller
{
    public function getTypeCounts(): JsonResponse
    {
        return response()->json([
            'data' => TypeCount::all()
        ]);
    }

    public function getBasicProducts(): JsonResponse
    {
        return response()->json([
            'data' => BasicProduct::get()
        ]);
    }

    public function getBasicTypeProducts(): JsonResponse
    {
        return response()->json([
            'data' => BasicTypeProduct::get()
        ]);
    }

    /**
     * @throws Exception
     */
    public static function generateRandomColor(): string
    {
        return fake()->hexColor;
    }
}
