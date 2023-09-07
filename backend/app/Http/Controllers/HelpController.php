<?php

namespace App\Http\Controllers;

use App\Models\TypeCount;
use Illuminate\Http\JsonResponse;

class HelpController extends Controller
{
    public function getTypeCounts(): JsonResponse
    {
        return response()->json([
            'data' => TypeCount::all()
        ]);
    }
}
