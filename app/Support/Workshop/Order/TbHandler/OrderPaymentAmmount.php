<?php

namespace App\Support\Workshop\Order\TbHandler;

use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;

class OrderPaymentAmmount extends ColumTable {

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        if(empty($value))
            $value = 'OrderPaymentAmmount::empty';

        return "<div>" .$value ."</div>";
    }
}