<?php

namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class OrderDeliverDate extends ColumnParseValue {

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