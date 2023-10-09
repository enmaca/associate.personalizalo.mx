<?php

namespace App\Support\Order;
use App\Enums\OrderStatusEnum;
class OrderStatus extends \Enmaca\LaravelUxmal\Support\ListJSTableColumn {

    public function __construct($attributes = [])
    {
        $this->enumClass = OrderStatusEnum::class;
        parent::__construct($attributes);
    }

    public function parseValue($value){
        $value = parent::parseValue($value);
        return "<div>".$value ."</div>";
    }
}