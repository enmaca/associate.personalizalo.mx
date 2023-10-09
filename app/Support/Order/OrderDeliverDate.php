<?php

namespace App\Support\Order;

class OrderDeliverDate extends \Enmaca\LaravelUxmal\Support\ListJSTableColumn {

    public function parseValue($value){
        if(empty($value))
            $value = 'OrderDeliverDate::empty';

        return "<div>" .$value ."</div>";
    }
}