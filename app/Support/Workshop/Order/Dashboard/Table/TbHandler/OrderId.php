<?php

namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class OrderId extends ColumnParseValue {

    public function parseValue($value): mixed
    {
        return $value;
    }
}