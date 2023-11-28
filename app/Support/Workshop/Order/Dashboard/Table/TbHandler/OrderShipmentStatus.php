<?php

namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use App\Support\Enums\ShipmentStatusEnum;
use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class OrderShipmentStatus extends ColumnParseValue {

    public function __construct($attributes = [])
    {
        parent::__construct($attributes, ShipmentStatusEnum::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        $value = parent::parseValue($value);
        return "<div>" .$value ."</div>";
    }
}