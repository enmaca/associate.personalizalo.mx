<?php

namespace App\Http\Controllers;

use App\Support\Workshop\PaymentMethods\SelectPaymentMethods;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function search_tomselect(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $values = [];
        $customer_id = $request->input('customer_id');
        if (!empty($customer_id))
            $values['customer_id'] = $customer_id;

        $searchObj = new SelectPaymentMethods(['values' => $values]);
        return $searchObj->search($search);
    }
}