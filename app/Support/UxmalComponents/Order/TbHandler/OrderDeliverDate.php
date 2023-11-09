<?php

namespace App\Support\UxmalComponents\Order\TbHandler;

use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;

class OrderDeliverDate extends ColumTable {

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        if(empty($value))
            $value = 'OrderDeliverDate::empty';

        return "<div>" .$value ."</div>";
    }
}