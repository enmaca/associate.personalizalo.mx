<?php

namespace App\Support\Order;

use Vinkla\Hashids\Facades\Hashids;

class OrderId extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn {

    public function parseValue($value){
        return Hashids::encode($value);
    }
}