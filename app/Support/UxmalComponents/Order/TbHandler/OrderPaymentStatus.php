<?php

namespace App\Support\UxmalComponents\Order\TbHandler;

use App\Enums\OrderPaymentStatusEnum;

class OrderPaymentStatus extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn
{

    public function __construct($attributes = [])
    {
        $this->enumClass = OrderPaymentStatusEnum::class;
        parent::__construct($attributes);
    }


    public function parseValue($value)
    {
        $value = parent::parseValue($value);
        return "<div>" . $value . "</div>";
    }
}