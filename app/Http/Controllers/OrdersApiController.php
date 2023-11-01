<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class OrdersApiController extends Controller
{
    public function api_post_order_add_product(Request $request)
    {
        $allInput = $request->all();

        dd($allInput);

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ], 201);
    }

}
