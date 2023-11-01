<?php

namespace App\Http\Controllers;

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

    /**
     * @throws Exception
     */
    public static function generateRandomColor(): string
    {
        return fake()->hexColor;
    }
}
