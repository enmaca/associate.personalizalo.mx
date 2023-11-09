<?php

namespace App\Support\UxmalComponents\Order\TbHandler;

use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;

class OrderId extends ColumTable {

    public function parseValue($value): mixed
    {
        return $value;
    }
}