<?php

namespace App\Support\UxmalComponents\Order\TbHandler;

class OrderPaymentAmmount extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn {

    public function parseValue($value){
        if(empty($value))
            $value = 'OrderPaymentAmmount::empty';

        return "<div>" .$value ."</div>";
    }
}