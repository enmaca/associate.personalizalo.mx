<?php

namespace App\Support\UxmalComponents\Order\TbHandler;

class OrderDeliverDate extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn {

    public function parseValue($value){
        if(empty($value))
            $value = 'OrderDeliverDate::empty';

        return "<div>" .$value ."</div>";
    }
}