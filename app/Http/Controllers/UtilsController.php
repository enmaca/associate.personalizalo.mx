<?php

namespace App\Http\Controllers;

use Enmaca\LaravelUxmal\Support\Helpers\BuildRoutesHelper;

class UtilsController extends Controller
{
    public function get_routes(): \Illuminate\Http\JsonResponse
    {
        return response()->json(BuildRoutesHelper::build());
    }
}
