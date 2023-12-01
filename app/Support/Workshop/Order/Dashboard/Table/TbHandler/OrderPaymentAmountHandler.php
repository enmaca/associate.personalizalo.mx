<?php

namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class OrderPaymentAmountHandler extends ColumnParseValue {

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        if(empty($value))
            $value = '$0.00';

        return "<div class='text-end me-1'>\$" .round($value, 2) ."</div>";
    }
}