<?php

namespace App\Support\Workshop\Order\TbHandler;

use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;

class OrderId extends ColumTable {

    public function parseValue($value): mixed
    {
        return $value;
    }
}