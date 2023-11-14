<?php

namespace App\Support\Workshop\OrderProductDynamicDetails\TbHandler;

use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class ProfitMargin extends ColumnParseValue
{

    public function parseValue(mixed $value): mixed
    {
        $value = parent::parseValue($value);
        if( empty( $value ))
            $value = '0%';
        return "<div>".$value ."</div>";
    }
}