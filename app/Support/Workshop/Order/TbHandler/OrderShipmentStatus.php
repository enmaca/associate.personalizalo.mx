<?php

namespace App\Support\Workshop\Order\TbHandler;

use App\Enums\ShipmentStatusEnum;
use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;

class OrderShipmentStatus extends ColumTable {

    public function __construct($attributes = [])
    {
        $this->enumClass = ShipmentStatusEnum::class;
        parent::__construct($attributes);
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