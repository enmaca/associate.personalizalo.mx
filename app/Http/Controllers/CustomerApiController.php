<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{

    /**
     * @param Request $request
     * @param mixed $customer_hashid
     * @return JsonResponse
     * @throws \Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException
     */
    public function get_customer(Request $request, mixed $customer_hashid): JsonResponse
    {
        $context = $request->input('context');

        $customer_id = Customer::keyFromHashId($customer_hashid);
        $client = Customer::findOrFail($customer_id);
        if(empty($client))
            return response()->json(['error' => 'Customer not found'], 404);

        $customerData2Return = $client->toArray();
        $customerData2Return['hashid'] = $customer_hashid;
        unset($customerData2Return['id']);

        return response()->json(['ok' => null, 'result' => $customerData2Return], 200);

    }
}