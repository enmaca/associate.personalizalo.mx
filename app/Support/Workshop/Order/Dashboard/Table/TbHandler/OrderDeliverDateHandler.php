<?php

namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;
use Illuminate\Support\Carbon;

class OrderDeliverDateHandler extends ColumnParseValue {

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        if(empty($value))
           return '[Sin fecha de entrega]';

        return "<div>" .Carbon::parse($value)->format('F j, Y') ."</div>";
    }
}