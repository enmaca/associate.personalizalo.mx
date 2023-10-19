<?php

namespace App\Support\UxmalComponents\Order\TbHandler;

class OrderId extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn {

    public function parseValue($value){
        return $value;
    }
}