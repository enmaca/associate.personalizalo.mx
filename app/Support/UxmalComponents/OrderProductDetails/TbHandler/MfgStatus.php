<?php

namespace App\Support\UxmalComponents\OrderProductDetails\TbHandler;
use App\Models\OrderProductDetail;
use Illuminate\Support\Facades\View;

class MfgStatus extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn {

    /**
     * @throws \Exception
     */
    public function parseValue(mixed $value): mixed
    {
        if( empty( $value ))
            return '';

        $order_product_detail_id = OrderProductDetail::keyFromHashId($value);
        if(empty($order_product_detail_id))
            throw new \Exception('The option ProductDescription.value is Required to be OrderProductDetail::hashId !!');

        return '';
    }
}