<?php

namespace App\Support\Workshop\OrderProductDynamicDetails\TbHandler;
use Enmaca\LaravelUxmal\Support\Components\Ui\Table\ColumnSupport;

class ProfitMargin extends ColumnSupport
{

    public function parseValue(mixed $value): mixed
    {
        $value = parent::parseValue($value);
        if( empty( $value ))
            $value = '0%';
        return "<div>".$value ."</div>";
    }
}