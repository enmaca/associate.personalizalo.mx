<?php

namespace App\Support\Order;

class OrderPaymentAmmount extends \Enmaca\LaravelUxmal\Support\ListJSTableColumn {

    public function parseValue($value){
        if(empty($value))
            $value = 'OrderPaymentAmmount::empty';

        return "<div>" .$value ."</div>";
    }
}