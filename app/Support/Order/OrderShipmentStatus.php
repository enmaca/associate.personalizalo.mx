<?php

namespace App\Support\Order;

use App\Enums\ShipmentStatusEnum;

class OrderShipmentStatus extends \Enmaca\LaravelUxmal\Support\ListJSTableColumn {

    public function __construct($attributes = [])
    {
        $this->enumClass = ShipmentStatusEnum::class;
        parent::__construct($attributes);
    }


    public function parseValue($value){
        $value = parent::parseValue($value);
        return "<div>" .$value ."</div>";
    }
}